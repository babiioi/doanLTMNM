@extends('admin.layouts.main')
@section('title', 'Sửa sản phẩm')
@section('content')
<h1 class="h3 mb-3">Cập nhật sản phẩm</h1>
<div class="card"><div class="card-body"><form method="POST" enctype="multipart/form-data" action="{{ route('admin.products.update', $product) }}">@csrf @method('PUT') @include('admin.products._form')</form></div></div>
@endsection
