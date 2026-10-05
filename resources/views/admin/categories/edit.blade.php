@extends('layouts.app')
@section('title','Edit Kategori')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-3">Edit Kategori</h3>
    <div class="card border-0 shadow-sm p-4">
        <form method="POST" action="{{ route('admin.categories.update',$category) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tipe</label>
                <input type="text" name="type" value="{{ $category->type }}" class="form-control">
            </div>
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
