<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
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

        $total = $items->sum('line_total');

        return view('cart.index', compact('items', 'total'));
    }

    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        if ($product->stock < 1) {
            return back()->with('error', 'Sản phẩm hiện đã hết hàng.');
        }

        $cart = session('cart', []);
        $current = (int) ($cart[$product->id] ?? 0);
        $newQuantity = $current + (int) $data['quantity'];

        if ($newQuantity > $product->stock) {
            return back()->with('error', 'Số lượng trong giỏ vượt quá tồn kho. Hiện còn '.$product->stock.' sản phẩm.');
        }

        $cart[$product->id] = $newQuantity;
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        if ((int) $data['quantity'] > $product->stock) {
            return back()->with('error', 'Số lượng vượt quá tồn kho. Hiện còn '.$product->stock.' sản phẩm.');
        }

        $cart = session('cart', []);
        if (!array_key_exists($product->id, $cart)) {
            return redirect()->route('cart.index');
        }

        $cart[$product->id] = (int) $data['quantity'];
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Đã cập nhật giỏ hàng.');
    }

    public function destroy(Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
    public function checkoutSelected(Request $request){
    $data = $request->validate([
        'selected' => ['required', 'array', 'min:1'],
        'selected.*' => ['required', 'integer', 'distinct'],
    ], [
        'selected.required' => 'Vui lòng chọn ít nhất một sản phẩm.',
        'selected.min' => 'Vui lòng chọn ít nhất một sản phẩm.',
    ]);

    $cart = session('cart', []);
    $selectedCart = [];

    foreach ($data['selected'] as $productId) {
        if (!array_key_exists($productId, $cart)) {
            continue;
        }

        $selectedCart[$productId] = (int) $cart[$productId];
    }

    if (empty($selectedCart)) {
        return redirect()->route('cart.index')
            ->with('error', 'Không tìm thấy sản phẩm được chọn trong giỏ hàng.');
    }

    session(['checkout_cart' => $selectedCart]);

    return redirect()->route('checkout.index');
    }
}
