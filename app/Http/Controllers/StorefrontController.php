<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StorefrontController extends Controller
{
    public function index()
    {
        // Sản phẩm mới: lấy 8 sản phẩm được thêm gần đây.
        $newProducts = Product::with('category')->latest()->take(8)->get();
        
        // Sản phẩm đang sale: giá sale thấp hơn giá gốc.
        $saleProducts = collect();

        if (
            DB::getSchemaBuilder()->hasColumn('products', 'sale_price') &&
            DB::getSchemaBuilder()->hasColumn('products', 'price')
        ) {
            $saleProducts = Product::with('category')
                ->whereNotNull('sale_price')
                ->whereColumn('sale_price', '<', 'price')
                ->latest()
                ->take(8)
                ->get();
        }

        // Sản phẩm bán chạy: xếp theo tổng số lượng đã đặt trong đơn hàng.
        // Nếu chưa có dữ liệu đơn hàng, dùng sản phẩm mới làm nội dung thay thế.
        $bestSellerIds = [];
        if (DB::getSchemaBuilder()->hasTable('order_items')) {
            $bestSellerIds = DB::table('order_items')
                ->select('product_id', DB::raw('SUM(quantity) as sold_quantity'))
                ->whereNotNull('product_id')
                ->groupBy('product_id')
                ->orderByDesc('sold_quantity')
                ->limit(8)
                ->pluck('product_id')
                ->all();
        }

        if (!empty($bestSellerIds)) {
            $order = implode(',', array_map('intval', $bestSellerIds));
            $bestSellers = Product::with('category')
                ->whereIn('id', $bestSellerIds)
                ->orderByRaw("FIELD(id, {$order})")
                ->get();
        } else {
            $bestSellers = $newProducts;
        }

        $collections = Collection::latest()
            ->take(4)
            ->get();

        return view('store.index', compact('newProducts','saleProducts', 'bestSellers', 'collections'));
    }

    public function products(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        // Các danh mục được liên kết trực tiếp với submenu trên thanh điều hướng.
        $menuCategories = [
            'do-ngu-nam' => 'Đồ ngủ nam',
            'do-ngu-nu' => 'Đồ ngủ nữ',
            'do-ngu-tre-em' => 'Đồ ngủ trẻ em',
            'phu-kien' => 'Phụ kiện',
        ];
        $collectionRecords = Collection::orderBy('name')->get();
        $collections = $collectionRecords->pluck('name', 'slug')->all();

        $selectedCategory = $request->query('category');
        $selectedCollection = $request->query('collection');
        $selectedCategoryName = $menuCategories[$selectedCategory] ?? null;
        $selectedCollectionName = $collections[$selectedCollection] ?? null;

        $products = Product::with('category')
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = trim((string) $request->query('q'));
                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('name', 'like', '%' . $term . '%')
                        ->orWhere('description', 'like', '%' . $term . '%');
                });
            })
            ->when($request->filled('category_id'), function ($query) use ($request) {
                $query->where('category_id', $request->integer('category_id'));
            })
            ->when($selectedCategoryName, function ($query) use ($selectedCategoryName) {
                $query->whereHas('category', fn ($categoryQuery) =>
                    $categoryQuery->where('name', $selectedCategoryName));
            })
            ->when($request->filled('category') && !$selectedCategoryName, function ($query) {
                // Slug danh mục không hợp lệ thì không trả về toàn bộ sản phẩm.
                $query->whereRaw('1 = 0');
            })
            ->when($selectedCollectionName, function ($query) use ($selectedCollectionName) {
                $query->where('collection', $selectedCollectionName);
            })
            ->when($request->filled('collection') && !$selectedCollectionName, function ($query) {
                $query->whereRaw('1 = 0');
            })
            ->latest()->paginate(12)->withQueryString();

        $pageTitle = $selectedCategoryName ?? $selectedCollectionName ?? 'Tất cả sản phẩm';

        return view('store.products', compact(
            'products', 'categories', 'menuCategories', 'collections',
            'selectedCategory', 'selectedCollection', 'pageTitle'
        ));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'variants']);
        return view('store.show', compact('product'));
    }
}
