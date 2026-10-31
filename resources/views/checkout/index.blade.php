@extends('layouts.store')
@section('title', 'Đặt hàng | Mơ Màng')

@section('content')
<div class="mb-4">
    <a href="{{ route('cart.index') }}" class="text-decoration-none text-secondary">← Quay lại giỏ hàng</a>
    <h1 class="h2 fw-bold mt-3">Thông tin đặt hàng</h1>
    <p class="text-secondary">Kiểm tra thông tin nhận hàng và chọn phương thức thanh toán.</p>
</div>

<form method="POST" action="{{ route('checkout.store') }}">
    @csrf
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="bg-white border rounded-4 p-4">
                <h2 class="h5 fw-bold mb-3">Thông tin người nhận</h2>

                <div class="mb-3">
                    <label class="form-label">Họ và tên *</label>
                    <input name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}"
                           class="form-control @error('customer_name') is-invalid @enderror" required maxlength="120">
                    @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Số điện thoại *</label>
                    <input name="customer_phone" value="{{ old('customer_phone') }}"
                           class="form-control @error('customer_phone') is-invalid @enderror"
                           required maxlength="30" placeholder="Ví dụ: 0901234567">
                    @error('customer_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Địa chỉ nhận hàng *</label>
                    <textarea name="shipping_address" rows="3"
                              class="form-control @error('shipping_address') is-invalid @enderror"
                              required maxlength="500" placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành">{{ old('shipping_address') }}</textarea>
                    @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Ghi chú đơn hàng (không bắt buộc)</label>
                    <textarea name="note" rows="2" class="form-control" maxlength="2000"
                              placeholder="Ví dụ: giao giờ hành chính">{{ old('note') }}</textarea>
                </div>

                <h2 class="h5 fw-bold mb-3">Phương thức thanh toán</h2>
                <label class="border rounded-3 p-3 d-flex gap-3 mb-2 w-100">
                    <input type="radio" name="payment_method" value="cod"
                           @checked(old('payment_method', 'cod') === 'cod') required>
                    <span><strong>Thanh toán khi nhận hàng (COD)</strong><br>
                        <small class="text-secondary">Thanh toán cho đơn vị giao hàng khi nhận được sản phẩm.</small></span>
                </label>
                <label class="border rounded-3 p-3 d-flex gap-3 w-100">
                    <input type="radio" name="payment_method" value="bank_transfer"
                           @checked(old('payment_method') === 'bank_transfer') required>
                    <span><strong>Chuyển khoản ngân hàng bằng QR</strong><br>
                        <small class="text-secondary">Sau khi đặt hàng, quét QR bằng ứng dụng ngân hàng để chuyển khoản. Cửa hàng sẽ đối soát và xác nhận thủ công.</small></span>
                </label>
                @error('payment_method')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="col-lg-5">
            <div class="bg-white border rounded-4 p-4">
                <h2 class="h5 fw-bold mb-3">Đơn hàng của bạn</h2>
                @foreach($items as $item)
                    <div class="d-flex justify-content-between gap-3 mb-3">
                        <div>
                            <div class="fw-semibold">{{ $item['product']->name }}</div>
                            @if($item['variant'])<small class="text-secondary">Màu: {{ $item['variant']->color }} · Size: {{ $item['size'] }}<br></small>@else<small class="text-secondary">Size: {{ $item['size'] ?: '—' }}<br></small>@endif
                            <small class="text-secondary">Số lượng: {{ $item['quantity'] }}</small>
                        </div>
                        <div class="text-nowrap">{{ number_format($item['line_total'], 0, ',', '.') }}₫</div>
                    </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Tổng cộng</span>
                    <span class="text-danger">{{ number_format($total, 0, ',', '.') }}₫</span>
                </div>
                <button type="submit" class="btn btn-dark w-100 rounded-pill py-3 mt-4">Xác nhận đặt hàng</button>
                <p class="small text-secondary mt-3 mb-0">Tồn kho sẽ được kiểm tra lại trước khi đơn hàng được tạo.</p>
            </div>
        </div>
    </div>
</form>
@endsection
