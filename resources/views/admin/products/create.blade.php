@extends('layouts.app')
@section('title','Tambah Produk')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-3">Tambah Produk</h3>
    <div class="card border-0 shadow-sm p-4">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Brand</label>
                    <input type="text" name="brand" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stock" class="form-control" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Foto Produk</label>
                    <input type="file" name="image" accept="image/*" class="form-control">
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_best_seller" value="1" id="bs">
                        <label class="form-check-label" for="bs">Tandai sebagai Best Seller</label>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary mt-3">Simpan</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mt-3">Batal</a>
        </form>
    </div>
</div>
@endsection
