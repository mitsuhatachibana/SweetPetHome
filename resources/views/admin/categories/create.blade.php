@extends('layouts.app')
@section('title','Tambah Kategori')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-3">Tambah Kategori</h3>
    <div class="card border-0 shadow-sm p-4">
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tipe</label>
                <input type="text" name="type" class="form-control" placeholder="Foods - Dry, Hewan - Ikan, dll">
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
