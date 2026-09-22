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
<div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs mb-6">
    <h3 class="font-bold text-lg text-brand-primary">Cari &amp; Lihat Fasilitas</h3>
    <p class="text-sm text-brand-secondary mb-5">Filter berdasarkan tipe, lokasi, dan kapasitas.</p>

    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-brand-primary hover:opacity-90 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition shadow-xs">
        Lihat Semua Fasilitas <span>→</span>
    </a>
</div>

<!-- Ringkasan Aktivitas (3 CARD CLICKABLE SCROLL) -->
<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    <!-- Card 1: Reservasi Aktif -->
    <a href="#riwayat-reservasi" class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs hover:shadow-md transition flex items-center justify-between cursor-pointer">
        <div>
            <span class="text-[10px] text-brand-secondary uppercase tracking-wider block">Reservasi Aktif</span>
            <span class="font-bold text-brand-primary text-2xl mt-1 block">{{ $activeReservations ?? 0 }}</span>
        </div>
    </a>

    <!-- Card 2: Menunggu Validasi -->
    <a href="#riwayat-reservasi" class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs hover:shadow-md transition flex items-center justify-between cursor-pointer">
        <div>
            <span class="text-[10px] text-brand-secondary uppercase tracking-wider block">Menunggu Validasi</span>
            <span class="font-bold text-brand-primary text-2xl mt-1 block">{{ $pendingReservations ?? 0 }}</span>
        </div>
    </a>

    <!-- Card 3: Laporan Kerusakan -->
    <a href="#riwayat-laporan" class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs hover:shadow-md transition flex items-center justify-between cursor-pointer">
        <div>
            <span class="text-[10px] text-brand-secondary uppercase tracking-wider block">Laporan Kerusakan</span>
            <span class="font-bold text-brand-primary text-2xl mt-1 block">{{ $reportsCount ?? 0 }}</span>
        </div>
    </a>
</div>

<!-- SECTION 1: RIWAYAT RESERVASI -->
<div id="riwayat-reservasi" class="mt-8 scroll-mt-6">
    <h3 class="font-bold text-lg text-brand-primary mb-4">Riwayat Reservasi</h3>

    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-sm font-semibold">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @forelse($reservations ?? [] as $reservation)
        @php
            $facility = $reservation->facility ?? ($reservation->details->first()->facility ?? null);
            $canCancel = in_array($reservation->status, ['menunggu', 'disetujui'])
                && now()->addHours(24)->lte($reservation->start_time);

            $statusLabel = [
                'menunggu'   => 'Menunggu',
                'disetujui'  => 'Disetujui',
                'ditolak'    => 'Ditolak',
                'dibatalkan' => 'Dibatalkan',
                'selesai'    => 'Selesai',
            ][$reservation->status] ?? $reservation->status;

            $statusColor = [
                'menunggu'   => 'bg-amber-50 text-amber-700 border-amber-200',
                'disetujui'  => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'ditolak'    => 'bg-rose-50 text-rose-700 border-rose-200',
                'dibatalkan' => 'bg-gray-100 text-gray-500 border-gray-200',
                'selesai'    => 'bg-blue-50 text-blue-700 border-blue-200',
            ][$reservation->status] ?? 'bg-gray-100 text-gray-500 border-gray-200';
        @endphp

        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs mb-4">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">{{ $reservation->reservation_code }}</p>
                    <h4 class="font-bold text-brand-primary text-base mt-0.5">
                        {{ $facility->name ?? 'Fasilitas tidak diketahui' }}
                    </h4>
                    <p class="text-sm text-brand-secondary mt-1">{{ $reservation->purpose }}</p>
                    <p class="text-xs text-brand-secondary mt-2">
                        📅 {{ \Carbon\Carbon::parse($reservation->start_time)->translatedFormat('d M Y, H:i') }}
                        &ndash;
                        {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }} WIB
                    </p>
                    @if($reservation->activity_description)
                        <p class="text-xs text-brand-secondary mt-1">{{ $reservation->activity_description }}</p>
                    @endif
                    <p class="text-xs text-brand-secondary mt-1">Jumlah peserta: {{ $reservation->participant_count }}</p>
                </div>

                <span class="text-xs font-bold px-3 py-1.5 rounded-full border whitespace-nowrap {{ $statusColor }}">
                    {{ strtoupper($statusLabel) }}
                </span>
            </div>

            @if($canCancel)
                <form id="cancel-form-{{ $reservation->id }}" action="{{ route('reservations.cancel', $reservation) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <button
                        type="button"
                        @click="$dispatch('open-cancel-modal', { formId: 'cancel-form-{{ $reservation->id }}', code: '{{ $reservation->reservation_code }}' })"
                        class="text-xs font-bold text-rose-600 border border-rose-200 hover:bg-rose-50 px-4 py-2 rounded-xl transition cursor-pointer">
                        Batalkan Reservasi
                    </button>
                </form>
            @elseif(in_array($reservation->status, ['menunggu', 'disetujui']))
                <p class="text-xs text-gray-400 mt-4">Sudah melewati batas waktu pembatalan (24 jam sebelum mulai).</p>
            @endif
        </div>
    @empty
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs text-sm text-brand-secondary">
            Belum ada reservasi.
        </div>
    @endforelse
</div>

<!-- SECTION 2: RIWAYAT LAPORAN KERUSAKAN -->
<div id="riwayat-laporan" class="mt-10 scroll-mt-6">
    <div class="mb-4">
        <h3 class="font-bold text-lg text-brand-primary">Riwayat Laporan Kerusakan</h3>
    </div>

    @forelse($reports ?? [] as $report)
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs mb-3 flex items-center justify-between gap-4">
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-brand-secondary uppercase bg-brand-neutral px-2 py-0.5 rounded border border-gray-200">{{ $report->category }}</span>
                <h4 class="text-sm font-bold text-brand-primary">{{ $report->facility->name ?? 'Fasilitas' }}</h4>
                <p class="text-xs text-brand-secondary">{{ $report->description }}</p>
                <span class="text-[10px] text-gray-400 block mt-1">
                    Dilaporkan: {{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('d M Y, H:i') }} WIB
                </span>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider shrink-0
                {{ $report->status === 'selesai' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($report->status === 'diproses' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-amber-50 text-amber-700 border border-amber-200') }}">
                {{ $report->status }}
            </span>
        </div>
    @empty
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs text-sm text-brand-secondary">
            Belum ada riwayat laporan kerusakan.
        </div>
    @endforelse
</div>

<!-- Modal Konfirmasi Cancel -->
<div
    x-data="{ show: false, formId: null, code: '' }"
    x-on:open-cancel-modal.window="show = true; formId = $event.detail.formId; code = $event.detail.code"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-[100] flex items-center justify-center p-4"
>
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/40" @click="show = false"></div>

    <!-- Modal Box -->
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        class="relative bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm"
    >
        <h3 class="font-bold text-lg text-brand-primary mb-2">Batalkan Reservasi?</h3>
        <p class="text-sm text-brand-secondary mb-6">
            Reservasi <span class="font-semibold" x-text="code"></span> akan dibatalkan dan tidak bisa dikembalikan. Yakin ingin melanjutkan?
        </p>

        <div class="flex justify-end gap-3">
            <button
                type="button"
                @click="show = false"
                class="text-sm font-semibold text-brand-secondary hover:text-brand-primary px-4 py-2 rounded-xl transition"
            >
                Batal
            </button>
            <button
                type="button"
                @click="document.getElementById(formId).submit(); show = false"
                class="text-sm font-bold bg-rose-600 hover:bg-rose-700 text-white px-5 py-2 rounded-xl transition"
            >
                Ya, Batalkan
            </button>
        </div>
    </div>
</div>

@endsection