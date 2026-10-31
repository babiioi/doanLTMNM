<!doctype html>
<html lang="vi">
<head>
<link rel="icon" type="image/png" href="{{ asset('images/mo-mang-favicon.png') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Quản trị - Mơ Màng')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --sidebar: #4A382E;
            --sidebar-hover: #624C3E;
            --purple: #8B6F5C;
            --page-bg: #F7F3EE;
            --text: #4A382E;
            --muted: #8D8177;
            --border: #EAE1D8;
            --accent-light: #F0E6DC;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--page-bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
        }

        /* SIDEBAR */
        .admin-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 245px;
            padding: 24px 15px;
            overflow-y: auto;
            background: var(--sidebar);
            color: #E8DCD1;
            z-index: 1000;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 0 10px 27px;
            color: #FFF9F3;
            text-decoration: none;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: .5px;
        }

        .brand-icon {
            display: grid;
            place-items: center;
            width: 37px;
            height: 37px;
            border-radius: 11px;
            background: #B89578;
            color: #FFFFFF;
            font-size: 20px;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 17px 9px;
            margin-bottom: 19px;
            border-top: 1px solid #665347;
            border-bottom: 1px solid #665347;
        }

        .avatar {
            display: grid;
            place-items: center;
            flex-shrink: 0;
            width: 39px;
            height: 39px;
            border-radius: 50%;
            background: #B89578;
            color: #FFFFFF;
            font-weight: 700;
        }

        .profile-name {
            color: #FFF9F3;
            font-weight: 700;
            font-size: 13px;
        }

        .profile-role {
            color: #C6B5A7;
            font-size: 11px;
            margin-top: 4px;
        }

        .menu-label {
            padding: 12px;
            color: #B5A092;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .side-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            margin: 4px 0;
            border-radius: 8px;
            color: #E1D4C9;
            text-decoration: none;
            transition: background .2s, color .2s;
        }

        .side-link:hover {
            background: var(--sidebar-hover);
            color: #FFFFFF;
        }

        .side-link.active {
            background: #A98568;
            color: #FFFFFF;
            box-shadow: 0 5px 15px #24170F30;
        }

        .side-icon {
            width: 21px;
            text-align: center;
            font-size: 17px;
        }

        .sidebar-bottom {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #665347;
        }

        .logout-btn {
            width: 100%;
            border: 0;
            background: transparent;
            text-align: left;
            font: inherit;
            cursor: pointer;
        }

        /* KHU VỰC NỘI DUNG */
        .admin-main {
            min-height: 100vh;
            margin-left: 245px;
            background: var(--page-bg);
        }

        .topbar {
            min-height: 78px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 16px 30px;
            background: #FFFCF9;
            border-bottom: 1px solid var(--border);
        }

        .topbar-title {
            margin: 0;
            color: var(--text);
            font-size: 18px;
            font-weight: 800;
        }

        .search-box {
            width: min(340px, 45%);
            padding: 11px 15px;
            border: 1px solid #E3D7CB;
            border-radius: 9px;
            outline: none;
            color: var(--text);
            background: #F9F5F0;
        }

        .search-box::placeholder {
            color: #A99A8D;
        }

        .search-box:focus {
            border-color: #A98568;
            box-shadow: 0 0 0 3px #A985681C;
        }

        .description-cell {
            max-width: 280px;
            overflow-wrap: anywhere;
            color: #8D8177;
            line-height: 1.5;
        }
        
        .page-content {
            padding: 30px;
            min-width: 0;
            overflow-x: auto;
        }

        .page-content .table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        /* Điều chỉnh độ rộng cột bảng danh mục */
.page-content .table {
    table-layout: fixed;
    width: 100%;
}

.page-content .table th:nth-child(1),
.page-content .table td:nth-child(1) {
    width: 6%;
}

.page-content .table th:nth-child(2),
.page-content .table td:nth-child(2) {
    width: 20%;
}

.page-content .table th:nth-child(3),
.page-content .table td:nth-child(3) {
    width: 44%;
}

.page-content .table th:nth-child(4),
.page-content .table td:nth-child(4) {
    width: 10%;
}

.page-content .table th:nth-child(5),
.page-content .table td:nth-child(5) {
    width: 20%;
}

        .page-content .table th {
            font-weight: 700;
            text-align: center;
            vertical-align: middle;
        }

        .page-content .table td {
            overflow-wrap: break-word;
            text-align: center;
            vertical-align: middle;
        }

        .page-content .table td .btn {
            margin: 2px;
        }


        .page-heading {
            margin-bottom: 7px;
            color: var(--text);
            font-size: 25px;
            font-weight: 800;
        }

        .page-subtitle {
            margin-bottom: 26px;
            color: var(--muted);
        }


        .stat-card {
            height: 100%;
            padding: 22px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: #FFFCF9;
            box-shadow: 0 4px 15px #4A382E08;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 9px 24px #4A382E12;
        }

        .stat-title {
            color: var(--muted);
            font-size: 13px;
        }

        .stat-number {
            margin: 13px 0;
            color: var(--text);
            font-size: 30px;
            font-weight: 800;
        }

        .stat-link {
            color: #8B6F5C;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
        }

        .stat-link:hover {
            color: #624C3E;
            text-decoration: underline;
        }

        /* KHUNG BIỂU ĐỒ */
        .content-card {
            padding: 23px;
            margin-top: 24px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: #FFFCF9;
            box-shadow: 0 4px 15px #4A382E08;
        }

        .content-card h5 {
            color: var(--text);
            font-weight: 800;
        }

        .content-card .text-secondary {
            color: var(--muted) !important;
        }

        .admin-footer {
            padding: 20px 30px;
            color: var(--muted);
            font-size: 12px;
        }

        /* THÔNG BÁO */
        .alert-success {
            color: #526849;
            background: #EDF2E8;
            border-color: #DCE7D4;
        }

        .alert-danger {
            color: #8B5147;
            background: #F8EAE5;
            border-color: #EED4CC;
        }

        /* ĐIỆN THOẠI */
        @media (max-width: 767px) {
            .admin-sidebar {
                position: relative;
                width: 100%;
                padding: 15px;
            }

            .admin-main {
                margin-left: 0;
            }

            .topbar {
                padding: 15px;
            }

            .page-content {
                padding: 18px 15px;
            }

            .search-box {
                width: 45%;
            }
        }
        
        .page-content .table td .btn-sm {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 16px;
        }
        
        
        .action-icon {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            margin-left: 4px;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.2s ease;
        }

        .action-icon:hover {
            transform: translateY(-2px);
        }

    </style>

</head>

<body>
    <aside class="admin-sidebar">
        <a class="brand" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/mo-mang-logo.png') }}" alt="Logo Mơ Màng" style="height:70px;width:75px;object-fit:contain;background:#fff;border-radius:10px;padding:3px;flex-shrink:0">
            <span>MƠ MÀNG</span>
        </a>

        <div class="admin-profile">
            <div class="avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div>
                <div class="profile-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="profile-role">Quản trị viên</div>
            </div>
        </div>

        <div class="menu-label">MENU CHÍNH</div>

        <a class="side-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
           href="{{ route('admin.dashboard') }}">
            <span class="side-icon">▦</span> Tổng quan
        </a>

        <a class="side-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
           href="{{ route('admin.categories.index') }}">
            <span class="side-icon">▤</span> Danh mục
        </a>

        <a class="side-link {{ request()->routeIs('admin.collections.*') ? 'active' : '' }}"
           href="{{ route('admin.collections.index') }}">
            <span class="side-icon">▧</span> Bộ sưu tập
        </a>

        <a class="side-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
           href="{{ route('admin.products.index') }}">
            <span class="side-icon">□</span> Sản phẩm
        </a>

        <a class="side-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
           href="{{ route('admin.orders.index') }}">
            <span class="side-icon">▣</span> Đơn hàng
        </a>

        <div class="menu-label">CỬA HÀNG</div>

        <a class="side-link" href="{{ route('store.home') }}">
            <span class="side-icon">⌂</span> Xem cửa hàng
        </a>

        <div class="sidebar-bottom">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="side-link logout-btn">
                    <span class="side-icon">↪</span> Đăng xuất
                </button>
            </form>
        </div>
    </aside>

    <div class="admin-main">
        <header class="topbar">
            <h1 class="topbar-title">Quản trị cửa hàng</h1>
        </header>

        <main class="page-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="admin-footer">
            © {{ date('Y') }} Mơ Màng · Hệ thống quản trị
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```