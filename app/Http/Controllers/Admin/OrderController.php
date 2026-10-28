<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use RuntimeException;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('user')
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = $request->q;
                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('order_number', 'like', '%'.$term.'%')
                        ->orWhere('customer_name', 'like', '%'.$term.'%')
                        ->orWhere('customer_phone', 'like', '%'.$term.'%');
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items', 'user']);

        return view('admin.orders.show', [
            'order' => $order,
            'statuses' => Order::STATUSES,
            'paymentStatuses' => Order::PAYMENT_STATUSES,
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(Order::STATUSES))],
            'payment_status' => ['required', Rule::in(array_keys(Order::PAYMENT_STATUSES))],
        ]);

        try {
            DB::transaction(function () use ($order, $data) {
                $lockedOrder = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();

                if ($lockedOrder->status === 'cancelled' && $data['status'] !== 'cancelled') {
                    throw new RuntimeException('Đơn đã hủy không thể mở lại. Vui lòng tạo đơn hàng mới nếu khách vẫn muốn mua.');
                }

                if ($lockedOrder->status !== 'cancelled' && $data['status'] === 'cancelled') {
                    $items = $lockedOrder->items()->get();

                    foreach ($items as $item) {
                        if ($item->product_id) {
                            $product = Product::whereKey($item->product_id)->lockForUpdate()->first();
                            if ($product) {
                                $product->increment('stock', $item->quantity);
                            }
                        }
                    }
                }

                $lockedOrder->update($data);
            }, 3);
        } catch (RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('admin.orders.show', $order)->with('success', 'Đã cập nhật đơn hàng.');
    }
}
