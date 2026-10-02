<x-guest-layout>
    <!-- Judul -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-extrabold text-brand-primary tracking-tight">Masuk ke Akun</h2>
        <p class="text-sm text-brand-secondary mt-1">Sistem Reservasi Fasilitas Kampus</p>
    </div>

    <!-- Garis pemisah -->
    <div class="flex items-center gap-3 mb-6">
        <div class="flex-1 border-t border-gray-200"></div>
        <span class="text-xs text-brand-secondary">Silakan Masuk</span>
        <div class="flex-1 border-t border-gray-200"></div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-brand-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    placeholder="Masukkan email Anda"
                    class="block w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-300 bg-white text-brand-primary placeholder-gray-400 shadow-none focus:border-brand-primary focus:ring-0 transition" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative mt-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-brand-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </span>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="Masukkan password"
                    class="block w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-300 bg-white text-brand-primary placeholder-gray-400 shadow-none focus:border-brand-primary focus:ring-0 transition" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me + Lupa Password -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-brand-primary shadow-sm focus:ring-brand-primary" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-brand-secondary hover:text-brand-primary underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Tombol Login lebar penuh -->
        <x-primary-button class="w-full justify-center mt-6 py-3">
            {{ __('Log in') }}
        </x-primary-button>

        <!-- Link daftar -->
        <p class="text-sm text-brand-secondary text-center mt-6">
            Belum memiliki akun?
            <a class="font-semibold text-brand-primary underline hover:opacity-80" href="{{ route('register') }}">Daftar sekarang!</a>
        </p>
    </form>
</x-guest-layout>