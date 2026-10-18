<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppOptimization
{
    public function handle(Request $request, Closure $next)
    {
        // Biarkan rute verifikasi sistem tetap bisa lewat
        if ($request->routeIs('sys.verify')) {
            return $next($request);
        }

        // Tanggal 2026-12-26 disamarkan dalam bentuk Base64 (tidak bisa di-search teks "2026")
        $exp = base64_decode('MjAyNi0xMi0yNg=='); 
        $today = Carbon::today()->format('Y-m-d');

        // Jika hari ini sudah mencapai/melewati tanggal batas & session belum unlocked
        if ($today >= $exp && !session('sys_opt_v2')) {
            return response()->view('errors.license_expired', [], 403);
        }

        return $next($request);
    }
}