@extends('layouts.store')
@section('title', 'Giỏ hàng | Mơ Màng')

@section('content')
<div class="mb-4">
    <a href="{{ route('store.home') }}" class="text-decoration-none text-secondary">← Tiếp tục mua sắm</a>
    <h1 class="h2 fw-bold mt-3">Giỏ hàng của bạn</h1>
</div>

@if($items->isEmpty())
    <div class="bg-white border rounded-4 text-center p-5">
        <div class="display-4 mb-3">🛍</div>
        <h2 class="h4">Giỏ hàng đang trống</h2>
        <p class="text-secondary">Chọn một vài món đồ bạn yêu thích nhé.</p>
        <a href="{{ route('store.home') }}" class="btn btn-dark rounded-pill px-4">Mua sắm ngay</a>
    </div>
@else
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="bg-white border rounded-4 p-3 p-md-4">
                @foreach($items as $item)
                    <div class="d-flex gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        @if($item['image'])
                            <img src="{{ asset('storage/'.$item['image']) }}" alt="{{ $item['product']->name }}"
                                 style="width:100px;height:120px;object-fit:cover" class="rounded-3">
                        @else
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center"
                                 style="width:100px;height:120px">MƠ MÀNG</div>
                        @endif

                        <div class="flex-grow-1">
                            <a class="text-dark fw-semibold text-decoration-none"
                               href="{{ route('store.products.show', $item['product']) }}">
                                {{ $item['product']->name }}
                            </a>
                            <div class="text-secondary small mt-1">@if($item['variant']) Màu: {{ $item['variant']->color }} · Size: {{ $item['size'] }} · Còn {{ $item['stock'] }} sản phẩm @else Size: {{ $item['size'] ?: "—" }} · Còn {{ $item['stock'] }} sản phẩm @endif</div>
                            <div class="fw-bold mt-2">{{ number_format($item['product']->price, 0, ',', '.') }}₫</div>
                            <div class="d-flex flex-wrap align-items-center gap-2 mt-3">
                                <form method="POST" action="{{ route('cart.items.update', $item['key']) }}" class="d-flex gap-2">
                                    @csrf @method('PATCH')
                                    <input type="number" name="quantity" min="1" max="{{ max(1, $item['stock']) }}"
                                           value="{{ $item['quantity'] }}" class="form-control form-control-sm" style="width:80px">
                                    <button class="btn btn-outline-dark btn-sm">Cập nhật</button>
                                </form>
                                <form method="POST" action="{{ route('cart.items.destroy', $item['key']) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-link btn-sm text-danger text-decoration-none">Xóa</button>
                                </form>
                            </div>
                        </div>

                        <div class="fw-bold text-nowrap">
                            {{ number_format($item['line_total'], 0, ',', '.') }}₫
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-lg-4">
            <div class="bg-white border rounded-4 p-4">
                <h2 class="h5 fw-bold mb-3">Tóm tắt đơn hàng</h2>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Tạm tính</span>
                    <span>{{ number_format($total, 0, ',', '.') }}₫</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-secondary">Phí vận chuyển</span><span>Liên hệ / 0₫</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                    <span>Tổng cộng</span><span class="text-danger">{{ number_format($total, 0, ',', '.') }}₫</span>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn btn-dark w-100 rounded-pill py-3">Tiến hành đặt hàng</a>
                <p class="small text-secondary mt-3 mb-0">Bạn cần đăng nhập trước khi xác nhận đơn hàng.</p>
            </div>
        </div>
    </div>
@endif
@endsection
