@extends('admin.layouts.main')
@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="h3 mb-1">Quản lý đơn hàng</h1>
        <p class="text-secondary mb-0">Theo dõi đơn hàng, thanh toán và giao hàng.</p>
    </div>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-6">
        <input class="form-control" name="q" value="{{ request('q') }}" placeholder="Tìm mã đơn, tên hoặc số điện thoại">
    </div>
    <div class="col-md-3">
        <select class="form-select" name="status">
            <option value="">Tất cả trạng thái</option>
            @foreach(\App\Models\Order::STATUSES as $key => $label)
                <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 d-flex gap-2">
        <button class="btn btn-dark">Lọc</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Xóa lọc</a>
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
            <tr>
                <th>Mã đơn</th><th>Khách hàng</th><th>Ngày đặt</th><th>Thanh toán</th><th>Tổng tiền</th><th>Trạng thái</th><th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($orders as $order)
                <tr>
                    <td class="fw-semibold">{{ $order->order_number }}</td>
                    <td>{{ $order->customer_name }}<br><small class="text-secondary">{{ $order->customer_phone }}</small></td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $order->payment_method_label }}<br><small class="text-secondary">{{ $order->payment_status_label }}</small></td>
                    <td class="text-nowrap">{{ number_format($order->total, 0, ',', '.') }}₫</td>
                    <td><span class="badge text-bg-light border">{{ $order->status_label }}</span></td>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-dark">Chi tiết</a></td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-secondary py-5">Chưa có đơn hàng nào.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $orders->links('pagination::bootstrap-5') }}</div>
@endsection
