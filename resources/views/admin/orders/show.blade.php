@extends('admin.layouts.main')

@section('title', 'Chi tiết đơn '.$order->order_number)

@section('content')
<div class="container-fluid px-0">

    {{-- Tiêu đề --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <a href="{{ route('admin.orders.index') }}"
               class="text-decoration-none text-secondary small">
                <i class="bi bi-arrow-left"></i> Quay lại danh sách đơn
            </a>

            <h1 class="page-heading mt-2 mb-1">
                Đơn hàng {{ $order->order_number }}
            </h1>

            <div class="text-secondary small">
                Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}
            </div>
        </div>

        <span class="badge text-bg-light border px-3 py-2">
            {{ $order->status_label }}
        </span>
    </div>

    <div class="row g-4">

        {{-- CỘT TRÁI --}}
        <div class="col-lg-7">

            {{-- Sản phẩm --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white border-0 p-3">
                    <h5 class="fw-bold mb-0">Sản phẩm trong đơn</h5>
                </div>

                <div class="order-detail-table-wrapper">
                    <table class="table table-hover align-middle mb-0 order-detail-table">
                        <thead class="table-light">
                            <tr>
                                <th>Ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>SL</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        @if($item->product?->image)
                                            <img
                                                src="{{ asset('storage/' . $item->product->image) }}"
                                                alt="{{ $item->product_name }}"
                                                class="order-product-thumbnail"
                                            >
                                        @else
                                            <div class="order-no-image">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="order-product-name">
                                            {{ $item->product_name }}
                                        </div>

                                        @if($item->product_color || $item->product_size)
                                            <small class="text-secondary">
                                                Màu: {{ $item->product_color ?: '—' }}
                                                <br>
                                                Size: {{ $item->product_size ?: '—' }}
                                            </small>
                                        @endif
                                    </td>

                                    <td class="text-nowrap">
                                        {{ number_format($item->product_price, 0, ',', '.') }} đ
                                    </td>

                                    <td>
                                        {{ $item->quantity }}
                                    </td>

                                    <td class="text-nowrap fw-semibold">
                                        {{ number_format($item->line_total, 0, ',', '.') }} đ
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Tổng kết đơn hàng --}}
                <div class="card-body border-top">
                    <div class="order-summary">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary">Tạm tính</span>
                            <span>
                                {{ number_format($order->subtotal, 0, ',', '.') }} đ
                            </span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary">Phí vận chuyển</span>
                            <span>
                                {{ number_format($order->shipping_fee ?? 0, 0, ',', '.') }} đ
                            </span>
                        </div>

                        @if($order->discount_amount > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary">
                                    Giảm giá
                                    @if($order->discount_code)
                                        <small class="text-success">
                                            ({{ $order->discount_code }})
                                        </small>
                                    @endif
                                </span>

                                <span class="text-success">
                                    -{{ number_format($order->discount_amount, 0, ',', '.') }} đ
                                </span>
                            </div>
                        @endif

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Tổng thanh toán</span>
                            <span class="fs-5 fw-bold text-danger">
                                {{ number_format($order->total, 0, ',', '.') }} đ
                            </span>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Cập nhật đơn hàng --}}
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-0 p-3">
                    <h5 class="fw-bold mb-0">Cập nhật đơn hàng</h5>
                </div>

                <div class="card-body">
                    <form method="POST"
                          action="{{ route('admin.orders.update', $order) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Trạng thái đơn hàng
                            </label>

                            <select name="status" class="form-select" required>
                                @foreach($statuses as $key => $label)
                                    <option value="{{ $key }}"
                                        @selected(old('status', $order->status) === $key)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="form-text">
                                Khi chuyển sang “Đã hủy”, tồn kho sẽ được hoàn lại một lần.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Trạng thái thanh toán
                            </label>

                            <select name="payment_status" class="form-select" required>
                                @foreach($paymentStatuses as $key => $label)
                                    <option value="{{ $key }}"
                                        @selected(old('payment_status', $order->payment_status) === $key)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="form-text">
                                Chỉ đánh dấu “Đã thanh toán” sau khi kiểm tra giao dịch ngân hàng thực tế.
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark px-4">
                            <i class="bi bi-check-lg me-1"></i>
                            Lưu cập nhật
                        </button>
                    </form>
                </div>
            </div>

        </div>

        {{-- CỘT PHẢI --}}
        <div class="col-lg-5">

            {{-- Thông tin khách hàng --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white border-0 p-3">
                    <h5 class="fw-bold mb-0">Thông tin khách hàng</h5>
                </div>

                <div class="card-body">
                    <div class="info-row">
                        <span>Họ tên</span>
                        <strong>{{ $order->customer_name }}</strong>
                    </div>

                    <div class="info-row">
                        <span>Điện thoại</span>
                        <strong>{{ $order->customer_phone }}</strong>
                    </div>

                    <div class="info-row">
                        <span>Địa chỉ</span>
                        <strong>{{ $order->shipping_address }}</strong>
                    </div>

                    <div class="info-row">
                        <span>Email tài khoản</span>
                        <strong>{{ $order->user?->email ?? 'Không còn tài khoản' }}</strong>
                    </div>

                    <div class="info-row mb-0">
                        <span>Ghi chú</span>
                        <strong>{{ $order->note ?: 'Không có' }}</strong>
                    </div>
                </div>
            </div>

            {{-- Thông tin thanh toán --}}
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-0 p-3">
                    <h5 class="fw-bold mb-0">Thông tin thanh toán</h5>
                </div>

                <div class="card-body">
                    <div class="info-row">
                        <span>Phương thức</span>
                        <strong>{{ $order->payment_method_label }}</strong>
                    </div>

                    <div class="info-row">
                        <span>Trạng thái</span>
                        <strong>{{ $order->payment_status_label }}</strong>
                    </div>

                    @if($order->payment_method === 'bank_transfer')
                        <div class="alert alert-light border small mb-0">
                            Đối chiếu nội dung chuyển khoản với mã đơn
                            <strong>{{ $order->order_number }}</strong>
                            trước khi xác nhận đã thanh toán.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    
    .order-detail-table-wrapper {
        width: 100%;
        max-width: 100%;
    }

    .order-detail-table {
        width: 100%;
        table-layout: fixed;
        margin-bottom: 0;
    }

    .order-detail-table th,
    .order-detail-table td {
        padding: 10px 5px;
        text-align: center;
        vertical-align: middle;
        overflow-wrap: anywhere;
        font-size: 13px;
    }

    .order-detail-table thead th {
        font-weight: 700;
        white-space: normal;
    }

    /* Ảnh */
    .order-detail-table th:nth-child(1),
    .order-detail-table td:nth-child(1) {
        width: 15% !important;
    }

    /* Tên sản phẩm */
    .order-detail-table th:nth-child(2),
    .order-detail-table td:nth-child(2) {
        width: 27%;
    }

    /* Đơn giá */
    .order-detail-table th:nth-child(3),
    .order-detail-table td:nth-child(3) {
        width: 18% !important;
    }

    /* Số lượng */
    .order-detail-table th:nth-child(4),
    .order-detail-table td:nth-child(4) {
        width: 10%;
    }

    /* Thành tiền */
    .order-detail-table th:nth-child(5),
    .order-detail-table td:nth-child(5) {
        width: 30%;
    }

    .order-product-thumbnail {
        display: block;
        width: 50px;
        height: 50px;
        max-width: 100%;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e5e5e5;
        margin: 0 auto;
    }

    .order-no-image {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f5f5f5;
        color: #999;
        border-radius: 8px;
        margin: 0 auto;
    }

    .order-product-name {
        font-weight: 600;
        color: #333;
    }

    .order-summary {
        max-width: 420px;
        margin-left: auto;
    }

    /* Thông tin khách hàng và thanh toán */
    .info-row {
        display: flex;
        flex-direction: column;
        gap: 5px;
        padding: 12px 0;
        border-bottom: 1px solid #eeeeee;
    }

    .info-row span {
        color: #777;
        font-size: 13px;
    }

    .info-row strong {
        color: #333;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    @media (max-width: 576px) {
        .order-summary {
            max-width: 100%;
        }
    }
</style>
@endsection
