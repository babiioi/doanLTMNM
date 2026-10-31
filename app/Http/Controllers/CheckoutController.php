<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use RuntimeException;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
if (empty($cart)) {
    return redirect()->route('cart.index')
        ->with('error', 'Giỏ hàng của bạn đang trống.');
}

        $items = collect($cart)->map(function ($quantity, $key) {
            [$type, $id, $size] = $this->decodeKey((string) $key);
            if ($type === 'variant') {
                $variant = ProductVariant::with('product')->find($id);
                if (!$variant) return null;
                $product = $variant->product;
            } else {
                $product = Product::find($id);
                $variant = null;
            }
            if (!$product) return null;
            return [
                'key' => $key, 'product' => $product, 'variant' => $variant, 'size' => str_contains(mb_strtolower($product->category?->name ?? ''), 'phụ kiện') ? null : ($size ?: $variant?->size),
                'quantity' => (int) $quantity,
                'line_total' => (float) $product->price * (int) $quantity,
            ];
        })->filter();

        if ($items->isEmpty()) return redirect()->route('cart.index')->with('error', 'Các sản phẩm trong giỏ không còn tồn tại.');
        $total = $items->sum('line_total');
        return view('checkout.index', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+\\s().-]{8,30}$/'],
            'shipping_address' => ['required', 'string', 'max:500'],
            'note' => ['nullable', 'string', 'max:2000'],
            'payment_method' => ['required', Rule::in(['cod', 'bank_transfer'])],
        ], [
            'customer_name.required' => 'Vui lòng nhập họ tên người nhận.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại.',
            'customer_phone.regex' => 'Số điện thoại không hợp lệ.',
            'shipping_address.required' => 'Vui lòng nhập địa chỉ nhận hàng.',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
        ]);

        if ($data['payment_method'] === 'bank_transfer' &&
            (!config('services.vietqr.bank_bin') || !config('services.vietqr.account') || !config('services.vietqr.account_name'))) {
            return back()->withInput()->withErrors(['payment_method' => 'Cửa hàng chưa cấu hình tài khoản nhận chuyển khoản QR. Vui lòng chọn COD hoặc liên hệ cửa hàng.']);
        }

        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');

        try {
            $shipping = session('checkout_shipping');

            if (
                !$shipping ||
                !isset($shipping['fee'], $shipping['district_id'], $shipping['ward_code'])
            ) {
                return redirect()->route('checkout.index')
                    ->with('error', 'Vui lòng tính phí vận chuyển trước khi đặt hàng.');
            }

            $shippingFee = (float) $shipping['fee'];

            $order = DB::transaction(function () use ($cart, $data, $request) {
                $orderLines = [];
                $subtotal = 0;

                foreach ($cart as $key => $quantity) {
                    [$type, $id, $size] = $this->decodeKey((string) $key);
                    $quantity = (int) $quantity;
                    if ($type === 'variant') {
                        $variant = ProductVariant::whereKey($id)->lockForUpdate()->first();
                        if (!$variant) throw new RuntimeException('Một biến thể trong giỏ không còn tồn tại. Vui lòng kiểm tra lại.');
                        $product = Product::whereKey($variant->product_id)->lockForUpdate()->first();
                        if (!$product || $quantity < 1 || $quantity > $product->stock) {
                            throw new RuntimeException('Sản phẩm "'.($product->name ?? 'không xác định').'" không đủ tồn kho cho màu và size đã chọn.');
                        }
                    } else {
                        $variant = null;
                        $product = Product::whereKey($id)->lockForUpdate()->first();
                        if ($product && $product->variants()->exists()) {
                            throw new RuntimeException('Sản phẩm "'.$product->name.'" vừa được cập nhật màu sắc và size. Vui lòng quay lại trang sản phẩm để chọn lại biến thể.');
                        }
                        if (!$product || $quantity < 1 || $quantity > $product->stock) {
                            throw new RuntimeException('Một sản phẩm trong giỏ không đủ tồn kho. Vui lòng kiểm tra lại.');
                        }
                    }
                    $size = str_contains(mb_strtolower($product->category?->name ?? ''), 'phụ kiện') ? null : ($size ?: $variant?->size);
                    $lineTotal = (float) $product->price * $quantity;
                    $subtotal += $lineTotal;
                    $orderLines[] = ['product' => $product, 'variant' => $variant, 'size' => $size, 'quantity' => $quantity, 'line_total' => $lineTotal];
                }

                // Tồn kho dùng chung: cộng số lượng mọi màu/size trước khi trừ.
                foreach (collect($orderLines)->groupBy(fn($line) => $line['product']->id) as $lines) {
                    $product = $lines->first()['product'];
                    if ($lines->sum('quantity') > $product->stock) throw new RuntimeException('Sản phẩm '.$product->name.' không đủ tồn kho chung.');
                }
                $order = Order::create([
                    'order_number' => 'FS'.now()->format('ymd').Str::upper(Str::random(6)),
                    'user_id' => $request->user()->id,
                    'customer_name' => $data['customer_name'],
                    'customer_phone' => $data['customer_phone'],
                    'shipping_address' => $data['shipping_address'],
                    'note' => $data['note'] ?? null,
                    'subtotal' => $subtotal,
                    'total' => $subtotal,
                    'shipping_fee' => $shippingFee,
                    'payment_method' => $data['payment_method'],
                    'payment_status' => 'unpaid',
                    'status' => 'pending',
                ]);

                foreach ($orderLines as $line) {
                    $product = $line['product'];
                    $variant = $line['variant'];
                    $order->items()->create([
                        'product_id' => $product->id,
                        'product_variant_id' => $variant?->id,
                        'product_name' => $product->name,
                        'product_color' => $variant?->color,
                        'product_size' => $line['size'],
                        'product_price' => $product->price,
                        'quantity' => $line['quantity'],
                        'line_total' => $line['line_total'],
                    ]);

                    $product->decrement('stock', $line['quantity']);
                }
                return $order;
            }, 3);
        } catch (RuntimeException $exception) {
            return redirect()->route('cart.index')->with('error', $exception->getMessage());
        }

        session()->forget(['cart', 'checkout_shipping']);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Đặt hàng thành công. Mã đơn hàng: '.$order->order_number);
    }

    private function decodeKey(string $key): array
    {
        if (preg_match('/^v_(\\d+)(?:_s_(S|M|L))?$/', $key, $m)) return ['variant', (int) $m[1], $m[2] ?? null];
        if (preg_match('/^p_(\\d+)(?:_s_(S|M|L))?$/', $key, $m)) return ['product', (int) $m[1], $m[2] ?? null];
        if (ctype_digit($key)) return ['product', (int) $key, null];
        return ['invalid', 0, null];
    }
    
    // Lấy danh sách tỉnh/thành theo danh mục GHN dùng để tính phí.
    public function provinces()
    {
        return $this->ghnGet('/shiip/public-api/master-data/province');
    }

    // Lấy quận/huyện theo tỉnh/thành.
    public function districts(int $provinceId)
    {
        return $this->ghnGet(
            '/shiip/public-api/master-data/district',
            ['province_id' => $provinceId]
        );
    }

    // Lấy phường/xã theo quận/huyện.
    public function wards(int $districtId)
    {
        return $this->ghnGet(
            '/shiip/public-api/master-data/ward',
            ['district_id' => $districtId]
        );
    }

    // Hàm dùng chung để gọi API GHN.
    private function ghnGet(string $endpoint, array $params = [])
    {
        $response = Http::withHeaders([
            'Token' => config('services.ghn.token'),
            'ShopId' => (string) config('services.ghn.shop_id'),
        ])->get(
            rtrim(config('services.ghn.api_url'), '/') . $endpoint,
            $params
        );

        if (!$response->successful() || $response->json('code') != 200) {
            return response()->json([
                'message' => 'GHN báo lỗi: ' . (
                    $response->json('message')
                    ?? $response->body()
                    ?? 'Không xác định'
                ),
                'ghn_code' => $response->json('code'),
                'ghn_response' => $response->json(),
            ], 502);
        }

        return response()->json($response->json());
    }

    // Tính phí vận chuyển GHN.
    public function shippingFee(Request $request)
    {
        $data = $request->validate([
            'to_district_id' => ['required', 'integer', 'min:1'],
            'to_ward_code' => ['required', 'string', 'max:20'],
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return response()->json([
                'message' => 'Giỏ hàng đang trống.',
            ], 422);
        }

        $products = Product::whereIn('id', array_keys($cart))->get();

        $weight = 0;
        $subtotal = 0;

        foreach ($cart as $productId => $quantity) {
            $product = $products->firstWhere('id', $productId);

            if (!$product) {
                return response()->json([
                    'message' => 'Có sản phẩm không còn tồn tại trong giỏ hàng.',
                ], 422);
            }

            $quantity = (int) $quantity;

            if ($quantity < 1) {
                return response()->json([
                    'message' => 'Số lượng sản phẩm không hợp lệ.',
                ], 422);
            }

            // Tạm tính mỗi sản phẩm nặng 500 gram.
            $weight += $quantity * (int) config('services.ghn.default_weight', 500);
            $subtotal += (float) $product->price * $quantity;
        }

        $payload = [
            'to_district_id' => (int) $data['to_district_id'],
            'to_ward_code' => $data['to_ward_code'],
            'service_type_id' => (int) config('services.ghn.service_type_id', 2),
            'weight' => max(1, $weight),
            'insurance_value' => (int) round($subtotal),
        ];

        try {
            $response = Http::timeout(15)->withHeaders([
                'Token' => config('services.ghn.token'),
                'ShopId' => (string) config('services.ghn.shop_id'),
            ])->post(
                rtrim(config('services.ghn.api_url'), '/') .
                    '/shiip/public-api/v2/shipping-order/fee',
                $payload
            );

            if (!$response->successful() || $response->json('code') != 200) {
                return response()->json([
                    'message' => 'GHN không tính được phí cho địa chỉ này. Vui lòng kiểm tra địa chỉ hoặc cấu hình GHN.',
                ], 502);
            }

            $fee = (int) $response->json('data.total');

            session([
                'checkout_shipping' => [
                    'district_id' => (int) $data['to_district_id'],
                    'ward_code' => $data['to_ward_code'],
                    'fee' => $fee,
                ],
            ]);

            return response()->json([
                'shipping_fee' => $fee,
                'formatted_fee' => number_format($fee, 0, ',', '.') . '₫',
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Không kết nối được GHN. Vui lòng thử lại.',
            ], 502);
        }
    }

    public function saveShippingInfo(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+\s().-]{8,30}$/'],
            'street_address' => ['required', 'string', 'max:300'],
            'shipping_address' => ['required', 'string', 'max:500'],
            'province_id' => ['required', 'integer', 'min:1'],
            'district_id' => ['required', 'integer', 'min:1'],
            'ward_code' => ['required', 'string', 'max:20'],
        ]);

        $request->user()->update([
            'name' => $data['customer_name'],
            'phone' => $data['customer_phone'],
            'street_address' => $data['street_address'],
            'shipping_address' => $data['shipping_address'],
            'shipping_province_id' => $data['province_id'],
            'shipping_district_id' => $data['district_id'],
            'shipping_ward_code' => $data['ward_code'],
        ]);

        return response()->json([
            'message' => 'Đã lưu thông tin nhận hàng thành công.',
        ]);
    }
}
