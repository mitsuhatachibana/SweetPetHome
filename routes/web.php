<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDash;
use App\Http\Controllers\Admin\CategoryController as AdminCat;
use App\Http\Controllers\Admin\ProductController as AdminProd;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\OrderController as UserOrder;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ReviewController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
| Home & about bisa diakses semua orang. Tapi kalau admin yang login,
| HomeController akan otomatis redirect ke dashboard admin.
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/product/{product}', [HomeController::class, 'show'])->name('product.show');

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| USER ROUTES (Login + Bukan Admin)
|--------------------------------------------------------------------------
| Cart, checkout, riwayat pesanan, review = hanya untuk user biasa.
| Admin diblokir oleh middleware 'not_admin'.
*/
Route::middleware(['auth', 'not_admin'])->group(function () {

    Route::get('/dashboard', fn() => redirect()->route('home'))->name('dashboard');

    // Profile (boleh user & admin, tapi ditaruh user dulu biar rapi)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/receipt/{order}', [CheckoutController::class, 'receipt'])->name('receipt');

    // Riwayat Pesanan (milik sendiri)
    Route::get('/orders', [UserOrder::class, 'index'])->name('orders.index');

    // Review
    Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('review.store');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
| Semua route admin prefix /admin, name prefix admin.
| Middleware: auth + admin
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDash::class, 'index'])->name('dashboard');

    // CRUD Kategori
    Route::resource('categories', AdminCat::class);

    // CRUD Produk
    Route::resource('products', AdminProd::class);

    // Manage Orders (semua order dari semua user)
    Route::get('orders', [AdminOrder::class, 'index'])->name('orders.index');
    Route::patch('orders/{order}/status', [AdminOrder::class, 'updateStatus'])->name('orders.status');
});
