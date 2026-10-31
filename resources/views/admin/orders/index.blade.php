```blade
@extends('admin.layouts.main')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="page-heading mb-0">Đơn hàng</h1>
</div>

{{-- Tìm kiếm và lọc đơn hàng --}}
<form class="row g-2 mb-4" method="GET">
    <div class="col-md-4">
        <input
            class="form-control"
            name="q"
            value="{{ request('q') }}"
            placeholder="Tìm mã đơn, tên hoặc số điện thoại"
        >
    </div>

    <div class="col-md-3">
        <select class="form-select" name="status">
            <option value="">Tất cả trạng thái</option>

            @foreach(\App\Models\Order::STATUSES as $key => $label)
                <option
                    value="{{ $key }}"
                    @selected(request('status') === $key)
                >
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-auto">
        <button class="btn btn-outline-dark" type="submit">
            <i class="bi bi-funnel"></i> Lọc
        </button>

        <a href="{{ route('admin.orders.index') }}"
           class="btn btn-outline-secondary">
            Xóa lọc
        </a>
    </div>
</form>

{{-- Bảng đơn hàng --}}
<div class="table-responsive bg-white rounded shadow-sm order-table-wrapper">
    <table class="table table-hover align-middle mb-0 order-table">
        <thead class="table-light">
            <tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Thanh toán</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>

        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td class="fw-semibold">
                        {{ $order->order_number }}
                    </td>

                    <td>
                        <div class="fw-semibold">
                            {{ $order->customer_name }}
                        </div>
                        <small class="text-secondary">
                            {{ $order->customer_phone }}
                        </small>
                    </td>

                    <td>
                        {{ $order->created_at->format('d/m/Y') }}
                        <br>
                        <small class="text-secondary">
                            {{ $order->created_at->format('H:i') }}
                        </small>
                    </td>

                    <td>
                        {{ $order->payment_method_label }}
                        <br>
                        <small class="text-secondary">
                            {{ $order->payment_status_label }}
                        </small>
                    </td>

                    <td class="text-nowrap fw-semibold">
                        {{ number_format($order->total, 0, ',', '.') }} đ
                    </td>

                    <td>
                        <span class="badge text-bg-light border">
                            {{ $order->status_label }}
                        </span>
                    </td>

                    <td class="text-nowrap">
                        <a
                            class="btn btn-sm btn-outline-primary action-icon"
                            href="{{ route('admin.orders.show', $order) }}"
                            title="Xem chi tiết"
                            aria-label="Xem chi tiết"
                        >
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4">
                        Chưa có đơn hàng.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Phân trang --}}
<div class="mt-3">
    {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
</div>

<style>
    /* Khung bảng */
    .order-table-wrapper {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
    }

    /* Bảng */
    .order-table {
        width: 100%;
        min-width: 950px;
        table-layout: fixed;
        margin-bottom: 0;
    }

    .order-table th,
    .order-table td {
        padding: 12px 8px;
        text-align: center;
        vertical-align: middle;
        overflow-wrap: break-word;
        font-size: 14px;
    }

    .order-table thead th {
        font-weight: 700;
        white-space: nowrap;
    }

    /* Mã đơn */
    .order-table th:nth-child(1),
    .order-table td:nth-child(1) {
        width: 13% !important;
    }

    /* Khách hàng */
    .order-table th:nth-child(2),
    .order-table td:nth-child(2) {
        width: 19% !important;
    }

    /* Ngày đặt */
    .order-table th:nth-child(3),
    .order-table td:nth-child(3) {
        width: 13% !important;
        white-space: nowrap;
    }

    /* Thanh toán */
    .order-table th:nth-child(4),
    .order-table td:nth-child(4) {
        width: 15% !important;
    }

    /* Tổng tiền */
    .order-table th:nth-child(5),
    .order-table td:nth-child(5) {
        width: 14% !important;
        white-space: nowrap;
    }

    /* Trạng thái */
    .order-table th:nth-child(6),
    .order-table td:nth-child(6) {
        width: 14% !important;
    }

    /* Thao tác */
    .order-table th:nth-child(7),
    .order-table td:nth-child(7) {
        width: 12% !important;
        white-space: nowrap;
    }

    /* Nút xem chi tiết */
    .order-table .action-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection
