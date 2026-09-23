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
    public function store(LoginRequest $request): RedirectResponse
{
    $start = microtime(true);

    $request->authenticate();

    logger()->info('AFTER AUTH', [
        'time' => microtime(true) - $start,
    ]);

    $start = microtime(true);

    $request->session()->regenerate();

    logger()->info('AFTER SESSION REGENERATE', [
        'time' => microtime(true) - $start,
    ]);

    $start = microtime(true);

    $user = Auth::user();

    logger()->info('AFTER AUTH USER', [
        'time' => microtime(true) - $start,
    ]);

    return match ($user->role) {
        'admin' => redirect('/admin'),
        'petugas' => redirect()->route('petugas.reservasi.dashboard'),
        'pengguna' => redirect('/pengguna'),
        default => redirect('/'),
    };
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
