@extends('layouts.store')
@section('title', 'Sản phẩm yêu thích - Mơ Màng')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-4"><h1 class="h3 mb-0">♡ Sản phẩm yêu thích</h1><a href="{{ route('store.products.index') }}" class="btn btn-outline-dark btn-sm">Tiếp tục mua sắm</a></div>
@if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
@include('store.partials.product-grid', ['products' => $products])
@endsection
