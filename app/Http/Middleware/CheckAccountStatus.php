<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->status_akun !== 'aktif') {
            auth()->logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Akun kamu belum aktif.',
                ]);
        }

        return $next($request);
    }
}