@extends('layouts.app')
@section('title','Profil Saya')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-4"><i class="bi bi-person-circle"></i> Profil Saya</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4">
                @if($user->photo)
                <img src="{{ asset('storage/'.$user->photo) }}" class="rounded-circle mx-auto mb-3" width="120" height="120" style="object-fit:cover;">
                @else
                <i class="bi bi-person-circle text-secondary" style="font-size:120px;"></i>
                @endif
                <h5 class="fw-bold">{{ $user->name }}</h5>
                <p class="text-muted small mb-0">{{ $user->email }}</p>
                <span class="badge bg-secondary mt-2">{{ ucfirst($user->role) }}</span>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PATCH')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" value="{{ old('name',$user->name) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email',$user->email) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. HP</label>
                            <input type="text" name="phone" value="{{ old('phone',$user->phone) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Foto Profil</label>
                            <input type="file" name="photo" accept="image/*" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address',$user->address) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password Baru (opsional)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                    <button class="btn btn-primary mt-3"><i class="bi bi-save"></i> Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
