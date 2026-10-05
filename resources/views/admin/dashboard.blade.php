@extends('layouts.app')
@section('title','Dashboard Admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h3 class="fw-bold mb-0">Welcome, SweetPetHome Administrator! 👋</h3>
        <span class="badge bg-primary fs-6">{{ auth()->user()->email }}</span>
    </div>

    {{-- STAT CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 text-white" style="background:linear-gradient(135deg,#ff7a59,#ffb26b);">
                <small class="opacity-75">Total Revenue</small>
                <h3 class="fw-bold mb-0">Rp {{ number_format($totalRevenue,0,',','.') }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 text-white bg-success">
                <small class="opacity-75">Total Products</small>
                <h3 class="fw-bold mb-0">{{ $totalProducts }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 text-white bg-primary">
                <small class="opacity-75">Total Users</small>
                <h3 class="fw-bold mb-0">{{ \App\Models\User::where('role','user')->count() }}</h3>
            </div>
        </div>
    </div>

    {{-- QUICK ACTIONS --}}
    <h5 class="fw-bold mb-3"><i class="bi bi-lightning-charge-fill text-warning"></i> Menu Cepat</h5>
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <a href="{{ route('admin.products.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm p-3 text-center h-100 menu-card">
                    <i class="bi bi-plus-circle fs-1 text-primary"></i>
                    <div class="fw-bold mt-2">Tambah Produk</div>
                    <small class="text-muted">Buat produk baru</small>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm p-3 text-center h-100 menu-card">
                    <i class="bi bi-box-seam fs-1 text-success"></i>
                    <div class="fw-bold mt-2">Kelola Produk</div>
                    <small class="text-muted">Edit / hapus produk</small>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm p-3 text-center h-100 menu-card">
                    <i class="bi bi-tags fs-1 text-warning"></i>
                    <div class="fw-bold mt-2">Kelola Kategori</div>
                    <small class="text-muted">Atur kategori produk</small>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm p-3 text-center h-100 menu-card">
                    <i class="bi bi-receipt-cutoff fs-1 text-danger"></i>
                    <div class="fw-bold mt-2">Kelola Pesanan</div>
                    <small class="text-muted">Lihat semua order</small>
                </div>
            </a>
        </div>
    </div>

    {{-- RECENT --}}
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0"><i class="bi bi-people"></i> Recent Users</h6>
                        <small class="text-muted">5 terbaru</small>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($recentUsers as $u)
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <span>
                                <i class="bi bi-person-circle text-muted"></i> {{ $u->name }}
                            </span>
                            <small class="text-muted">{{ $u->email }}</small>
                        </li>
                        @empty
                        <li class="list-group-item px-0 text-muted small">Belum ada user.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0"><i class="bi bi-receipt"></i> Recent Orders</h6>
                        <a href="{{ route('admin.orders.index') }}" class="small text-decoration-none">Lihat semua →</a>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($recentOrders as $o)
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <span>
                                <code class="small">{{ $o->order_code }}</code>
                            </span>
                            <span class="fw-bold text-danger small">Rp {{ number_format($o->total,0,',','.') }}</span>
                        </li>
                        @empty
                        <li class="list-group-item px-0 text-muted small">Belum ada pesanan.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .menu-card {
        transition: all .25s ease;
        cursor: pointer;
    }

    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(255, 122, 89, .25) !important;
    }
</style>
@endpush
@endsection
