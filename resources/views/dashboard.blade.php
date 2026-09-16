@extends('layouts.app')

@section('content')

<!-- Header Selamat Datang -->
<div class="mb-8">
    <h2 class="text-2xl font-extrabold text-brand-primary">Beranda</h2>
    <p class="text-sm text-brand-secondary mt-1">
        Selamat datang, {{ Auth::user()->name }} 👋 &middot; Cari fasilitas, buat reservasi, dan lihat aktivitas Anda di sini.
    </p>
</div>

<!-- Card Cari & Lihat Fasilitas -->
<div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm mb-6">
    <h3 class="font-bold text-lg text-brand-primary">Cari &amp; Lihat Fasilitas</h3>
    <p class="text-sm text-brand-secondary mb-5">Filter berdasarkan tipe, lokasi, dan kapasitas.</p>

    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-brand-primary hover:opacity-90 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition shadow-sm">
        Lihat Semua Fasilitas <span>→</span>
    </a>
</div>

<!-- Ringkasan Aktivitas -->
<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
        <span class="text-[10px] text-brand-secondary uppercase tracking-wider block">Reservasi Aktif</span>
        <span class="font-bold text-brand-primary text-xl">{{ $activeReservations ?? 0 }}</span>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
        <span class="text-[10px] text-brand-secondary uppercase tracking-wider block">Menunggu Validasi</span>
        <span class="font-bold text-brand-primary text-xl">{{ $pendingReservations ?? 0 }}</span>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
        <span class="text-[10px] text-brand-secondary uppercase tracking-wider block">Laporan Kerusakan</span>
        <span class="font-bold text-brand-primary text-xl">{{ $reportsCount ?? 0 }}</span>
    </div>
</div>

@endsection