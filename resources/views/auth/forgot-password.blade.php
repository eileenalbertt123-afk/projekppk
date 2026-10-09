<x-guest-layout>
    <!-- Judul -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-extrabold text-brand-primary tracking-tight">Lupa Password?</h2>
        <p class="text-sm text-brand-secondary mt-1">Sistem Reservasi Fasilitas Kampus</p>
    </div>

    <!-- Garis pemisah -->
    <div class="flex items-center gap-3 mb-6">
        <div class="flex-1 border-t border-gray-200"></div>
        <span class="text-xs text-brand-secondary">Reset Password</span>
        <div class="flex-1 border-t border-gray-200"></div>
    </div>

    <!-- Deskripsi -->
    <p class="mb-6 text-sm text-brand-secondary text-center leading-relaxed">
        Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password Anda.
    </p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
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
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="Masukkan email Anda"
                    class="block w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-300 bg-white text-brand-primary placeholder-gray-400 shadow-none focus:border-brand-primary focus:ring-0 transition" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Tombol Kirim lebar penuh -->
        <x-primary-button class="w-full justify-center mt-6 py-3">
            <svg class="w-5 h-5 mr-2 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
            </svg>
            Kirim Tautan Reset Password
        </x-primary-button>

        <!-- Link kembali ke login -->
        <p class="text-sm text-brand-secondary text-center mt-6">
            <a class="inline-flex items-center font-semibold text-brand-primary underline hover:opacity-80" href="{{ route('login') }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke halaman login
            </a>
        </p>
    </form>
</x-guest-layout>