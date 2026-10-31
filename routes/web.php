<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CollectionController as AdminCollectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StorefrontController::class, 'index'])->name('store.home');
Route::get('/products', [StorefrontController::class, 'products'])->name('store.products.index');
Route::get('/products/{product}', [StorefrontController::class, 'show'])->name('store.products.show');
Route::get('/gioi-thieu', function () {
    $categories = ['nang' => 'Đồ ngủ nữ', 'chang' => 'Đồ ngủ nam', 'be' => 'Đồ ngủ trẻ em'];
    $aboutProducts = [];
    foreach ($categories as $key => $category) {
        $aboutProducts[$key] = \App\Models\Product::whereNotNull('image')
            ->whereHas('category', fn ($query) => $query->where('name', $category))
            ->latest()->first();
    }
    return view('store.about', compact('aboutProducts'));
})->name('store.about');
Route::view('/lien-he', 'store.contact')->name('store.contact');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/items/{key}', [CartController::class, 'updateItem'])->name('cart.items.update');
Route::delete('/cart/items/{key}', [CartController::class, 'destroyItem'])->name('cart.items.destroy');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/yeu-thich', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/yeu-thich/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index');
    
    Route::post('/checkout/save-shipping-info', [CheckoutController::class, 'saveShippingInfo'])
    ->name('checkout.save-shipping-info');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');

    // API địa chỉ và phí vận chuyển GHN
    Route::get('/checkout/ghn/provinces', [CheckoutController::class, 'provinces'])
        ->name('checkout.ghn.provinces');

    Route::get('/checkout/ghn/districts/{provinceId}', [CheckoutController::class, 'districts'])
        ->name('checkout.ghn.districts');

    Route::get('/checkout/ghn/wards/{districtId}', [CheckoutController::class, 'wards'])
        ->name('checkout.ghn.wards');

    Route::post('/checkout/ghn/fee', [CheckoutController::class, 'shippingFee'])
        ->name('checkout.ghn.fee');
        Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    });

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('collections', AdminCollectionController::class)->except(['show']);
    Route::resource('products', AdminProductController::class);
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
});

require __DIR__.'/auth.php';
