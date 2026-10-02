@extends('layouts.app')

@section('content')
@php
    $statusLabel = [
        'menunggu' => 'Menunggu', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak',
        'dibatalkan' => 'Dibatalkan', 'selesai' => 'Selesai',
    ][$reservation->status] ?? $reservation->status;

    $statusColor = [
        'menunggu'   => 'bg-amber-50 text-amber-700 border-amber-200',
        'disetujui'  => 'bg-brand-tertiary/30 text-brand-primary border-brand-tertiary',
        'ditolak'    => 'bg-rose-50 text-rose-700 border-rose-200',
        'dibatalkan' => 'bg-gray-100 text-gray-500 border-gray-200',
        'selesai'    => 'bg-blue-50 text-blue-700 border-blue-200',
    ][$reservation->status] ?? 'bg-gray-100 text-gray-500 border-gray-200';

    $minutes = (int) round(abs($reservation->start_time->diffInMinutes($reservation->end_time)));
    $slots   = (int) ceil($minutes / 30);

    // GANTI 'image' kalau nama kolom gambar di tabel facilities berbeda
    $img = $facility?->image;
    $imgUrl = $img
        ? (\Illuminate\Support\Str::startsWith($img, ['http://', 'https://']) ? $img : asset('storage/' . $img))
        : null;

    $user = $reservation->user;
@endphp

<a href="{{ route('riwayat') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-brand-secondary hover:text-brand-primary mb-6 transition">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    <span>Kembali ke riwayat</span>
</a>

<div class="animate-fade-up flex items-start justify-between gap-4 flex-wrap mb-6">
    <div>
        <h2 class="text-brand-primary" style="font-size: 30px; font-weight: 800; line-height: 36px; letter-spacing: -0.75px;">
            Detail Reservasi
        </h2>
        <p class="text-sm text-brand-secondary mt-1">
            Rincian peminjaman fasilitas <span class="font-bold">{{ $facility->name ?? 'Fasilitas tidak diketahui' }}</span>
            &middot; <span class="font-semibold">{{ $reservation->reservation_code }}</span>
        </p>
    </div>
    <span class="text-xs font-bold px-3 py-1.5 rounded-full border whitespace-nowrap {{ $statusColor }}">
        {{ strtoupper($statusLabel) }}
    </span>
</div>

<div class="grid gap-6 lg:grid-cols-3 items-start">

    <!-- Kolom kiri: gambar fasilitas -->
    <div class="lg:col-span-1">
        <div style="animation-delay: 100ms" class="animate-fade-up bg-white rounded-2xl border border-gray-200 shadow-panel overflow-hidden">
            @if($imgUrl)
                <img src="{{ $imgUrl }}" alt="{{ $facility->name }}" class="w-full h-56 object-cover">
            @else
                <div class="w-full h-56 bg-brand-tertiary/20 flex items-center justify-center text-sm text-brand-secondary">
                    Gambar tidak tersedia
                </div>
            @endif

            <div class="p-5 space-y-4">
                <div>
                    <h3 class="font-bold text-brand-primary text-lg">{{ $facility->name ?? 'Fasilitas tidak diketahui' }}</h3>
                    <p class="text-sm text-brand-secondary mt-0.5">{{ $facility->location ?? '-' }}</p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-brand-neutral rounded-xl p-3 border border-gray-200 shadow-card">
                        <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Tipe</p>
                        <p class="font-bold text-brand-primary text-sm mt-0.5">{{ $facility->type_label }}</p>
                    </div>
                    <div class="bg-brand-neutral rounded-xl p-3 border border-gray-200 shadow-card">
                        <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Kapasitas</p>
                        <p class="font-bold text-brand-primary text-sm mt-0.5">
                            {{ $facility->capacity ? $facility->capacity . ' orang' : '-' }}
                        </p>
                    </div>
                </div>

                @if($facility->description)
                    <div>
                        <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Tentang</p>
                        <p class="text-sm text-brand-secondary mt-1">{{ $facility->description }}</p>
                    </div>
                @endif

                @if(!empty($facility->equipment))
                    <div>
                        <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider mb-2">Fasilitas &amp; Peralatan</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($facility->equipment as $item)
                                <span class="inline-flex items-center gap-1 text-xs text-brand-primary border border-brand-tertiary bg-brand-tertiary/10 px-2.5 py-1 rounded-lg">
                                    ✓ {{ $item }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Kolom kanan: rincian -->
    <div class="lg:col-span-2 space-y-6">

        <!-- Informasi Pemohon -->
        <div style="animation-delay: 200ms" class="animate-fade-up bg-white rounded-2xl border border-gray-200 shadow-panel p-6">
            <h3 class="font-bold text-lg text-brand-primary">Informasi Pemohon</h3>
            <p class="text-sm text-brand-secondary mb-4">Data identitas pengguna yang mengajukan.</p>

            <div class="grid gap-4 sm:grid-cols-3">
                <div class="border border-gray-200 rounded-2xl p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-brand-primary text-white flex items-center justify-center text-xs font-bold shrink-0">
                        {{ strtoupper(mb_substr($user->name ?? '-', 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Nama Pemohon</p>
                        <p class="font-bold text-brand-primary truncate">{{ $user->name ?? '-' }}</p>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-2xl p-4">
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Role / Peran</p>
                    {{-- GANTI 'name' kalau kolom di tabel user_types berbeda --}}
                    <p class="font-bold text-brand-primary">{{ $user->userType->name ?? '-' }}</p>
                </div>

                <div class="border border-gray-200 rounded-2xl p-4 min-w-0">
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Email</p>
                    <p class="font-bold text-brand-primary break-all">{{ $user->email ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Detail Waktu & Penggunaan -->
        <div style="animation-delay: 300ms" class="animate-fade-up bg-white rounded-2xl border border-gray-200 shadow-panel p-6">
            <h3 class="font-bold text-lg text-brand-primary">Detail Waktu &amp; Penggunaan</h3>
            <p class="text-sm text-brand-secondary mb-4">Jadwal, agenda kegiatan, dan dokumen permohonan.</p>

            <div class="grid gap-4 sm:grid-cols-3">
                <div class="border border-gray-200 rounded-2xl p-4">
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Tanggal Penggunaan</p>
                    <p class="font-bold text-brand-primary mt-1">
                        {{ $reservation->start_time->locale('id')->translatedFormat('d F Y') }}
                    </p>
                    <p class="text-xs text-brand-secondary">
                        {{ $reservation->start_time->locale('id')->translatedFormat('l') }}
                    </p>
                </div>

                <div class="border border-gray-200 rounded-2xl p-4">
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Rentang Waktu</p>
                    <p class="font-bold text-brand-primary mt-1">
                        {{ $reservation->start_time->format('H:i') }} – {{ $reservation->end_time->format('H:i') }} WIB
                    </p>
                    <p class="text-xs text-brand-secondary">Durasi {{ $minutes }} menit ({{ $slots }} slot)</p>
                </div>

                <div class="border border-gray-200 rounded-2xl p-4">
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Dokumen Surat</p>
                    @if($reservation->document)
                        <a href="{{ asset('storage/' . $reservation->document) }}" target="_blank"
                           class="inline-block mt-1 font-bold text-brand-primary underline">Lihat dokumen</a>
                    @else
                        <p class="mt-1 text-sm text-brand-secondary">Tidak ada dokumen</p>
                    @endif
                </div>
            </div>

            <div class="border border-gray-200 rounded-2xl p-5 mt-4 space-y-5">
                <div>
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Tujuan / Agenda Utama</p>
                    <p class="font-bold text-brand-primary mt-1">{{ $reservation->purpose }}</p>
                </div>
                <div class="border-t border-gray-200 pt-4">
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Deskripsi Rincian Aktivitas</p>
                    <p class="text-brand-primary mt-1">{{ $reservation->activity_description ?: '-' }}</p>
                </div>
                <div class="border-t border-gray-200 pt-4">
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Estimasi Jumlah Peserta</p>
                    <p class="font-bold text-brand-primary mt-1">{{ $reservation->participant_count }}</p>
                </div>
                <div class="border-t border-gray-200 pt-4">
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Diajukan pada</p>
                    <p class="text-sm text-brand-secondary mt-1">
                        {{ $reservation->created_at->locale('id')->translatedFormat('d M Y, H:i') }} WIB
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection