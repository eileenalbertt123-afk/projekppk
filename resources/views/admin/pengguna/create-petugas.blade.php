@extends('layouts.admin')

@section('content')

<div class="min-h-full">

    <div class="px-8 py-8">

        {{-- HEADER --}}
        <div class="mb-8">

            <div class="mb-4">
                <button
                    type="button"
                    onclick="history.back()"
                    class="inline-flex items-center gap-2
                           text-sm font-semibold text-[#708993]
                           hover:text-[#19183b]
                           transition">

                    <svg
                        class="size-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 19l-7-7 7-7" />

                    </svg>

                    Kembali

                </button>
            </div>


            <h1 class="font-extrabold text-[30px] tracking-[-0.75px] text-[#19183b]">
                Tambah Petugas
            </h1>

            <p class="text-sm text-[#708993] mt-1">
                Tambahkan akun petugas yang dapat mengelola reservasi dalam sistem.
            </p>

        </div>


        {{-- FORM --}}
        <div class="w-full bg-white border border-[#e2ebe9] rounded-2xl shadow-sm">

            <div class="px-6 py-5 border-b border-[#eef1f1]">

                <h2 class="text-base font-bold text-[#19183b]">
                    Data Akun Petugas
                </h2>

                <p class="text-xs text-[#708993] mt-1">
                    Isi data petugas dengan lengkap.
                </p>

            </div>


            <form
                action="{{ route('admin.pengguna.store.petugas') }}"
                method="POST"
                class="p-6 space-y-5">

                @csrf


                {{-- NAMA --}}
                <div>

                    <label
                        for="name"
                        class="block text-sm font-semibold text-[#19183b] mb-2">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        class="w-full px-4 py-3 rounded-xl
                               border border-[#dfe7e6]
                               text-sm text-[#19183b]
                               placeholder:text-[#9aaab0]
                               focus:outline-none
                               focus:ring-2 focus:ring-[#19183b]/10
                               focus:border-[#19183b]"
                        placeholder="Masukkan nama lengkap">

                    @error('name')
                        <p class="mt-1.5 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- EMAIL --}}
                <div>

                    <label
                        for="email"
                        class="block text-sm font-semibold text-[#19183b] mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full px-4 py-3 rounded-xl
                               border border-[#dfe7e6]
                               text-sm text-[#19183b]
                               placeholder:text-[#9aaab0]
                               focus:outline-none
                               focus:ring-2 focus:ring-[#19183b]/10
                               focus:border-[#19183b]"
                        placeholder="Masukkan email petugas">

                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- PASSWORD --}}
                <div>

                    <label
                        for="password"
                        class="block text-sm font-semibold text-[#19183b] mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full px-4 py-3 rounded-xl
                               border border-[#dfe7e6]
                               text-sm text-[#19183b]
                               placeholder:text-[#9aaab0]
                               focus:outline-none
                               focus:ring-2 focus:ring-[#19183b]/10
                               focus:border-[#19183b]"
                        placeholder="Masukkan password">

                    @error('password')
                        <p class="mt-1.5 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- KONFIRMASI PASSWORD --}}
                <div>

                    <label
                        for="password_confirmation"
                        class="block text-sm font-semibold text-[#19183b] mb-2">
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        class="w-full px-4 py-3 rounded-xl
                               border border-[#dfe7e6]
                               text-sm text-[#19183b]
                               placeholder:text-[#9aaab0]
                               focus:outline-none
                               focus:ring-2 focus:ring-[#19183b]/10
                               focus:border-[#19183b]"
                        placeholder="Ulangi password">

                </div>


                {{-- INFO ROLE --}}
                <div class="rounded-xl bg-[#f4f8f7] border border-[#dfeae7] px-4 py-3">

                    <p class="text-xs text-[#52656d]">

                        <span class="font-semibold text-[#19183b]">
                            Role:
                        </span>

                        Petugas

                    </p>

                    <p class="text-xs text-[#708993] mt-1">
                        Akun ini dibuat langsung oleh admin dan akan memiliki role petugas.
                    </p>

                </div>


                {{-- BUTTON --}}
                <div class="flex items-center justify-end gap-3 pt-2">

                    <a
                        href="{{ route('admin.pengguna.index') }}"
                        class="px-5 py-2.5 rounded-xl
                               border border-[#dfe7e6]
                               text-sm font-semibold text-[#52656d]
                               hover:bg-[#f7f9f9]
                               transition">
                        Batal
                    </a>


                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-xl
                               bg-[#19183b]
                               text-white
                               text-sm font-semibold
                               hover:bg-[#29284f]
                               transition">
                        Tambah Petugas
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection