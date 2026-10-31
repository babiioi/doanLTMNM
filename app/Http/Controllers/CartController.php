<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $items = collect($cart)->map(function ($quantity, $key) {
            [$type, $id, $size] = $this->decodeKey((string) $key);
            if ($type === 'variant') {
                $variant = ProductVariant::with('product')->find($id);
                if (!$variant) return null;
                $product = $variant->product;
                $stock = $product->stock;
                $image = $variant->image ?: $product->image;
            } else {
                $product = Product::find($id);
                if (!$product) return null;
                $variant = null;
                $stock = $product->stock;
                $image = $product->image;
            }
            return [
                'key' => $key, 'product' => $product, 'variant' => $variant, 'size' => $size ?: $variant?->size,
                'stock' => $stock, 'image' => $image, 'quantity' => (int) $quantity,
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
            'variant_id' => ['nullable', 'integer'],
            'size' => ['required', 'in:S,M,L'],
        ]);

        $variantsExist = $product->variants()->exists();
        if ($variantsExist) {
            $variant = $product->variants()->whereKey($data['variant_id'] ?? 0)->first();
            if (!$variant) return back()->with('error', 'Vui lòng chọn màu sắc và kích thước hợp lệ.');
            $stock = $product->stock;
            $key = 'v_'.$variant->id.'_s_'.$data['size'];
        } else {
            $variant = null;
            $stock = $product->stock;
            $key = 'p_'.$product->id.'_s_'.$data['size'];
        }

        if ($stock < 1) return back()->with('error', 'Biến thể này hiện đã hết hàng.');
        $cart = session('cart', []);
        $newQuantity = (int) ($cart[$key] ?? 0) + (int) $data['quantity'];
        $totalForProduct = 0;
        foreach ($cart as $cartKey => $cartQty) {
            [$cartType, $cartId] = $this->decodeKey((string) $cartKey);
            $cartProductId = $cartType === 'variant' ? ProductVariant::whereKey($cartId)->value('product_id') : ($cartType === 'product' ? $cartId : null);
            if ((int) $cartProductId === (int) $product->id) $totalForProduct += (int) $cartQty;
        }
        if ($totalForProduct + (int) $data['quantity'] > $stock) return back()->with('error', 'Tổng số lượng các màu/size vượt tồn kho chung. Hiện còn '.$stock.' sản phẩm.');
        $cart[$key] = $newQuantity;
        session(['cart' => $cart]);
        return redirect()->route('cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function updateItem(Request $request, string $key)
    {
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:99']]);
        $cart = session('cart', []);
        if (!array_key_exists($key, $cart)) return redirect()->route('cart.index');
        [$type, $id] = $this->decodeKey($key);
        $stock = $type === 'variant' ? Product::whereKey(ProductVariant::whereKey($id)->value('product_id'))->value('stock') : Product::whereKey($id)->value('stock');
        if ($stock === null || (int) $data['quantity'] > $stock) {
            return back()->with('error', 'Số lượng vượt quá tồn kho hiện tại.');
        }
        $productId = $type === 'variant' ? ProductVariant::whereKey($id)->value('product_id') : $id;
        $otherQuantity = 0;
        foreach ($cart as $otherKey => $otherQty) {
            if ((string) $otherKey === $key) continue;
            [$otherType, $otherId] = $this->decodeKey((string) $otherKey);
            $otherProductId = $otherType === 'variant' ? ProductVariant::whereKey($otherId)->value('product_id') : ($otherType === 'product' ? $otherId : null);
            if ((int) $otherProductId === (int) $productId) $otherQuantity += (int) $otherQty;
        }
        if ($otherQuantity + (int) $data['quantity'] > $stock) return back()->with('error', 'Tổng số lượng các màu/size vượt tồn kho chung.');
        $cart[$key] = (int) $data['quantity'];
        session(['cart' => $cart]);
        return back()->with('success', 'Đã cập nhật giỏ hàng.');
    }

    public function destroyItem(string $key)
    {
        $cart = session('cart', []);
        unset($cart[$key]);
        session(['cart' => $cart]);
        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    // Giữ tương thích với các URL cũ nếu còn được sử dụng.
    public function update(Request $request, Product $product)
    {
        $key = 'p_'.$product->id.'_s_'.$data['size'];
        return $this->updateItem($request, $key);
    }

    public function destroy(Product $product)
    {
        return $this->destroyItem('p_'.$product->id);
    }

    private function decodeKey(string $key): array
    {
        if (preg_match('/^v_(\d+)(?:_s_(S|M|L))?$/', $key, $m)) return ['variant', (int) $m[1], $m[2] ?? null];
        if (preg_match('/^p_(\d+)(?:_s_(S|M|L))?$/', $key, $m)) return ['product', (int) $m[1], $m[2] ?? null];
        // Giỏ hàng tạo từ phiên bản cũ dùng trực tiếp product_id làm khóa.
        if (ctype_digit($key)) return ['product', (int) $key, null];
        return ['invalid', 0, null];
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
