<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
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
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $items = collect($cart)->map(function ($quantity, $productId) use ($products) {
            $product = $products->get($productId);
            if (!$product) {
                return null;
            }

            return [
                'product' => $product,
                'quantity' => (int) $quantity,
                'line_total' => (float) $product->price * (int) $quantity,
            ];
        })->filter();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Các sản phẩm trong giỏ không còn tồn tại.');
        }

        $total = $items->sum('line_total');

        return view('checkout.index', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+\s().-]{8,30}$/'],
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

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        try {
            $order = DB::transaction(function () use ($cart, $data, $request) {
                $orderLines = [];
                $subtotal = 0;

                foreach ($cart as $productId => $quantity) {
                    $product = Product::whereKey($productId)->lockForUpdate()->first();

                    if (!$product) {
                        throw new RuntimeException('Một sản phẩm trong giỏ không còn tồn tại. Vui lòng kiểm tra lại giỏ hàng.');
                    }

                    $quantity = (int) $quantity;
                    if ($quantity < 1 || $quantity > $product->stock) {
                        throw new RuntimeException('Sản phẩm "'.$product->name.'" không đủ tồn kho. Vui lòng cập nhật giỏ hàng.');
                    }

                    $lineTotal = (float) $product->price * $quantity;
                    $subtotal += $lineTotal;

                    $orderLines[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'line_total' => $lineTotal,
                    ];
                }

                $orderNumber = 'FS'.now()->format('ymd').Str::upper(Str::random(6));

                $order = Order::create([
                    'order_number' => $orderNumber,
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

                    $order->items()->create([
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_price' => $product->price,
                        'quantity' => $line['quantity'],
                        'line_total' => $line['line_total'],
                    ]);

                    // Giữ hàng ngay khi đặt thành công để tránh bán vượt tồn kho.
                    $product->decrement('stock', $line['quantity']);
                }

                return $order;
            }, 3);
        } catch (RuntimeException $exception) {
            return redirect()->route('cart.index')->with('error', $exception->getMessage());
        }

        session()->forget('cart');

        return redirect()->route('orders.show', $order)
            ->with('success', 'Đặt hàng thành công. Mã đơn hàng: '.$order->order_number);
    }
}
