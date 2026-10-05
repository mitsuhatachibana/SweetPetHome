<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = User::current();

        if (! $user || ! $user->isAdmin()) {
            abort(403, 'Akses hanya untuk admin.');
        }

        return $next($request);
    }
}
