<x-guest-layout>
    <!-- Judul -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-extrabold text-brand-primary tracking-tight">Buat Akun Baru</h2>
        <p class="text-sm text-brand-secondary mt-1">Sistem Reservasi Fasilitas Kampus</p>
    </div>

    <!-- Garis pemisah -->
    <div class="flex items-center gap-3 mb-6">
        <div class="flex-1 border-t border-gray-200"></div>
        <span class="text-xs text-brand-secondary">Silakan Daftar</span>
        <div class="flex-1 border-t border-gray-200"></div>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nama Lengkap -->
        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-brand-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </span>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    placeholder="Masukkan nama lengkap"
                    class="block w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-300 bg-white text-brand-primary placeholder-gray-400 shadow-none focus:border-brand-primary focus:ring-0 transition" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" value="Email" />
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-brand-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    placeholder="Masukkan email Anda"
                    class="block w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-300 bg-white text-brand-primary placeholder-gray-400 shadow-none focus:border-brand-primary focus:ring-0 transition" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- NIM / NIP -->
        <div class="mt-4">
            <x-input-label for="nim_nip" value="NIM / NIP" />
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-brand-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                    </svg>
                </span>
                <input id="nim_nip" type="text" name="nim_nip" value="{{ old('nim_nip') }}" required inputmode="numeric"
                    placeholder="Masukkan NIM/NIP 14 digit"
                    class="block w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-300 bg-white text-brand-primary placeholder-gray-400 shadow-none focus:border-brand-primary focus:ring-0 transition" />
            </div>
            <x-input-error :messages="$errors->get('nim_nip')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-brand-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </span>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="Masukkan password"
                    class="block w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-300 bg-white text-brand-primary placeholder-gray-400 shadow-none focus:border-brand-primary focus:ring-0 transition" />
            </div>
            <p class="text-xs text-brand-secondary mt-1.5">Password minimal 8 karakter.</p>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Konfirmasi Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-brand-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </span>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    placeholder="Ulangi password"
                    class="block w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-300 bg-white text-brand-primary placeholder-gray-400 shadow-none focus:border-brand-primary focus:ring-0 transition" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Tombol Daftar lebar penuh -->
        <x-primary-button class="w-full justify-center mt-6 py-3">
            Daftar
        </x-primary-button>

        <!-- Link login -->
        <p class="text-sm text-brand-secondary text-center mt-6">
            Sudah punya akun?
            <a class="font-semibold text-brand-primary underline hover:opacity-80" href="{{ route('login') }}">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>