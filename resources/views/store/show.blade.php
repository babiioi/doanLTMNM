@extends('layouts.store')
@section('title', $product->name)

@section('content')
<a href="{{ route('store.home') }}" class="text-secondary text-decoration-none">← Quay lại sản phẩm</a>
<div class="row g-4 mt-2">
    <div class="col-md-6">
        @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded-4 w-100" alt="{{ $product->name }}">
        @else
            <div class="rounded-4 bg-light d-flex align-items-center justify-content-center" style="height:420px">FASHION STORE</div>
        @endif
    </div>
    <div class="col-md-6 py-md-4">
        <div class="text-secondary">{{ $product->category?->name }}</div>
        <h1 class="display-6 fw-bold mt-2">{{ $product->name }}</h1>
        <p class="price fs-3">{{ number_format($product->price, 0, ',', '.') }}₫</p>
        <p>{{ $product->description ?: 'Sản phẩm thời trang dành cho phong cách hằng ngày.' }}</p>
        <p class="text-secondary">Tình trạng: {{ $product->stock > 0 ? 'Còn '.$product->stock.' sản phẩm' : 'Tạm hết hàng' }}</p>

        @if($product->stock > 0)
            <form method="POST" action="{{ route('cart.store', $product) }}" class="d-flex flex-wrap align-items-end gap-3 mt-4">
                @csrf
                <div>
                    <label for="quantity" class="form-label">Số lượng</label>
                    <input id="quantity" type="number" name="quantity" value="1" min="1"
                           max="{{ min(99, $product->stock) }}" class="form-control" style="width:100px" required>
                </div>
                <button class="btn btn-dark btn-lg rounded-pill px-4">Thêm vào giỏ hàng</button>
            </form>
        @else
            <button class="btn btn-secondary btn-lg" disabled>Hết hàng</button>
        @endif
    </div>
</div>
@endsection
