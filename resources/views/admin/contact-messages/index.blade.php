
@extends('admin.layouts.main')

@section('title', 'Quản lý góp ý')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="page-heading mb-0">Góp ý khách hàng</h1>
</div>

{{-- Bảng góp ý khách hàng --}}
<div class="table-responsive bg-white rounded shadow-sm contact-table-wrapper">
    <table class="table table-hover align-middle mb-0 contact-table">
        <thead class="table-light">
            <tr>
                <th>STT</th>
                <th>Khách hàng</th>
                <th>Email</th>
                <th>Nội dung góp ý</th>
                <th>Ngày gửi</th>
                <th>Thao tác</th>
            </tr>
        </thead>

        <tbody>
            @forelse($messages as $message)
                <tr>
                    <td>
                        {{ $messages->firstItem() + $loop->index }}
                    </td>

                    <td class="fw-semibold">
                        {{ $message->name }}
                    </td>

                    <td>
                        {{ $message->email }}
                    </td>

                    <td>
                        {{ \Illuminate\Support\Str::limit($message->message, 45) }}
                    </td>

                    <td>
                        {{ $message->created_at->format('d/m/Y') }}
                        <br>
                        <small class="text-secondary">
                            {{ $message->created_at->format('H:i') }}
                        </small>
                    </td>

                    <td class="text-nowrap">
                        <a
                            class="btn btn-sm btn-outline-primary action-icon"
                            href="{{ route('admin.contact-messages.show', $message) }}"
                            title="Xem chi tiết"
                            aria-label="Xem chi tiết"
                        >
                            <i class="bi bi-eye"></i>
                        </a>

                        <form
                            action="{{ route('admin.contact-messages.destroy', $message) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Bạn có chắc muốn xóa góp ý này?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-sm btn-outline-danger action-icon"
                                title="Xóa góp ý"
                                aria-label="Xóa góp ý"
                            >
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4">
                        Chưa có góp ý từ khách hàng.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Phân trang --}}
<div class="mt-3">
    {{ $messages->links('pagination::bootstrap-5') }}
</div>

<style>
    /* Khung bảng */
    .contact-table-wrapper {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
    }

    /* Bảng */
    .contact-table {
        width: 100%;
        min-width: 950px;
        table-layout: fixed;
        margin-bottom: 0;
    }

    .contact-table th,
    .contact-table td {
        padding: 12px 8px;
        text-align: center;
        vertical-align: middle;
        overflow-wrap: break-word;
        font-size: 14px;
    }

    .contact-table thead th {
        font-weight: 700;
        white-space: nowrap;
    }

    /* STT */
    .contact-table th:nth-child(1),
    .contact-table td:nth-child(1) {
        width: 8%;
    }

    /* Khách hàng */
    .contact-table th:nth-child(2),
    .contact-table td:nth-child(2) {
        width: 17%;
    }

    /* Email */
    .contact-table th:nth-child(3),
    .contact-table td:nth-child(3) {
        width: 20%;
    }

    /* Nội dung góp ý */
    .contact-table th:nth-child(4),
    .contact-table td:nth-child(4) {
        width: 25%;
    }

    /* Ngày gửi */
    .contact-table th:nth-child(5),
    .contact-table td:nth-child(5) {
        width: 15%;
    }

    /* Thao tác */
    .contact-table th:nth-child(6),
    .contact-table td:nth-child(6) {
        width: 15%;
        white-space: nowrap;
    }

    /* Nút thao tác */
    .contact-table .action-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection
