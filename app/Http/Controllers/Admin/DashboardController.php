<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $categoryCount = Category::count();
        $productCount = Product::count();
        $orderCount = Order::count();
        $pendingOrderCount = Order::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'categoryCount',
            'productCount',
            'orderCount',
            'pendingOrderCount'
        ));
    }
}
