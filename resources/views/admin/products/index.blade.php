@extends('layouts.app')
@section('title','Manage Products')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3 class="fw-bold">Daftar Produk</h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Produk</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Sold</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                    <tr>
                        <td>
                            <img src="{{ $p->image ? asset('storage/'.$p->image) : 'https://via.placeholder.com/50' }}" width="50" height="50" style="object-fit:cover;" class="rounded">
                        </td>
                        <td>
                            {{ $p->name }}
                            @if($p->is_best_seller)<span class="badge badge-bestseller">🔥</span>@endif
                        </td>
                        <td>{{ $p->category->name }}</td>
                        <td>Rp {{ number_format($p->price,0,',','.') }}</td>
                        <td>{{ $p->stock }}</td>
                        <td>{{ $p->sold }}</td>
                        <td>
                            <a href="{{ route('admin.products.edit',$p) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.products.destroy',$p) }}" class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $products->links() }}</div>
</div>
@endsection
