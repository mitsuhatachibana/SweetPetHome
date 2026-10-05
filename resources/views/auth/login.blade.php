<x-guest-layout>

    <h5 class="fw-bold text-center mb-1">Masuk ke Akun Anda</h5>
    <p class="text-center text-muted small mb-4">Silakan login untuk melanjutkan</p>

    @if (session('status'))
    <div class="alert alert-success small">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email / Username</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror"
                required autofocus autocomplete="username"
                placeholder="Masukkan email Anda">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password"
                class="form-control @error('password') is-invalid @enderror"
                required autocomplete="current-password"
                placeholder="Masukkan password">
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Remember --}}
        <div class="form-check mb-3">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label for="remember_me" class="form-check-label small">Ingat saya</label>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-sph mb-3">
            <i class="bi bi-box-arrow-in-right"></i> Login
        </button>

        {{-- Links --}}
        <div class="text-center small">
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="auth-link">Lupa password?</a>
            <span class="text-muted mx-1">•</span>
            @endif
            <span class="text-muted">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="auth-link">Register</a>
        </div>
    </form>

</x-guest-layout>
