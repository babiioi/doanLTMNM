
<nav class="admin-sidebar">
    <a href="{{ route('admin.dashboard') }}" class="admin-brand">
        <span class="brand-icon">F</span>
        <span>FASHION STORE</span>
    </a>

    <div class="admin-user">
        <div class="user-avatar">
            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
        </div>
        <div class="user-info">
            <strong>{{ Auth::user()->name ?? 'Admin' }}</strong>
            <small>Quản trị viên</small>
        </div>
    </div>

    <div class="admin-menu-label">MENU CHÍNH</div>

    <a href="{{ route('admin.dashboard') }}"
       class="admin-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span>▦</span> Tổng quan
    </a>

    <a href="{{ route('admin.categories.index') }}"
       class="admin-menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
        <span>▤</span> Danh mục
    </a>

    <a href="{{ route('admin.products.index') }}"
       class="admin-menu-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
        <span>□</span> Sản phẩm
    </a>

    <a href="{{ route('admin.orders.index') }}"
       class="admin-menu-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        <span>▣</span> Đơn hàng
    </a>

    <div class="admin-menu-label">CỬA HÀNG</div>

    <a href="{{ route('store.home') }}" class="admin-menu-item">
        <span>⌂</span> Xem cửa hàng
    </a>

    <a href="{{ route('profile.edit') }}" class="admin-menu-item">
        <span>⚙</span> Tài khoản
    </a>

    <div class="admin-menu-bottom">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="admin-menu-item logout-button">
                <span>↪</span> Đăng xuất
            </button>
        </form>
    </div>
</nav>

<style>
    .admin-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 245px;
        overflow-y: auto;
        z-index: 1000;
        padding: 24px 15px;
        background: #222538;
        color: #c4c7d7;
        font-family: Arial, sans-serif;
    }

    .admin-brand {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 0 10px 26px;
        color: white;
        text-decoration: none;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: .5px;
    }

    .brand-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
        border-radius: 10px;
        background: #7167f9;
        color: white;
        font-size: 20px;
    }

    .admin-user {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 16px 10px;
        margin-bottom: 20px;
        border-top: 1px solid #383b50;
        border-bottom: 1px solid #383b50;
    }

    .user-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #7167f9;
        color: white;
        font-weight: 700;
    }

    .user-info { display: flex; flex-direction: column; gap: 4px; }
    .user-info strong { color: white; font-size: 13px; }
    .user-info small { color: #a5a9bd; font-size: 11px; }

    .admin-menu-label {
        padding: 10px 12px;
        color: #858aa5;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .admin-menu-item {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        padding: 12px;
        margin: 4px 0;
        border: 0;
        border-radius: 8px;
        background: transparent;
        color: #c4c7d7;
        text-align: left;
        text-decoration: none;
        font-size: 13px;
        cursor: pointer;
        transition: background .2s, color .2s;
    }

    .admin-menu-item span {
        width: 20px;
        text-align: center;
        font-size: 17px;
    }

    .admin-menu-item:hover {
        background: #303349;
        color: white;
    }

    .admin-menu-item.active {
        background: #7167f9;
        color: white;
        box-shadow: 0 4px 12px #7167f944;
    }

    .admin-menu-bottom {
        margin-top: 24px;
        border-top: 1px solid #383b50;
        padding-top: 14px;
    }

    .logout-button { font-family: inherit; }

    @media (max-width: 767px) {
        .admin-sidebar {
            position: relative;
            width: 100%;
            bottom: auto;
            padding: 15px;
        }

        .admin-brand { padding-bottom: 15px; }
        .admin-user { margin-bottom: 8px; }
        .admin-menu-label { padding-top: 8px; }
        .admin-menu-bottom { margin-top: 8px; }
    }
</style>
