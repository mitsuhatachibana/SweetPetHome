<x-guest-layout>

    <h5 class="fw-bold text-center mb-1">Daftar Akun Baru</h5>
    <p class="text-center text-muted small mb-4">Isi data di bawah untuk membuat akun</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                class="form-control @error('name') is-invalid @enderror"
                required autofocus autocomplete="name"
                placeholder="Nama Anda">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror"
                required autocomplete="username"
                placeholder="email@example.com">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
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
                placeholder="Ulangi password">
            @error('password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-sph mb-3">
            <i class="bi bi-person-plus"></i> Register
        </button>

        {{-- Link --}}
        <div class="text-center small">
            <span class="text-muted">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="auth-link">Login di sini</a>
        </div>
    </form>

</x-guest-layout>
