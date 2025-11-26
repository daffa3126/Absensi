<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan memiliki data yang valid
        if (!Auth::check() || !Auth::user() || !Auth::user()->role) {
            // Jika ada session yang rusak/tidak valid, bersihkan
            if (Auth::check()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            // Generate unique key berdasarkan IP dan User Agent
            $userKey = 'login_' . md5($request->ip() . $request->userAgent());

            // Cek apakah user pernah login (dari cache/storage)
            $wasLoggedIn = Cache::has($userKey);

            if ($wasLoggedIn) {
                // User pernah login sebelumnya, session expired
                session()->flash('error_session_expired', 'Sesi login anda telah habis, Silahkan login kembali');

                // Hapus marker login
                Cache::forget($userKey);
            } else {
                // User belum pernah login, akses langsung
                session()->flash('error_direct_access', 'Silahkan login terlebih dahulu untuk mengakses halaman tersebut');
            }

            // arahkan ke halaman login
            return redirect()->route('login');
        }

        // Set marker bahwa user pernah login (bertahan 2 jam)
        $userKey = 'login_' . md5($request->ip() . $request->userAgent());
        Cache::put($userKey, true, now()->addHours(2));

        return $next($request);
    }
}
