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

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');

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
                'key' => $key, 'product' => $product, 'variant' => $variant, 'size' => $size ?: $variant?->size,
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
                    $size = $size ?: $variant?->size;
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

        session()->forget('cart');
        return redirect()->route('orders.show', $order)->with('success', 'Đặt hàng thành công. Mã đơn hàng: '.$order->order_number);
    }

    private function decodeKey(string $key): array
    {
        if (preg_match('/^v_(\\d+)(?:_s_(S|M|L))?$/', $key, $m)) return ['variant', (int) $m[1], $m[2] ?? null];
        if (preg_match('/^p_(\\d+)(?:_s_(S|M|L))?$/', $key, $m)) return ['product', (int) $m[1], $m[2] ?? null];
        if (ctype_digit($key)) return ['product', (int) $key, null];
        return ['invalid', 0, null];
    }
}
