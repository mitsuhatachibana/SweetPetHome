@extends('layouts.app')
@section('title','Home')

@section('content')
<div class="container">
    {{-- Hero --}}
    <div class="p-5 mb-4 rounded-4 text-white" style="background:linear-gradient(135deg,#ff7a59,#ffb26b);">
        <h1 class="fw-bold">Selamat Datang di SweetPetHome 🐾</h1>
        <p class="mb-3">Belanja kebutuhan hewan kesayangan Anda dengan harga terbaik & gratis ongkir!</p>
        <a href="#produk" class="btn btn-light fw-semibold">Belanja Sekarang</a>
    </div>

    {{-- Best Seller --}}
    @if($bestSellers->count())
    <h4 class="fw-bold mb-3"><i class="bi bi-fire text-danger"></i> Produk Terlaris</h4>
    <div class="row g-3 mb-5">
        @foreach($bestSellers as $p)
        <div class="col-6 col-md-3">
            <a href="{{ route('product.show',$p) }}" class="text-decoration-none text-body">
                <div class="card card-product h-100">
                    <img src="{{ $p->image ? asset('storage/'.$p->image) : 'https://via.placeholder.com/300x200?text='.$p->name }}" class="card-img-top" style="height:180px;object-fit:cover;">
                    <div class="card-body">
                        <span class="badge badge-bestseller mb-2">🔥 Terlaris</span>
                        <h6 class="fw-bold mb-1">{{ $p->name }}</h6>
                        <small class="text-muted">{{ $p->brand }}</small>
                        <div class="fw-bold text-danger mt-2">Rp {{ number_format($p->price,0,',','.') }}</div>
                        <small class="text-muted">{{ $p->sold }} sold</small>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Filter --}}
    <div id="produk" class="card border-0 shadow-sm mb-4 p-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small">Cari Produk</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Telusuri...">
            </div>
            <div class="col-md-2">
                <label class="form-label small">Kategori</label>
                <select name="category" class="form-select">
                    <option value="">Semua</option>
                    @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(request('category')==$c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Harga Min</label>
                <input type="number" name="min_price" value="{{ request('min_price') }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label small">Harga Max</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label small">Urutkan</label>
                <select name="sort" class="form-select">
                    <option value="">Terbaru</option>
                    <option value="best_seller" @selected(request('sort')=='best_seller' )>Terlaris</option>
                    <option value="low" @selected(request('sort')=='low' )>Harga Terendah</option>
                    <option value="high" @selected(request('sort')=='high' )>Harga Tertinggi</option>
                </select>
            </div>
            <div class="col-md-1 d-grid gap-1">
                <button class="btn btn-primary btn-sm">Apply</button>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>

    {{-- Daftar Produk --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Daftar Produk</h5>
        <small class="text-muted">Showing {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }} products</small>
    </div>
    <div class="row g-3">
        @forelse($products as $p)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card card-product h-100">
                <a href="{{ route('product.show',$p) }}">
                    <img src="{{ $p->image ? asset('storage/'.$p->image) : 'https://via.placeholder.com/300x200?text='.$p->name }}" class="card-img-top" style="height:180px;object-fit:cover;">
                </a>
                <div class="card-body d-flex flex-column">
                    @if($p->is_best_seller)
                    <span class="badge badge-bestseller align-self-start mb-2">🔥 Terlaris</span>
                    @endif
                    <h6 class="fw-bold mb-1">{{ $p->name }}</h6>
                    <small class="text-muted">{{ $p->brand }} • {{ $p->category->name }}</small>
                    <div class="stars small my-1">
                        @php $r = round($p->reviews_avg_rating ?? 0); @endphp
                        @for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=$r?'-fill':'' }}"></i>@endfor
                            <span class="text-muted">({{ number_format($p->reviews_avg_rating ?? 0,1) }})</span>
                    </div>
                    <div class="fw-bold text-danger">Rp {{ number_format($p->price,0,',','.') }}</div>
                    <small class="text-muted mb-2">{{ $p->sold }} sold • Stok: {{ $p->stock }}</small>
                    <form method="POST" action="{{ route('cart.add',$p) }}" class="mt-auto">
                        @csrf
                        <button class="btn btn-primary btn-sm w-100" {{ $p->stock<1?'disabled':'' }}>
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Produk tidak ditemukan.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection
