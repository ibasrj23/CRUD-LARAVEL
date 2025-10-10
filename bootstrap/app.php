<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // 1. Cek apakah user login dan apakah role-nya 1 (Admin)
        if ($user && $user->role == 1) {
            return $next($request);
        }

        // 2. Jika tidak, redirect ke halaman home atau index
        // Kita tidak perlu me-logout user jika mereka hanya user biasa (Role 2)
        else {
            // Mengarahkan ke halaman home atau dashboard user dengan pesan error
            return redirect('/home')
                ->with('error', "Akses Ditolak! Anda harus menjadi Administrator untuk mengakses halaman ini.");

            /* // Jika Anda lebih suka mengembalikan error 403 HTTP:
            // abort(403, 'Anda tidak memiliki akses!');
            */
        }
    }
}