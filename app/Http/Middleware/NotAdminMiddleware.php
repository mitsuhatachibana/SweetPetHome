<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class NotAdminMiddleware
{
    /**
     * Blokir admin dari halaman khusus user (cart, checkout, dll).
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::current();

        if ($user && $user->isAdmin()) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Admin tidak dapat mengakses halaman keranjang.');
        }

        return $next($request);
    }
}
