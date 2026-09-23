@extends('layouts.petugas')

@section('content')

    <div class="px-8 py-8">

        {{-- ==================== PAGE HEADER ==================== --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>
                <h1 class="font-extrabold text-[30px] tracking-[-0.75px] text-[#0f172a] leading-9">
                    {{ $pageTitle ?? 'Daftar Laporan' }}
                </h1>
                <p class="text-sm font-normal text-[#64748b] leading-5">
                    {{ $pageSubtitle ?? 'Kelola dan pantau seluruh laporan kerusakan fasilitas kampus secara terpadu' }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <div class="bg-[#d1fae5] border border-[#a7f3d0] rounded-lg px-[13px] py-[7px] flex items-center gap-1.5">
                    <span class="bg-[#059669] rounded-full size-2"></span>
                    <span class="text-xs font-semibold text-[#065f46] leading-4 whitespace-nowrap">
                        {{ $activePeriod ?? 'Semester Genap 2026' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ==================== KEY SUMMARY STAT STRIP ==================== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

            {{-- Card 1: Total Laporan --}}
            <div class="relative bg-white border border-[#f1f5f9] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl px-[21px] py-[33px] flex items-center justify-between gap-4 min-w-0">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium tracking-[0.6px] uppercase text-[#94a3b8] leading-4">Total Laporan</p>
                    <p class="font-black text-2xl text-[#0f172a] leading-8 pt-0.5">{{ $totalLaporan }}</p>
                    <div class="flex items-center gap-1 pt-0.5">
                        <svg class="size-3.5 text-[#047857]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l6-6 4 4 7.5-7.5M15 10.5h5.25V15.75" />
                        </svg>
                        <span class="text-[11px] font-semibold text-[#047857] leading-[16.5px] whitespace-nowrap">
                            {{ $totalLaporanGrowth ?? 'Seluruh data laporan' }}
                        </span>
                    </div>
                </div>
                <div class="bg-[#f1f5f9] rounded-xl size-11 flex items-center justify-center shrink-0">
                    <svg class="size-5 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
            </div>

            {{-- Card 2: Baru --}}
            <div class="relative bg-white border border-[#f1f5f9] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl px-[21px] py-[33px] flex items-center justify-between gap-4 min-w-0">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium tracking-[0.6px] uppercase text-[#94a3b8] leading-4">Laporan</p>
                    <p class="text-xs font-medium tracking-[0.6px] uppercase text-[#94a3b8] leading-4">Baru</p>
                    <p class="font-black text-2xl text-[#0f172a] leading-8 pt-2">{{ $baruCount }}</p>
                    <p class="text-[11px] font-medium text-[#b45309] leading-[16.5px] whitespace-nowrap">
                        {{ $baruDesc ?? 'Perlu tindakan segera' }}
                    </p>
                </div>
                <div class="bg-[#fffbeb] rounded-xl size-11 flex items-center justify-center shrink-0">
                    <svg class="size-[15px] text-[#b45309]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            {{-- Card 3: Diproses --}}
            <div class="relative bg-white border border-[#f1f5f9] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl px-[21px] py-[33px] flex items-center justify-between gap-4 min-w-0">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium tracking-[0.6px] uppercase text-[#94a3b8] leading-4 pt-6">Diproses</p>
                    <p class="font-black text-2xl text-[#0f172a] leading-8 pt-2">{{ $diprosesCount }}</p>
                    <p class="text-[11px] font-medium text-[#5b21b6] leading-[16.5px] whitespace-nowrap">
                        {{ $diprosesDesc ?? 'Sedang ditangani teknisi' }}
                    </p>
                </div>
                <div class="bg-[#ede9fe] rounded-xl size-11 flex items-center justify-center shrink-0">
                    <svg class="size-5 text-[#5b21b6]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                    </svg>
                </div>
            </div>

            {{-- Card 4: Selesai --}}
            <div class="relative bg-white border border-[#f1f5f9] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl px-[21px] py-[33px] flex items-center justify-between gap-4 min-w-0">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium tracking-[0.6px] uppercase text-[#94a3b8] leading-4 pt-6">Selesai</p>
                    <p class="font-black text-2xl text-[#0f172a] leading-8 pt-2">{{ $selesaiCount }}</p>
                    <p class="text-[11px] font-medium text-[#0369a1] leading-[16.5px] whitespace-nowrap">
                        {{ $selesaiDesc ?? 'Fasilitas sudah diperbaiki' }}
                    </p>
                </div>
                <div class="bg-[#e0f2fe] rounded-xl size-11 flex items-center justify-center shrink-0">
                    <svg class="size-5 text-[#0369a1]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

        </div>

        {{-- ==================== MAIN TABLE CARD ==================== --}}
        <div class="bg-white border border-[#f1f5f9] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl overflow-hidden">

            {{-- Table Toolbar --}}
            <div class="border-b border-[#f1f5f9] px-5 pt-5 pb-[21px]">

                <div class="flex flex-wrap items-center gap-3">

                    {{-- Search --}}
                    <form method="GET"
                        action="{{ route('petugas.laporan.index') }}"
                        class="relative w-full sm:w-[289px] shrink-0">

                        @if (request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif

                        <span class="absolute inset-y-0 left-0 pl-[14px] flex items-center pointer-events-none">
                            <svg class="size-4 text-[#94a3b8]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </span>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari ID, pelapor, atau fasilitas..."
                            class="w-full bg-white border border-[#e2e8f0] rounded-xl pl-[41px] pr-[17px] py-[11px] text-xs font-medium text-[#0f172a] placeholder:text-[#94a3b8] focus:outline-none focus:ring-2 focus:ring-[#0f172a]/10">

                    </form>

                    {{-- Status Pills + Sort --}}
                    <div class="flex items-center gap-1.5 min-w-0">

                        <div class="flex items-center gap-1.5 overflow-x-auto min-w-0">
                            <div class="flex items-center gap-1.5 w-max">

                                @php
                                    $filterPills = [
                                        [
                                            'label' => 'Semua',
                                            'key'   => 'semua',
                                            'bg'    => 'bg-[#f8fafc]',
                                            'text'  => 'text-[#334155]',
                                        ],
                                        [
                                            'label' => 'Baru',
                                            'key'   => 'baru',
                                            'bg'    => 'bg-[#fffbeb]',
                                            'text'  => 'text-[#b45309]',
                                        ],
                                        [
                                            'label' => 'Diproses',
                                            'key'   => 'diproses',
                                            'bg'    => 'bg-[#ede9fe]',
                                            'text'  => 'text-[#5b21b6]',
                                        ],
                                        [
                                            'label' => 'Selesai',
                                            'key'   => 'selesai',
                                            'bg'    => 'bg-[#e0f2fe]',
                                            'text'  => 'text-[#0369a1]',
                                        ],
                                        [
                                            'label' => 'Ditolak',
                                            'key'   => 'ditolak',
                                            'bg'    => 'bg-[#fff1f2]',
                                            'text'  => 'text-[#be123c]',
                                        ],
                                    ];

                                    $activeStatus = request('status', 'semua');
                                @endphp

                                @foreach ($filterPills as $pill)
                                    @php $isActive = $activeStatus === $pill['key']; @endphp
                                    <a
                                        href="{{ route('petugas.laporan.index', array_merge(request()->except('page'), ['status' => $pill['key']])) }}"
                                        class="{{ $pill['bg'] }} {{ $pill['text'] }} rounded-lg px-3 py-1.5 text-xs text-center whitespace-nowrap shrink-0 font-semibold transition
                                            {{ $isActive ? 'border-2 border-[#19183b] font-bold shadow-sm' : 'border border-transparent hover:brightness-95' }}"
                                    >
                                        {{ $pill['label'] }}
                                    </a>
                                @endforeach

                            </div>
                        </div>

                        {{-- Sort --}}
                        <details class="relative">
                            <summary class="list-none cursor-pointer border border-[#e2e8f0] rounded-xl px-[13px] py-[9px] flex items-center gap-1.5 shrink-0">
                                <svg class="size-3.5 text-[#334155]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M6 12h12M10 18h4" />
                                </svg>
                                <span class="text-xs font-semibold text-[#334155] whitespace-nowrap">Urutkan</span>
                            </summary>

                            <div class="absolute right-0 top-12 z-30 w-[180px] bg-white border border-[#e2e8f0] rounded-xl shadow-lg p-2">
                                <a href="{{ route('petugas.laporan.index', array_merge(request()->except('page'), ['sort' => 'terbaru'])) }}"
                                   class="block rounded-lg px-3 py-2 text-xs font-semibold {{ request('sort', 'terbaru') === 'terbaru' ? 'bg-[#eef4f3] text-[#19183b]' : 'text-[#64748b] hover:bg-[#f8fafc]' }}">
                                    Terbaru
                                </a>
                                <a href="{{ route('petugas.laporan.index', array_merge(request()->except('page'), ['sort' => 'terlama'])) }}"
                                   class="block rounded-lg px-3 py-2 text-xs font-semibold {{ request('sort') === 'terlama' ? 'bg-[#eef4f3] text-[#19183b]' : 'text-[#64748b] hover:bg-[#f8fafc]' }}">
                                    Terlama
                                </a>
                            </div>
                        </details>

                    </div>

                </div>

            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-[960px] text-left">
                    <thead class="bg-[rgba(248,250,252,0.7)] border-b border-[#f1f5f9]">
                        <tr>
                            <th class="pl-6 pr-4 py-3.5 text-[11px] font-bold uppercase tracking-[0.55px] text-[#94a3b8]">
                                Laporan ID</th>
                            <th class="px-4 py-3.5 text-[11px] font-bold uppercase tracking-[0.55px] text-[#94a3b8]">
                                Nama Pelapor</th>
                            <th class="px-4 py-3.5 text-[11px] font-bold uppercase tracking-[0.55px] text-[#94a3b8]">
                                Fasilitas</th>
                            <th class="px-4 py-3.5 text-[11px] font-bold uppercase tracking-[0.55px] text-[#94a3b8]">
                                Kategori</th>
                            <th class="px-4 py-3.5 text-[11px] font-bold uppercase tracking-[0.55px] text-[#94a3b8]">
                                Tanggal</th>
                            <th class="px-4 py-3.5 text-[11px] font-bold uppercase tracking-[0.55px] text-[#94a3b8]">
                                Status</th>
                            <th class="pl-4 pr-6 py-3.5 text-[11px] font-bold uppercase tracking-[0.55px] text-[#94a3b8] text-right">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f5f9]">

                        @forelse ($reports as $report)
                            @php
                                $categoryLabel = match($report->category) {

                                    'elektronik_av'
                                        => 'Elektronik & AV',

                                    'struktur_bangunan'
                                        => 'Struktur Bangunan',

                                    'mekanikal_utilitas'
                                        => 'Mekanikal & Utilitas',

                                    'furnitur'
                                        => 'Furnitur',

                                    'jaringan_it'
                                        => 'Jaringan IT',

                                    'kebersihan'
                                        => 'Kebersihan',

                                    'lainnya'
                                        => 'Lainnya',

                                    default
                                        => ucwords(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $report->category
                                            )
                                        ),

                                };
                            @endphp
                            <tr>

                                {{-- Laporan ID --}}
                                <td class="pl-6 pr-4 py-5 text-sm font-bold text-[#0f172a] whitespace-nowrap">
                                    {{ $report->report_code }}
                                </td>

                                {{-- Nama Pelapor --}}
                                <td class="px-4 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="size-9 rounded-full bg-[#eef4f3] flex items-center justify-center text-xs font-bold text-[#19183b]">
                                            {{ strtoupper(substr($report->user->name, 0, 2)) }}
                                        </div>
                                        <span class="text-sm font-semibold text-[#0f172a] whitespace-nowrap">
                                            {{ $report->user->name }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Fasilitas --}}
                                <td class="px-4 py-5 text-sm font-medium text-[#334155]">
                                    {{ $report->facility->name ?? '-' }}
                                </td>

                                {{-- Kategori --}}
                                <td class="px-4 py-5 text-sm font-medium text-[#708993] whitespace-nowrap">
                                    <span
                                        class="inline-flex
                                            bg-[#f1f5f9]
                                            border border-[#e2e8f0]
                                            rounded-lg
                                            px-3 py-1
                                            text-xs
                                            font-medium
                                            text-[#475569]"
                                    >
                                        {{ $categoryLabel }}

                                    </span>
                                </td>

                                {{-- Tanggal --}}
                                <td class="px-4 py-5 text-sm font-medium text-[#708993] whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($report->created_at)->format('d-m-Y') }}
                                </td>

                                {{-- Status --}}
                                <td class="px-4 py-5 whitespace-nowrap">
                                    <x-petugas.status-laporan-badge :status="$report->status" />
                                </td>

                                {{-- Aksi --}}
                                <td class="px-4 py-4 text-center">
                                    <x-petugas.detail-button
                                        :href="route('petugas.laporan.detail', $report->id)"/>
                                </td>

                            </tr>
                            @empty

                            <tr>

                                <td colspan="7"
                                    class="px-4 py-10 text-center text-sm text-[#708993]">

                                    Tidak ada data laporan.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- Pagination Footer --}}
            <div class="border-t border-[#f1f5f9] flex items-center justify-between gap-4 px-4 pt-[17px] pb-4 flex-wrap">
                <p class="text-xs font-medium text-[#64748b] leading-4">
                    Menampilkan
                    <span class="font-semibold text-[#0f172a]">
                        {{ $reports->firstItem() ?? 0 }} – {{ $reports->lastItem() ?? 0 }}
                    </span>
                    dari
                    <span class="font-semibold text-[#0f172a]">
                        {{ $reports->total() }}
                    </span>
                    laporan
                </p>

                <nav class="flex items-center gap-1">

                    {{-- Previous --}}
                    @if ($reports->onFirstPage())
                        <span class="border border-[#e2e8f0] rounded-lg p-[7px] opacity-40 cursor-not-allowed">←</span>
                    @else
                        <a href="{{ $reports->previousPageUrl() }}" class="border border-[#e2e8f0] rounded-lg p-[7px]">←</a>
                    @endif

                    {{-- Page numbers --}}
                    @for ($page = 1; $page <= $reports->lastPage(); $page++)
                        <a href="{{ $reports->url($page) }}"
                           class="size-8 rounded-lg flex items-center justify-center text-xs
                               {{ $reports->currentPage() == $page
                                   ? 'bg-[#0f172a] font-bold text-white'
                                   : 'font-medium text-[#475569]' }}">
                            {{ $page }}
                        </a>
                    @endfor

                    {{-- Next --}}
                    @if ($reports->hasMorePages())
                        <a href="{{ $reports->nextPageUrl() }}" class="border border-[#e2e8f0] rounded-lg p-[7px]">→</a>
                    @else
                        <span class="border border-[#e2e8f0] rounded-lg p-[7px] opacity-40 cursor-not-allowed">→</span>
                    @endif

                </nav>
            </div>

        </div>

    </div>

@endsection