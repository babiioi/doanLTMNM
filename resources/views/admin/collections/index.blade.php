@extends('admin.layouts.main')
@section('title', 'Quản trị bộ sưu tập')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4"><div><h1 class="h3 mb-1">Quản trị bộ sưu tập</h1><p class="text-secondary mb-0">Thêm, đổi tên hoặc xóa bộ sưu tập hiển thị trên cửa hàng.</p></div><a class="btn btn-dark" href="{{ route('admin.collections.create') }}">+ Thêm bộ sưu tập</a></div>
<div class="table-responsive bg-white rounded shadow-sm"><table class="table table-hover align-middle mb-0"><thead class="table-light"><tr><th>#</th><th>Tên bộ sưu tập</th><th>Đường dẫn</th><th>Số sản phẩm</th><th class="text-end">Thao tác</th></tr></thead><tbody>
@forelse($collections as $collection)
<tr><td>{{ $collections->firstItem() + $loop->index }}</td><td><div class="fw-semibold">{{ $collection->name }}</div>@if($collection->description)<div class="small text-secondary">{{ $collection->description }}</div>@endif</td><td><code>{{ $collection->slug }}</code></td><td><span class="badge text-bg-light">{{ $productCounts[$collection->name] ?? 0 }} sản phẩm</span></td><td class="text-end text-nowrap"><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.collections.edit', $collection) }}">Sửa</a> <form class="d-inline" method="POST" action="{{ route('admin.collections.destroy', $collection) }}" onsubmit="return confirm('Xóa bộ sưu tập này? Sản phẩm sẽ vẫn còn nhưng không thuộc bộ sưu tập nào.')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Xóa</button></form></td></tr>
@empty<tr><td colspan="5" class="text-center py-4">Chưa có bộ sưu tập. Hãy thêm bộ sưu tập đầu tiên.</td></tr>@endforelse
</tbody></table></div><div class="mt-3">{{ $collections->links('pagination::bootstrap-5') }}</div>
@endsection
