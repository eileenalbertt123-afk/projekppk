@extends('layouts.petugas')

@section('content')

<div class="flex flex-col gap-6 p-8 w-full">

    {{-- ============================================================
         PAGE HEADER
    ============================================================ --}}
    <div class="flex items-start justify-between gap-6">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-3">
                <h1 class="text-[24px] font-extrabold text-[#0f172a] tracking-[-0.6px] leading-8">
                    Fasilitas
                </h1>
                <span class="inline-flex items-center gap-1.5 bg-[#ecfdf5] border border-[rgba(167,243,208,0.7)] rounded-full px-[11px] py-[5px]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
                    <span class="text-[12px] font-semibold text-[#047857] whitespace-nowrap">Semester Genap 2026</span>
                </span>
            </div>
            <p class="text-[14px] font-medium text-[#64748b]">
                Manajemen dan monitoring kondisi fasilitas kampus.
            </p>
        </div>

        {{-- Operational Info Banner --}}
        <div class="flex items-center gap-2 bg-white border border-[rgba(226,232,240,0.7)] shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-xl px-[15px] py-[9px]">
            <svg class="w-4 h-4 shrink-0 text-[#475569]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <p class="text-[12px] text-[#475569] whitespace-nowrap">
                Jam Operasional Fasilitas:
                <span class="font-bold text-[#1e293b]">07.00 – 20.00 WIB</span>
            </p>
        </div>
    </div>

    {{-- ============================================================
         SUMMARY METRIC CARDS
    ============================================================ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 w-full">

        {{-- Total Fasilitas --}}
        <div class="flex items-center justify-between bg-white border border-[rgba(226,232,240,0.7)] shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl p-[21px]">
            <div class="flex flex-col gap-1.5">
                <span class="text-[12px] font-bold text-[#94a3b8] uppercase tracking-[0.6px]">TOTAL FASILITAS</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-[30px] font-extrabold text-[#0f172a] leading-9">{{ $totalFasilitas }}</span>
                    <span class="text-[12px] font-bold text-[#64748b]">Unit terdata</span>
                </div>
            </div>
            <div class="w-12 h-12 flex items-center justify-center bg-[#f8fafc] border border-[#f1f5f9] rounded-xl shrink-0">
                <svg class="w-6 h-6 text-[#475569]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                </svg>
            </div>
        </div>

        {{-- Tersedia --}}
        <div class="flex items-center justify-between bg-white border border-[rgba(226,232,240,0.7)] shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl p-[21px]">
            <div class="flex flex-col gap-1.5">
                <span class="text-[12px] font-bold text-[#94a3b8] uppercase tracking-[0.6px]">TERSEDIA</span>
                <div class="flex items-end gap-2">
                    <span class="text-[30px] font-extrabold text-[#0f172a] leading-9">{{ $tersediaCount }}</span>
                    <span class="inline-flex bg-[#ecfdf5] rounded-[6px] px-2 py-0.5 text-[11px] font-bold text-[#047857] whitespace-nowrap">Siap Pakai</span>
                </div>
            </div>
            <div class="w-12 h-12 flex items-center justify-center bg-[#ecfdf5] border border-[#d1fae5] rounded-xl shrink-0">
                <svg class="w-6 h-6 text-[#10b981]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
        </div>

        {{-- Dalam Perbaikan --}}
        <div class="flex items-center justify-between bg-white border border-[rgba(226,232,240,0.7)] shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl p-[21px]">
            <div class="flex flex-col gap-1.5">
                <span class="text-[12px] font-bold text-[#94a3b8] uppercase tracking-[0.6px]">DALAM PERBAIKAN</span>
                <div class="flex items-end gap-2">
                    <span class="text-[30px] font-extrabold text-[#0f172a] leading-9">{{ $maintenanceCount }}</span>
                    <span class="inline-flex bg-[#fffbeb] rounded-[6px] px-2 py-0.5 text-[11px] font-bold text-[#b45309] whitespace-nowrap">Perbaikan Aktif</span>
                </div>
            </div>
            <div class="bg-[#fffbeb] border border-[#fef3c7] rounded-xl size-11 flex items-center justify-center shrink-0">
                <svg class="size-5 text-[#f59e0b]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                </svg>
            </div>
        </div>

        {{-- Nonaktif --}}
        <div class="flex items-center justify-between bg-white border border-[rgba(226,232,240,0.7)] shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl p-[21px]">
            <div class="flex flex-col gap-1.5">
                <span class="text-[12px] font-bold text-[#94a3b8] uppercase tracking-[0.6px]">NONAKTIF</span>
                <div class="flex items-end gap-2">
                    <span class="text-[30px] font-extrabold text-[#0f172a] leading-9">{{ $nonaktifCount }}</span>
                    <span class="inline-flex bg-[#fff1f2] rounded-[6px] px-2 py-0.5 text-[11px] font-bold text-[#be123c] whitespace-nowrap">Terkunci</span>
                </div>
            </div>
            <div class="w-12 h-12 flex items-center justify-center bg-[#fff1f2] border border-[#ffe4e6] rounded-xl shrink-0">
                <svg class="w-6 h-6 text-[#f43f5e]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </div>
        </div>

    </div>

    {{-- ============================================================
         SEARCH & FILTER TOOLBAR
    ============================================================ --}}
    <div class="flex flex-col gap-3.5 bg-white border border-[rgba(226,232,240,0.7)] shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl p-[17px]">

        {{-- Row 1: Search + Status Filter --}}
        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">

            {{-- Search Box --}}
            <form method="GET" action="{{ route('petugas.fasilitas.index') }}" class="w-full xl:w-[420px] shrink-0">
                <div class="relative">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-[#94a3b8] pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Cari nama fasilitas..."
                        class="w-full bg-[#f8fafc] border border-[#e2e8f0] rounded-xl pl-10 pr-4 py-[11px] text-[12px] font-medium text-[#1e293b] placeholder-[#94a3b8] focus:outline-none focus:ring-2 focus:ring-[#19183b]/20 focus:border-[#19183b]">
                    {{-- Preserve other filters on search --}}
                    @if(isset($filterType) && $filterType)
                    <input type="hidden" name="type" value="{{ $filterType }}">
                    @endif
                    @if(isset($filterStatus) && $filterStatus)
                    <input type="hidden" name="status" value="{{ $filterStatus }}">
                    @endif
                </div>
            </form>

            {{-- Status Filter Tabs --}}
            <div class="flex items-center bg-[#f8fafc] rounded-xl p-[5px] gap-1.5 overflow-x-auto">
                @php
                $currentStatus = request('status', '');
                $statusOptions = [
                '' => 'Semua (' . $totalFasilitas . ')',
                'tersedia' => 'Tersedia (' . $tersediaCount . ')',
                'dalam_perbaikan' => 'Dalam Perbaikan (' . $maintenanceCount . ')',
                'nonaktif' => 'Nonaktif (' . $nonaktifCount . ')',
                ];
                @endphp

                @foreach($statusOptions as $value => $label)
                <a href="{{ route('petugas.fasilitas.index', array_merge(request()->query(), ['status' => $value, 'page' => 1])) }}"
                    class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-[12px] whitespace-nowrap transition-all
                              {{ $currentStatus === $value
                                  ? 'bg-[#19183b] text-white font-bold shadow-[0px_1px_1px_rgba(0,0,0,0.05)]'
                                  : 'text-[#475569] font-semibold hover:bg-white hover:shadow-sm' }}">
                    @if($value === 'dalam_perbaikan')
                    <span class="w-2 h-2 rounded-full bg-[#f59e0b] shrink-0 {{ $currentStatus === $value ? 'hidden' : '' }}"></span>
                    @endif
                    {{ $label }}
                </a>
                @endforeach
            </div>

        </div>

        {{-- Row 2: Type Filter Chips --}}
        <div class="border-t border-[#f1f5f9] pt-2.5 overflow-x-auto">
            <div class="flex items-center gap-2 pb-1">
                <span class="text-[10px] font-bold text-[#94a3b8] uppercase tracking-[0.5px] whitespace-nowrap shrink-0 pr-1">
                    TIPE FASILITAS:
                </span>

                @php
                $currentType = request('type', '');
                $typeOptions = [
                '' => 'Semua Tipe',
                'ruangan' => 'Ruangan',
                'laboratorium' => 'Laboratorium',
                'area_olahraga' => 'Area Olahraga',
                'peralatan_presentasi' => 'Peralatan Presentasi',
                'audio_multimedia' => 'Audio Multimedia',
                'lainnya' => 'Lainnya',
                ];
                @endphp

                @foreach($typeOptions as $value => $label)
                <a href="{{ route('petugas.fasilitas.index', array_merge(request()->query(), ['type' => $value, 'page' => 1])) }}"
                    class="px-3 py-1 rounded-lg text-[12px] whitespace-nowrap transition-all shrink-0
                              {{ $currentType === $value
                                  ? 'bg-[#0f172a] text-white font-semibold shadow-[0px_1px_1px_rgba(0,0,0,0.05)]'
                                  : 'bg-[#f8fafc] border border-[rgba(226,232,240,0.7)] text-[#475569] font-medium hover:bg-white hover:shadow-sm' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>
        </div>

    </div>

    {{-- ============================================================
         FACILITY CARDS GRID
    ============================================================ --}}
    @if($facilities->isEmpty())
    <div class="flex flex-col items-center justify-center py-20 bg-white border border-[rgba(226,232,240,0.7)] rounded-2xl">
        <svg class="w-12 h-12 text-[#cbd5e1] mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
        </svg>
        <p class="text-[14px] font-semibold text-[#64748b]">Tidak ada fasilitas ditemukan</p>
        <p class="text-[12px] text-[#94a3b8] mt-1">Coba ubah filter atau kata kunci pencarian</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @foreach($facilities as $facility)

        @php
        // {{-- Type label map --}}
        $typeLabels = [
        'ruangan' => 'Ruangan',
        'laboratorium' => 'Laboratorium',
        'area_olahraga' => 'Area Olahraga',
        'peralatan_presentasi' => 'Peralatan Presentasi',
        'audio_multimedia' => 'Audio Multimedia',
        'lainnya' => 'Fasilitas Lainnya',
        ];

        // {{-- Card border by status --}}
        $cardBorder = match($facility->status) {
        'dalam_perbaikan' => 'border-[rgba(253,230,138,0.8)]',
        'nonaktif' => 'border-[rgba(254,205,211,0.8)]',
        default => 'border-[rgba(226,232,240,0.8)]',
        };

        // {{-- Top color stripe by status --}}
        $topStripe = match($facility->status) {
        'dalam_perbaikan' => 'bg-[#fbbf24]',
        'nonaktif' => 'bg-[#fb7185]',
        default => null,
        };


        // {{-- Active report badge --}}
        $hasActiveReport = isset($facility->active_reports_count) && $facility->active_reports_count > 0;
        $reportBg = match($facility->status) {
        'dalam_perbaikan' => 'bg-[#fffbeb]',
        'nonaktif' => 'bg-[#fff1f2]',
        default => 'bg-[#f1f5f9]',
        };
        $reportText = match($facility->status) {
        'dalam_perbaikan' => 'text-[#b45309]',
        'nonaktif' => 'text-[#be123c]',
        default => 'text-[#64748b]',
        };
        $reportCount = $facility->active_reports_count ?? 0;

        // {{-- Detail panel styles by status --}}
        $detailBg = match($facility->status) {
        'dalam_perbaikan' => 'bg-[rgba(255,251,235,0.6)] border border-[#fef3c7]',
        'nonaktif' => 'bg-[rgba(255,241,242,0.6)] border border-[#ffe4e6]',
        default => 'bg-[rgba(248,250,252,0.7)] border border-[#f1f5f9]',
        };
        @endphp

        <div class="flex flex-col justify-between bg-white {{ $cardBorder }} border rounded-2xl overflow-hidden shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] p-px">

            {{-- Thumbnail --}}
            <div class="relative">
                <div class="relative h-40 bg-[#f1f5f9] overflow-hidden w-full">
                    <img
                        src="{{ $facility->image ? asset('storage/' . $facility->image) : 'https://placehold.co/600x400/f1f5f9/94a3b8?text=' . urlencode($facility->name) }}"
                        alt="{{ $facility->name }}"
                        class="absolute inset-0 w-full h-full object-cover">
                </div>
                @if($topStripe)
                <div class="absolute top-0 left-0 right-0 h-1 {{ $topStripe }}"></div>
                @endif
            </div>

            {{-- Card Body --}}
            <div class="flex flex-col gap-1.5 pt-5 px-5">

                {{-- Type + Status Badge --}}
                <div class="flex items-start justify-between">
                    <span class="inline-flex bg-[#f1f5f9] rounded px-2 py-0.5 text-[11px] font-bold text-[#475569] uppercase tracking-[0.275px]">
                        {{ $typeLabels[$facility->type] ?? ucfirst(str_replace('_', ' ', $facility->type)) }}
                    </span>
                    <x-petugas.status-fasilitas-badge
                        :status="$facility->status" />
                </div>

                {{-- Name --}}
                <div class="pt-1.5">
                    <h3 class="text-[16px] font-extrabold text-[#0f172a] tracking-[-0.4px] leading-[22px]">
                        {{ $facility->name }}
                    </h3>
                </div>

                {{-- Location --}}
                <div class="flex items-center gap-1.5 pb-2.5">
                    <svg class="w-3.5 h-3.5 text-[#64748b] shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    <span class="text-[12px] font-medium text-[#64748b]">{{ $facility->location }}</span>
                </div>

                {{-- Active Report Row --}}
                <div class="flex items-center justify-between border-t border-[#f1f5f9] pt-[15px]">
                    <span class="text-[12px] font-medium text-[#64748b]">Laporan Aktif:</span>
                    <span class="inline-flex items-center gap-1 {{ $reportBg }} rounded-[6px] px-2 py-0.5 {{ $reportText }} text-[12px] font-bold whitespace-nowrap">
                        @if($hasActiveReport)
                        <svg class="w-3.5 h-3.5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                        @endif
                        {{ $reportCount }} {{ $facility->status === 'nonaktif' ? 'laporan evaluasi' : 'laporan aktif' }}
                    </span>
                </div>

                {{-- Detail Info Box --}}
                <div class="{{ $detailBg }} rounded-xl px-3 pb-3 pt-[19px] flex flex-col gap-1">

                    @if($facility->status === 'dalam_perbaikan')
                    {{-- Technician Info --}}
                    <div class="flex items-center justify-between">
                        <span class="text-[12px] font-medium text-[#64748b]">Teknisi:</span>
                        <span class="text-[12px] font-bold text-[#1e293b]">
                            {{ $facility->technician_name ?? '—' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[12px] font-medium text-[#64748b]">Mulai Perbaikan:</span>
                        <span class="text-[12px] font-semibold text-[#334155]">
                            {{ isset($facility->repair_start_date) ? \Carbon\Carbon::parse($facility->repair_start_date)->translatedFormat('d F Y') : '—' }}
                        </span>
                    </div>
                    @if($facility->repair_notes ?? null)
                    <div class="border-t border-[rgba(253,230,138,0.5)] pt-[5px] mt-1">
                        <p class="text-[11px] font-medium text-[#92400e] leading-4">
                            Kendala: {{ $facility->repair_notes }}
                        </p>
                    </div>
                    @endif

                    @elseif($facility->status === 'nonaktif')
                    {{-- Inactive Info --}}
                    <div class="flex items-center justify-between">
                        <span class="text-[12px] font-medium text-[#64748b]">Alasan Kunci:</span>
                        <span class="text-[12px] font-bold text-[#1e293b]">
                            {{ $facility->inactive_reason ?? '—' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[12px] font-medium text-[#64748b]">Status Reservasi:</span>
                        <span class="text-[12px] font-semibold text-[#e11d48]">Ditutup Sementara</span>
                    </div>

                    @else
                    {{-- Tersedia: Capacity + Info --}}
                    <div class="flex items-center justify-between">
                        <span class="text-[12px] font-medium text-[#64748b]">Kapasitas:</span>
                        <span class="text-[12px] font-bold text-[#1e293b]">
                            @if($facility->capacity)
                            {{ number_format($facility->capacity) }} peserta
                            @else
                            —
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[12px] font-medium text-[#64748b]">Kondisi:</span>
                        <span class="text-[12px] font-semibold text-[#059669]">Siap Digunakan</span>
                    </div>
                    @endif

                </div>

            </div>

            {{-- Quick Action Button --}}
            <div class="px-5 pb-5 pt-5">
                <div class="border-t border-[#f1f5f9] pt-3">
                    <a href="{{ route('petugas.laporan.index', ['facility_id' => $facility->id]) }}"
                        class="flex items-center justify-center gap-1.5 w-full bg-white border border-[#e2e8f0] rounded-xl px-3 py-2.5 shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] hover:bg-[#f8fafc] transition-colors">
                        <span class="text-[12px] font-bold text-[#334155]">Lihat Laporan</span>
                        <svg class="w-3.5 h-3.5 text-[#334155] shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        @endforeach
    </div>
    @endif

    {{-- ============================================================
         PAGINATION & FOOTER INFO
    ============================================================ --}}
    @if($facilities->hasPages() || $facilities->total() > 0)
    <div class="flex items-center justify-between pt-2">

        {{-- Info text --}}
        <p class="text-[12px] font-medium text-[#64748b]">
            Menampilkan
            <span class="font-bold text-[#334155]">{{ $facilities->firstItem() }} – {{ $facilities->lastItem() }}</span>
            dari
            <span class="font-bold text-[#334155]">{{ $facilities->total() }}</span>
            fasilitas kampus
        </p>

        {{-- Pagination links --}}
        @if($facilities->hasPages())
        <div class="flex items-center gap-1.5">

            {{-- Previous --}}
            @if($facilities->onFirstPage())
            <span class="w-8 h-8 flex items-center justify-center bg-white border border-[rgba(226,232,240,0.8)] rounded-lg opacity-40 cursor-not-allowed">
                <svg class="w-4 h-4 text-[#475569]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </span>
            @else
            <a href="{{ $facilities->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center bg-white border border-[rgba(226,232,240,0.8)] rounded-lg hover:bg-[#f8fafc] transition-colors">
                <svg class="w-4 h-4 text-[#475569]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </a>
            @endif

            {{-- Page numbers --}}
            @foreach($facilities->getUrlRange(1, $facilities->lastPage()) as $page => $url)
            @if($page === 1 || $page === $facilities->lastPage() || abs($page - $facilities->currentPage()) <= 1)
                @if($page==$facilities->currentPage())
                <span class="w-8 h-8 flex items-center justify-center bg-[#19183b] text-white text-[12px] font-bold rounded-lg shadow-[0px_1px_1px_rgba(0,0,0,0.05)]">
                    {{ $page }}
                </span>
                @else
                <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center bg-white border border-[rgba(226,232,240,0.8)] text-[#475569] text-[12px] font-semibold rounded-lg hover:bg-[#f8fafc] transition-colors">
                    {{ $page }}
                </a>
                @endif
                @elseif($page === $facilities->currentPage() - 2 || $page === $facilities->currentPage() + 2)
                <span class="flex items-center justify-center px-1 text-[12px] text-[#94a3b8]">...</span>
                @endif
                @endforeach

                {{-- Next --}}
                @if($facilities->hasMorePages())
                <a href="{{ $facilities->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center bg-white border border-[rgba(226,232,240,0.8)] rounded-lg hover:bg-[#f8fafc] transition-colors">
                    <svg class="w-4 h-4 text-[#475569]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
                @else
                <span class="w-8 h-8 flex items-center justify-center bg-white border border-[rgba(226,232,240,0.8)] rounded-lg opacity-40 cursor-not-allowed">
                    <svg class="w-4 h-4 text-[#475569]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </span>
                @endif

        </div>
        @endif

    </div>
    @endif

</div>

@endsection