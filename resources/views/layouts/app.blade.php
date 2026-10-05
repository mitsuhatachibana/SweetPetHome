<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SweetPetHome - @yield('title', 'Belanja Kebutuhan Hewan')</title>

    {{-- Set tema SEBELUM render biar tidak flash --}}
    <script>
        (function() {
            const saved = localStorage.getItem('theme') ||
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-bs-theme', saved);
        })();
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #ff7a59;
            --secondary: #ffb26b;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9f7f4;
            transition: background .3s, color .3s;
        }

        .navbar-brand {
            font-weight: 800;
            color: var(--primary) !important;
            font-size: 1.5rem;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: #e56a4a;
            border-color: #e56a4a;
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* Product Card */
        .card-product {
            transition: all .3s ease;
            border: none;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
            background: #fff;
        }

        .card-product:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(255, 122, 89, .25);
        }

        .card-product .card-img-top {
            height: 200px;
            object-fit: cover;
            background: #f4f1ec;
        }

        .card-product .card-body {
            padding: 14px;
        }

        .card-product .product-title {
            font-size: .95rem;
            font-weight: 700;
            margin-bottom: 4px;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 2.5em;
        }

        .card-product .product-price {
            font-weight: 800;
            color: #e63946;
            font-size: 1.05rem;
        }

        .card-product .product-meta {
            font-size: .78rem;
            color: #888;
        }

        .btn-add-cart {
            background: var(--primary);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 8px 0;
            border-radius: 8px;
            transition: all .2s;
            font-size: .9rem;
        }

        .btn-add-cart:hover:not(:disabled) {
            background: #e56a4a;
            color: #fff;
        }

        .btn-add-cart:disabled {
            background: #ccc;
        }

        .badge-bestseller {
            background: linear-gradient(45deg, #ff7a59, #ffb26b);
            color: #fff;
            font-size: .7rem;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .stars {
            color: #ffc107;
            font-size: .8rem;
        }

        /* Pagination Custom */
        .pagination {
            gap: 4px;
        }

        .pagination .page-link {
            color: var(--primary);
            border: 1px solid #eee;
            border-radius: 8px !important;
            padding: 6px 12px;
            font-weight: 600;
            font-size: .9rem;
        }

        .pagination .page-link:hover {
            background: #fff1ec;
            color: var(--primary);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .pagination .page-item.disabled .page-link {
            color: #ccc;
            background: #fafafa;
        }

        footer {
            background: #2b2b2b;
            color: #fff;
            padding: 40px 0 20px;
            margin-top: 60px;
            transition: background .3s;
        }

        footer a {
            color: #ffb26b;
            text-decoration: none;
        }

        footer a:hover {
            color: #fff;
        }

        /* Toggle tema button */
        .theme-toggle {
            background: transparent;
            border: 1px solid rgba(255, 122, 89, .3);
            color: var(--primary);
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
            font-size: 1.1rem;
        }

        .theme-toggle:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        /* ===== DARK MODE OVERRIDE ===== */
        [data-bs-theme="dark"] {
            --primary: #ff9a7d;
            --secondary: #ffc79b;
        }

        [data-bs-theme="dark"] body {
            background: #121212;
            color: #e0e0e0;
        }

        [data-bs-theme="dark"] .card-product {
            background: #1e1e1e;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .5);
        }

        [data-bs-theme="dark"] .card-product .card-img-top {
            background: #2a2a2a;
        }

        [data-bs-theme="dark"] .card-product .product-meta {
            color: #aaa;
        }

        [data-bs-theme="dark"] .navbar {
            background: #1a1a1a !important;
            border-bottom: 1px solid #2a2a2a;
        }

        [data-bs-theme="dark"] .navbar-brand {
            color: var(--primary) !important;
        }

        [data-bs-theme="dark"] .nav-link {
            color: #e0e0e0 !important;
        }

        [data-bs-theme="dark"] .nav-link:hover {
            color: var(--primary) !important;
        }

        [data-bs-theme="dark"] .card {
            background: #1e1e1e;
            color: #e0e0e0;
            border-color: #2a2a2a;
        }

        [data-bs-theme="dark"] .card-body,
        [data-bs-theme="dark"] .card-header {
            background: transparent;
            color: #e0e0e0;
        }

        [data-bs-theme="dark"] .dropdown-menu {
            background: #1e1e1e;
            border-color: #2a2a2a;
        }

        [data-bs-theme="dark"] .dropdown-item {
            color: #e0e0e0;
        }

        [data-bs-theme="dark"] .dropdown-item:hover {
            background: #2a2a2a;
            color: var(--primary);
        }

        [data-bs-theme="dark"] .dropdown-divider {
            border-color: #2a2a2a;
        }

        [data-bs-theme="dark"] .table {
            color: #e0e0e0;
            border-color: #2a2a2a;
        }

        [data-bs-theme="dark"] .table>thead {
            background: #2a2a2a;
            color: #e0e0e0;
        }

        [data-bs-theme="dark"] .table>tbody>tr>td {
            background: transparent;
            border-color: #2a2a2a;
        }

        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select {
            background: #1e1e1e;
            color: #e0e0e0;
            border-color: #2a2a2a;
        }

        [data-bs-theme="dark"] .form-control:focus,
        [data-bs-theme="dark"] .form-select:focus {
            background: #1e1e1e;
            color: #e0e0e0;
            border-color: var(--primary);
            box-shadow: 0 0 0 .2rem rgba(255, 154, 125, .2);
        }

        [data-bs-theme="dark"] .form-control::placeholder {
            color: #777;
        }

        [data-bs-theme="dark"] .pagination .page-link {
            background: #1e1e1e;
            border-color: #2a2a2a;
            color: var(--primary);
        }

        [data-bs-theme="dark"] .pagination .page-link:hover {
            background: #2a2a2a;
        }

        [data-bs-theme="dark"] .pagination .page-item.active .page-link {
            background: var(--primary);
            color: #fff;
        }

        [data-bs-theme="dark"] .pagination .page-item.disabled .page-link {
            background: #181818;
            color: #555;
        }

        [data-bs-theme="dark"] footer {
            background: #0a0a0a;
        }

        [data-bs-theme="dark"] .alert-info {
            background: #1a2a35;
            color: #a0d3e8;
            border-color: #2a3a45;
        }

        [data-bs-theme="dark"] .alert-success {
            background: #1a2f1a;
            color: #a0e8a0;
            border-color: #2a3f2a;
        }

        [data-bs-theme="dark"] .alert-danger {
            background: #351a1a;
            color: #e8a0a0;
            border-color: #452a2a;
        }

        [data-bs-theme="dark"] .list-group-item {
            background: transparent;
            color: #e0e0e0;
            border-color: #2a2a2a;
        }

        [data-bs-theme="dark"] .text-muted {
            color: #999 !important;
        }

        [data-bs-theme="dark"] .text-dark {
            color: #e0e0e0 !important;
        }

        [data-bs-theme="dark"] .bg-white {
            background: #1e1e1e !important;
        }
    </style>
    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ auth()->check() && auth()->user()->isAdmin() ? route('admin.dashboard') : route('home') }}">
                <i class="bi bi-heart-fill"></i> SweetPetHome
            </a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">

                {{-- MENU KIRI (beda untuk admin & user) --}}
                <ul class="navbar-nav me-auto">
                    @auth
                    @if(auth()->user()->isAdmin())
                    {{-- MENU ADMIN --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'fw-bold text-primary' : '' }}"
                            href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'fw-bold text-primary' : '' }}"
                            href="{{ route('admin.products.index') }}">
                            <i class="bi bi-box-seam"></i> Kelola Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'fw-bold text-primary' : '' }}"
                            href="{{ route('admin.categories.index') }}">
                            <i class="bi bi-tags"></i> Kelola Kategori
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'fw-bold text-primary' : '' }}"
                            href="{{ route('admin.orders.index') }}">
                            <i class="bi bi-receipt-cutoff"></i> Kelola Pesanan
                        </a>
                    </li>
                    @else
                    {{-- MENU USER --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">Riwayat Pesanan</a>
                    </li>
                    @endif
                    @else
                    {{-- GUEST --}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About Us</a></li>
                    @endauth
                </ul>

                {{-- MENU KANAN --}}
                <ul class="navbar-nav ms-auto align-items-center">

                    {{-- Tombol Toggle Tema --}}
                    <li class="nav-item me-2">
                        <button class="theme-toggle" onclick="toggleTheme()" title="Ganti tema" id="themeBtn">
                            <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
                        </button>
                    </li>

                    @auth
                    @if(!auth()->user()->isAdmin())
                    {{-- Cart icon HANYA untuk user biasa --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 fs-5"></i>
                            @php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity'); @endphp
                            @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                            </span>
                            @endif
                        </a>
                    </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown" href="#">
                            @if(auth()->user()->photo)
                            <img src="{{ asset('storage/'.auth()->user()->photo) }}"
                                class="rounded-circle" width="32" height="32" style="object-fit:cover;">
                            @else
                            <i class="bi bi-person-circle fs-4"></i>
                            @endif
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if(auth()->user()->isAdmin())
                            {{-- Admin: menu lebih simpel --}}
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard Admin</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.products.index') }}"><i class="bi bi-box-seam"></i> Kelola Produk</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}"><i class="bi bi-tags"></i> Kelola Kategori</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}"><i class="bi bi-receipt-cutoff"></i> Kelola Pesanan</a></li>
                            @else
                            {{-- User: menu biasa --}}
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person"></i> Profil Saya</a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="bi bi-receipt"></i> Riwayat Pesanan</a></li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="btn btn-primary btn-sm ms-2" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @if(session('success'))
        <div class="container">
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        @endif
        @if($errors->any())
        <div class="container">
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        @endif
        @if(session('error'))
        <div class="container">
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        @endif
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="fw-bold"><i class="bi bi-heart-fill text-warning"></i> SweetPetHome</h5>
                    <p class="small">Toko online kebutuhan hewan peliharaan terlengkap & terpercaya sejak 2023.</p>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold">Kategori</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('home') }}">Makanan & Snack</a></li>
                        <li><a href="{{ route('home') }}">Vitamin & Obat</a></li>
                        <li><a href="{{ route('home') }}">Aksesoris & Mainan</a></li>
                        <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold">Pembayaran</h6>
                    <p class="small">GoPay • OVO • DANA • BCA • Mandiri • BSI • BRI • BNI • BTN • SeaBank • ShopeePay</p>
                </div>
            </div>
            <hr class="bg-light">
            <p class="text-center small mb-0">&copy; 2023 SweetPetHome. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Script Toggle Tema --}}
    <script>
        function updateToggleIcon(theme) {
            const icon = document.getElementById('themeIcon');
            if (!icon) return;
            if (theme === 'dark') {
                icon.className = 'bi bi-sun-fill';
            } else {
                icon.className = 'bi bi-moon-stars-fill';
            }
        }

        function toggleTheme() {
            const current = document.documentElement.getAttribute('data-bs-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', next);
            localStorage.setItem('theme', next);
            updateToggleIcon(next);
        }

        // Sync icon saat pertama load
        document.addEventListener('DOMContentLoaded', function() {
            const current = document.documentElement.getAttribute('data-bs-theme') || 'light';
            updateToggleIcon(current);
        });

        // Listen perubahan tema OS
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('theme')) {
                const next = e.matches ? 'dark' : 'light';
                document.documentElement.setAttribute('data-bs-theme', next);
                updateToggleIcon(next);
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
