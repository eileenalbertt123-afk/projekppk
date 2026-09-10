<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Domain email yang diizinkan, dan role/tipe yang otomatis diberikan.
     */
    private const DOMAIN_MAP = [
    'students.undip.ac.id' => ['role' => 'pengguna', 'user_type' => 'mahasiswa'],
    'lecturer.undip.ac.id' => ['role' => 'pengguna', 'user_type' => 'dosen'],
    'staff.undip.ac.id'    => ['role' => 'pengguna', 'user_type' => 'staf'],
    'worker.undip.ac.id'   => ['role' => 'petugas',  'user_type' => null],
];

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $domain = strtolower(substr(strrchr($request->email, '@'), 1));

        if (!array_key_exists($domain, self::DOMAIN_MAP)) {
            throw ValidationException::withMessages([
                'email' => 'Gunakan email UNDIP resmi (@students.undip.ac.id, @lecturer.undip.ac.id, @staff.undip.ac.id, atau @worker.undip.ac.id).',
            ]);
        }

        $mapping = self::DOMAIN_MAP[$domain];

        $userTypeId = null;
        if ($mapping['user_type']) {
            $userTypeId = UserType::where('name', $mapping['user_type'])->value('id');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $mapping['role'],
            'user_type_id' => $userTypeId,
            'status_akun' => 'aktif',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}