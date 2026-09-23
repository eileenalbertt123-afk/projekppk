@extends('layouts.petugas')

@section('content')

    <div class="px-8 py-8">

        {{-- ==================== PAGE HEADER ==================== --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>
                <h1 class="font-extrabold text-[30px] tracking-[-0.75px] text-[#0f172a] leading-9">
                    {{ $pageTitle ?? 'Daftar Reservasi' }}
                </h1>
                <p class="text-sm font-normal text-[#64748b] leading-5">
                    {{ $pageSubtitle ?? 'Kelola dan pantau seluruh reservasi fasilitas kampus secara terpadu' }}
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

            {{-- Card 1: Total Reservasi --}}
            <div
                class="relative bg-white border border-[#f1f5f9] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl px-[21px] py-[33px] flex items-center justify-between gap-4 min-w-0">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium tracking-[0.6px] uppercase text-[#94a3b8] leading-4">Total Reservasi</p>
                    <p class="font-black text-2xl text-[#0f172a] leading-8 pt-0.5">{{ $totalReservasi }}</p>
                    <div class="flex items-center gap-1 pt-0.5">
                        <svg class="size-3.5 text-[#047857]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.5 19.5l6-6 4 4 7.5-7.5M15 10.5h5.25V15.75" />
                        </svg>
                        <span class="text-[11px] font-semibold text-[#047857] leading-[16.5px] whitespace-nowrap">
                            {{ $totalReservasiGrowth ?? 'Seluruh data reservasi' }}
                        </span>
                    </div>
                </div>
                <div class="bg-[#f1f5f9] rounded-xl size-11 flex items-center justify-center shrink-0">
                    <svg class="size-5 text-[#0f172a]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                    </svg>
                </div>
            </div>

            {{-- Card 2: Menunggu Konfirmasi --}}
            <div
                class="relative bg-white border border-[#f1f5f9] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl px-[21px] py-[33px] flex items-center justify-between gap-4 min-w-0">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium tracking-[0.6px] uppercase text-[#94a3b8] leading-4">Menunggu</p>
                    <p class="text-xs font-medium tracking-[0.6px] uppercase text-[#94a3b8] leading-4">Konfirmasi</p>
                    <p class="font-black text-2xl text-[#0f172a] leading-8 pt-2">{{ $menungguCount }}</p>
                    <p class="text-[11px] font-medium text-[#b45309] leading-[16.5px] whitespace-nowrap">
                        {{ $menungguDesc ?? 'Perlu tindakan review' }}
                    </p>
                </div>
                <div class="bg-[#fffbeb] rounded-xl size-11 flex items-center justify-center shrink-0">
                    <svg class="size-[15px] text-[#b45309]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            {{-- Card 3: Disetujui --}}
            <div
                class="relative bg-white border border-[#f1f5f9] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl px-[21px] py-[33px] flex items-center justify-between gap-4 min-w-0">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium tracking-[0.6px] uppercase text-[#94a3b8] leading-4 pt-6">Disetujui</p>
                    <p class="font-black text-2xl text-[#0f172a] leading-8 pt-2">{{ $disetujuiCount }}</p>
                    <p class="text-[11px] font-medium text-[#047857] leading-[16.5px] whitespace-nowrap">
                        {{ $disetujuiDesc ?? 'Terkonfirmasi aktif' }}
                    </p>
                </div>
                <div class="bg-[#ecfdf5] rounded-xl p-3 flex items-center justify-center shrink-0">
                    <svg class="size-5 text-[#047857]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            {{-- Card 4: Dibatalkan / Ditolak --}}
            <div
                class="relative bg-white border border-[#f1f5f9] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl px-[21px] py-[33px] flex items-center justify-between gap-4 min-w-0">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium tracking-[0.6px] uppercase text-[#94a3b8] leading-4">Dibatalkan /</p>
                    <p class="text-xs font-medium tracking-[0.6px] uppercase text-[#94a3b8] leading-4">Ditolak</p>
                    <p class="font-black text-2xl text-[#0f172a] leading-8 pt-2">{{ $dibatalkanDitolakCount }}</p>
                    <p class="text-[11px] font-medium text-[#be123c] leading-[16.5px] whitespace-nowrap">
                        {{ $dibatalkanDesc ?? 'Jadwal bentrok / dibatalkan' }}
                    </p>
                </div>
                <div class="bg-[#fff1f2] rounded-xl size-11 flex items-center justify-center shrink-0">
                    <svg class="size-[15px] text-[#be123c]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- ==================== MAIN TABLE CARD ==================== --}}
        <div
            class="bg-white border border-[#f1f5f9] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl overflow-hidden">

            {{-- Table Toolbar --}}
            <div class="border-b border-[#f1f5f9] px-5 pt-5 pb-[21px]">

                <div class="flex flex-wrap items-center gap-3">

                    {{-- Search --}}
                    <form method="GET"
                        action="{{ route('petugas.reservasi.index') }}"
                        class="relative w-full sm:w-[289px] shrink-0">

                        {{-- pertahankan filter status --}}
                        @if (request('status'))
                            <input type="hidden"
                                name="status"
                                value="{{ request('status') }}">
                        @endif

                        <span class="absolute inset-y-0 left-0 pl-[14px] flex items-center pointer-events-none">
                            <svg class="size-4 text-[#94a3b8]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </span>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari ID, nama peminjam, atau fasilitas..."
                            class="w-full bg-white border border-[#e2e8f0] rounded-xl pl-[41px] pr-[17px] py-[11px] text-xs font-medium text-[#0f172a] placeholder:text-[#94a3b8] focus:outline-none focus:ring-2 focus:ring-[#0f172a]/10">

                    </form>

                    {{-- Status + Filter Lanjutan --}}
                    <div class="flex items-center gap-1.5 min-w-0">

                        {{-- Status Pills --}}
                        <div class="flex items-center gap-1.5 overflow-x-auto min-w-0">
                            <div class="flex items-center gap-1.5 w-max">

                                @php
                                    $filterPills = [
                                        [
                                            'label' => 'Semua',
                                            'key' => 'semua',
                                            'bg' => 'bg-[#f8fafc]',
                                            'text' => 'text-[#334155]',
                                        ],
                                        [
                                            'label' => 'Menunggu',
                                            'key' => 'menunggu',
                                            'bg' => 'bg-[#fffbeb]',
                                            'text' => 'text-[#b45309]',
                                        ],
                                        [
                                            'label' => 'Disetujui',
                                            'key' => 'disetujui',
                                            'bg' => 'bg-[#ecfdf5]',
                                            'text' => 'text-[#047857]',
                                        ],
                                        [
                                            'label' => 'Ditolak',
                                            'key' => 'ditolak',
                                            'bg' => 'bg-[#fff1f2]',
                                            'text' => 'text-[#be123c]',
                                        ],
                                        [
                                            'label' => 'Dibatalkan',
                                            'key' => 'dibatalkan',
                                            'bg' => 'bg-[#fdf2f8]',
                                            'text' => 'text-[#be185d]',
                                        ],
                                        [
                                            'label' => 'Selesai',
                                            'key' => 'selesai',
                                            'bg' => 'bg-[#f0f9ff]',
                                            'text' => 'text-[#0369a1]',
                                        ],
                                    ];

                                    $activeStatus = request('status', 'semua');
                                @endphp

                                @foreach ($filterPills as $pill)

                                    @php
                                        $isActive = $activeStatus === $pill['key'];
                                    @endphp

                                    <a
                                        href="{{ route('petugas.reservasi.index', array_merge(
                                            request()->except('page'),
                                            ['status' => $pill['key']]
                                        )) }}"
                                        class="
                                            {{ $pill['bg'] }}
                                            {{ $pill['text'] }}
                                            rounded-lg
                                            px-3 py-1.5
                                            text-xs
                                            text-center
                                            whitespace-nowrap
                                            shrink-0
                                            font-semibold
                                            transition
                                            {{ $isActive
                                                ? 'border-2 border-[#19183b] font-bold shadow-sm'
                                                : 'border border-transparent hover:brightness-95'
                                            }}
                                        "
                                    >
                                        {{ $pill['label'] }}
                                    </a>

                                @endforeach
                            </div>
                        </div>


                        {{-- Filter Pengurutan --}}
                        <details class="relative">

                            <summary
                                class="list-none cursor-pointer border border-[#e2e8f0] rounded-xl px-[13px] py-[9px] flex items-center gap-1.5 shrink-0">

                                <svg class="size-3.5 text-[#334155]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 6h18M6 12h12M10 18h4" />
                                </svg>

                                <span class="text-xs font-semibold text-[#334155] whitespace-nowrap">
                                    Urutkan
                                </span>

                            </summary>

                            <div class="absolute right-0 top-12 z-30 w-[180px] bg-white border border-[#e2e8f0] rounded-xl shadow-lg p-2">

                                <a
                                    href="{{ route('petugas.reservasi.index', array_merge(
                                        request()->except('page'),
                                        ['sort' => 'terbaru']
                                    )) }}"
                                    class="block rounded-lg px-3 py-2 text-xs font-semibold
                                    {{ request('sort', 'terbaru') === 'terbaru'
                                        ? 'bg-[#eef4f3] text-[#19183b]'
                                        : 'text-[#64748b] hover:bg-[#f8fafc]'
                                    }}">
                                    Terbaru
                                </a>

                                <a
                                    href="{{ route('petugas.reservasi.index', array_merge(
                                        request()->except('page'),
                                        ['sort' => 'terlama']
                                    )) }}"
                                    class="block rounded-lg px-3 py-2 text-xs font-semibold
                                    {{ request('sort') === 'terlama'
                                        ? 'bg-[#eef4f3] text-[#19183b]'
                                        : 'text-[#64748b] hover:bg-[#f8fafc]'
                                    }}">
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
                                Reservation ID</th>
                            <th class="px-4 py-3.5 text-[11px] font-bold uppercase tracking-[0.55px] text-[#94a3b8]">
                                Nama Peminjam</th>
                            <th class="px-4 py-3.5 text-[11px] font-bold uppercase tracking-[0.55px] text-[#94a3b8]">
                                Fasilitas</th>
                            <th class="px-4 py-3.5 text-[11px] font-bold uppercase tracking-[0.55px] text-[#94a3b8]">
                                Tanggal</th>
                            <th class="px-4 py-3.5 text-[11px] font-bold uppercase tracking-[0.55px] text-[#94a3b8]">
                                Waktu</th>
                            <th class="px-4 py-3.5 text-[11px] font-bold uppercase tracking-[0.55px] text-[#94a3b8]">
                                Status</th>
                            <th
                                class="pl-4 pr-6 py-3.5 text-[11px] font-bold uppercase tracking-[0.55px] text-[#94a3b8] text-right">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f5f9]">
                       @forelse ($reservations as $reservation)
                            <tr>
                                {{-- Reservation ID --}}
                                <td class="px-6 py-5 text-sm font-bold text-[#0f172a] whitespace-nowrap">
                                    {{ $reservation->reservation_code }}
                                </td>
                                {{-- Nama Peminjam --}}
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="size-9 rounded-full bg-[#eef4f3] flex items-center justify-center text-xs font-bold text-[#19183b]">
                                            {{ strtoupper(substr($reservation->user->name, 0, 2)) }}
                                        </div>
                                        <span class="text-sm font-semibold text-[#0f172a] whitespace-nowrap">
                                            {{ $reservation->user->name }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Fasilitas --}}
                                <td class="px-6 py-5 text-sm font-medium text-[#334155]">
                                    {{ $reservation->details->pluck('facility.name')->join(', ') }}
                                </td>

                                {{-- Tanggal --}}
                                <td class="px-6 py-5 text-sm font-medium text-[#708993] whitespace-nowrap">
                                    {{ $reservation->start_time->format('d-m-Y') }}
                                </td>

                                {{-- Waktu --}}
                                <td class="px-6 py-5 text-sm font-medium text-[#708993] whitespace-nowrap">
                                    {{ $reservation->start_time->format('H.i') }}
                                    -
                                    {{ $reservation->end_time->format('H.i') }}
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <x-petugas.status-badge :status="$reservation->status" />
                                </td>

                                <td class="px-4 py-4 text-center">
                                    <x-petugas.detail-button
                                        :href="route('petugas.reservasi.detail', $reservation->id)"
                                    />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="px-6 py-10 text-center text-sm text-[#708993]">
                                    Tidak ada data reservasi.
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
                        {{ $reservations->firstItem() ?? 0 }} – {{ $reservations->lastItem() ?? 0 }}
                    </span>
                    dari
                    <span class="font-semibold text-[#0f172a]">
                        {{ $reservations->total() }}
                    </span>
                    reservasi
                </p>

                <nav class="flex items-center gap-1">

                    {{-- Previous --}}
                    @if ($reservations->onFirstPage())
                        <span class="border border-[#e2e8f0] rounded-lg p-[7px] opacity-40 cursor-not-allowed">
                            ←
                        </span>
                    @else
                        <a href="{{ $reservations->previousPageUrl() }}"
                        class="border border-[#e2e8f0] rounded-lg p-[7px]">
                            ←
                        </a>
                    @endif

                    {{-- Page numbers --}}
                    @for ($page = 1; $page <= $reservations->lastPage(); $page++)
                        <a href="{{ $reservations->url($page) }}"
                        class="size-8 rounded-lg flex items-center justify-center text-xs
                        {{ $reservations->currentPage() == $page
                                ? 'bg-[#0f172a] font-bold text-white'
                                : 'font-medium text-[#475569]' }}">
                            {{ $page }}
                        </a>
                    @endfor

                    {{-- Next --}}
                    @if ($reservations->hasMorePages())
                        <a href="{{ $reservations->nextPageUrl() }}"
                        class="border border-[#e2e8f0] rounded-lg p-[7px]">
                            →
                        </a>
                    @else
                        <span class="border border-[#e2e8f0] rounded-lg p-[7px] opacity-40 cursor-not-allowed">
                            →
                        </span>
                    @endif

                </nav>
            </div>
        </div>
    </div>

@endsection
