<x-guest-layout>

    <h5 class="fw-bold text-center mb-1">Lupa Password?</h5>
    <p class="text-center text-muted small mb-4">
        Masukkan email Anda, kami akan mengirim link untuk reset password.
    </p>

    @if (session('status'))
    <div class="alert alert-success small">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror"
                required autofocus
                placeholder="email@example.com">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-sph mb-3">
            <i class="bi bi-envelope"></i> Kirim Link Reset
        </button>

        <div class="text-center small">
            <a href="{{ route('login') }}" class="auth-link">
                <i class="bi bi-arrow-left"></i> Kembali ke Login
            </a>
        </div>
    </form>

</x-guest-layout>
