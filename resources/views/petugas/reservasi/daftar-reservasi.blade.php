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
                <div class="bg-white border border-[#e2e8f0] rounded-xl px-[15px] py-[9px] flex items-center gap-2">
                    <span class="bg-[#10b981] rounded-full size-2"></span>
                    <span class="text-xs font-semibold text-[#334155] leading-4 whitespace-nowrap">
                        {{ $activePeriod ?? 'Semester Genap 2026' }}
                    </span>
                </div>

                <a href="{{ Route::has('petugas.reservasi.create') ? route('petugas.reservasi.create') : '#' }}"
                    class="bg-[#0f172a] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-xl px-4 py-2 flex items-center gap-1.5">
                    <svg class="size-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span class="text-xs font-semibold text-white leading-4 whitespace-nowrap">Buat Reservasi Baru</span>
                </a>
            </div>
        </div>

        {{-- ==================== KEY SUMMARY STAT STRIP ==================== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

            {{-- Card 1: Total Reservasi --}}
            <div
                class="relative bg-white border border-[#f1f5f9] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl px-[21px] py-[33px] flex items-center justify-between gap-4 min-w-0">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium tracking-[0.6px] uppercase text-[#94a3b8] leading-4">Total Reservasi</p>
                    <p class="font-black text-2xl text-[#0f172a] leading-8 pt-0.5">{{ $totalReservasi ?? 156 }}</p>
                    <div class="flex items-center gap-1 pt-0.5">
                        <svg class="size-3.5 text-[#047857]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.5 19.5l6-6 4 4 7.5-7.5M15 10.5h5.25V15.75" />
                        </svg>
                        <span class="text-[11px] font-semibold text-[#047857] leading-[16.5px] whitespace-nowrap">
                            {{ $totalReservasiGrowth ?? '+7% vs bulan lalu' }}
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
                    <p class="font-black text-2xl text-[#0f172a] leading-8 pt-2">{{ $menungguCount ?? 10 }}</p>
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
                    <p class="font-black text-2xl text-[#0f172a] leading-8 pt-2">{{ $disetujuiCount ?? 80 }}</p>
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
                    <p class="font-black text-2xl text-[#0f172a] leading-8 pt-2">{{ $dibatalkanCount ?? 15 }}</p>
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
                    <div class="relative w-full sm:w-[289px] shrink-0">
                        <span class="absolute inset-y-0 left-0 pl-[14px] flex items-center pointer-events-none">
                            <svg class="size-4 text-[#94a3b8]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </span>

                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            placeholder="Cari ID, nama peminjam, atau fasilitas..."
                            class="w-full bg-white border border-[#e2e8f0] rounded-xl pl-[41px] pr-[17px] py-[11px] text-xs font-medium text-[#0f172a] placeholder:text-[#94a3b8] focus:outline-none focus:ring-2 focus:ring-[#0f172a]/10">
                    </div>


                    {{-- Status + Filter Lanjutan --}}
                    <div class="flex items-center gap-1.5 min-w-0">

                        {{-- Status Pills --}}
                        <div class="flex items-center gap-1.5 overflow-x-auto min-w-0">
                            <div class="flex items-center gap-1.5 w-max">

                                @php
                                    $filterPills = $filterPills ?? [
                                        [
                                            'label' => 'Semua',
                                            'key' => 'semua',
                                            'active' => true,
                                            'bg' => 'bg-[#0f172a]',
                                            'text' => 'text-white',
                                        ],
                                        [
                                            'label' => 'Menunggu',
                                            'key' => 'menunggu',
                                            'active' => false,
                                            'bg' => 'bg-[#fffbeb]',
                                            'text' => 'text-[#b45309]',
                                        ],
                                        [
                                            'label' => 'Disetujui',
                                            'key' => 'disetujui',
                                            'active' => false,
                                            'bg' => 'bg-[#ecfdf5]',
                                            'text' => 'text-[#047857]',
                                        ],
                                        [
                                            'label' => 'Ditolak',
                                            'key' => 'ditolak',
                                            'active' => false,
                                            'bg' => 'bg-[#fff1f2]',
                                            'text' => 'text-[#be123c]',
                                        ],
                                        [
                                            'label' => 'Dibatalkan',
                                            'key' => 'dibatalkan',
                                            'active' => false,
                                            'bg' => 'bg-[#fdf2f8]',
                                            'text' => 'text-[#be185d]',
                                        ],
                                        [
                                            'label' => 'Selesai',
                                            'key' => 'selesai',
                                            'active' => false,
                                            'bg' => 'bg-[#f0f9ff]',
                                            'text' => 'text-[#0369a1]',
                                        ],
                                    ];
                                @endphp

                                @foreach ($filterPills as $pill)
                                    <a href="{{ url()->current() }}?status={{ $pill['key'] }}"
                                        class="{{ $pill['bg'] }} {{ $pill['text'] }} rounded-lg px-3 py-1.5 text-xs {{ $pill['active'] ? 'font-bold' : 'font-semibold' }} text-center whitespace-nowrap shrink-0">
                                        {{ $pill['label'] }}
                                    </a>
                                @endforeach

                            </div>
                        </div>


                        {{-- Filter Lanjutan --}}
                        <button type="button"
                            class="border border-[#e2e8f0] rounded-xl px-[13px] py-[9px] flex items-center gap-1.5 shrink-0">
                            <svg class="size-3.5 text-[#334155]" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                            </svg>

                            <span class="text-xs font-semibold text-[#334155] leading-4 whitespace-nowrap">
                                Filter Lanjutan
                            </span>
                        </button>

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
                        {{--
                        Controller sebaiknya mengirim $reservations (misal hasil
                        Reservation::with('facility','user')->paginate(12)) dengan
                        atribut kurang lebih: $reservation->id_display,
                        $reservation->user->name, $reservation->facility->name,
                        $reservation->date, $reservation->start_time / end_time,
                        $reservation->status.
                    --}}
                        @php
                            $statusStyles = [
                                'Menunggu' => [
                                    'bg' => 'bg-[#fffbeb]',
                                    'border' => 'border-[rgba(253,230,138,0.6)]',
                                    'text' => 'text-[#b45309]',
                                    'dot' => 'bg-[#f59e0b]',
                                ],
                                'Disetujui' => [
                                    'bg' => 'bg-[#ecfdf5]',
                                    'border' => 'border-[rgba(167,243,208,0.6)]',
                                    'text' => 'text-[#047857]',
                                    'dot' => 'bg-[#10b981]',
                                ],
                                'Ditolak' => [
                                    'bg' => 'bg-[#fff1f2]',
                                    'border' => 'border-[rgba(254,205,211,0.6)]',
                                    'text' => 'text-[#be123c]',
                                    'dot' => 'bg-[#f43f5e]',
                                ],
                                'Dibatalkan' => [
                                    'bg' => 'bg-[#fdf2f8]',
                                    'border' => 'border-[rgba(251,207,232,0.6)]',
                                    'text' => 'text-[#be185d]',
                                    'dot' => 'bg-[#ec4899]',
                                ],
                                'Selesai' => [
                                    'bg' => 'bg-[#f0f9ff]',
                                    'border' => 'border-[rgba(186,230,253,0.6)]',
                                    'text' => 'text-[#0369a1]',
                                    'dot' => 'bg-[#0ea5e9]',
                                ],
                            ];
                            $avatarPalette = [
                                ['bg' => 'bg-[#e0e7ff]', 'text' => 'text-[#4338ca]'],
                                ['bg' => 'bg-[#f3e8ff]', 'text' => 'text-[#7e22ce]'],
                                ['bg' => 'bg-[#ccfbf1]', 'text' => 'text-[#0f766e]'],
                                ['bg' => 'bg-[#fef3c7]', 'text' => 'text-[#b45309]'],
                                ['bg' => 'bg-[#e0f2fe]', 'text' => 'text-[#0369a1]'],
                                ['bg' => 'bg-[#ffe4e6]', 'text' => 'text-[#be123c]'],
                            ];
                        @endphp

                        @forelse (($reservations ?? []) as $i => $reservation)
                            @php
                                $status = $reservation->status ?? $reservation['status'];
                                $style = $statusStyles[$status] ?? $statusStyles['Menunggu'];
                                $avatar = $avatarPalette[$i % count($avatarPalette)];
                                $name = $reservation->user->name ?? $reservation['name'];
                                $initials = collect(explode(' ', $name))
                                    ->map(fn($w) => strtoupper($w[0] ?? ''))
                                    ->take(2)
                                    ->implode('');
                            @endphp
                            <tr>
                                <td
                                    class="pl-6 pr-4 py-[23.5px] font-mono text-xs font-bold text-[#0f172a] whitespace-nowrap">
                                    {{ $reservation->id_display ?? $reservation['id'] }}
                                </td>
                                <td class="px-4 py-[17.5px]">
                                    <div class="flex items-center gap-2.5">
                                        <span
                                            class="{{ $avatar['bg'] }} {{ $avatar['text'] }} rounded-full size-7 flex items-center justify-center text-[10px] font-bold">
                                            {{ $initials }}
                                        </span>
                                        <span
                                            class="text-xs font-semibold text-[#0f172a] whitespace-nowrap">{{ $name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-[23px] text-xs font-medium text-[#1e293b] whitespace-nowrap">
                                    {{ $reservation->facility->name ?? $reservation['facility'] }}
                                </td>
                                <td class="px-4 py-[23px] text-xs font-medium text-[#64748b] whitespace-nowrap">
                                    {{ $reservation->date ?? $reservation['date'] }}
                                </td>
                                <td class="px-4 py-[23px] text-xs font-medium text-[#64748b] whitespace-nowrap">
                                    {{ $reservation->start_time ?? $reservation['start_time'] }} –
                                    {{ $reservation->end_time ?? $reservation['end_time'] }}
                                </td>
                                <td class="px-4 py-[18.5px]">
                                    <span
                                        class="inline-flex items-center gap-1.5 {{ $style['bg'] }} border {{ $style['border'] }} rounded-full px-[11px] py-[5px] text-[11px] font-semibold {{ $style['text'] }} whitespace-nowrap">
                                        <span class="{{ $style['dot'] }} rounded-full size-1.5"></span>
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="pl-4 pr-6 py-[16.5px] text-right">
                                    <a href="{{ Route::has('petugas.reservasi.show') ? route('petugas.reservasi.show', $reservation->id ?? $reservation['id']) : '#' }}"
                                        class="inline-flex items-center justify-center bg-white border border-[#e2e8f0] rounded-lg px-[13px] py-[7px] text-xs font-semibold text-[#334155] whitespace-nowrap">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            {{-- Dummy/placeholder data mengikuti tampilan Figma --}}
                            @foreach ([
            ['id' => 'RV15', 'name' => 'Januar Pratama', 'facility' => 'Ruang A101 (Auditorium)', 'date' => '14-04-2026', 'start_time' => '07.00', 'end_time' => '10.30', 'status' => 'Menunggu'],
            ['id' => 'RV14', 'name' => 'Tawinan Phavat', 'facility' => 'Mic Wireless & Speaker', 'date' => '14-04-2026', 'start_time' => '08.00', 'end_time' => '11.30', 'status' => 'Menunggu'],
            ['id' => 'RV13', 'name' => 'Jimmy Saputra', 'facility' => 'Laboratorium Komputer B', 'date' => '13-04-2026', 'start_time' => '10.00', 'end_time' => '12.00', 'status' => 'Disetujui'],
            ['id' => 'RV12', 'name' => 'Arsyanendra Elang', 'facility' => 'Ruang Rapat Lt. 3', 'date' => '13-04-2026', 'start_time' => '13.00', 'end_time' => '15.00', 'status' => 'Disetujui'],
            ['id' => 'RV11', 'name' => 'Sagara Anendra', 'facility' => 'Lapangan Basket', 'date' => '12-04-2026', 'start_time' => '16.00', 'end_time' => '18.00', 'status' => 'Selesai'],
            ['id' => 'RV10', 'name' => 'Kejora Puspa', 'facility' => 'Aula Serbaguna', 'date' => '12-04-2026', 'start_time' => '09.00', 'end_time' => '11.00', 'status' => 'Ditolak'],
            ['id' => 'RV09', 'name' => 'Bagas Wirayuda', 'facility' => 'Ruang A102', 'date' => '11-04-2026', 'start_time' => '07.30', 'end_time' => '09.30', 'status' => 'Dibatalkan'],
            ['id' => 'RV08', 'name' => 'Naila Ramadhani', 'facility' => 'Studio Musik', 'date' => '11-04-2026', 'start_time' => '14.00', 'end_time' => '16.00', 'status' => 'Selesai'],
            ['id' => 'RV07', 'name' => 'Fajar Nugraha', 'facility' => 'Proyektor Portable', 'date' => '10-04-2026', 'start_time' => '08.00', 'end_time' => '10.00', 'status' => 'Menunggu'],
            ['id' => 'RV06', 'name' => 'Citra Ayu Lestari', 'facility' => 'Ruang B203', 'date' => '10-04-2026', 'start_time' => '11.00', 'end_time' => '13.00', 'status' => 'Disetujui'],
            ['id' => 'RV05', 'name' => 'Dewangga Putra', 'facility' => 'Lapangan Futsal', 'date' => '09-04-2026', 'start_time' => '15.00', 'end_time' => '17.00', 'status' => 'Ditolak'],
            ['id' => 'RV04', 'name' => 'Melati Anjani', 'facility' => 'Perpustakaan Ruang Diskusi', 'date' => '09-04-2026', 'start_time' => '09.00', 'end_time' => '10.30', 'status' => 'Disetujui'],
        ] as $i => $reservation)
                                @php
                                    $style = $statusStyles[$reservation['status']];
                                    $avatar = $avatarPalette[$i % count($avatarPalette)];
                                    $initials = collect(explode(' ', $reservation['name']))
                                        ->map(fn($w) => strtoupper($w[0] ?? ''))
                                        ->take(2)
                                        ->implode('');
                                @endphp
                                <tr>
                                    <td
                                        class="pl-6 pr-4 py-[23.5px] font-mono text-xs font-bold text-[#0f172a] whitespace-nowrap">
                                        {{ $reservation['id'] }}</td>
                                    <td class="px-4 py-[17.5px]">
                                        <div class="flex items-center gap-2.5">
                                            <span
                                                class="{{ $avatar['bg'] }} {{ $avatar['text'] }} rounded-full size-7 flex items-center justify-center text-[10px] font-bold">
                                                {{ $initials }}
                                            </span>
                                            <span
                                                class="text-xs font-semibold text-[#0f172a] whitespace-nowrap">{{ $reservation['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-[23px] text-xs font-medium text-[#1e293b] whitespace-nowrap">
                                        {{ $reservation['facility'] }}</td>
                                    <td class="px-4 py-[23px] text-xs font-medium text-[#64748b] whitespace-nowrap">
                                        {{ $reservation['date'] }}</td>
                                    <td class="px-4 py-[23px] text-xs font-medium text-[#64748b] whitespace-nowrap">
                                        {{ $reservation['start_time'] }} – {{ $reservation['end_time'] }}</td>
                                    <td class="px-4 py-[18.5px]">
                                        <span
                                            class="inline-flex items-center gap-1.5 {{ $style['bg'] }} border {{ $style['border'] }} rounded-full px-[11px] py-[5px] text-[11px] font-semibold {{ $style['text'] }} whitespace-nowrap">
                                            <span class="{{ $style['dot'] }} rounded-full size-1.5"></span>
                                            {{ $reservation['status'] }}
                                        </span>
                                    </td>
                                    <td class="pl-4 pr-6 py-[16.5px] text-right">
                                        <a href="#"
                                            class="inline-flex items-center justify-center bg-white border border-[#e2e8f0] rounded-lg px-[13px] py-[7px] text-xs font-semibold text-[#334155] whitespace-nowrap">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Footer --}}
            <div class="border-t border-[#f1f5f9] flex items-center justify-between gap-4 px-4 pt-[17px] pb-4 flex-wrap">
                <p class="text-xs font-medium text-[#64748b] leading-4">
                    Menampilkan
                    <span class="font-semibold text-[#0f172a]">{{ $pageFrom ?? 1 }} – {{ $pageTo ?? 12 }}</span>
                    dari
                    <span class="font-semibold text-[#0f172a]">{{ $totalReservasi ?? 156 }}</span>
                    reservasi
                </p>

                {{--
                Ganti blok navigasi manual di bawah ini dengan paginator
                Laravel bawaan bila $reservations sudah berupa hasil
                ->paginate(), misalnya: {{ $reservations->links() }}
                (lalu sesuaikan stylingnya dengan tema di atas).
            --}}
                <nav class="flex items-center gap-1">
                    <button type="button"
                        class="border border-[#e2e8f0] rounded-lg p-[7px] opacity-40 cursor-not-allowed" disabled>
                        <svg class="size-4 text-[#334155]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>

                    @php $pageLinks = $pageLinks ?? [1, 2, 3, '...', 13]; @endphp
                    @foreach ($pageLinks as $page)
                        @if ($page === '...')
                            <span
                                class="size-8 flex items-center justify-center text-xs font-medium text-[#94a3b8]">...</span>
                        @else
                            <a href="{{ url()->current() }}?page={{ $page }}"
                                class="size-8 rounded-lg flex items-center justify-center text-xs
                                  {{ ($currentPage ?? 1) == $page ? 'bg-[#0f172a] font-bold text-white' : 'font-medium text-[#475569]' }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    <a href="{{ url()->current() }}?page={{ ($currentPage ?? 1) + 1 }}"
                        class="border border-[#e2e8f0] rounded-lg p-[7px]">
                        <svg class="size-4 text-[#334155]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </nav>
            </div>
        </div>
    </div>

@endsection
