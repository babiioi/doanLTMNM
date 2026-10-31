
@extends('admin.layouts.main')

@section('title', 'Quản lý góp ý - Mơ Màng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-heading">Góp ý khách hàng</h1>
        <p class="page-subtitle mb-0">Quản lý các yêu cầu hỗ trợ và góp ý từ khách hàng.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">STT</th>
                        <th>Họ và tên</th>
                        <th>Email</th>
                        <th>Nội dung góp ý</th>
                        <th>Thời gian gửi</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr>
                            <td class="text-center">
                                {{ $messages->firstItem() + $loop->index }}
                            </td>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>
                                {{ \Illuminate\Support\Str::limit($message->message, 50) }}
                            </td>
                            <td>
                                {{ $message->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="text-center text-nowrap">
                                <a href="{{ route('admin.contact-messages.show', $message) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Xem chi tiết">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <form action="{{ route('admin.contact-messages.destroy', $message) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa góp ý này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Xóa">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-secondary">
                                Chưa có góp ý nào từ khách hàng.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $messages->links() }}
</div>
@endsection
