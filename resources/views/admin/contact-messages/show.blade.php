
@extends('admin.layouts.main')

@section('title', 'Chi tiết góp ý - Mơ Màng')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.contact-messages.index') }}"
       class="text-decoration-none">
        ← Quay lại danh sách góp ý
    </a>

    <h1 class="page-heading mt-3">Chi tiết góp ý</h1>
    <p class="page-subtitle">Thông tin khách hàng đã gửi đến Mơ Màng.</p>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="mb-4">
            <div class="text-secondary small mb-1">Họ và tên</div>
            <div class="fw-bold">{{ $contactMessage->name }}</div>
        </div>

        <div class="mb-4">
            <div class="text-secondary small mb-1">Email</div>
            <div class="fw-bold">{{ $contactMessage->email }}</div>
        </div>

        <div class="mb-4">
            <div class="text-secondary small mb-1">Thời gian gửi</div>
            <div>{{ $contactMessage->created_at->format('d/m/Y H:i') }}</div>
        </div>

        <hr>

        <div>
            <div class="text-secondary small mb-2">Nội dung góp ý</div>
            <div class="p-3 rounded-3" style="background:#F7F3EE; white-space:pre-line">
                {{ $contactMessage->message }}
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <a href="mailto:{{ $contactMessage->email }}"
               class="btn btn-dark">
                <i class="bi bi-envelope me-1"></i> Phản hồi qua email
            </a>

            <form action="{{ route('admin.contact-messages.destroy', $contactMessage) }}"
                  method="POST"
                  onsubmit="return confirm('Bạn có chắc muốn xóa góp ý này?')">
                @csrf
                @method('DELETE')

                <button class="btn btn-outline-danger">
                    <i class="bi bi-trash me-1"></i> Xóa góp ý
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
