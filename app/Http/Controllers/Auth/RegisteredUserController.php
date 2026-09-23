<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RegistrableUser;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class,
            ],

            'identifier' => [
                'required',
                'digits:14',
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::min(8),
            ],
        ]);

        // Mencari NIM/NIP yang terdaftar dan belum digunakan.
        $registrableUser = RegistrableUser::where('identifier', $request->identifier)
            ->where('is_registered', false)
            ->first();

        if (!$registrableUser) {
            throw ValidationException::withMessages([
                'identifier' => 'NIM/NIP tidak terdaftar atau sudah digunakan untuk registrasi.',
            ]);
        }

        DB::transaction(function () use ($request, $registrableUser) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'identifier' => $request->identifier,
                'password' => Hash::make($request->password),
                'role' => 'pengguna',
                'user_type_id' => $registrableUser->user_type_id,
                'status_akun' => 'menunggu',
            ]);

            // Menandai NIM/NIP bahwa sudah digunakan.
            $registrableUser->update([
                'is_registered' => true,
            ]);

            event(new Registered($user));

            
        });

        return redirect()->route('login')->with(
            'status',
            'Registrasi berhasil. Akun Anda sedang menunggu verifikasi admin.'
        );
    }
}
