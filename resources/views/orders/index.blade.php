@extends('layouts.store')
@section('title', 'Đơn hàng của tôi | Mơ Màng')

@section('content')
<h1 class="h2 fw-bold mb-4">Đơn hàng của tôi</h1>
<div class="bg-white border rounded-4 p-3 p-md-4">
    @forelse($orders as $order)
        <div class="d-flex flex-column flex-md-row justify-content-between gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
            <div>
                <div class="fw-bold">Mã đơn: {{ $order->order_number }}</div>
                <div class="small text-secondary mt-1">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                <div class="small mt-2">{{ $order->payment_method_label }} · {{ $order->payment_status_label }}</div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-md-end">
                    <div class="fw-bold">{{ number_format($order->total, 0, ',', '.') }}₫</div>
                    <span class="badge text-bg-light border">{{ $order->status_label }}</span>
                </div>
                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-dark btn-sm">Chi tiết</a>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <h2 class="h5">Bạn chưa có đơn hàng nào</h2>
            <a href="{{ route('store.home') }}" class="btn btn-dark rounded-pill mt-2">Bắt đầu mua sắm</a>
        </div>
    @endforelse
    <div class="mt-3">{{ $orders->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
