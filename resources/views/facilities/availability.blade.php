@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">
    <a href="{{ route('home') }}" class="text-brand-primary text-sm font-medium hover:underline mb-3 inline-block">&larr; Kembali ke Daftar Fasilitas</a>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-brand-primary mb-1">{{ $facility->name }}</h1>
            <p class="text-sm text-brand-secondary">
                {{ ucfirst($facility->type) }} &middot; {{ $facility->location }} &middot; Kapasitas {{ $facility->capacity }} Orang
            </p>
        </div>
        <span class="px-3 py-1 rounded-full text-xs font-semibold border shadow-sm self-start md:self-auto {{ $facility->status === 'tersedia' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-600 border-rose-200' }}">
            {{ ucfirst($facility->status) }}
        </span>
    </div>

    <!-- Form Pilih Tanggal -->
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-6">
        <form method="GET" class="flex items-center gap-3 flex-wrap">
            <label class="text-sm font-medium text-brand-primary">Pilih Tanggal:</label>
            <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()" class="bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-brand-primary focus:outline-none focus:border-brand-primary/50 focus:ring-1 focus:ring-brand-primary/30">
        </form>
    </div>

    <!-- Grid Slot Waktu -->
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <h2 class="text-lg font-bold text-brand-primary mb-1">Status Ketersediaan Slot Waktu</h2>
        <p class="text-xs text-brand-secondary mb-6">Slot yang sudah terisi ditampilkan tanpa informasi detail pemohon untuk menjaga privasi.</p>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
            @foreach ($slots as $slot)
                <div class="p-3 rounded-lg border text-center flex flex-col justify-between gap-2 {{ $slot['status'] === 'tersedia' ? 'bg-brand-neutral border-gray-200 text-brand-primary' : 'bg-rose-50 border-rose-200 text-rose-600' }}">
                    <div>
                        <span class="block text-[10px] text-brand-secondary uppercase tracking-wider">Jam Slot</span>
                        <span class="font-semibold text-sm">{{ $slot['start'] }} - {{ $slot['end'] }}</span>
                    </div>

                    @if ($slot['status'] === 'tersedia')
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Tersedia
                        </span>

                        @auth
                            <a href="{{ route('dashboard') }}?facility_id={{ $facility->id }}&date={{ $date }}&start={{ $slot['start'] }}&end={{ $slot['end'] }}" class="mt-1 bg-brand-primary hover:opacity-90 text-white text-xs py-1 px-2 rounded transition block font-medium">
                                Pesan Slot
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="mt-1 bg-gray-100 hover:bg-gray-200 text-brand-secondary text-[10px] py-1 px-2 rounded transition block">
                                Login u/ Pesan
                            </a>
                        @endauth
                    @else
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-rose-100 text-rose-600 border border-rose-200">
                            Tidak Tersedia
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection