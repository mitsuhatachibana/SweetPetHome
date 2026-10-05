@extends('layouts.app')
@section('title','Manage Orders')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-3">Manage Orders</h3>
    <form method="GET" class="mb-3">
        <div class="row g-2">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" @selected(request('status')=='pending' )>Pending</option>
                    <option value="shopped" @selected(request('status')=='shopped' )>Shopped</option>
                    <option value="delivered" @selected(request('status')=='delivered' )>Delivered</option>
                </select>
            </div>
            <div class="col-md-2"><button class="btn btn-primary w-100">Filter</button></div>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Kode Order</th>
                        <th>Customer</th>
                        <th>Payment</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $o)
                    <tr>
                        <td><strong>{{ $o->order_code }}</strong></td>
                        <td>
                            {{ $o->user->name }}<br>
                            <small class="text-muted">{{ $o->user->email }}</small>
                        </td>
                        <td>{{ $o->payment_method }}</td>
                        <td>{{ $o->created_at->format('d M Y H:i') }}</td>
                        <td class="fw-bold">Rp {{ number_format($o->total,0,',','.') }}</td>
                        <td>
                            <span class="badge bg-{{ $o->status=='delivered'?'success':($o->status=='shopped'?'info':'warning') }}">
                                {{ ucfirst($o->status) }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.orders.status',$o) }}" class="d-flex gap-1">
                                @csrf @method('PATCH')
                                <select name="status" class="form-select form-select-sm" style="width:110px;">
                                    <option value="pending" @selected($o->status=='pending')>Pending</option>
                                    <option value="shopped" @selected($o->status=='shopped')>Shopped</option>
                                    <option value="delivered" @selected($o->status=='delivered')>Delivered</option>
                                </select>
                                <button class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $orders->links() }}</div>
</div>
@endsection
