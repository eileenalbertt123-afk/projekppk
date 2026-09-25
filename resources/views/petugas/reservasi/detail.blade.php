@extends('layouts.petugas')

@section('title', 'Detail Reservasi')

@section('content')

@php
// Status asli dari database
$status = $reservation->status;

// State UI dari query URL
// contoh: ?action=reject atau ?action=cancel
$action = request('action');

// =========================
// PANEL STATE
// =========================
$panelState = match (true) {

$status === 'menunggu' && $action === 'reject'
=> 'rejection_form',

$status === 'disetujui' && $action === 'cancel'
=> 'cancellation_form',

$status === 'menunggu' && $hasConflict
=> 'waiting_conflict',

$status === 'menunggu'
=> 'waiting',

$status === 'disetujui'
=> 'approved',

$status === 'dibatalkan'
=> 'cancelled',

$status === 'ditolak'
=> 'rejected',

default
=> 'waiting',
};


// =========================
// STATUS BANNER
// =========================
$bannerStatus = match (true) {

$panelState === 'waiting'
=> 'waiting',

$panelState === 'waiting_conflict'
=> 'conflict',

$panelState === 'rejection_form' && $hasConflict
=> 'conflict',

$panelState === 'rejection_form'
=> 'waiting',

$panelState === 'approved'
=> 'approved',

$panelState === 'cancellation_form'
=> 'cancellation_pending',

$panelState === 'cancelled'
=> 'cancelled',

$panelState === 'rejected'
=> 'rejected',

default
=> 'waiting',
};


// =========================
// STATUS HISTORY
// =========================
$approvedHistory = $reservation->statusHistories
->where('status', 'disetujui')
->sortByDesc('created_at')
->first();

$rejectedHistory = $reservation->statusHistories
->where('status', 'ditolak')
->sortByDesc('created_at')
->first();

$cancelledHistory = $reservation->statusHistories
->where('status', 'dibatalkan')
->sortByDesc('created_at')
->first();

$conflictFacility = $conflictingReservation?->details
->first()?->facility;

$conflictDescription = $conflictingReservation
? 'Bentrok dengan #' . $conflictingReservation->reservation_code
. ' ' . ($conflictingReservation->purpose ?? '')
. ' (' . \Illuminate\Support\Str::title($conflictingReservation->user?->name ?? '-') . '), '
. $conflictingReservation->start_time->locale('id')->translatedFormat('d M Y')
. ' pukul '
. $conflictingReservation->start_time->format('H.i')
. '–'
. $conflictingReservation->end_time->format('H.i')
. ' di '
. ($conflictFacility?->name ?? 'fasilitas yang sama')
. '. Tolak reservasi ini agar pemohon dapat mengajukan slot lain.'
: null;
@endphp

{{-- STATUS BANNER --}}
<x-petugas.reservation-status-banner
    :status="$bannerStatus"

    :conflict-code="$conflictingReservation?->reservation_code ?? '-'"

    :conflict-description="$conflictDescription"

    :conflict-link="$conflictingReservation
        ? route('petugas.reservasi.detail', $conflictingReservation->id)
        : '#'" />

{{-- BREADCRUMB --}}
<div class="mt-4 mb-6 flex items-center gap-3">

    <a href="{{ route('petugas.reservasi.index') }}"
        class="inline-flex items-center gap-1.5 bg-white border border-slate-200 rounded-xl px-3.5 py-1.5 text-slate-800 font-medium text-xs shadow-sm hover:bg-slate-50 transition">

        <svg class="w-3.5 h-3.5 text-slate-600 stroke-[2.5]"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">

            <path stroke-linecap="round"
                stroke-linejoin="round"
                d="M15 19l-7-7 7-7" />

        </svg>

        Kembali ke Daftar Reservasi

    </a>

    {{-- Separator --}}
    <div class="h-4 w-[1px] bg-gray-200 mx-0.5"></div>

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-1.5 text-xs text-gray-500">

        <a href="#"
            class="hover:text-gray-800 transition">
            Daftar Reservasi
        </a>

        <span class="text-gray-400">
            /
        </span>

        <span class="font-semibold text-gray-800">
            Detail Reservasi #{{ $reservation->reservation_code }}
        </span>

    </div>

</div>


{{-- HEADER DETAIL RESERVASI --}}
<div class="bg-white border border-gray-200 rounded-2xl p-6 mb-6">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

        {{-- Sisi Kiri: Judul & Deskripsi --}}
        <div>

            <div class="flex items-center gap-3">

                <h1 class="text-xl font-bold text-gray-900">
                    Detail Reservasi Fasilitas
                </h1>

                <x-petugas.status-badge :status="$reservation->status" />

            </div>

            <p class="text-xs text-gray-500 mt-1 max-w-xl leading-relaxed">
                Tinjau kelayakan peminjam, ketersediaan fasilitas, serta potensi bentrok sebelum mengambil tindakan.
            </p>

        </div>

        {{-- Sisi Kanan: Metadata Badges (Berjejer Kesamping) --}}
        <div class="flex items-center gap-3 flex-shrink-0">

            <div class="bg-gray-50/80 border border-gray-200/80 rounded-xl px-4 py-2.5 min-w-[120px]">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">
                    ID RESERVASI
                </p>
                <p class="font-bold text-slate-900 text-sm mt-0.5">
                    {{ $reservation->reservation_code }}
                </p>
            </div>

            <div class="bg-gray-50/80 border border-gray-200/80 rounded-xl px-4 py-2.5 min-w-[120px]">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">
                    NOMOR ANTREAN
                </p>
                <p class="font-bold text-indigo-600 text-sm mt-0.5">
                    #{{ $queueNumber }}
                </p>
            </div>

            <div class="bg-gray-50/80 border border-gray-200/80 rounded-xl px-4 py-2.5 min-w-[140px]">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">
                    TGL PENGAJUAN
                </p>
                <p class="font-bold text-slate-900 text-sm mt-0.5">
                    {{ $reservation->created_at->locale('id')->translatedFormat('d F Y, H.i') }}
                </p>
            </div>

        </div>

    </div>

</div>


{{-- GRID UTAMA --}}
<style>
    .reservation-detail-grid {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
        gap: 1.5rem;
        width: 100%;
    }

    .reservation-main-column {
        min-width: 0;
        width: 100%;
    }

    .reservation-sidebar {
        min-width: 0;
        width: 100%;
    }

    .facility-detail-row {
        display: flex;
        gap: 1.25rem;
        width: 100%;
        min-width: 0;
    }

    .facility-photo {
        position: relative;
        width: 16rem;
        min-width: 16rem;
        height: 11rem;
        flex-shrink: 0;
    }

    .facility-content {
        flex: 1;
        min-width: 0;
    }

    @media (max-width: 1023px) {
        .reservation-detail-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .facility-detail-row {
            flex-direction: column;
        }

        .facility-photo {
            width: 100%;
            min-width: 0;
        }
    }
</style>

<div class="grid grid-cols-1 gap-6 reservation-detail-grid">

    <div class="reservation-main-column space-y-6">

        {{-- INFORMASI PEMOHON --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6">

            {{-- Header --}}
            <div class="flex items-center gap-3 mb-4">

                <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-500"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>

                <div>
                    <h2 class="font-semibold text-gray-900">
                        Informasi Pemohon
                    </h2>

                    <p class="text-xs text-gray-400">
                        Data identitas pemohon reservasi
                    </p>
                </div>

            </div>

            <hr class="border-gray-100 mb-4">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- Nama Pemohon --}}
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">

                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">
                        Nama Pemohon
                    </p>

                    <div class="flex items-center gap-3">

                        {{-- Initial Avatar --}}
                        <div class="w-9 h-9 rounded-full bg-indigo-600 text-white
                                    flex items-center justify-center
                                    text-xs font-semibold shrink-0">

                            {{ \Illuminate\Support\Str::of($reservation->user->name)
                                ->explode(' ')
                                ->filter()
                                ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                                ->take(2)
                                ->implode('') }}

                        </div>

                        <div class="min-w-0">

                            <p class="font-semibold text-gray-900 text-sm">
                                {{ $reservation->user->name }}
                            </p>

                            @if($reservation->user->identifier)
                            <p class="text-xs text-gray-500">
                                {{ $reservation->user->userType?->name === 'mahasiswa' ? 'NIM' : 'ID' }}:
                                {{ $reservation->user->identifier }}
                            </p>
                            @endif

                        </div>

                    </div>

                </div>


                {{-- Tipe Pemohon --}}
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">

                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">
                        Tipe Pemohon
                    </p>

                    <p class="font-semibold text-gray-900 text-sm capitalize">
                        {{ $reservation->user->userType?->name ?? '-' }}
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        Pengguna fasilitas kampus
                    </p>

                </div>


                {{-- Kontak --}}
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">

                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">
                        Kontak & Email
                    </p>

                    <p class="font-semibold text-gray-900 text-sm break-words">
                        {{ $reservation->user->email }}
                    </p>

                </div>

            </div>

        </div>

        {{-- INFORMASI FASILITAS --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6">

            <div class="flex items-center gap-3 mb-4">
                <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-500"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 21h18M5 21V7l7-4 7 4v14M9 9h.01M9 13h.01M9 17h.01M15 9h.01M15 13h.01M15 17h.01" />
                    </svg>
                </div>

                <div>
                    <h2 class="font-semibold text-gray-900">
                        Informasi Fasilitas Kampus
                    </h2>

                    <p class="text-xs text-gray-400">
                        Verifikasi visual dan status operasional fasilitas
                    </p>
                </div>
            </div>

            <hr class="border-gray-100 mb-5">

            @foreach ($reservation->details as $detail)

            @php
            $facility = $detail->facility;
            @endphp

            <div class="facility-detail-row">

                {{-- Foto --}}
                <div class="facility-photo">

                    <img
                        src="{{ $facility?->image
                                ? asset('storage/' . $facility->image)
                                : 'https://placehold.co/400x300' }}"
                        alt="Foto {{ $facility?->name ?? 'Fasilitas' }}"
                        class="w-full h-full object-cover rounded-xl border border-gray-200">

                    <span class="absolute bottom-2 left-2 bg-black/60 text-white text-[10px] px-2 py-1 rounded">
                        Foto Resmi
                    </span>

                </div>

                {{-- Konten --}}
                <div class="facility-content">

                    {{-- Nama + Status --}}
                    <div class="flex items-start justify-between gap-3 flex-wrap">

                        <div>
                            <h3 class="text-xl font-bold text-[#19183b]">
                                {{ $facility?->name ?? '-' }}
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Tipe:
                                <span class="text-indigo-600 font-medium bg-indigo-50 px-2 py-0.5 rounded">
                                    {{ ucwords(str_replace('_', ' ', $facility?->type ?? '-')) }}
                                </span>
                            </p>
                        </div>

                        <x-petugas.facility-status-badge :status="$facility?->status" />

                    </div>

                    {{-- Detail fasilitas --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-4">

                        {{-- Lokasi --}}
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">
                                Lokasi
                            </p>

                            <p class="font-semibold text-gray-900 text-sm">
                                {{ $facility?->location ?? '-' }}
                            </p>
                        </div>

                        {{-- Kapasitas --}}
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">
                                Kapasitas
                            </p>

                            <p class="font-semibold text-gray-900 text-sm">
                                @if ($facility?->capacity)
                                {{ $facility->capacity }} Peserta
                                @else
                                -
                                @endif
                            </p>
                        </div>

                        {{-- Peralatan --}}
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">
                                Peralatan
                            </p>

                            <p class="font-semibold text-gray-900 text-sm">
                                @if (!empty($facility?->equipment))
                                {{ is_array($facility->equipment)
                                            ? implode(', ', $facility->equipment)
                                            : $facility->equipment }}
                                @else
                                -
                                @endif
                            </p>
                        </div>

                    </div>

                    {{-- Deskripsi --}}
                    @if ($facility?->description)
                    <div class="mt-4 bg-gray-50 border border-gray-200 rounded-xl p-4">
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">
                            Deskripsi
                        </p>

                        <p class="text-sm text-gray-700">
                            {{ $facility->description }}
                        </p>
                    </div>
                    @endif

                </div>

            </div>

            @endforeach

        </div>

        {{-- DETAIL WAKTU & PENGGUNAAN --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-4">

                <div class="flex items-center gap-3">

                    <div class="w-9 h-9 rounded-lg bg-violet-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-violet-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <div>
                        <h2 class="font-semibold text-gray-900">
                            Detail Waktu &amp; Penggunaan
                        </h2>

                        <p class="text-xs text-gray-400">
                            Jadwal, agenda kegiatan, dan berkas surat
                        </p>
                    </div>

                </div>

                <span class="bg-slate-100 text-slate-500 text-xs font-semibold px-3 py-1 rounded-lg">
                    READ-ONLY
                </span>

            </div>

            <hr class="border-gray-100 mb-4">


            @php
            $startTime = $reservation->start_time;
            $endTime = $reservation->end_time;

            $durationMinutes = $startTime->diffInMinutes($endTime);
            $durationHours = $durationMinutes / 60;

            // 1 slot = 30 menit
            $durationSlots = $durationMinutes / 30;
            @endphp


            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                {{-- Tanggal Penggunaan --}}
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">

                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">
                        Tanggal Penggunaan
                    </p>

                    <div class="flex items-center gap-2">

                        <svg class="w-4 h-4 text-indigo-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>

                        <p class="font-semibold text-gray-900 text-sm">
                            {{ $startTime->locale('id')->translatedFormat('d F Y') }}
                        </p>

                    </div>

                    <p class="text-xs text-gray-500 mt-1">
                        {{ $startTime->locale('id')->translatedFormat('l') }}
                    </p>

                </div>


                {{-- Rentang Waktu --}}
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">

                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">
                        Rentang Waktu
                    </p>

                    <div class="flex items-center gap-2">

                        <svg class="w-4 h-4 text-emerald-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        <p class="font-semibold text-gray-900 text-sm">
                            {{ $startTime->format('H.i') }}
                            –
                            {{ $endTime->format('H.i') }}
                            WIB
                        </p>

                    </div>

                    <p class="text-xs text-gray-500 mt-1">
                        Durasi
                        {{ number_format($durationHours, 1, ',', '.') }}
                        jam setara
                        {{ $durationSlots }}
                        slot
                    </p>

                </div>


                {{-- Dokumen Permohonan --}}
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">

                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">
                        Dokumen Permohonan
                    </p>

                    @if ($reservation->document)

                    <a href="{{ asset('storage/' . $reservation->document) }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700">

                        <svg class="w-4 h-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>

                        Pratinjau Dokumen

                    </a>

                    @else

                    <p class="text-sm text-gray-400">
                        Tidak ada dokumen
                    </p>

                    @endif

                </div>

            </div>


            {{-- Tujuan / Agenda --}}
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mt-3">

                <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">
                    Tujuan / Agenda Penggunaan
                </p>

                <p class="font-semibold text-gray-900 mb-1">
                    {{ $reservation->purpose ?? '-' }}
                </p>

                <p class="text-sm text-gray-500">
                    {{ $reservation->activity_description ?? '-' }}
                </p>

            </div>

        </div>

    </div>

    {{-- SIDEBAR KANAN --}}
    <div class="reservation-sidebar space-y-6">

        {{-- PANEL AKSI PETUGAS (Aksen Garis Gelap/Biru di Atas) --}}
        <x-petugas.action-panel
            :state="$panelState"

            :officer-name="Auth::user()?->name ?? '-'"

            :reservation-id="$reservation->id"

            :approve-action="route('petugas.reservasi.update-status', $reservation->id)"
            :reject-action="route('petugas.reservasi.update-status', $reservation->id)"
            :cancel-action="route('petugas.reservasi.update-status', $reservation->id)"

            :approved-by="$approvedHistory?->changedBy?->name ?? '-'"
            :approved-at="$approvedHistory?->created_at
                ? $approvedHistory->created_at->locale('id')->translatedFormat('d M Y H.i') . ' WIB'
                : '-'"

            :rejected-by="$rejectedHistory?->changedBy?->name ?? '-'"
            :rejected-at="$rejectedHistory?->created_at
                ? $rejectedHistory->created_at->locale('id')->translatedFormat('d M Y H.i') . ' WIB'
                : '-'"
            :reject-reason-detail="$rejectedHistory?->reason"

            :cancelled-by="$cancelledHistory?->changedBy?->name ?? '-'"
            :cancelled-at="$cancelledHistory?->created_at
                ? $cancelledHistory->created_at->locale('id')->translatedFormat('d M Y H.i') . ' WIB'
                : '-'"
            :cancel-reason-detail="$cancelledHistory?->reason" />

        {{-- ATURAN TRANSISI STATUS --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6">

            <div class="flex items-center gap-2 mb-3">

                <svg class="w-4 h-4 text-indigo-500"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />

                </svg>

                <h2 class="text-sm font-semibold text-gray-900">
                    Aturan Transisi Status
                </h2>

            </div>

            <ul class="space-y-2 text-sm text-gray-600 mb-4">

                <li class="flex items-start gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-gray-300 mt-1.5 shrink-0"></span>
                    Menunggu &rarr; Disetujui atau Ditolak
                </li>

                <li class="flex items-start gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-gray-300 mt-1.5 shrink-0"></span>
                    Disetujui &rarr; Dibatalkan, wajib alasan
                </li>

                <li class="flex items-start gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-gray-300 mt-1.5 shrink-0"></span>
                    Disetujui &rarr; Selesai, otomatis sistem
                </li>

            </ul>

            <p class="text-xs text-gray-400">
                Pusat Bantuan Petugas &mdash; Sarpras Hub Ext. 201
            </p>

        </div>

    </div>

</div>

@endsection