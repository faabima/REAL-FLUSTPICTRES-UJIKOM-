<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OneAccessOnly
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && ! $user->hasAccess()) {
            // Jika pengguna tidak memiliki akses, redirect ke halaman tertentu
            return redirect('/forbidden');
        }
        return $next($request);
    }
}
