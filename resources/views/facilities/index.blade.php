@extends('layouts.app')

@section('content')

<!-- HEADER UTAMA -->
<div class="mb-8">
    <div class="flex items-center gap-3 mb-3">
        <div class="bg-brand-primary rounded-xl size-12 flex items-center justify-center shrink-0 shadow-card">
            <svg class="size-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 14.25l2.25 2.25 5.25-5.25" />
            </svg>
        </div>
        <h1 class="text-3xl font-extrabold text-brand-primary tracking-tight">
            Book<span class="text-brand-secondary">&amp;</span>Fix
        </h1>
    </div>
    <p class="text-sm text-brand-secondary max-w-2xl leading-relaxed">
        Platform reservasi fasilitas kampus. Cek ketersediaan ruangan, ajukan peminjaman,
        dan laporkan kerusakan fasilitas dalam satu tempat.
    </p>
</div>

<div class="bg-white/60 backdrop-blur-sm rounded-3xl border border-white/80 shadow-panel p-5 sm:p-8">
    <!-- 1. HEADER RINGKASAN & JUDUL -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-brand-primary">Daftar Fasilitas</h2>
            <p class="text-sm text-brand-secondary mt-0.5">Temukan dan cek ketersediaan ruang fasilitas yang tersedia.</p>
        </div>

        <div class="flex items-center gap-3">
        <div class="bg-white px-4 py-2 rounded-xl border border-gray-200 shadow-card text-center md:-translate-y-2">
            <span class="text-[10px] text-brand-secondary uppercase tracking-wider block">Total Fasilitas</span>
            <span class="font-bold text-brand-primary text-base">{{ $facilities->count() }} Ruangan</span>
        </div>
    </div>
    </div>


    <!-- PANDUAN RESERVASI -->
    <div class="animate-fade-up bg-brand-primary/5 border border-brand-primary/15 rounded-xl p-4 mb-6 shadow-md">
            <p class="text-sm font-semibold text-brand-primary mb-3">Cara meminjam fasilitas</p>
            <ol class="grid gap-3 sm:grid-cols-3">

                <!-- Langkah 1: Pilih fasilitas -->
                <li class="flex items-center gap-3">
                    <span class="size-9 shrink-0 rounded-lg bg-brand-primary flex items-center justify-center shadow-sm">
                        <svg class="size-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <span class="text-xs font-semibold text-brand-primary leading-snug">
                        Pilih fasilitas yang ingin dipinjam dari daftar di bawah
                    </span>
                </li>

                <!-- Langkah 2: Cek jadwal -->
                <li class="flex items-center gap-3">
                    <span class="size-9 shrink-0 rounded-lg bg-brand-primary flex items-center justify-center shadow-sm">
                        <svg class="size-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                    </span>
                    <span class="text-xs font-semibold text-brand-primary leading-snug">
                        Cek jadwal dan ketersediaan pada halaman fasilitas
                    </span>
                </li>

                <!-- Langkah 3: Ajukan peminjaman -->
                <li class="flex items-center gap-3">
                    <span class="size-9 shrink-0 rounded-lg bg-brand-primary flex items-center justify-center shadow-sm">
                        <svg class="size-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <span class="text-xs font-semibold text-brand-primary leading-snug">
                        Pilih waktu kosong lalu ajukan peminjaman
                    </span>
                </li>

            </ol>
        </div>

        <!-- 2. FILTER & PENCARIAN -->
        <form method="GET" style="animation-delay: 150ms" class="animate-fade-up bg-white p-3 rounded-xl border border-gray-200 shadow-card mb-8 flex flex-wrap gap-2 items-center">

            <!-- Tipe -->
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none text-brand-secondary">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </span>
                <select name="type" class="bg-gray-50 border border-gray-200 rounded-lg pl-8 pr-2 py-1.5 text-xs text-brand-primary focus:outline-none focus:border-brand-primary/50 focus:ring-1 focus:ring-brand-primary/30">
                    <option value="">Semua Tipe</option>
                    @foreach ($types as $type)
                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Lokasi -->
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none text-brand-secondary">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </span>
                <select name="location" class="bg-gray-50 border border-gray-200 rounded-lg pl-8 pr-2 py-1.5 text-xs text-brand-primary focus:outline-none focus:border-brand-primary/50 focus:ring-1 focus:ring-brand-primary/30">
                    <option value="">Semua Lokasi</option>
                    @foreach ($locations as $location)
                    <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>{{ $location }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Kapasitas -->
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none text-brand-secondary">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </span>
                <input type="number" name="capacity" placeholder="Kapasitas min" value="{{ request('capacity') }}" class="bg-gray-50 border border-gray-200 rounded-lg pl-8 pr-2 py-1.5 text-xs text-brand-primary placeholder-brand-secondary/70 focus:outline-none focus:border-brand-primary/50 focus:ring-1 focus:ring-brand-primary/30 w-36">
            </div>

            <!-- Status -->
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-2.5 pointer-events-none text-brand-secondary">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </span>
                <select name="status" class="bg-gray-50 border border-gray-200 rounded-lg pl-8 pr-2 py-1.5 text-xs text-brand-primary focus:outline-none focus:border-brand-primary/50 focus:ring-1 focus:ring-brand-primary/30">
                    <option value="">Semua Status</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
                    <option value="dalam_perbaikan" {{ request('status') == 'dalam_perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                </select>
            </div>

            <!-- Tombol Cari -->
            <button type="submit" class="inline-flex items-center gap-1.5 bg-brand-primary hover:opacity-90 text-white font-semibold px-4 py-1.5 rounded-lg text-xs transition ml-auto shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <span>Cari</span>
            </button>
        </form>

        <!-- 3. GRID KARTU FASILITAS -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($facilities as $facility)
            <a href="{{ route('facilities.availability', $facility) }}" style="animation-delay: {{ $loop->index * 80 }}ms" class="animate-fade-up group block cursor-pointer bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-card hover:shadow-card-hover hover:-translate-y-0.5 transition duration-200">
                <!-- Gambar & Badge Status -->
                <div class="relative h-48 bg-gradient-to-br from-brand-secondary/25 to-brand-tertiary/25 overflow-hidden">
                    @if ($facility->image)
                    <img src="{{ asset('storage/' . $facility->image) }}" alt="{{ $facility->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @else
                    <div class="w-full h-full flex flex-col items-center justify-center gap-1 text-brand-secondary">
                        <svg class="w-8 h-8 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-xs font-medium">Tidak ada gambar</span>
                    </div>
                    @endif

                    <span class="absolute top-3 right-3 text-xs px-2.5 py-1 rounded-full font-semibold border shadow-sm
            {{ $facility->status === 'tersedia'
                ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                : ($facility->status === 'nonaktif'
                    ? 'bg-gray-50 text-gray-600 border-gray-200'
                    : 'bg-amber-50 text-amber-700 border-amber-200')
            }}">
                        {{ $facility->status === 'nonaktif'
                ? 'Non Aktif'
                : ($facility->status === 'dalam_perbaikan'
                    ? 'Dalam Perbaikan'
                    : 'Tersedia') }}
                    </span>
                </div>

                <!-- Detail Ruangan -->
                <div class="p-4">
                    <h3 class="font-bold text-lg text-brand-primary group-hover:opacity-80 transition">{{ $facility->name }}</h3>

                    <!-- Info dengan ikon -->
                    <ul class="mt-3 space-y-2">
                        <!-- Tipe -->
                        <li class="flex items-center gap-2.5 text-xs text-brand-secondary">
                            <span class="size-7 shrink-0 rounded-lg bg-white border border-gray-200 shadow-card flex items-center justify-center text-brand-primary">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </span>
                            <span class="font-medium">{{ ucfirst($facility->type) }}</span>
                        </li>

                        <!-- Lokasi -->
                        <li class="flex items-center gap-2.5 text-xs text-brand-secondary">
                            <span class="size-7 shrink-0 rounded-lg bg-white border border-gray-200 shadow-card flex items-center justify-center text-brand-primary">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </span>
                            <span class="font-medium">{{ $facility->location }}</span>
                        </li>

                        <!-- Kapasitas -->
                        <li class="flex items-center gap-2.5 text-xs text-brand-secondary">
                            <span class="size-7 shrink-0 rounded-lg bg-white border border-gray-200 shadow-card flex items-center justify-center text-brand-primary">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </span>
                            <span class="font-medium">Kapasitas {{ $facility->capacity }} Orang</span>
                        </li>
                    </ul>

                    <!-- CTA -->
                    <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                        @if ($facility->status === 'tersedia')
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-primary group-hover:underline">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                Cek Jadwal &amp; Pinjam
                            </span>
                            <svg class="size-4 text-brand-primary group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-brand-secondary">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Lihat detail
                            </span>
                        @endif
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-12 text-brand-secondary bg-white rounded-xl border border-gray-200 shadow-card">
                Fasilitas tidak ditemukan.
            </div>
            @endforelse
        </div>
    </div>
@endsection