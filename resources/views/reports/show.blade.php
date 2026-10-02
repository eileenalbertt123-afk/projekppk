@extends('layouts.app')

@section('content')
@php
    $statusLabel = [
        'baru' => 'Baru', 'diproses' => 'Diproses',
        'selesai' => 'Selesai', 'ditolak' => 'Ditolak',
    ][$report->status] ?? $report->status;

    $statusColor = [
        'baru'     => 'bg-amber-50 text-amber-700 border-amber-200',
        'diproses' => 'bg-blue-50 text-blue-700 border-blue-200',
        'selesai'  => 'bg-brand-tertiary/30 text-brand-primary border-brand-tertiary',
        'ditolak'  => 'bg-rose-50 text-rose-700 border-rose-200',
    ][$report->status] ?? 'bg-gray-100 text-gray-500 border-gray-200';

    $categoryLabel = [
        'elektronik_av'      => 'Elektronik / AC / Proyektor',
        'furnitur'           => 'Meubeler / Kursi / Meja',
        'kebersihan'         => 'Kebersihan',
        'mekanikal_utilitas' => 'Kelistrikan / Lampu',
        'struktur_bangunan'  => 'Struktur Bangunan',
        'jaringan_it'        => 'Jaringan / IT',
        'lainnya'            => 'Lainnya',
    ][$report->category] ?? $report->category;

    $img = $report->image_path;
    $imgUrl = $img
        ? (\Illuminate\Support\Str::startsWith($img, ['http://', 'https://']) ? $img : asset('storage/' . $img))
        : null;
    
    $facImg = $facility->image ?? null;
    $facImgUrl = $facImg
        ? (\Illuminate\Support\Str::startsWith($facImg, ['http://', 'https://']) ? $facImg : asset('storage/' . $facImg))
        : null;
@endphp

<a href="{{ route('riwayat', ['tab' => 'laporan']) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-brand-secondary hover:text-brand-primary mb-6 transition">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    <span>Kembali ke riwayat</span>
</a>

<div class="animate-fade-up flex items-start justify-between gap-4 flex-wrap mb-6">
    <div>
        <h2 class="text-brand-primary" style="font-size: 30px; font-weight: 800; line-height: 36px; letter-spacing: -0.75px;">
            Detail Laporan
        </h2>
        <p class="text-sm text-brand-secondary mt-1">
            Laporan kerusakan pada <span class="font-bold">{{ $facility->name ?? 'Fasilitas tidak diketahui' }}</span>
            &middot; <span class="font-semibold">{{ $report->report_code ?? '#' . $report->id }}</span>
        </p>
    </div>
    <span class="text-xs font-bold px-3 py-1.5 rounded-full border whitespace-nowrap {{ $statusColor }}">
        {{ strtoupper($statusLabel) }}
    </span>
</div>

<div class="grid gap-6 lg:grid-cols-3 items-start">

    <!-- Kolom kiri: foto bukti -->
    <div class="lg:col-span-1">
        <div style="animation-delay: 100ms" class="animate-fade-up bg-white rounded-2xl border border-gray-200 shadow-panel overflow-hidden">

            @if($imgUrl)
                    <img src="{{ $facImgUrl }}" alt="{{ $facility->name ?? 'Fasilitas' }}" class="w-full h-56 object-cover">
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
                        <p class="font-bold text-brand-primary text-sm mt-0.5">{{ $facility->type_label ?? '-' }}</p>
                    </div>
                    <div class="bg-brand-neutral rounded-xl p-3 border border-gray-200 shadow-card">
                        <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Kapasitas</p>
                        <p class="font-bold text-brand-primary text-sm mt-0.5">
                            {{ ($facility->capacity ?? null) ? $facility->capacity . ' orang' : '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom kanan: rincian -->
    <div class="lg:col-span-2 space-y-6">

        <!-- Informasi Pelapor -->
        <div style="animation-delay: 200ms" class="animate-fade-up bg-white rounded-2xl border border-gray-200 shadow-panel p-6">
            <h3 class="font-bold text-lg text-brand-primary">Informasi Pelapor</h3>
            <p class="text-sm text-brand-secondary mb-4">Data identitas pengguna yang melapor.</p>

            <div class="grid gap-4 sm:grid-cols-3">
                <div class="border border-gray-200 rounded-2xl p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-brand-primary text-white flex items-center justify-center text-xs font-bold shrink-0">
                        {{ strtoupper(mb_substr($user->name ?? '-', 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Nama Pelapor</p>
                        <p class="font-bold text-brand-primary truncate">{{ $user->name ?? '-' }}</p>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-2xl p-4">
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Role / Peran</p>
                    <p class="font-bold text-brand-primary capitalize">{{ $user->role_type ?? 'Mahasiswa' }}</p>
                </div>

                <div class="border border-gray-200 rounded-2xl p-4 min-w-0">
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Email</p>
                    <p class="font-bold text-brand-primary break-all">{{ $user->email ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Detail Kerusakan -->
        <div style="animation-delay: 300ms" class="animate-fade-up bg-white rounded-2xl border border-gray-200 shadow-panel p-6">
            <h3 class="font-bold text-lg text-brand-primary">Detail Kerusakan</h3>
            <p class="text-sm text-brand-secondary mb-4">Kategori, waktu pelaporan, dan penjelasan kendala.</p>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="border border-gray-200 rounded-2xl p-4">
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Kategori</p>
                    <p class="font-bold text-brand-primary mt-1">{{ $categoryLabel }}</p>
                </div>

                <div class="border border-gray-200 rounded-2xl p-4">
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Tanggal Pelaporan</p>
                    <p class="font-bold text-brand-primary mt-1">
                        {{ $report->created_at->locale('id')->translatedFormat('d F Y') }}
                    </p>
                    <p class="text-xs text-brand-secondary">
                        {{ $report->created_at->locale('id')->translatedFormat('l') }}
                    </p>
                </div>

                <div class="border border-gray-200 rounded-2xl p-4">
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Waktu Lapor</p>
                    <p class="font-bold text-brand-primary mt-1">{{ $report->created_at->format('H:i') }} WIB</p>
                </div>

                <div class="border border-gray-200 rounded-2xl p-4">
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Foto Bukti</p>
                    @if($report->image_path)
                        <a href="{{ route('reports.image', $report) }}"
                        target="_blank"
                        class="font-semibold text-brand-primary underline">
                            Lihat foto
                        </a>
                    @else
                        <span class="text-gray-400">
                            Tidak ada foto
                        </span>
                    @endif
                </div>
            </div>

            <div class="border border-gray-200 rounded-2xl p-5 mt-4 space-y-5">
                <div>
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Deskripsi Kerusakan</p>
                    <p class="text-brand-primary mt-1 whitespace-pre-line">{{ $report->description }}</p>
                </div>
                <div class="border-t border-gray-200 pt-4">
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">Status Penanganan</p>
                    <span class="inline-block mt-1 text-xs font-bold px-3 py-1 rounded-full border {{ $statusColor }}">
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection