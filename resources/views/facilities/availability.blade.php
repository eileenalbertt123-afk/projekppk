@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Tombol Kembali & Info Fasilitas -->
    <a href="{{ route('home') }}" class="text-indigo-400 text-sm hover:underline mb-3 inline-block">&larr; Kembali ke Daftar Fasilitas</a>
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white mb-1">{{ $facility->name }}</h1>
            <p class="text-sm text-gray-400">
                {{ ucfirst($facility->type) }} &middot; {{ $facility->location }} &middot; Kapasitas {{ $facility->capacity }} Orang
            </p>
        </div>
        <span class="px-3 py-1 rounded-full text-xs font-semibold border self-start md:self-auto {{ $facility->status === 'tersedia' ? 'bg-emerald-950/80 text-emerald-400 border-emerald-500/30' : 'bg-rose-950/80 text-rose-400 border-rose-500/30' }}">
            {{ ucfirst($facility->status) }}
        </span>
    </div>

    <!-- Form Pilih Tanggal -->
    <div class="bg-gray-800 p-4 rounded-xl border border-gray-700 mb-6">
        <form method="GET" class="flex items-center gap-3 flex-wrap">
            <label class="text-sm font-medium text-gray-300">Pilih Tanggal:</label>
            <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()" class="bg-gray-900 border border-gray-700 rounded-lg px-3 py-1.5 text-sm text-gray-200 focus:outline-none focus:border-indigo-500">
        </form>
    </div>

    <!-- Grid Slot Waktu (Sesuai SRS Poin 1) -->
    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700">
        <h2 class="text-lg font-bold text-white mb-1">Status Ketersediaan Slot Waktu</h2>
        <p class="text-xs text-gray-400 mb-6">Slot yang sudah terisi ditampilkan tanpa informasi detail pemohon untuk menjaga privasi.</p>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
            @foreach ($slots as $slot)
                <div class="p-3 rounded-lg border text-center flex flex-col justify-between gap-2 {{ $slot['status'] === 'tersedia' ? 'bg-gray-900 border-gray-700 text-gray-200' : 'bg-rose-950/20 border-rose-800/50 text-rose-300' }}">
                    <div>
                        <span class="block text-[10px] text-gray-400 uppercase tracking-wider">Jam Slot</span>
                        <span class="font-semibold text-sm">{{ $slot['start'] }} - {{ $slot['end'] }}</span>
                    </div>

                    @if ($slot['status'] === 'tersedia')
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-900/50 text-emerald-400 border border-emerald-700/50">
                            Tersedia
                        </span>

                        @auth
                            <!-- Tombol Pesan jika sudah Login (Menuju Poin 3 SRS) -->
                            <a href="{{ route('dashboard') }}?facility_id={{ $facility->id }}&date={{ $date }}&start={{ $slot['start'] }}&end={{ $slot['end'] }}" class="mt-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs py-1 px-2 rounded transition block font-medium">
                                Pesan Slot
                            </a>
                        @else
                            <!-- Tombol Login jika belum Login -->
                            <a href="{{ route('login') }}" class="mt-1 bg-gray-800 hover:bg-gray-700 text-gray-400 text-[10px] py-1 px-2 rounded transition block">
                                Login u/ Pesan
                            </a>
                        @endauth
                    @else
                        <!-- Jika Tidak Tersedia (Hanya Status Tanpa Detail Pemohon) -->
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-rose-900/50 text-rose-400 border border-rose-700/50">
                            Tidak Tersedia
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection