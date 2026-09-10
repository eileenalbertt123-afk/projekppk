@extends('layouts.app')

@section('content')

<!-- 1. HEADER RINGKASAN & JUDUL -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-white">Daftar Fasilitas</h2>
        <p class="text-sm text-gray-400">Temukan dan cek ketersediaan ruang fasilitas yang tersedia.</p>
    </div>

    <!-- Ringkasan Statistik (Sederhana) -->
    <div class="flex items-center gap-3">
        <div class="bg-gray-800 px-4 py-2 rounded-xl border border-gray-700 text-center">
            <span class="text-[10px] text-gray-400 uppercase tracking-wider block">Total Fasilitas</span>
            <span class="font-bold text-indigo-400 text-base">{{ $facilities->count() }} Ruangan</span>
        </div>
    </div>
</div>

<!-- 2. FILTER & PENCARIAN (Rapi 1 Baris) -->
<form method="GET" class="bg-gray-800 p-4 rounded-xl border border-gray-700 mb-8 flex flex-wrap gap-3 items-center">
    <select name="type" class="bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-200 focus:outline-none focus:border-indigo-500">
        <option value="">Semua Tipe</option>
        @foreach ($types as $type)
            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
        @endforeach
    </select>

    <select name="location" class="bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-200 focus:outline-none focus:border-indigo-500">
        <option value="">Semua Lokasi</option>
        @foreach ($locations as $location)
            <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>{{ $location }}</option>
        @endforeach
    </select>

    <input type="number" name="capacity" placeholder="Kapasitas min" value="{{ request('capacity') }}" class="bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-200 focus:outline-none focus:border-indigo-500 w-36">

    <select name="status" class="bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm text-gray-200 focus:outline-none focus:border-indigo-500">
        <option value="">Semua Status</option>
        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
        <option value="tidak tersedia" {{ request('status') == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
    </select>

    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2 rounded-lg text-sm transition ml-auto">
        Cari
    </button>
</form>

<!-- 3. GRID KARTU FASILITAS -->
<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
    @forelse ($facilities as $facility)
        <a href="{{ route('facilities.availability', $facility) }}" class="group block border border-gray-800 bg-gray-800/60 rounded-xl overflow-hidden hover:border-gray-600 hover:bg-gray-800 transition duration-200">
            <!-- Gambar & Badge Status Overlay -->
            <div class="relative h-44 bg-gray-700 overflow-hidden">
                @if ($facility->image)
                    <img src="{{ asset('storage/' . $facility->image) }}" alt="{{ $facility->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-500 text-sm">Tidak ada gambar</div>
                @endif
                
                <!-- Badge Status di Pojok Gambar -->
                <span class="absolute top-3 right-3 text-xs px-2.5 py-1 rounded-full font-semibold border shadow-md {{ $facility->status === 'tersedia' ? 'bg-emerald-950/80 text-emerald-400 border-emerald-500/30' : 'bg-rose-950/80 text-rose-400 border-rose-500/30' }}">
                    {{ ucfirst($facility->status) }}
                </span>
            </div>

            <!-- Detail Ruangan -->
            <div class="p-5">
                <h3 class="font-bold text-lg text-white group-hover:text-indigo-400 transition">{{ $facility->name }}</h3>
                <p class="text-xs text-gray-400 mt-1 mb-4">
                    {{ ucfirst($facility->type) }} &middot; {{ $facility->location }} &middot; Kapasitas {{ $facility->capacity }} Orang
                </p>

                <div class="flex items-center justify-between border-t border-gray-700/60 pt-3 text-xs text-indigo-400 font-medium">
                    <span>Cek Ketersediaan</span>
                    <span>→</span>
                </div>
            </div>
        </a>
    @empty
        <div class="col-span-full text-center py-12 text-gray-500 bg-gray-800/30 rounded-xl border border-gray-800">
            Fasilitas tidak ditemukan.
        </div>
    @endforelse
</div>

@endsection