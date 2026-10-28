@extends('admin.layouts.main')
@section('title', 'Quản lý danh mục')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3"><h1 class="h3">Danh mục</h1><a class="btn btn-dark" href="{{ route('admin.categories.create') }}">+ Thêm danh mục</a></div>
<form class="row g-2 mb-3"><div class="col-md-5"><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Tìm tên danh mục"></div><div class="col-auto"><button class="btn btn-outline-dark">Tìm kiếm</button></div></form>
<div class="table-responsive bg-white rounded shadow-sm"><table class="table table-hover align-middle mb-0">
<thead><tr><th>#</th><th>Tên danh mục</th><th>Mô tả</th><th>Số sản phẩm</th><th class="text-end">Thao tác</th></tr></thead><tbody>
@forelse($categories as $category)
<tr><td>{{ $categories->firstItem() + $loop->index }}</td><td>{{ $category->name }}</td><td>{{ $category->description }}</td><td>{{ $category->products_count }}</td><td class="text-end">
<a class="btn btn-sm btn-outline-primary" href="{{ route('admin.categories.edit', $category) }}">Sửa</a>
<form class="d-inline" method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Bạn chắc chắn muốn xóa danh mục này?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Xóa</button></form>
</td></tr>
@empty<tr><td colspan="5" class="text-center py-4">Chưa có danh mục.</td></tr>@endforelse
</tbody></table></div>
<div class="mt-3">{{ $categories->links('pagination::bootstrap-5') }}</div>
@endsection
