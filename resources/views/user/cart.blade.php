@extends('layouts.app')
@section('title','Keranjang')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-4"><i class="bi bi-cart3"></i> Keranjang Belanja</h3>

    @if($carts->isEmpty())
    <div class="alert alert-info">Keranjang masih kosong. <a href="{{ route('home') }}">Belanja dulu yuk!</a></div>
    @else
    <div class="card border-0 shadow-sm p-3">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($carts as $c)
                    @php $sub = $c->product->price * $c->quantity; $total += $sub; @endphp
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $c->product->image ? asset('storage/'.$c->product->image) : 'https://via.placeholder.com/60' }}" width="60" height="60" style="object-fit:cover;" class="rounded">
                                <div>
                                    <div class="fw-semibold">{{ $c->product->name }}</div>
                                    <small class="text-muted">{{ $c->product->brand }}</small>
                                </div>
                            </div>
                        </td>
                        <td>Rp {{ number_format($c->product->price,0,',','.') }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.update',$c) }}" class="d-flex gap-1">
                                @csrf @method('PATCH')
                                <input type="number" name="quantity" value="{{ $c->quantity }}" min="1" class="form-control form-control-sm" style="width:70px;">
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-arrow-repeat"></i></button>
                            </form>
                        </td>
                        <td class="fw-bold">Rp {{ number_format($sub,0,',','.') }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.remove',$c) }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th colspan="2" class="text-danger fs-5">Rp {{ number_format($total,0,',','.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="text-end">
            <a href="{{ route('checkout.index') }}" class="btn btn-primary">Lanjut Checkout <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
    @endif
</div>
@endsection
