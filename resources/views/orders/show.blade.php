@extends('layouts.store')
@section('title', 'Đơn '.$order->order_number.' | Mơ Màng')

@section('content')
<div class="mb-4">
    <a href="{{ route('orders.index') }}" class="text-decoration-none text-secondary">← Đơn hàng của tôi</a>
    <h1 class="h2 fw-bold mt-3">Đơn hàng {{ $order->order_number }}</h1>
    <p class="text-secondary mb-0">Đặt lúc {{ $order->created_at->format('d/m/Y H:i') }}</p>
</div>

@if($order->payment_method === 'bank_transfer' && $order->payment_status !== 'paid' && $order->status !== 'cancelled')
    @php
        $bankBin = config('services.vietqr.bank_bin');
        $bankAccount = config('services.vietqr.account');
        $bankName = config('services.vietqr.account_name');
        $qrUrl = $bankBin && $bankAccount
            ? 'https://img.vietqr.io/image/'.rawurlencode($bankBin).'-'.rawurlencode($bankAccount).'-compact2.png?amount='.urlencode((string) (int) $order->total).'&addInfo='.urlencode($order->order_number).'&accountName='.urlencode($bankName ?? '')
            : null;
    @endphp
    <div class="alert alert-info">
        <strong>Hướng dẫn chuyển khoản</strong><br>
        Vui lòng quét mã bằng ứng dụng ngân hàng và kiểm tra đúng số tiền, số tài khoản, nội dung chuyển khoản trước khi xác nhận. Sau khi ngân hàng báo chuyển thành công, cửa hàng sẽ kiểm tra và cập nhật trạng thái thủ công.
        <br><small>Không đóng trang trước khi lưu lại mã đơn: {{ $order->order_number }}</small>
    </div>
    <div class="bg-white border rounded-4 p-4 mb-4">
        @if($qrUrl)
            <div class="row align-items-center g-4">
                <div class="col-md-4 text-center">
                    <img src="{{ $qrUrl }}" alt="Mã QR chuyển khoản" class="img-fluid" style="max-width:280px">
                </div>
                <div class="col-md-8">
                    <h2 class="h5 fw-bold">Quét mã QR để thanh toán</h2>
                    <p class="mb-1">Số tiền: <strong class="text-danger">{{ number_format($order->total, 0, ',', '.') }}₫</strong></p>
                    <p class="mb-1">Mã ngân hàng (BIN): {{ $bankBin }}</p>
                    <p class="mb-1">Chủ tài khoản: {{ $bankName }}</p><p class="mb-1">Số tài khoản: <strong id="bank-account">{{ $bankAccount }}</strong> <button type="button" class="btn btn-outline-secondary btn-sm" onclick="navigator.clipboard.writeText(document.getElementById('bank-account').textContent)">Sao chép</button></p>
                    <p class="mb-0">Nội dung chuyển khoản: <strong id="transfer-note">Thanh toan {{ $order->order_number }}</strong> <button type="button" class="btn btn-outline-secondary btn-sm" onclick="navigator.clipboard.writeText(document.getElementById('transfer-note').textContent)">Sao chép</button></p>
                </div>
                <div class="mt-3 p-3 rounded-3" style="background:#fff9f5; border:1px solid #f0e5dc;">
                    <h3 class="h6 fw-bold mb-2">Thanh toán qua VietQR</h3>
                    <p class="mb-2">Quét mã QR bằng ứng dụng ngân hàng để thanh toán đơn hàng. Số tiền và nội dung chuyển khoản đã được điền sẵn.</p>
                    <p class="mb-2">Sau khi chuyển khoản thành công, Mơ Màng sẽ kiểm tra và xác nhận đơn hàng trong thời gian sớm nhất.</p>
                    <p class="mb-0 fw-semibold">Mơ Màng cảm ơn bạn đã tin tưởng và mua sắm tại cửa hàng. Chúc bạn một ngày thật vui vẻ!</p>
                </div>
            </div>
        @else
            <p class="mb-2">Bạn cần cấu hình thông tin ngân hàng trong file <code>.env</code> để hiển thị mã QR.</p>
            <p class="mb-1">Số tiền: <strong>{{ number_format($order->total, 0, ',', '.') }}₫</strong></p>
            <p class="mb-0">Nội dung chuyển khoản: <strong>Thanh toan {{ $order->order_number }}</strong></p>
        @endif
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-7">
        <div class="bg-white border rounded-4 p-4">
            <h2 class="h5 fw-bold mb-3">Sản phẩm đã đặt</h2>
            @foreach($order->items as $item)
                <div class="d-flex justify-content-between gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div>
                        <div class="fw-semibold">{{ $item->product_name }}</div>
                        @if($item->product_color || $item->product_size)<small class="text-secondary">Màu: {{ $item->product_color ?: '—' }} · Size: {{ $item->product_size ?: '—' }}</small><br>@endif
                        <small class="text-secondary">{{ number_format($item->product_price, 0, ',', '.') }}₫ × {{ $item->quantity }}</small>
                    </div>
                    <div class="fw-semibold text-nowrap">{{ number_format($item->line_total, 0, ',', '.') }}₫</div>
                </div>
            @endforeach
            <hr>
            <div class="d-flex justify-content-between fw-bold fs-5">
                <span>Tổng tiền</span><span>{{ number_format($order->total, 0, ',', '.') }}₫</span>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="bg-white border rounded-4 p-4">
            <h2 class="h5 fw-bold mb-3">Thông tin giao hàng</h2>
            <p class="mb-1"><strong>Người nhận:</strong> {{ $order->customer_name }}</p>
            <p class="mb-1"><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</p>
            <p class="mb-1"><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
            @if($order->note)<p class="mb-1"><strong>Ghi chú:</strong> {{ $order->note }}</p>@endif
            <hr>
            <p class="mb-2"><strong>Trạng thái đơn:</strong> {{ $order->status_label }}</p>
            <p class="mb-2"><strong>Thanh toán:</strong> {{ $order->payment_method_label }}</p>
            <p class="mb-0"><strong>Trạng thái thanh toán:</strong> {{ $order->payment_status_label }}</p>
        </div>
    </div>
</div>
@endsection
