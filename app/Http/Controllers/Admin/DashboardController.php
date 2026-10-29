<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $productCount = Product::count();
        $collectionCount = Collection::count();
        $orderCount = Order::count();

        $totalRevenue = Order::where('status', 'completed')
            ->sum('total');

        $revenueLabels = [];
        $revenueData = [];

        foreach (range(5, 0) as $i) {
            $month = now()->startOfMonth()->subMonths($i);

            $revenueLabels[] = 'T' . $month->format('m/Y');

            $revenueData[] = (float) Order::where('status', 'completed')
                ->whereBetween('created_at', [
                    $month->copy()->startOfMonth(),
                    $month->copy()->endOfMonth(),
                ])
                ->sum('total');
        }

        return view('admin.dashboard', compact(
            'productCount',
            'collectionCount',
            'orderCount',
            'totalRevenue',
            'revenueLabels',
            'revenueData'
        ));
    }
}
