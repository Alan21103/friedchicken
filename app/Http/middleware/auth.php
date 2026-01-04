<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Auth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah session login dummy ada
        if (!$request->session()->has('user_logged_in')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Cek apakah role di session sesuai dengan parameter di route
        if ($request->session()->get('user_role') !== $role) {
            $currentRole = $request->session()->get('user_role');
            return redirect('/' . $currentRole)->with('error', 'Akses ditolak!');
        }

        return $next($request);
    }
}