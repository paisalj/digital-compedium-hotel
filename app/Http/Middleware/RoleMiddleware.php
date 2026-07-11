<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
public function handle(Request $request, Closure $next, ...$roles)
{
    // Jika user belum login, lempar ke halaman login
    if (!auth()->check()) {
        return redirect('login');
    }

    // Cek apakah role user ada di dalam daftar akses yang diperbolehkan
    if (!in_array(auth()->user()->role, $roles)) {
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }

    return $next($request);
}

}
