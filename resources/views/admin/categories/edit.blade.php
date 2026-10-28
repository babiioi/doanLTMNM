@extends('admin.layouts.main')
@section('title', 'Sửa danh mục')
@section('content')
<h1 class="h3 mb-3">Cập nhật danh mục</h1>
<div class="card"><div class="card-body"><form method="POST" action="{{ route('admin.categories.update', $category) }}">@csrf @method('PUT') @include('admin.categories._form')</form></div></div>
@endsection
