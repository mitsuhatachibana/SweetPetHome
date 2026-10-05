@extends('layouts.app')
@section('title',$product->name)

@section('content')
<div class="container">
    <nav class="small text-muted mb-3">
        <a href="{{ route('home') }}" class="text-decoration-none">Home</a> /
        <span>{{ $product->category->name }}</span> / <span>{{ $product->name }}</span>
    </nav>

    <div class="row g-4">
        <div class="col-md-5">
            <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/500x400?text='.$product->name }}" class="img-fluid rounded-4 shadow-sm w-100" style="object-fit:cover;">
        </div>
        <div class="col-md-7">
            <h2 class="fw-bold">{{ $product->name }}</h2>
            <p class="text-muted mb-2">Brand: <strong>{{ $product->brand }}</strong> • Kategori: {{ $product->category->name }}</p>
            <div class="stars mb-2">
                @for($i=1;$i<=5;$i++)
                    @php
                    // Kalau rating 4.7 → bintang ke-5 jadi half (bi-star-half)
                    if ($rating>= $i) {
                    $icon = 'bi-star-fill';
                    } elseif ($rating >= $i - 0.5) {
                    $icon = 'bi-star-half';
                    } else {
                    $icon = 'bi-star';
                    }
                    @endphp
                    <i class="bi {{ $icon }}"></i>
                    @endfor
                    <span class="text-muted">
                        ({{ number_format($rating, 1) }} • {{ $product->reviews->count() }} review)
                    </span>
            </div>
            <h3 class="text-danger fw-bold">Rp {{ number_format($product->price,0,',','.') }}</h3>
            <p class="text-muted">{{ $product->sold }} sold • Stok: {{ $product->stock }}</p>
            <p>{{ $product->description }}</p>

            <form method="POST" action="{{ route('cart.add',$product) }}" class="row g-2 align-items-center mt-3">
                @csrf
                <div class="col-auto">
                    <label class="form-label small mb-0">Jumlah</label>
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="width:100px;">
                </div>
                <div class="col-auto align-self-end">
                    <button class="btn btn-primary" {{ $product->stock<1?'disabled':'' }}>
                        <i class="bi bi-cart-plus"></i> Add to Cart
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Review --}}
    <div class="mt-5">
        <h4 class="fw-bold mb-3">Ulasan Pembeli</h4>
        @auth
        @php
        // Cek kalau user sudah pernah review produk ini
        $myReview = $product->reviews->firstWhere('user_id', auth()->id());
        @endphp

        <form method="POST" action="{{ route('review.store',$product) }}" class="card p-3 border-0 shadow-sm mb-3">
            @csrf
            <h6 class="fw-bold mb-3">
                <i class="bi bi-star-fill text-warning"></i>
                {{ $myReview ? 'Edit Ulasan Anda' : 'Tulis Ulasan' }}
            </h6>

            <div class="row g-3">
                {{-- Rating Input --}}
                <div class="col-md-4">
                    <label class="small fw-semibold mb-1">Rating (1.0 - 5.0)</label>
                    <input type="number" name="rating" id="ratingInput"
                        value="{{ old('rating', $myReview->rating ?? 5) }}"
                        min="1" max="5" step="0.1"
                        class="form-control @error('rating') is-invalid @enderror"
                        required>
                    @error('rating')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    {{-- Preview bintang otomatis --}}
                    <div class="stars mt-2" id="ratingPreview">
                        {{-- diisi oleh JS --}}
                    </div>
                    <small class="text-muted" id="ratingText">5.0 ⭐</small>
                </div>

                {{-- Komentar --}}
                <div class="col-md-6">
                    <label class="small fw-semibold mb-1">Komentar</label>
                    <input type="text" name="comment"
                        value="{{ old('comment', $myReview->comment ?? '') }}"
                        class="form-control" placeholder="Tulis ulasan...">
                </div>

                {{-- Submit --}}
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-send"></i> Kirim
                    </button>
                </div>
            </div>

            <small class="text-muted mt-2 d-block">
                Tips: contoh rating 4.7 untuk "hampir sempurna", 4.9 untuk "hampir luar biasa"
            </small>
        </form>

        @push('scripts')
        <script>
            function renderStars(rating) {
                const preview = document.getElementById('ratingPreview');
                const text = document.getElementById('ratingText');
                if (!preview) return;

                let html = '';
                for (let i = 1; i <= 5; i++) {
                    if (rating >= i) {
                        html += '<i class="bi bi-star-fill"></i> ';
                    } else if (rating >= i - 0.5) {
                        html += '<i class="bi bi-star-half"></i> ';
                    } else {
                        html += '<i class="bi bi-star"></i> ';
                    }
                }
                preview.innerHTML = html;
                text.textContent = Number(rating).toFixed(1) + ' ⭐';
            }

            document.addEventListener('DOMContentLoaded', function() {
                const input = document.getElementById('ratingInput');
                if (!input) return;

                renderStars(input.value);

                input.addEventListener('input', function() {
                    let val = parseFloat(this.value);
                    if (isNaN(val)) val = 0;
                    if (val > 5) val = 5;
                    if (val < 0) val = 0;
                    renderStars(val);
                });
            });
        </script>
        @endpush
        @else
        <p class="text-muted"><a href="{{ route('login') }}">Login</a> untuk memberi ulasan.</p>
        @endauth

        @foreach($product->reviews as $rv)
        <div class="card border-0 shadow-sm mb-2 p-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <strong>{{ $rv->user->name }}</strong>
                    <small class="text-muted d-block">{{ $rv->created_at->diffForHumans() }}</small>
                </div>
                <div class="stars small text-end">
                    @for($i=1;$i<=5;$i++)
                        @php
                        if ($rv->rating >= $i) {
                        $icon = 'bi-star-fill';
                        } elseif ($rv->rating >= $i - 0.5) {
                        $icon = 'bi-star-half';
                        } else {
                        $icon = 'bi-star';
                        }
                        @endphp
                        <i class="bi {{ $icon }}"></i>
                        @endfor
                        <div class="text-muted small mt-1">{{ number_format($rv->rating, 1) }} / 5.0</div>
                </div>
            </div>
            @if($rv->comment)
            <p class="mb-0 small mt-2">{{ $rv->comment }}</p>
            @endif
        </div>
        @endforeach
    </div>

    {{-- Related --}}
    @if($related->count())
    <h4 class="fw-bold mt-5 mb-3">Produk Serupa</h4>
    <div class="row g-3">
        @foreach($related as $p)
        <div class="col-6 col-md-3">
            <a href="{{ route('product.show',$p) }}" class="text-decoration-none text-body">
                <div class="card card-product">
                    <img src="{{ $p->image ? asset('storage/'.$p->image) : 'https://via.placeholder.com/300x200?text='.$p->name }}" class="card-img-top" style="height:160px;object-fit:cover;">
                    <div class="card-body">
                        <h6 class="fw-bold mb-1 small">{{ $p->name }}</h6>
                        <div class="fw-bold text-danger small">Rp {{ number_format($p->price,0,',','.') }}</div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
