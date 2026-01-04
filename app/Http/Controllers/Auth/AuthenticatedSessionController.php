<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        // 1. Data Dummy User (Ganti Database)
        $dummyUsers = [
            'owner@owner.com' => ['password' => 'owner123', 'role' => 'owner', 'name' => 'Owner MFC'],
            'kasir@kasir.com' => ['password' => 'kasir123', 'role' => 'kasir', 'name' => 'Kasir Utama'],
            'dapur@dapur.com' => ['password' => 'dapur123', 'role' => 'dapur', 'name' => 'Chef Dapur'],
        ];

        $email = $request->email;
        $password = $request->password;

        // 2. Cek apakah email ada di dummy data & password cocok
        if (isset($dummyUsers[$email]) && $dummyUsers[$email]['password'] === $password) {

            // 3. Simpan data ke SESSION (Bukan Auth Guard)
            session([
                'user_logged_in' => true,
                'user_role' => $dummyUsers[$email]['role'],
                'user_name' => $dummyUsers[$email]['name']
            ]);

            // 4. Redirect sesuai role
            return match ($dummyUsers[$email]['role']) {
                'owner' => redirect('/owner'),
                'dapur' => redirect('/dapur'),
                'kasir' => redirect('/kasir'),
            };
        }

        return back()->withErrors(['email' => 'Email atau password dummy salah!']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Hapus semua data session dummy
        $request->session()->forget(['user_logged_in', 'user_role', 'user_name']);

        // Opsional: Bersihkan semua session untuk keamanan prototype
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
