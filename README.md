# 🐾 SweetPetHome

Aplikasi e-commerce petshop berbasis Laravel + Breeze + Bootstrap 5.

## ✨ Fitur

### Admin
- Login
- CRUD Kategori
- CRUD Produk + upload gambar
- Kelola Pesanan (semua order dari user)
- Dashboard (total revenue, products, users)

### User
- Register (perlu login ulang setelah daftar)
- Login
- Home + filter (search, kategori, harga, sort)
- Detail produk + rating desimal (4.7, 4.8, dst) + review
- Add to cart
- Checkout (Cash/Tunai, GoPay, OVO, DANA, Bank, dll)
- Struk bisa di-print
- Riwayat pesanan
- Edit profil + upload foto

## 🛠️ Tech Stack
- Laravel 11/12
- Laravel Breeze (Blade)
- Bootstrap 5.3
- MySQL
- Bootstrap Icons
- Dark mode toggle

## 📦 Instalasi

```bash
git clone https://github.com/usernamekamu/sweetpethome.git
cd sweetpethome
composer install
cp .env.example .env
php artisan key:generate
# Edit .env → set DB_DATABASE, DB_USERNAME, DB_PASSWORD
php artisan migrate --seed
php artisan storage:link
php artisan serve
