@extends('layouts.app')
@section('title','Checkout')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-4">Checkout</h3>
    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf
        <div class="row g-4">
            <div class="col-md-7">
                <div class="card border-0 shadow-sm p-3 mb-3">
                    <h6 class="fw-bold">Informasi Pengiriman</h6>
                    <div class="mb-2">
                        <label class="form-label small">No. HP</label>
                        <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label small">Alamat</label>
                        <textarea name="address" class="form-control" rows="3" required>{{ old('address', auth()->user()->address) }}</textarea>
                    </div>
                </div>
                <div class="card border-0 shadow-sm p-3">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-credit-card"></i> Metode Pembayaran
                    </h6>

                    @php
                    $iconMap = [
                    'Cash / Tunai' => 'bi-cash-coin',
                    'GoPay' => 'bi-phone',
                    'OVO' => 'bi-phone',
                    'DANA' => 'bi-phone',
                    'ShopeePay' => 'bi-phone',
                    'PayLater' => 'bi-calendar-check',
                    'Transfer Bank'=> 'bi-bank',
                    'BCA' => 'bi-bank',
                    'Mandiri' => 'bi-bank',
                    'BSI' => 'bi-bank',
                    'BRI' => 'bi-bank',
                    'BNI' => 'bi-bank',
                    'BTN' => 'bi-bank',
                    'SeaBank' => 'bi-bank',
                    'HSBC' => 'bi-bank',
                    ];
                    @endphp

                    @foreach($paymentMethods as $pm)
                    <div class="form-check payment-option p-2 ps-4 rounded mb-1">
                        <input class="form-check-input" type="radio" name="payment_method"
                            value="{{ $pm }}" id="pm{{ $loop->index }}"
                            {{ $loop->first ? 'checked' : '' }}>
                        <label class="form-check-label d-flex align-items-center gap-2"
                            for="pm{{ $loop->index }}">
                            <i class="bi {{ $iconMap[$pm] ?? 'bi-credit-card' }} text-primary"></i>
                            <span>{{ $pm }}</span>
                            @if($pm === 'Cash / Tunai')
                            <span class="badge bg-success ms-auto">Bayar di Tempat</span>
                            @endif
                        </label>
                    </div>
                    @endforeach
                </div>

                @push('styles')
                <style>
                    .payment-option {
                        transition: background .2s;
                        cursor: pointer;
                    }

                    .payment-option:hover {
                        background: rgba(255, 122, 89, .08);
                    }
                </style>
                @endpush
            </div>
            <div class="col-md-5">
                <div class="card border-0 shadow-sm p-3">
                    <h6 class="fw-bold">Ringkasan Pesanan</h6>
                    <ul class="list-group list-group-flush">
                        @foreach($carts as $c)
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>{{ $c->product->name }} <small class="text-muted">x{{ $c->quantity }}</small></span>
                            <span>Rp {{ number_format($c->product->price * $c->quantity,0,',','.') }}</span>
                        </li>
                        @endforeach
                        <li class="list-group-item d-flex justify-content-between px-0 fw-bold">
                            <span>Total</span>
                            <span class="text-danger">Rp {{ number_format($total,0,',','.') }}</span>
                        </li>
                    </ul>
                    <button class="btn btn-primary w-100 mt-3">Bayar Sekarang</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
