<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Nama --}}
        <div>
            <x-input-label for="name" value="Nama Lengkap" />

            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div class="mt-4">
            <x-input-label for="email" value="Email" />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- NIM / NIP --}}
        <div class="mt-4">
            <x-input-label for="identifier" value="NIM / NIP" />

            <x-text-input
                id="identifier"
                class="block mt-1 w-full"
                type="text"
                name="identifier"
                :value="old('identifier')"
                required
                inputmode="numeric"
                maxlength="14"
                pattern="[0-9]{14}"
                placeholder="Masukkan NIM/NIP 14 digit"
            />

            <x-input-error :messages="$errors->get('identifier')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <x-input-label for="password" value="Password" />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />

            <p class="text-xs text-gray-500 mt-1">
                Password minimal 8 karakter.
            </p>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Konfirmasi Password --}}
        <div class="mt-4">
            <x-input-label
                for="password_confirmation"
                value="Konfirmasi Password"
            />

            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />
        </div>

        {{-- Tombol --}}
        <div class="flex items-center justify-end mt-4">
            <a
                href="{{ route('login') }}"
                class="underline text-sm text-gray-600 hover:text-gray-900"
            >
                Sudah punya akun?
            </a>

            <x-primary-button class="ms-4">
                Daftar
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>