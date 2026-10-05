<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'phone', 'address', 'photo'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    /**
     * Akun yang sedang login.
     *
     * Dipakai menggantikan Auth::user() / $request->user() supaya return type-nya
     * eksplisit dan bisa diketeksi IDE serta static analysis.
     */
    public static function current(): ?self
    {
        $user = Auth::user();

        return $user instanceof self ? $user : null;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
