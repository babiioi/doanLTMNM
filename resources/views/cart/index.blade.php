
@extends('layouts.store')
@section('title', 'Giỏ hàng | Mơ Màng')

@section('content')
<div class="mb-4">
    <a href="{{ route('store.home') }}" class="text-decoration-none text-secondary">
        ← Tiếp tục mua sắm
    </a>
    <h1 class="h2 fw-bold mt-3">Giỏ hàng của bạn</h1>
</div>

@if($items->isEmpty())
    <div class="bg-white border rounded-4 text-center p-5">
        <div class="display-4 mb-3">🛍</div>
        <h2 class="h4">Giỏ hàng đang trống</h2>
        <p class="text-secondary">Chọn một vài món đồ bạn yêu thích nhé.</p>
        <a href="{{ route('store.home') }}"
           class="btn btn-dark rounded-pill px-4">
            Mua sắm ngay
        </a>
    </div>
@else

    <form id="selectedCheckoutForm"
          method="POST"
          action="{{ route('cart.checkout-selected') }}">
        @csrf
    </form>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="bg-white border rounded-4 p-3 p-md-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <strong>Chọn sản phẩm muốn mua</strong>

                    <button type="button"
                            id="selectAll"
                            class="btn btn-sm btn-outline-dark">
                        Chọn tất cả
                    </button>
                </div>

                @foreach($items as $item)
                    <div class="d-flex gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">

                        {{-- Checkbox chọn sản phẩm --}}
                        <div class="d-flex align-items-start pt-2">
                            <input type="checkbox"
                                   class="form-check-input product-checkbox"
                                   form="selectedCheckoutForm"
                                   name="selected[]"
                                   value="{{ $item['key'] }}"
                                   data-price="{{ $item['product']->price }}"
                                   data-quantity="{{ $item['quantity'] }}"
                                   style="width:20px;height:20px">
                        </div>

                        {{-- Hình ảnh sản phẩm --}}
                        @php
                            $image = $item['image'] ?? $item['product']->image;
                        @endphp

                        @if($image)
                            <img src="{{ asset('storage/'.$image) }}"
                                 alt="{{ $item['product']->name }}"
                                 style="width:100px;height:120px;object-fit:cover"
                                 class="rounded-3">
                        @else
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center"
                                 style="width:100px;height:120px">
                                MƠ MÀNG
                            </div>
                        @endif

                        <div class="flex-grow-1">

                            <a class="text-dark fw-semibold text-decoration-none"
                               href="{{ route('store.products.show', $item['product']) }}">
                                {{ $item['product']->name }}
                            </a>

                            {{-- Thông tin biến thể --}}
                            <div class="text-secondary small mt-1">
                                @if($item['variant'])
                                    Màu: {{ $item['variant']->color }}
                                    · Size: {{ $item['size'] }}
                                @else
                                    Size: {{ $item['size'] ?: '—' }}
                                @endif

                                · Còn {{ $item['stock'] }} sản phẩm
                            </div>

                            <div class="fw-bold mt-2">
                                {{ number_format($item['product']->price, 0, ',', '.') }}₫
                            </div>

                            <div class="d-flex flex-wrap align-items-center gap-2 mt-3">

                                {{-- Cập nhật số lượng --}}
                                <form method="POST"
                                      action="{{ route('cart.items.update', $item['key']) }}"
                                      class="d-flex gap-2">
                                    @csrf
                                    @method('PATCH')

                                    <input type="number"
                                           name="quantity"
                                           min="1"
                                           max="{{ max(1, $item['stock']) }}"
                                           value="{{ $item['quantity'] }}"
                                           class="form-control form-control-sm"
                                           style="width:80px">

                                    <button class="btn btn-outline-dark btn-sm">
                                        Cập nhật
                                    </button>
                                </form>

                                {{-- Xóa sản phẩm --}}
                                <form method="POST"
                                      action="{{ route('cart.items.destroy', $item['key']) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-link btn-sm text-danger text-decoration-none">
                                        Xóa
                                    </button>
                                </form>

                            </div>
                        </div>

                        {{-- Thành tiền --}}
                        <div class="fw-bold text-nowrap">
                            {{ number_format($item['line_total'], 0, ',', '.') }}₫
                        </div>

                    </div>
                @endforeach

            </div>
        </div>

        {{-- Tóm tắt đơn hàng --}}
        <div class="col-lg-4">
            <div class="bg-white border rounded-4 p-4">
                <h2 class="h5 fw-bold mb-3">Tóm tắt đơn hàng</h2>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Sản phẩm đã chọn</span>
                    <span id="selectedCount">0</span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Tạm tính</span>
                    <strong id="selectedTotal">0₫</strong>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span class="text-secondary">Phí vận chuyển</span>
                    <span>Tính tại bước thanh toán</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                    <span>Tổng cộng</span>
                    <span class="text-danger" id="selectedGrandTotal">0₫</span>
                </div>

                <button type="submit"
                        form="selectedCheckoutForm"
                        id="checkoutButton"
                        class="btn btn-dark w-100 rounded-pill py-3"
                        disabled>
                    Thanh toán sản phẩm đã chọn
                </button>

                <p class="small text-secondary mt-3 mb-0">
                    Sản phẩm không được chọn vẫn sẽ nằm trong giỏ hàng.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            const selectAll = document.getElementById('selectAll');
            const selectedCount = document.getElementById('selectedCount');
            const selectedTotal = document.getElementById('selectedTotal');
            const selectedGrandTotal = document.getElementById('selectedGrandTotal');
            const checkoutButton = document.getElementById('checkoutButton');

            function updateSummary() {
                let count = 0;
                let total = 0;

                checkboxes.forEach(function (checkbox) {
                    if (checkbox.checked) {
                        count++;
                        total += Number(checkbox.dataset.price) *
                                 Number(checkbox.dataset.quantity);
                    }
                });

                const formatted = total.toLocaleString('vi-VN') + '₫';

                selectedCount.textContent = count;
                selectedTotal.textContent = formatted;
                selectedGrandTotal.textContent = formatted;
                checkoutButton.disabled = count === 0;

                const allChecked = [...checkboxes].every(cb => cb.checked);

                selectAll.textContent = allChecked
                    ? 'Bỏ chọn tất cả'
                    : 'Chọn tất cả';
            }

            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', updateSummary);
            });

            selectAll.addEventListener('click', function () {
                const allChecked = [...checkboxes].every(cb => cb.checked);

                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = !allChecked;
                });

                updateSummary();
            });

            updateSummary();
        });
    </script>

@endif
@endsection
