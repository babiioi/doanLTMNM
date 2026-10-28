@extends('admin.layouts.main')
@section('title', 'Thêm sản phẩm')
@section('content')
<h1 class="h3 mb-3">Thêm sản phẩm</h1>
<div class="card"><div class="card-body"><form method="POST" enctype="multipart/form-data" action="{{ route('admin.products.store') }}">@csrf @include('admin.products._form')</form></div></div>
@endsection
