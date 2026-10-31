@extends('admin.layouts.main')
@section('title', 'Chi tiết đơn '.$order->order_number)

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">← Quay lại danh sách đơn</a>
        <h1 class="h3 mt-2 mb-1">Đơn hàng {{ $order->order_number }}</h1>
        <div class="text-secondary">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</div>
    </div>
    <span class="badge text-bg-light border fs-6">{{ $order->status_label }}</span>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">Sản phẩm trong đơn</div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light"><tr><th>Sản phẩm</th><th>Đơn giá</th><th>SL</th><th>Thành tiền</th></tr></thead>
                    <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}@if($item->product_color || $item->product_size)<div class="small text-secondary">Màu: {{ $item->product_color ?: '—' }} · Size: {{ $item->product_size ?: '—' }}</div>@endif</td>
                            <td>{{ number_format($item->product_price, 0, ',', '.') }}₫</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-nowrap">{{ number_format($item->line_total, 0, ',', '.') }}₫</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot><tr><th colspan="3" class="text-end">Tổng tiền</th><th>{{ number_format($order->total, 0, ',', '.') }}₫</th></tr></tfoot>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Cập nhật đơn hàng</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label">Trạng thái đơn hàng</label>
                        <select name="status" class="form-select" required>
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" @selected(old('status', $order->status) === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Khi chuyển sang “Đã hủy”, tồn kho sẽ được hoàn lại một lần.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Trạng thái thanh toán</label>
                        <select name="payment_status" class="form-select" required>
                            @foreach($paymentStatuses as $key => $label)
                                <option value="{{ $key }}" @selected(old('payment_status', $order->payment_status) === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="form-text">Chỉ đánh dấu “Đã thanh toán” sau khi kiểm tra giao dịch ngân hàng thực tế.</div>
                    </div>
                    <button class="btn btn-dark">Lưu cập nhật</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">Thông tin khách hàng</div>
            <div class="card-body">
                <p><strong>Họ tên:</strong> {{ $order->customer_name }}</p>
                <p><strong>Điện thoại:</strong> {{ $order->customer_phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                <p><strong>Email tài khoản:</strong> {{ $order->user?->email ?? 'Không còn tài khoản' }}</p>
                <p class="mb-0"><strong>Ghi chú:</strong> {{ $order->note ?: 'Không có' }}</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Thanh toán</div>
            <div class="card-body">
                <p><strong>Phương thức:</strong> {{ $order->payment_method_label }}</p>
                <p><strong>Trạng thái:</strong> {{ $order->payment_status_label }}</p>
                <p><strong>Tổng tiền:</strong> <span class="text-danger fw-bold">{{ number_format($order->total, 0, ',', '.') }}₫</span></p>
                @if($order->payment_method === 'bank_transfer')
                    <p class="small text-secondary mb-0">Đối chiếu nội dung chuyển khoản với mã đơn {{ $order->order_number }} trước khi xác nhận đã thanh toán.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
