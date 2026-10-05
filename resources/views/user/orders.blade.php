@extends('layouts.app')
@section('title','Riwayat Pesanan')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-4"><i class="bi bi-receipt"></i> Riwayat Pesanan</h3>

    @forelse($orders as $o)
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <div>
                    <div class="fw-bold">{{ $o->order_code }}</div>
                    <small class="text-muted">{{ $o->created_at->format('d M Y H:i') }}</small>
                </div>
                <div class="text-end">
                    <span class="badge bg-{{ $o->status=='delivered'?'success':($o->status=='shopped'?'info':'warning') }}">{{ ucfirst($o->status) }}</span>
                    <div class="fw-bold text-danger mt-1">Rp {{ number_format($o->total,0,',','.') }}</div>
                </div>
            </div>
            <ul class="list-group list-group-flush small">
                @foreach($o->items as $it)
                <li class="list-group-item px-0 d-flex justify-content-between">
                    <span>{{ $it->product->name }} x{{ $it->quantity }}</span>
                    <span>Rp {{ number_format($it->price*$it->quantity,0,',','.') }}</span>
                </li>
                @endforeach
            </ul>
            <a href="{{ route('receipt',$o) }}" class="btn btn-sm btn-outline-primary mt-2"><i class="bi bi-receipt"></i> Lihat Struk</a>
        </div>
    </div>
    @empty
    <div class="alert alert-info">Belum ada pesanan.</div>
    @endforelse
</div>
@endsection
