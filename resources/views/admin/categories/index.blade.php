@extends('layouts.app')
@section('title','Manage Categories')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h3 class="fw-bold">Kategori Produk</h3>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Kategori</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Slug</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $c)
                    <tr>
                        <td>{{ $loop->iteration + ($categories->currentPage()-1)*$categories->perPage() }}</td>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->type }}</td>
                        <td><code>{{ $c->slug }}</code></td>
                        <td>
                            <a href="{{ route('admin.categories.edit',$c) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.categories.destroy',$c) }}" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
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
    <div class="mt-3">{{ $categories->links() }}</div>
</div>
@endsection
