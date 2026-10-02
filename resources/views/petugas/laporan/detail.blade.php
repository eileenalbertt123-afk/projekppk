@extends('layouts.petugas')

@section('title', 'Detail Laporan')

@section('content')

@php
    $status = strtolower($report->status ?? 'baru');

    $action = request('action');

    $reporter = $report->user ?? null;
    $facility = $report->facility ?? null;
    $category = $report->category ?? null;

    $facilityStatus = strtolower(str_replace([' ', '-'], '_', $facility?->status ?? 'tersedia'));

    $isReviewed = $isReviewed ?? false;
    $isRepairReady = $isRepairReady ?? false;
    $isRepairCompleted = $isRepairCompleted ?? false;

    $affectedReservations = $affectedReservations ?? [];

    $hasFacilityConflict =
        count($affectedReservations) > 0
        && $status === 'diproses'
        && $facilityStatus === 'dalam_perbaikan';

    // dd([
    //     'affected' => count($affectedReservations),
    //     'status' => $status,
    //     'facilityStatus' => $facilityStatus,
    //     'conflict' => $hasFacilityConflict
    // ]);

    // =========================================================
    // REPORT ACTION PANEL STATE
    // =========================================================
    //
    // Urutan sangat penting:
    // state paling spesifik harus diperiksa terlebih dahulu.
    // =========================================================

    $panelState = match (true) {

        $status === 'baru'
            && $action === 'reject'
                => 'rejection-form',


        // KONDISI 7
        // buka form penyelesaian
        $status === 'diproses'
            && $action === 'complete'
                => 'completion-form',


        $status === 'selesai'
            => 'completed',


        $status === 'ditolak'
            => 'rejected',


        $status === 'diproses'
            && $hasFacilityConflict
                => 'facility-conflict',


        $status === 'diproses'
            && $isRepairReady
                => 'repair-ready',


        $status === 'diproses'
            && $facilityStatus === 'dalam_perbaikan'
                => 'repair-pending',


        $status === 'diproses'
            && $facilityStatus === 'tersedia'
                => 'repair-pending',


        $status === 'baru'
            && $isReviewed
                => 'ready',


        default
            => 'waiting',
    };

    // =========================================================
    // REPORT STATUS BANNER
    // =========================================================
    $bannerStatus = match (true) {

        $status === 'ditolak'
            => 'rejected',

        $status === 'selesai'
            => 'resolved',

        $hasFacilityConflict
            => 'conflict',

        $status === 'diproses'
            && (
                $isRepairReady
                || strtolower($facilityStatus) === 'dalam_perbaikan'
            )
                => 'maintenance',

        default
            => 'new',
    };

    // =========================================================
    // REPORTER INITIALS
    // =========================================================

    $reporterName = $reporter?->name ?? '-';

    $reporterInitials = collect(explode(' ', $reporterName))
        ->filter()
        ->take(2)
        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
        ->implode('');


    // =========================================================
    // ROUTES
    // =========================================================

    // Kembali ke daftar laporan
    $backUrl = route('petugas.laporan.index');

    // Route detail laporan yang memang sudah kamu punya
    $detailUrl = route(
        'petugas.laporan.detail',
        $report->id
    );

    // Hanya untuk mengganti tampilan/action panel melalui query URL
    $rejectFormUrl = $detailUrl . '?action=reject';

    $completeFormUrl = $detailUrl . '?action=complete';

    $processAction = route('petugas.laporan.process', $report);

    $startRepairAction = route('petugas.laporan.start-repair', $report);

    $rejectAction = route('petugas.laporan.reject', $report);

    $completeAction = route('petugas.laporan.complete', $report);
    @endphp
{{-- ══════════════════════════════════════════════════════════════
     1.  FULL-WIDTH REPORT STATUS BANNER
     ══════════════════════════════════════════════════════════════ --}}
<x-petugas.report-status-banner :type="$bannerStatus" />

{{-- ══════════════════════════════════════════════════════════════
     PAGE BODY
     ══════════════════════════════════════════════════════════════ --}}
<div class="px-8 py-6 space-y-6">

    {{-- ── 2.  BREADCRUMB ─────────────────────────────────────────── --}}
    <div class="flex items-center gap-3">
        {{-- Back button --}}
        <a href="{{ $backUrl }}"
           class="flex items-center gap-2 bg-white border border-[#e2e8f0] text-[#475569] text-[13px] font-semibold leading-[16px] px-[15px] py-[9px] rounded-[8px] shadow-[0px_1px_1px_rgba(0,0,0,0.05)] hover:bg-slate-50 transition-colors no-underline">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali ke Daftar Laporan
        </a>

        {{-- Divider --}}
        <span class="text-[#cbd5e1] text-[14px]">|</span>

        {{-- Breadcrumb trail --}}
        <div class="flex items-center gap-2 text-[13px]">
            <span class="text-[#94a3b8] font-normal">Daftar Laporan</span>
            <span class="text-[#cbd5e1]">/</span>
            <span class="text-[#19183b] font-semibold">
                Detail Laporan #{{ $report->report_code ?? ($report->id ?? '-') }}
            </span>
        </div>
    </div>

    {{-- ── 3.  HEADER CARD ─────────────────────────────────────────── --}}
    <div class="bg-white border border-[rgba(226,232,240,0.8)] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 p-[25px] rounded-[16px]">

        {{-- Left: title + subtitle --}}
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="font-extrabold text-[#19183b] text-[24px] tracking-[-0.6px] leading-[32px] m-0">
                    Detail Laporan Kerusakan
                </h1>
                {{-- Report status badge --}}
                <x-petugas.status-laporan-badge :status="$report->status ?? 'Baru'" />
            </div>
            <p class="font-normal text-[#708993] text-[14px] leading-[20px] m-0">
                Tinjau kelayakan laporan, kondisi fasilitas, serta potensi bentrok
                reservasi sebelum mengambil tindakan operasional sarpras.
            </p>
        </div>

        {{-- Right: metadata chips --}}
        <div class="flex items-center gap-3 flex-wrap shrink-0">

            {{-- ID Laporan --}}
            <div class="bg-[#f8fafc] border border-[#e2e8f0] flex flex-col gap-[1.75px] items-start px-[17px] py-[11px] rounded-[12px]">
                <span class="font-bold text-[#94a3b8] text-[11px] tracking-[0.55px] uppercase leading-[16.5px]">ID Laporan</span>
                <span class="font-bold text-[#19183b] text-[16px] leading-[24px] font-mono">
                    {{ $report->report_code ?? ('#' . str_pad($report->id ?? 0, 5, '0', STR_PAD_LEFT)) }}
                </span>
            </div>


            {{-- Tanggal Pengajuan --}}
            <div class="bg-[#f8fafc] border border-[#e2e8f0] flex flex-col gap-[1.75px] items-start px-[17px] py-[11px] rounded-[12px]">
                <span class="font-bold text-[#94a3b8] text-[11px] tracking-[0.55px] uppercase leading-[16.5px]">Tgl Pengajuan</span>
                <span class="font-bold text-[#1e293b] text-[14px] leading-[20px]">
                    {{ $report->created_at?->translatedFormat('d M Y, H.i') ?? '-' }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── 4.  MAIN GRID  (2/3 content + 1/3 sidebar) ─────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- ════════════════════════════════════════
             LEFT COLUMN  (lg:col-span-2)
             ════════════════════════════════════════ --}}
        <div class="lg:col-span-2 flex flex-col gap-6">

            {{-- ── 5.  INFORMASI PELAPOR ───────────────────────────── --}}
            <div class="bg-white border border-[rgba(226,232,240,0.8)] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] flex flex-col gap-4 p-[25px] rounded-[16px]">

                {{-- Section header --}}
                <div class="border-b border-[#f1f5f9] pb-[17px]">
                    <div class="flex items-center gap-3">
                        <div class="bg-[#eff6ff] flex items-center justify-center rounded-[8px] shrink-0 size-[32px]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                 fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-[#19183b] text-[16px] leading-[24px] m-0">Informasi Pelapor</p>
                            <p class="font-normal text-[#94a3b8] text-[12px] leading-[16px] m-0">Data identitas pelapor kerusakan</p>
                        </div>
                    </div>
                </div>

                {{-- Profile grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-1">

                    {{-- Nama Pemohon --}}
                    <div class="bg-[rgba(248,250,252,0.7)] border border-[#f1f5f9] flex flex-col gap-1 p-[17px] rounded-[12px]">
                        <span class="font-semibold text-[#94a3b8] text-[12px] tracking-[0.6px] uppercase leading-[16px]">NAMA PEMOHON</span>
                        <div class="flex items-center gap-[10px] pt-1">
                            {{-- Avatar --}}
                            <div class="bg-[#2563eb] flex items-center justify-center rounded-full shrink-0 size-[32px]">
                                <span class="font-bold text-white text-[12px] leading-[16px]">{{ $reporterInitials }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-bold text-[#0f172a] text-[14px] leading-[20px]">
                                    {{ $reporterName }}
                                </span>

                                @if ($reporter?->identifier)
                                    <span class="font-normal text-[#64748b] text-[11px] leading-[16.5px]">
                                        {{ $reporter?->userType?->name === 'mahasiswa' ? 'NIM' : 'ID' }}:
                                        {{ $reporter->identifier }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Role / Organisasi --}}
                    <div class="bg-[rgba(248,250,252,0.7)] border border-[#f1f5f9] flex flex-col gap-1 p-[17px] rounded-[12px]">
                        <span class="font-semibold text-[#94a3b8] text-[12px] tracking-[0.6px] uppercase leading-[16px]">ROLE / ORGANISASI</span>
                        <span class="font-bold text-[#0f172a] text-[14px] leading-[20px] pt-1 capitalize">
                            {{ $reporter?->userType?->name ?? '-' }}
                        </span>
                        <span class="font-normal text-[#64748b] text-[12px] leading-[16px]">
                            Pengguna fasilitas kampus
                        </span>
                    </div>

                    {{-- Kontak & Email --}}
                    <div class="bg-[rgba(248,250,252,0.7)] border border-[#f1f5f9] flex flex-col gap-1 p-[17px] rounded-[12px]">
                        <span class="font-semibold text-[#94a3b8] text-[12px] tracking-[0.6px] uppercase leading-[16px]">KONTAK &amp; EMAIL</span>
                        <span class="font-bold text-[#0f172a] text-[14px] leading-[20px] pt-1 break-all">
                            {{ $reporter?->email ?? '-' }}
                        </span>
                        <span class="font-normal text-[#64748b] text-[12px] leading-[16px]">
                            {{ $reporter?->phone ?? '-' }}  {{-- @NOTE: adjust field --}}
                        </span>
                    </div>
                </div>
            </div>

            {{-- ── 6.  INFORMASI FASILITAS ─────────────────────────── --}}
            <div class="bg-white border border-[rgba(226,232,240,0.8)] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] flex flex-col gap-4 p-[25px] rounded-[16px]">

                {{-- Section header --}}
                <div class="border-b border-[#f1f5f9] pb-[17px]">
                    <div class="flex items-center gap-3">
                        <div class="bg-[#ecfdf5] flex items-center justify-center rounded-[8px] shrink-0 size-[32px]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                 fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-[#19183b] text-[16px] leading-[24px] m-0">Informasi Fasilitas Kampus</p>
                            <p class="font-normal text-[#94a3b8] text-[12px] leading-[16px] m-0">Verifikasi visual dan status operasional fasilitas</p>
                        </div>
                    </div>
                </div>

                {{-- Facility body --}}
                <div class="flex flex-col sm:flex-row gap-5 items-start">

                    {{-- Thumbnail --}}
                    <div class="bg-[#f1f5f9] border border-[#e2e8f0] overflow-hidden relative rounded-[12px] shrink-0 w-full sm:w-[176px] h-[128px]">
                        @if ($facility?->image)

                            <img
                                src="{{ asset('storage/' . $facility->image) }}"
                                alt="Foto {{ $facility->name }}"
                                class="absolute inset-0 w-full h-full object-cover"
                            >

                        @else

                            <div class="absolute inset-0 flex items-center justify-center bg-slate-100">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="32"
                                    height="32"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#94a3b8"
                                    stroke-width="1.5"
                                >
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                            </div>

                        @endif
                        <div class="absolute bottom-[8px] left-[8px] bg-[rgba(0,0,0,0.7)] rounded-[4px] px-[8px] py-[2px]">
                            <span class="font-semibold text-white text-[10px] leading-[15px]">Foto Resmi</span>
                        </div>
                    </div>

                    {{-- Facility details --}}
                    <div class="flex flex-col gap-3 flex-1 min-w-0">

                        {{-- Name, type, status --}}
                        <div class="flex items-start justify-between gap-3 flex-wrap">
                            <div class="flex flex-col gap-[2px]">
                                <h3 class="font-extrabold text-[#19183b] text-[18px] leading-[28px] m-0">
                                    {{ $facility?->name ?? '-' }}
                                </h3>
                                <div class="flex items-center gap-1">
                                    <span class="font-semibold text-[#64748b] text-[12px] leading-[16px]">Tipe:</span>
                                    <span class="bg-[#eff6ff] font-bold text-[#1d4ed8] text-[12px] leading-[16px] px-[8px] py-[1.5px] rounded-[4px]">
                                        {{ $facility?->type ?? $facility?->category ?? '-' }}  {{-- @NOTE: adjust field --}}
                                    </span>
                                </div>
                            </div>
                            {{-- Facility status badge --}}
                            <x-petugas.status-fasilitas-badge :status="$facilityStatus" />
                        </div>

                        {{-- Metadata chips --}}
                        <div class="flex gap-3 flex-wrap pt-1">
                            <div class="bg-[#f8fafc] border border-[#f1f5f9] flex flex-col gap-1 px-[11px] py-[10px] rounded-[8px] min-w-[100px]">
                                <span class="font-semibold text-[#94a3b8] text-[11px] uppercase leading-[16.5px]">LOKASI</span>
                                <span class="font-bold text-[#1e293b] text-[12px] leading-[16px]">
                                    {{ $facility?->location ?? $facility?->building ?? '-' }}  {{-- @NOTE: adjust field --}}
                                </span>
                            </div>
                            <div class="bg-[#f8fafc] border border-[#f1f5f9] flex flex-col gap-1 px-[11px] py-[10px] rounded-[8px] min-w-[100px]">
                                <span class="font-semibold text-[#94a3b8] text-[11px] uppercase leading-[16.5px]">KAPASITAS</span>
                                <span class="font-bold text-[#1e293b] text-[12px] leading-[16px]">
                                    {{ $facility?->capacity ? $facility->capacity . ' Peserta' : '-' }}
                                </span>
                            </div>
                            <div class="bg-[#f8fafc] border border-[#f1f5f9] flex flex-col gap-1 px-[11px] py-[10px] rounded-[8px] min-w-[100px]">
                                <span class="font-semibold text-[#94a3b8] text-[11px] uppercase leading-[16.5px]">KONDISI PERANGKAT</span>
                                <span class="font-bold text-[#1e293b] text-[12px] leading-[16px]">
                                    {{ $facility?->condition ?? $facility?->device_condition ?? '-' }}  {{-- @NOTE: adjust field --}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── 7.  DETAIL LAPORAN & BUKTI KERUSAKAN ────────────── --}}
            <div class="bg-white border border-[rgba(226,232,240,0.8)] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] flex flex-col gap-4 p-[25px] rounded-[16px]">

                {{-- Section header --}}
                <div class="border-b border-[#f1f5f9] pb-[17px] flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-[#fafaf9] border border-[#e2e8f0] flex items-center justify-center rounded-[8px] shrink-0 size-[32px]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="15" viewBox="0 0 24 24"
                                 fill="none" stroke="#475569" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                                <line x1="16" y1="13" x2="8" y2="13"/>
                                <line x1="16" y1="17" x2="8" y2="17"/>
                                <polyline points="10 9 9 9 8 9"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-[#19183b] text-[16px] leading-[24px] m-0">Detail Laporan &amp; Bukti Kerusakan</p>
                            <p class="font-normal text-[#94a3b8] text-[12px] leading-[16px] m-0">Informasi lengkap laporan yang diajukan pelapor</p>
                        </div>
                    </div>
                    {{-- READ-ONLY badge --}}
                    <span class="bg-[#f1f5f9] border border-[#e2e8f0] font-semibold text-[#64748b] text-[11px] tracking-[0.22px] uppercase leading-[16.5px] px-[10px] py-[4px] rounded-[6px] shrink-0">
                        READ-ONLY
                    </span>
                </div>

                {{-- Kategori & Waktu --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-[#f8fafc] border border-[#e2e8f0] flex flex-col gap-[10px] p-[17px] rounded-[8px]">
                        <span class="font-semibold text-[#94a3b8] text-[11px] tracking-[0.55px] uppercase leading-[16px]">KATEGORI KERUSAKAN</span>
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                 fill="none" stroke="#475569" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            <span class="font-bold text-[#0f172a] text-[14px] leading-[20px]">
                                {{ $category?->name ?? $report->damage_category ?? '-' }}  {{-- @NOTE: adjust field --}}
                            </span>
                        </div>
                    </div>
                    <div class="bg-[#f8fafc] border border-[#e2e8f0] flex flex-col gap-[10px] p-[17px] rounded-[8px]">
                        <span class="font-semibold text-[#94a3b8] text-[11px] tracking-[0.55px] uppercase leading-[16px]">WAKTU PELAPORAN</span>
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                 fill="none" stroke="#475569" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <span class="font-bold text-[#0f172a] text-[14px] leading-[20px]">
                                {{ $report->created_at?->translatedFormat('d M Y, H:i') ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="flex flex-col gap-2">
                    <div>
                        <p class="font-semibold text-[#475569] text-[12px] tracking-[0.6px] uppercase leading-[16px] m-0">DESKRIPSI KERUSAKAN</p>
                        <p class="font-normal text-[#94a3b8] text-[12px] leading-[16px] m-0">Deskripsi yang diberikan oleh pelapor</p>
                    </div>
                    <div class="bg-[#f8fafc] border border-[#e2e8f0] flex flex-col gap-3 p-[17px] rounded-[8px]">
                        <p class="font-bold text-[#0f172a] text-[14px] leading-[20px] m-0">
                            {{ $report->damage_title ?? $report->title ?? '-' }}  {{-- @NOTE: adjust field --}}
                        </p>
                        <p class="font-normal text-[#334155] text-[13px] leading-[20px] m-0 whitespace-pre-line">
                            {{ $report->description ?? $report->damage_description ?? '-' }}  {{-- @NOTE: adjust field --}}
                        </p>
                    </div>
                </div>

                {{-- Dokumentasi --}}
                <div class="flex flex-col gap-2">
                    <div>
                        <p class="font-semibold text-[#475569] text-[12px] tracking-[0.6px] uppercase leading-[16px] m-0">DOKUMENTASI BUKTI KERUSAKAN</p>
                        <p class="font-normal text-[#94a3b8] text-[12px] leading-[16px] m-0">Bukti foto kerusakan fasilitas</p>
                    </div>

                    {{-- Photo grid / single --}}
                    @php
                        $photos = $report->photos ?? ($report->attachments ?? []);
                        // Normalize: accept a single URL string, an Eloquent collection, or a plain array
                        if (is_string($photos)) $photos = [$photos];
                        if ($photos instanceof \Illuminate\Support\Collection) $photos = $photos->toArray();
                    @endphp

                    @if (count($photos) > 0)
                    <div class="border border-[#e2e8f0] overflow-hidden relative rounded-[12px]">
                        {{-- Main photo --}}
                        <div class="relative w-full" style="padding-top:44%;">
                            <img src="{{ is_array($photos[0]) ? ($photos[0]['url'] ?? $photos[0]['path'] ?? '') : $photos[0] }}"
                                 alt="Bukti Kerusakan"
                                 class="absolute inset-0 w-full h-full object-cover" />
                            {{-- Bottom overlay --}}
                            <div class="absolute bottom-0 left-0 right-0 bg-[rgba(0,0,0,0.55)] backdrop-blur-sm flex items-center justify-between px-3 py-3">
                                <span class="font-normal text-white text-[12px] leading-[16px]">
                                    {{ count($photos) }} foto tersedia
                                </span>
                                @if (count($photos) > 1)
                                <button type="button" class="bg-white/20 border border-white/30 text-white text-[11px] font-semibold leading-[16px] px-3 py-[5px] rounded-[6px] flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                        <polyline points="21 15 16 10 5 21"/>
                                    </svg>
                                    Lihat Semua Foto
                                </button>
                                @endif
                            </div>
                        </div>

                        {{-- Thumbnails strip (if more than 1 photo) --}}
                        @if (count($photos) > 1)
                        <div class="flex gap-2 p-3 bg-[#f8fafc] overflow-x-auto">
                            @foreach (array_slice($photos, 0, 5) as $photo)
                            <div class="bg-[#e2e8f0] overflow-hidden relative rounded-[6px] shrink-0 size-[56px]">
                                <img src="{{ is_array($photo) ? ($photo['url'] ?? $photo['path'] ?? '') : $photo }}"
                                     alt="Foto {{ $loop->iteration }}"
                                     class="absolute inset-0 w-full h-full object-cover" />
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="bg-[#f8fafc] border border-[#e2e8f0] border-dashed flex flex-col items-center justify-center gap-2 p-8 rounded-[12px]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                             fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <p class="font-normal text-[#94a3b8] text-[13px] leading-[20px] m-0 text-center">Tidak ada foto bukti kerusakan</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>{{-- /left column --}}

        {{-- ════════════════════════════════════════
             RIGHT COLUMN  (lg:col-span-1)
             ════════════════════════════════════════ --}}
        <div class="lg:col-span-1 flex flex-col gap-6 lg:sticky lg:top-6">

            {{-- ── 8a.  REPORT ACTION PANEL ─────────────────────────── --}}
            <x-petugas.report-action-panel
                :state="$panelState"
                :report-id="$report->id"
                :petugas-name="\Illuminate\Support\Facades\Auth::user()?->name ?? '-'"

                :affected-reservations="$affectedReservations"

                :completion-note="$completedHistory?->reason"
                :rejection-reason="$rejectedHistory?->reason"
                :hasFacilityConflict="$hasFacilityConflict"

                :reject-url="$rejectFormUrl"
                :complete-url="$completeFormUrl"
                :cancel-url="$detailUrl"

                :action="match ($panelState) {

                    'waiting',
                    'ready' => $processAction,

                    'repair-ready' => $startRepairAction,

                    'completion-form' => $completeAction,

                    'rejection-form' => $rejectAction,

                    default => null,
                }"

                :method="match ($panelState) {
                    'completion-form',
                    'rejection-form' => 'PATCH',

                    default => 'POST',
                }"
            />

            {{-- ── 8b.  ATURAN TRANSISI STATUS ─────────────────────── --}}
            <div class="bg-white border border-[rgba(226,232,240,0.8)] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] p-[21px] rounded-[16px]">

                {{-- Title --}}
                <div class="flex items-center gap-[6px] mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <span class="font-bold text-[#334155] text-[12px] tracking-[0.3px] uppercase leading-[16px]">Aturan Transisi Status</span>
                </div>

                {{-- Rules list --}}
                <ul class="flex flex-col gap-[10px] list-none p-0 m-0 mb-4">
                    <li class="flex items-start gap-[14px]">
                        <span class="bg-[#cbd5e1] rounded-full shrink-0 mt-[5px]" style="width:6px;height:6px;display:inline-block;"></span>
                        <span class="font-normal text-[#475569] text-[12px] leading-[16px]">
                            <strong>Baru</strong> → Diproses atau Ditolak
                        </span>
                    </li>
                    <li class="flex items-start gap-[14px]">
                        <span class="bg-[#cbd5e1] rounded-full shrink-0 mt-[5px]" style="width:6px;height:6px;display:inline-block;"></span>
                        <span class="font-normal text-[#475569] text-[12px] leading-[16px]">
                            <strong>Diproses</strong> → Selesai, setelah fasilitas pulih
                        </span>
                    </li>
                    <li class="flex items-start gap-[14px]">
                        <span class="bg-[#cbd5e1] rounded-full shrink-0 mt-[5px]" style="width:6px;height:6px;display:inline-block;"></span>
                        <span class="font-normal text-[#475569] text-[12px] leading-[16px]">
                            <strong>Ditolak</strong> → Arsip sistem, wajib alasan
                        </span>
                    </li>
                </ul>

                {{-- Footer divider + helpdesk --}}
                <div class="border-t border-[#f1f5f9] pt-[9px]">
                    <span class="font-normal text-[#94a3b8] text-[11px] leading-[16px]">
                        Pusat Bantuan Petugas — Sarpras Hub Ext. 201
                    </span>
                </div>
            </div>

        </div>{{-- /right column --}}

    </div>{{-- /main grid --}}

</div>{{-- /page body --}}

@endsection