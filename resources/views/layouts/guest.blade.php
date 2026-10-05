<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SweetPetHome - Auth</title>

    <script>
        (function() {
            const saved = localStorage.getItem('theme') ||
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-bs-theme', saved);
        })();
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #ff7a59, #ffb26b);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            transition: background .3s;
        }

        [data-bs-theme="dark"] body {
            background: linear-gradient(135deg, #2a1810, #1a0f0a);
        }

        .auth-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px 32px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .15);
            width: 100%;
            max-width: 440px;
            position: relative;
            transition: background .3s, color .3s;
        }

        [data-bs-theme="dark"] .auth-card {
            background: #1e1e1e;
            color: #e0e0e0;
        }

        .auth-brand {
            font-weight: 800;
            font-size: 1.8rem;
            color: #ff7a59;
            text-align: center;
            margin-bottom: 4px;
        }

        [data-bs-theme="dark"] .auth-brand {
            color: #ff9a7d;
        }

        .auth-sub {
            color: #888;
            text-align: center;
            font-size: .9rem;
            margin-bottom: 28px;
        }

        .form-label {
            font-weight: 600;
            font-size: .88rem;
            color: #444;
        }

        [data-bs-theme="dark"] .form-label {
            color: #ccc;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 14px;
            border: 1px solid #e5e5e5;
            font-size: .92rem;
        }

        [data-bs-theme="dark"] .form-control {
            background: #2a2a2a;
            color: #e0e0e0;
            border-color: #3a3a3a;
        }

        .form-control:focus {
            border-color: #ff7a59;
            box-shadow: 0 0 0 .2rem rgba(255, 122, 89, .2);
        }

        [data-bs-theme="dark"] .form-control:focus {
            background: #2a2a2a;
            color: #e0e0e0;
        }

        .btn-sph {
            background: #ff7a59;
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 11px;
            border-radius: 10px;
            width: 100%;
            transition: .2s;
        }

        .btn-sph:hover {
            background: #e56a4a;
            color: #fff;
        }

        .auth-link {
            color: #ff7a59;
            text-decoration: none;
            font-weight: 600;
        }

        .auth-link:hover {
            text-decoration: underline;
            color: #e56a4a;
        }

        [data-bs-theme="dark"] .auth-link {
            color: #ff9a7d;
        }

        .form-check-input:checked {
            background-color: #ff7a59;
            border-color: #ff7a59;
        }

        .form-check-input:focus {
            border-color: #ff7a59;
            box-shadow: 0 0 0 .2rem rgba(255, 122, 89, .2);
        }

        .invalid-feedback {
            font-size: .8rem;
        }

        [data-bs-theme="dark"] .text-muted {
            color: #999 !important;
        }

        /* Floating theme toggle */
        .theme-toggle-floating {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            background: #fff;
            border: 2px solid #ff7a59;
            color: #ff7a59;
            border-radius: 50%;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all .2s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
        }

        .theme-toggle-floating:hover {
            background: #ff7a59;
            color: #fff;
        }

        [data-bs-theme="dark"] .theme-toggle-floating {
            background: #1e1e1e;
            border-color: #ff9a7d;
            color: #ff9a7d;
        }

        [data-bs-theme="dark"] .theme-toggle-floating:hover {
            background: #ff9a7d;
            color: #1e1e1e;
        }
    </style>
</head>

<body>

    <button class="theme-toggle-floating" onclick="toggleTheme()" title="Ganti tema">
        <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
    </button>

    <div class="auth-card">
        <div class="auth-brand">
            <i class="bi bi-heart-fill"></i> SweetPetHome
        </div>
        <div class="auth-sub">Belanja kebutuhan hewan kesayangan</div>

        {{ $slot }}
    </div>

    <script>
        function updateToggleIcon(theme) {
            const icon = document.getElementById('themeIcon');
            if (!icon) return;
            icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
        }

        function toggleTheme() {
            const current = document.documentElement.getAttribute('data-bs-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', next);
            localStorage.setItem('theme', next);
            updateToggleIcon(next);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const current = document.documentElement.getAttribute('data-bs-theme') || 'light';
            updateToggleIcon(current);
        });
    </script>
</body>

</html>
