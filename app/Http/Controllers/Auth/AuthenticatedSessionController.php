<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Permission\Traits\HasRoles;

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
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Logika Redirect berdasarkan Role
        $user = $request->user();

        if ($user->hasRole('admin_tu')) {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->hasRole('kepala_sekolah')) {
            return redirect()->intended(route('kepsek.dashboard'));
        } elseif ($user->hasRole('orang_tua')) {
            return redirect()->intended(route('ortu.dashboard'));
        }

        // Fallback jika tidak punya role (opsional)
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login')->with('status', 'Anda telah berhasil keluar dari sistem.');
    }
}
