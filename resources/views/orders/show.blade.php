
@extends('layouts.store')
@section('title', 'Đơn '.$order->order_number.' | Mơ Màng')

@section('content')
<style>
    .mm-order-title {
        color: #49372e;
    }

    .mm-order-card {
        background: #fff;
        border: 1px solid #eadfd5;
        border-radius: 22px;
        overflow: hidden;
    }

    .mm-order-success {
        text-align: center;
        padding: 30px 20px;
        background: #faf5ef;
        border-bottom: 1px solid #eadfd5;
    }

    .mm-order-success .mm-check {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 54px;
        height: 54px;
        border-radius: 50%;
        background: #e8efe4;
        color: #587250;
        font-size: 27px;
        margin-bottom: 12px;
    }

    .mm-qr-box {
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
        padding: 14px;
        border: 1px solid #eadfd5;
        border-radius: 18px;
        background: white;
    }

    .mm-qr-box img {
        display: block;
        width: 100%;
        height: auto;
    }

    .mm-payment-info {
        background: #fcf8f4;
        border: 1px solid #efe4db;
        border-radius: 16px;
        padding: 22px;
    }

    .mm-info-line {
        padding: 12px 0;
        border-bottom: 1px solid #e9ded5;
        overflow-wrap: anywhere;
    }

    .mm-info-line:last-child {
        border-bottom: none;
    }

    .mm-copy-btn {
        border: 1px solid #cbb7a7;
        background: white;
        color: #634d3e;
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 13px;
        cursor: pointer;
    }

    .mm-copy-btn:hover {
        background: #eee3d8;
    }

    .mm-payment-note {
        background: #faf5ef;
        border-radius: 14px;
        padding: 20px;
        color: #695548;
        line-height: 1.8;
    }
</style>

<div class="mb-4">
    <a href="{{ route('orders.index') }}"
       class="text-decoration-none text-secondary">
        ← Đơn hàng của tôi
    </a>

    <h1 class="h2 fw-bold mt-3 mm-order-title">
        Đơn hàng {{ $order->order_number }}
    </h1>

    <p class="text-secondary mb-0">
        Đặt lúc {{ $order->created_at->format('d/m/Y H:i') }}
    </p>
</div>

@if(
    $order->payment_method === 'bank_transfer'
    && $order->payment_status !== 'paid'
    && $order->status !== 'cancelled'
)
    @php
        $bankBin = config('services.vietqr.bank_bin');
        $bankAccount = config('services.vietqr.account');
        $bankName = config('services.vietqr.account_name');

        $qrUrl = $bankBin && $bankAccount
            ? 'https://img.vietqr.io/image/'
                .rawurlencode($bankBin)
                .'-'
                .rawurlencode($bankAccount)
                .'-compact2.png?amount='
                .urlencode((string) (int) $order->total)
                .'&addInfo='
                .urlencode($order->order_number)
                .'&accountName='
                .urlencode($bankName ?? '')
            : null;
    @endphp

    <div class="mm-order-card mb-4">

        <div class="mm-order-success">
            <div class="mm-check">✓</div>

            <h2 class="h4 fw-bold mm-order-title mb-2">
                Đơn hàng đã được ghi nhận!
            </h2>

            <p class="text-secondary mb-2">
                Mơ Màng cảm ơn bạn đã tin tưởng và mua sắm.
            </p>

            <div class="fw-semibold">
                Mã đơn: {{ $order->order_number }}
            </div>

            <div class="small text-secondary mt-2">
                Đơn hàng đang chờ thanh toán qua chuyển khoản.
            </div>
        </div>

        <div class="p-3 p-md-5">
            <div class="text-center mb-4">
                <h2 class="h4 fw-bold mm-order-title">
                    Thanh toán qua VietQR
                </h2>

                <p class="text-secondary mb-0">
                    Quét mã QR bằng ứng dụng ngân hàng
                    để thanh toán đơn hàng.
                </p>
            </div>

            @if($qrUrl)
                <div class="row g-4 align-items-center justify-content-center">

                    <div class="col-12 col-lg-5 text-center">
                        <div class="mm-qr-box">
                            <img src="{{ $qrUrl }}"
                                 alt="Mã VietQR thanh toán đơn hàng">
                        </div>

                        <p class="small text-secondary mt-3 mb-0">
                            Số tiền và mã đơn hàng đã được
                            điền sẵn trong mã QR.
                        </p>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="mm-payment-info">

                            <div class="mm-info-line">
                                <div class="text-secondary small mb-1">
                                    Số tiền cần thanh toán
                                </div>

                                <div class="h4 fw-bold mb-0"
                                     style="color:#b45e50;">
                                    {{ number_format($order->total, 0, ',', '.') }}₫
                                </div>
                            </div>

                            <div class="mm-info-line">
                                <div class="text-secondary small mb-1">
                                    Chủ tài khoản
                                </div>

                                <strong>{{ $bankName }}</strong>
                            </div>

                            <div class="mm-info-line">
                                <div class="text-secondary small mb-1">
                                    Số tài khoản
                                </div>

                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <strong id="bank-account">
                                        {{ $bankAccount }}
                                    </strong>

                                    <button type="button"
                                            class="mm-copy-btn"
                                            onclick="navigator.clipboard.writeText(document.getElementById('bank-account').textContent.trim())">
                                        Sao chép
                                    </button>
                                </div>
                            </div>

                            <div class="mm-info-line">
                                <div class="text-secondary small mb-1">
                                    Nội dung chuyển khoản
                                </div>

                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <strong id="transfer-note">
                                        {{ $order->order_number }}
                                    </strong>

                                    <button type="button"
                                            class="mm-copy-btn"
                                            onclick="navigator.clipboard.writeText(document.getElementById('transfer-note').textContent.trim())">
                                        Sao chép
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @else
                <div class="mm-payment-note text-center">
                    Chưa có thông tin ngân hàng để hiển thị mã QR.

                    <div class="mt-2">
                        Số tiền:
                        <strong>
                            {{ number_format($order->total, 0, ',', '.') }}₫
                        </strong>
                    </div>

                    <div>
                        Mã đơn: {{ $order->order_number }}
                    </div>
                </div>
            @endif

            <div class="mm-payment-note mt-4">
                <div class="fw-bold mb-2 mm-order-title">
                    Lưu ý khi chuyển khoản
                </div>

                <p class="mb-2">
                    Vui lòng kiểm tra đúng số tiền,
                    tài khoản nhận và nội dung chuyển khoản
                    trước khi xác nhận thanh toán.
                </p>

                <p class="mb-2">
                    Sau khi chuyển khoản thành công,
                    Mơ Màng sẽ kiểm tra và xác nhận
                    đơn hàng trong thời gian sớm nhất.
                </p>

                <p class="mb-0 fw-semibold">
                    Mơ Màng cảm ơn bạn đã tin tưởng
                    và mua sắm tại cửa hàng.
                    Chúc bạn một ngày thật vui vẻ! ☾
                </p>
            </div>

        </div>
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-7">
        <div class="bg-white border rounded-4 p-4">
            <h2 class="h5 fw-bold mb-3">
                Sản phẩm đã đặt
            </h2>

            @foreach($order->items as $item)
                <div class="d-flex justify-content-between gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div>
                        <div class="fw-semibold">
                            {{ $item->product_name }}
                        </div>

                        @if($item->product_color || $item->product_size)
                            <small class="text-secondary">
                                @if($item->product_color)
                                    Màu: {{ $item->product_color }}
                                @endif

                                @if($item->product_size)
                                    @if($item->product_color)
                                        ·
                                    @endif
                                    Size: {{ $item->product_size }}
                                @endif
                            </small>
                            <br>
                        @endif

                        <small class="text-secondary">
                            {{ number_format($item->product_price, 0, ',', '.') }}₫
                            × {{ $item->quantity }}
                        </small>
                    </div>

                    <div class="fw-semibold text-nowrap">
                        {{ number_format($item->line_total, 0, ',', '.') }}₫
                    </div>
                </div>
            @endforeach

            <hr>

            <div class="d-flex justify-content-between fw-bold fs-5">
                <span>Tổng tiền</span>
                <span>
                    {{ number_format($order->total, 0, ',', '.') }}₫
                </span>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="bg-white border rounded-4 p-4">
            <h2 class="h5 fw-bold mb-3">
                Thông tin giao hàng
            </h2>

            <p class="mb-1">
                <strong>Người nhận:</strong>
                {{ $order->customer_name }}
            </p>

            <p class="mb-1">
                <strong>Số điện thoại:</strong>
                {{ $order->customer_phone }}
            </p>

            <p class="mb-1">
                <strong>Địa chỉ:</strong>
                {{ $order->shipping_address }}
            </p>

            @if($order->note)
                <p class="mb-1">
                    <strong>Ghi chú:</strong>
                    {{ $order->note }}
                </p>
            @endif

            <hr>

            <p class="mb-2">
                <strong>Trạng thái đơn:</strong>
                {{ $order->status_label }}
            </p>

            <p class="mb-2">
                <strong>Thanh toán:</strong>
                {{ $order->payment_method_label }}
            </p>

            <p class="mb-0">
                <strong>Trạng thái thanh toán:</strong>
                {{ $order->payment_status_label }}
            </p>
        </div>
    </div>
</div>
@endsection
