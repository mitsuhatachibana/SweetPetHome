<x-guest-layout>

    <h5 class="fw-bold text-center mb-1">Reset Password</h5>
    <p class="text-center text-muted small mb-4">Buat password baru untuk akun Anda</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                class="form-control @error('email') is-invalid @enderror"
                required autofocus autocomplete="username">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password Baru</label>
            <input id="password" type="password" name="password"
                class="form-control @error('password') is-invalid @enderror"
                required autocomplete="new-password"
                placeholder="Minimal 8 karakter">
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                required autocomplete="new-password"
                placeholder="Ulangi password baru">
            @error('password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-sph mb-3">
            <i class="bi bi-key"></i> Reset Password
        </button>

        <div class="text-center small">
            <a href="{{ route('login') }}" class="auth-link">
                <i class="bi bi-arrow-left"></i> Kembali ke Login
            </a>
        </div>
    </form>

</x-guest-layout>
