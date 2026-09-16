@extends('layouts.app')

@section('content')

<!-- 1. HEADER RINGKASAN & JUDUL -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-extrabold text-brand-primary">Daftar Fasilitas</h2>
        <p class="text-sm text-brand-secondary mt-0.5">Temukan dan cek ketersediaan ruang fasilitas yang tersedia.</p>
    </div>

    <div class="flex items-center gap-3">
        <div class="bg-white px-4 py-2 rounded-xl border border-gray-200 shadow-sm text-center">
            <span class="text-[10px] text-brand-secondary uppercase tracking-wider block">Total Fasilitas</span>
            <span class="font-bold text-brand-primary text-base">{{ $facilities->count() }} Ruangan</span>
        </div>
    </div>
</div>

<!-- 2. FILTER & PENCARIAN -->
<form method="GET" class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-8 flex flex-wrap gap-3 items-center">
    <select name="type" class="bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm text-brand-primary focus:outline-none focus:border-brand-primary/50 focus:ring-1 focus:ring-brand-primary/30">
        <option value="">Semua Tipe</option>
        @foreach ($types as $type)
            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
        @endforeach
    </select>

    <select name="location" class="bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm text-brand-primary focus:outline-none focus:border-brand-primary/50 focus:ring-1 focus:ring-brand-primary/30">
        <option value="">Semua Lokasi</option>
        @foreach ($locations as $location)
            <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>{{ $location }}</option>
        @endforeach
    </select>

    <input type="number" name="capacity" placeholder="Kapasitas min" value="{{ request('capacity') }}" class="bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm text-brand-primary placeholder-brand-secondary/70 focus:outline-none focus:border-brand-primary/50 focus:ring-1 focus:ring-brand-primary/30 w-36">

    <select name="status" class="bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm text-brand-primary focus:outline-none focus:border-brand-primary/50 focus:ring-1 focus:ring-brand-primary/30">
        <option value="">Semua Status</option>
        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
        <option value="tidak tersedia" {{ request('status') == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
    </select>

    <button type="submit" class="bg-brand-primary hover:opacity-90 text-white font-semibold px-5 py-2 rounded-lg text-sm transition ml-auto shadow-sm">
        Cari
    </button>
</form>

<!-- 3. GRID KARTU FASILITAS -->
<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
    @forelse ($facilities as $facility)
        <a href="{{ route('facilities.availability', $facility) }}" class="group block bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-0.5 transition duration-200">
            <!-- Gambar & Badge Status -->
            <div class="relative h-44 bg-gradient-to-br from-brand-secondary/25 to-brand-tertiary/25 overflow-hidden">
                @if ($facility->image)
                    <img src="{{ asset('storage/' . $facility->image) }}" alt="{{ $facility->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center gap-1 text-brand-secondary">
                        <svg class="w-8 h-8 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs font-medium">Tidak ada gambar</span>
                    </div>
                @endif

                <span class="absolute top-3 right-3 text-xs px-2.5 py-1 rounded-full font-semibold border shadow-sm {{ $facility->status === 'tersedia' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-600 border-rose-200' }}">
                    {{ ucfirst($facility->status) }}
                </span>
            </div>

            <!-- Detail Ruangan -->
            <div class="p-5">
                <h3 class="font-bold text-lg text-brand-primary group-hover:opacity-80 transition">{{ $facility->name }}</h3>
                <p class="text-xs text-brand-secondary mt-1 mb-4">
                    {{ ucfirst($facility->type) }} &middot; {{ $facility->location }} &middot; Kapasitas {{ $facility->capacity }} Orang
                </p>

                <div class="flex items-center justify-between border-t border-gray-100 pt-3 text-xs text-brand-primary font-semibold">
                    <span>Cek Ketersediaan</span>
                    <span>→</span>
                </div>
            </div>
        </a>
    @empty
        <div class="col-span-full text-center py-12 text-brand-secondary bg-white rounded-xl border border-gray-200 shadow-sm">
            Fasilitas tidak ditemukan.
        </div>
    @endforelse
</div>

@endsection