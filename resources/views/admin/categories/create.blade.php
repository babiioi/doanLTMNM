@extends('admin.layouts.main')
@section('title', 'Thêm danh mục')
@section('content')
<h1 class="h3 mb-3">Thêm danh mục</h1>
<div class="card"><div class="card-body"><form method="POST" action="{{ route('admin.categories.store') }}">@csrf @include('admin.categories._form')</form></div></div>
@endsection
