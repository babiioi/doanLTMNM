<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class WishlistController extends Controller {
    public function index(Request $request) {
        $ids = DB::table('wishlists')->where('user_id', $request->user()->id)->pluck('product_id');
        $products = Product::whereIn('id', $ids)->get();
        return view('store.wishlist', compact('products'));
    }
    public function toggle(Request $request, Product $product) {
        $query = DB::table('wishlists')->where('user_id', $request->user()->id)->where('product_id', $product->id);
        if ($query->exists()) { $query->delete(); $message = 'Đã bỏ khỏi yêu thích.'; }
        else { DB::table('wishlists')->insert(['user_id'=>$request->user()->id,'product_id'=>$product->id,'created_at'=>now(),'updated_at'=>now()]); $message = 'Đã thêm vào yêu thích.'; }
        if ($request->expectsJson()) {
            return response()->json(['active' => $message === 'Đã thêm vào yêu thích.', 'message' => $message]);
        }
        return back()->with('status', $message);
    }
}
