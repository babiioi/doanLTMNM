@extends('layouts.store')
@section('title', ($pageTitle ?? 'Sản phẩm') . ' - Mơ Màng')
@section('content')
<div class="mb-4"><h1 class="h2 fw-bold">{{ $pageTitle ?? 'Tất cả sản phẩm' }}</h1><p class="text-secondary">Tìm thiết kế phù hợp với phong cách của bạn.</p></div>
<form method="GET" action="{{ route('store.products.index') }}" class="row g-2 mb-4">
    <div class="col-md-6"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm quần áo..."></div>
    <div class="col-md-4"><select class="form-select" name="category_id"><option value="">Tất cả danh mục</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>@endforeach</select></div>
    @if(request()->filled('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
    @if(request()->filled('collection'))<input type="hidden" name="collection" value="{{ request('collection') }}">@endif
    <div class="col-md-2 d-grid"><button class="btn btn-dark">Tìm kiếm</button></div>
</form>
<div class="d-flex justify-content-between align-items-end mb-3"><h2 class="h4">Sản phẩm</h2><span class="text-secondary small">{{ $products->total() }} sản phẩm</span></div>
@include('store.partials.product-grid', ['products' => $products])
<div class="mt-4">{{ $products->links('pagination::bootstrap-5') }}</div>
@endsection
