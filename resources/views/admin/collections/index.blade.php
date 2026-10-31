@extends('admin.layouts.main')

@section('title', 'Quản trị bộ sưu tập')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h1 class="page-heading mb-1">Quản trị bộ sưu tập</h1>
        <p class="text-secondary mb-0">
            Thêm, đổi tên hoặc xóa bộ sưu tập hiển thị trên cửa hàng.
        </p>
    </div>

    <a class="btn btn-dark" href="{{ route('admin.collections.create') }}">
        <i class="bi bi-plus-lg"></i> Thêm bộ sưu tập
    </a>
</div>

{{-- Bảng bộ sưu tập --}}
<div class="table-responsive bg-white rounded shadow-sm collection-table-wrapper">
    <table class="table table-hover align-middle mb-0 collection-table">
        <thead class="table-light">
            <tr>
                <th>SL</th>
                <th>Tên bộ sưu tập</th>
                <th>Đường dẫn</th>
                <th>Số sản phẩm</th>
                <th>Thao tác</th>
            </tr>
        </thead>

        <tbody>
            @forelse($collections as $collection)
                <tr>
                    <td>
                        {{ $collections->firstItem() + $loop->index }}
                    </td>

                    <td class="collection-name">
                        <div>{{ $collection->name }}</div>

                        @if($collection->description)
                            <div class="collection-description">
                                {{ $collection->description }}
                            </div>
                        @endif
                    </td>

                    <td>
                        <code>{{ $collection->slug }}</code>
                    </td>

                    <td>
                        <span class="badge text-bg-light">
                            {{ $productCounts[$collection->name] ?? 0 }} sản phẩm
                        </span>
                    </td>

                    <td class="text-nowrap">
                        <a
                            class="btn btn-sm btn-outline-primary action-icon"
                            href="{{ route('admin.collections.edit', $collection) }}"
                            title="Sửa bộ sưu tập"
                            aria-label="Sửa bộ sưu tập"
                        >
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form
                            class="d-inline"
                            method="POST"
                            action="{{ route('admin.collections.destroy', $collection) }}"
                            onsubmit="return confirm('Xóa bộ sưu tập này? Sản phẩm sẽ vẫn còn nhưng không thuộc bộ sưu tập nào.')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-sm btn-outline-danger action-icon"
                                title="Xóa bộ sưu tập"
                                aria-label="Xóa bộ sưu tập"
                            >
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">
                        Chưa có bộ sưu tập. Hãy thêm bộ sưu tập đầu tiên.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Phân trang --}}
<div class="mt-3">
    {{ $collections->links('pagination::bootstrap-5') }}
</div>

<style>
    /* Khung bảng */
    .collection-table-wrapper {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
    }

    /* Bảng */
    .collection-table {
        width: 100%;
        min-width: 700px;
        table-layout: fixed;
        margin-bottom: 0;
    }

    .collection-table th,
    .collection-table td {
        padding: 14px 12px;
        text-align: center;
        vertical-align: middle;
        overflow-wrap: break-word;
        font-size: 15px;
    }

    .collection-table thead th {
        font-weight: 700;
        white-space: nowrap;
    }

    /* Cột số lượng */
    .collection-table th:nth-child(1),
    .collection-table td:nth-child(1) {
        width: 8% !important;
    }

    /* Tên bộ sưu tập */
    .collection-table th:nth-child(2),
    .collection-table td:nth-child(2) {
        width: 35% !important;
    }

    /* Đường dẫn */
    .collection-table th:nth-child(3),
    .collection-table td:nth-child(3) {
        width: 17% !important;
    }

    /* Số sản phẩm */
    .collection-table th:nth-child(4),
    .collection-table td:nth-child(4) {
        width: 20% !important;
    }

    /* Thao tác */
    .collection-table th:nth-child(5),
    .collection-table td:nth-child(5) {
        width: 20% !important;
        white-space: nowrap;
    }

    /* Tên bộ sưu tập */
    .collection-name {
        font-weight: 600;
        color: #333;
    }

    /* Mô tả */
    .collection-description {
        margin-top: 4px;
        font-size: 13px;
        font-weight: 400;
        color: #6c757d;
        overflow-wrap: anywhere;
    }

    /* Đường dẫn */
    .collection-table code {
        overflow-wrap: anywhere;
    }

    .collection-table .action-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection
