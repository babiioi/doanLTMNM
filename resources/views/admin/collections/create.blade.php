@extends('admin.layouts.main')
@section('title', 'Thêm bộ sưu tập')
@section('content')<h1 class="h3 mb-4">Thêm bộ sưu tập</h1><div class="card border-0 shadow-sm"><div class="card-body"><form method="POST" action="{{ route('admin.collections.store') }}">@csrf @include('admin.collections._form')</form></div></div>@endsection
