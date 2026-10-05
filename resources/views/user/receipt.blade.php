@extends('layouts.app')
@section('title','Struk')

@section('content')
<div class="container">
    <div class="card border-0 shadow-sm mx-auto" style="max-width:600px;" id="receipt">
        <div class="card-body p-4">
            <div class="text-center mb-3">
                <h3 class="fw-bold mb-0">🐾 SweetPetHome</h3>
                <small class="text-muted">Toko Kebutuhan Hewan Terpercaya</small>
                <hr>
            </div>
            <div class="row small mb-2">
                <div class="col-6">
                    <div><strong>Kode Order:</strong> {{ $order->order_code }}</div>
                    <div><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</div>
                </div>
                <div class="col-6 text-end">
                    <div><strong>Pembeli:</strong> {{ $order->user->name }}</div>
                    <div>
                        <strong>Bayar:</strong> {{ $order->payment_method }}
                        @if($order->payment_method === 'Cash / Tunai')
                        <span class="badge bg-success ms-1">Bayar di Tempat</span>
                        @endif
                    </div>
                </div>
            </div>
            <hr>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $it)
                    <tr>
                        <td>{{ $it->product->name }}</td>
                        <td>{{ $it->quantity }}</td>
                        <td>Rp {{ number_format($it->price,0,',','.') }}</td>
                        <td>Rp {{ number_format($it->price*$it->quantity,0,',','.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">TOTAL</th>
                        <th class="text-danger">Rp {{ number_format($order->total,0,',','.') }}</th>
                    </tr>
                </tfoot>
            </table>
            <hr>
            <p class="small">Alamat: {{ $order->address }} • HP: {{ $order->phone }}</p>
            <p class="text-center small text-muted mb-0">Terima kasih telah berbelanja di SweetPetHome! 🐶🐱</p>
        </div>
    </div>
    <div class="text-center mt-3">
        <button class="btn btn-primary" onclick="window.print()"><i class="bi bi-printer"></i> Print Struk</button>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Riwayat Pesanan</a>
    </div>
</div>

@push('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #receipt,
        #receipt * {
            visibility: visible;
            color: #000 !important;
            background: #fff !important;
        }

        #receipt {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        #receipt .card-body {
            background: #fff !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush
@endsection
