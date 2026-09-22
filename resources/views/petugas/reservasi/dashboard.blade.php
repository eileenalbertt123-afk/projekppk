@extends('layouts.petugas')

@section('content')

    {{-- Dashboard Body --}}
        <main class="px-8 py-8">

            {{-- Section title & subtitle --}}
            <div class="flex items-center justify-between mb-[56px]">
                <div>
                    <h1 class="font-extrabold text-[30px] tracking-[-0.75px] text-[#19183b] leading-9">
                        {{ $pageTitle ?? 'Reservasi' }}
                    </h1>
                    <p class="text-sm font-normal text-[#708993] leading-5">
                        {{ $pageSubtitle ?? 'Manajemen Fasilitas & Pemesanan Kampus Terpadu' }}
                    </p>
                </div>
                <div class="bg-[#d1fae5] border border-[#a7f3d0] rounded-lg px-[13px] py-[7px] flex items-center gap-1.5">
                    <span class="bg-[#059669] rounded-full size-2"></span>
                    <span class="text-xs font-semibold text-[#065f46] leading-4 whitespace-nowrap">
                        {{ $activePeriod ?? 'Semester Genap 2026' }}
                    </span>
                </div>
            </div>

            {{-- KPI Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 mb-8">

                {{-- KPI 1: Total Peminjam --}}
                <div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] p-[21px] min-w-0">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-[#708993] leading-5">
                            Total Peminjam
                        </p>

                        <div class="bg-[#eef4f3] rounded-xl size-9 flex items-center justify-center shrink-0">
                            <svg class="size-5 text-[#19183b]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-[26px] flex flex-wrap items-end gap-2">
                        <p class="font-extrabold text-[30px] tracking-[-0.75px] text-[#19183b] leading-9">
                            {{ $totalPeminjam }}
                        </p>

                        @if ($persenPeminjam !== null)
                            <span class="bg-[#d1fae5] border border-[#a7f3d0] rounded-full px-[9px] py-[3px] text-xs font-bold text-[#065f46] leading-4 whitespace-nowrap">
                                {{ $persenPeminjam > 0 ? '+' : '' }}{{ $persenPeminjam }}% vs bulan lalu
                            </span>
                        @else
                            <span class="bg-[#f1f5f9] border border-[#e2e8f0] rounded-full px-[9px] py-[3px] text-xs font-bold text-[#64748b] leading-4 whitespace-nowrap">
                                Belum ada data bulan lalu
                            </span>
                        @endif
                    </div>
                </div>


                {{-- KPI 2: Rata-rata Waktu Reservasi --}}
                <div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] p-[21px] min-w-0">

                    {{-- Header KPI --}}
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-[#708993] leading-5">
                            Rata-rata Waktu Reservasi
                        </p>

                        <div class="bg-[#fef3c7] rounded-xl p-2.5 flex items-center justify-center shrink-0">
                            <svg class="size-4 text-[#b45309]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>


                    {{-- Nilai + perbandingan --}}
                    <div class="mt-[26px] flex items-center gap-2 flex-nowrap">

                        <p class="flex items-end tracking-[-0.75px] shrink-0">
                            <span class="font-extrabold text-[30px] text-[#19183b] leading-9">
                                {{ number_format($rataRataWaktuReservasi, 1, ',', '.') }}
                            </span>

                            <span class="font-bold text-[18px] text-[#708993] leading-7 ml-1">
                                jam
                            </span>
                        </p>


                        @if (!$adaDataBulanLalu)

                            <span class="shrink-0 translate-y-1.5 bg-[#f1f5f9] border border-[#e2e8f0] rounded-full px-2 py-1 text-[10px] font-bold text-[#64748b] leading-3 whitespace-nowrap">
                                Belum ada data bulan lalu
                            </span>

                        @elseif ($selisihWaktuReservasi > 0)

                            <span class="bg-[#f1f5f9] border border-[#e2e8f0] rounded-full px-[9px] py-[3px] text-xs font-bold text-[#64748b] leading-4 whitespace-nowrap">
                                +{{ $selisihWaktuReservasi }} menit vs bulan lalu
                            </span>

                        @elseif ($selisihWaktuReservasi < 0)

                            <span class="bg-[#f1f5f9] border border-[#e2e8f0] rounded-full px-[9px] py-[3px] text-xs font-bold text-[#64748b] leading-4 whitespace-nowrap">
                                {{ $selisihWaktuReservasi }} menit vs bulan lalu
                            </span>

                        @else

                            <span class="bg-[#f1f5f9] border border-[#e2e8f0] rounded-full px-[9px] py-[3px] text-xs font-bold text-[#64748b] leading-4 whitespace-nowrap">
                                Sama dengan bulan lalu
                            </span>

                        @endif

                    </div>

                </div>


                {{-- KPI 3: Total Reservasi --}}
                <div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] p-[21px] min-w-0">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-[#708993] leading-5">
                            Total Reservasi
                        </p>

                        <div class="bg-[#eef4f3] rounded-xl p-2.5 flex items-center justify-center shrink-0">
                            <svg class="size-5 text-[#19183b]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-[26px] flex flex-wrap items-end gap-2">
                        <p class="font-extrabold text-[30px] tracking-[-0.75px] text-[#19183b] leading-9">
                            {{ $totalReservasi }}
                        </p>

                        @if ($persenReservasi !== null)
                            <span class="bg-[#d1fae5] border border-[#a7f3d0] rounded-full px-[9px] py-[3px] text-xs font-bold text-[#065f46] leading-4 whitespace-nowrap">
                                {{ $persenReservasi > 0 ? '+' : '' }}{{ $persenReservasi }}% vs bulan lalu
                            </span>
                        @else
                            <span class="bg-[#f1f5f9] border border-[#e2e8f0] rounded-full px-[9px] py-[3px] text-xs font-bold text-[#64748b] leading-4 whitespace-nowrap">
                                Belum ada data bulan lalu
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Content grid: 2 columns --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">

                {{-- Left column (span 2) --}}
                <div class="xl:col-span-2 flex flex-col gap-6">

                    {{-- Incoming Reservations --}}
                    <div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] overflow-hidden">
                        <div class="border-b border-[#e2ebe9] flex items-center justify-between px-6 py-4">
                            <div class="flex items-center gap-2.5">
                                <span class="bg-[#d97706] rounded-full size-2.5"></span>
                                <h2 class="font-bold text-base text-[#19183b] leading-6">Incoming Reservations</h2>
                                <span class="bg-[#eef4f3] rounded-full px-2 py-0.5 text-xs font-semibold text-[#708993] leading-4 whitespace-nowrap">
                                    {{ $totalIncomingReservations }} permohonan
                                </span>
                            </div>
                            <a href="{{ route('petugas.reservasi.index') }}"
                               class="flex items-center gap-1 text-xs font-bold text-[#19183b] leading-4 whitespace-nowrap">
                                Lihat Semua
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[720px] text-left">
                                <thead class="bg-[rgba(238,244,243,0.6)] border-b border-[#e2ebe9]">
                                    <tr>
                                        <th class="px-4 py-3 text-[11px] font-bold uppercase tracking-[0.55px] text-[#708993]">ID</th>
                                        <th class="px-4 py-3 text-[11px] font-bold uppercase tracking-[0.55px] text-[#708993]">Nama</th>
                                        <th class="px-4 py-3 text-[11px] font-bold uppercase tracking-[0.55px] text-[#708993]">Fasilitas</th>
                                        <th class="px-4 py-3 text-[11px] font-bold uppercase tracking-[0.55px] text-[#708993]">Tanggal</th>
                                        <th class="px-4 py-3 text-[11px] font-bold uppercase tracking-[0.55px] text-[#708993]">Waktu</th>
                                        <th class="px-4 py-3 text-[11px] font-bold uppercase tracking-[0.55px] text-[#708993]">Status</th>
                                        <th class="px-4 py-3 text-[11px] font-bold uppercase tracking-[0.55px] text-[#708993] text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[rgba(226,235,233,0.7)]">
                                    @forelse (($incomingReservations ?? []) as $reservation)
                                        <tr>
                                            <td class="px-4 py-5 text-sm font-bold text-[#19183b] whitespace-nowrap">{{ $reservation->reservation_code }}</td>
                                            <td class="px-4 py-5">
                                                <div class="flex items-center gap-2">
                                                    <span class="bg-[#eef4f3] border border-[#bacdc9] rounded-full size-7 flex items-center justify-center text-xs font-bold text-[#19183b]">
                                                        {{ strtoupper(substr($reservation->user->name, 0, 1)) }}
                                                    </span>
                                                    <span class="text-sm font-semibold text-[#19183b] whitespace-nowrap">{{ $reservation->user->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-5 text-sm font-medium text-[#708993] whitespace-nowrap">{{ $reservation->details->pluck('facility.name')->join(', ') }}</td>
                                            <td class="px-4 py-5 text-xs font-medium text-[#708993] whitespace-nowrap">{{ $reservation->start_time->format('d-m-Y') }}</td>
                                            <td class="px-4 py-5 text-xs font-semibold text-[#19183b] whitespace-nowrap"> {{ $reservation->start_time->format('H.i') }} - {{ $reservation->end_time->format('H.i') }}</td>
                                            <td class="px-4 py-5">
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
                                            <td colspan="7" class="px-4 py-8 text-center text-sm text-[#708993]">
                                                Tidak ada reservasi yang menunggu.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- This Month Summary --}}
                    @php
                        $statusStyles = [
                            'menunggu' => [
                                'bg' => 'bg-[rgba(254,243,199,0.8)]',
                                'border' => 'border-[#fde68a]',
                                'label' => 'text-[#92400e]',
                                'value' => 'text-[#78350f]',
                                'desc' => 'text-[#b45309]',
                            ],

                            'disetujui' => [
                                'bg' => 'bg-[rgba(209,250,229,0.8)]',
                                'border' => 'border-[#a7f3d0]',
                                'label' => 'text-[#065f46]',
                                'value' => 'text-[#064e3b]',
                                'desc' => 'text-[#047857]',
                            ],

                            'dibatalkan_ditolak' => [
                                'bg' => 'bg-[rgba(255,228,230,0.8)]',
                                'border' => 'border-[#fecdd3]',
                                'label' => 'text-[#9f1239]',
                                'value' => 'text-[#881337]',
                                'desc' => 'text-[#be123c]',
                            ],

                            'selesai' => [
                                'bg' => 'bg-[rgba(186,230,253,0.8)]',
                                'border' => 'border-[#bae6fd]',
                                'label' => 'text-[#0ea5e9]',
                                'value' => 'text-[#0369a1]',
                                'desc' => 'text-[#1c83b1]',
                            ],
                        ];
                    @endphp

                    <div class="bg-white border border-[#e2ebe9] rounded-2xl drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] p-[25px]">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-5">
                            <div class="bg-[#eef4f3] rounded-lg p-2 flex items-center justify-center">
                                <svg class="size-4 text-[#19183b]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                            </div>
                            <h2 class="font-bold text-base text-[#19183b] leading-6">This Month</h2>
                            <p class="text-xs font-medium text-[#708993] leading-4">
                                {{ $monthSummarySubtitle ?? 'Ringkasan status aplikasi periode berjalan' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

                            @foreach ($statusSummary as $status)

                                @php
                                    $style = $statusStyles[$status['key']];
                                @endphp

                                <div class="{{ $style['bg'] }}
                                            border
                                            {{ $style['border'] }}
                                            rounded-xl
                                            px-[17px]
                                            pb-[17px]
                                            flex
                                            flex-col
                                            items-center
                                            gap-0.5
                                            text-center
                                            {{ $status['key'] === 'dibatalkan_ditolak'
                                                ? 'pt-[15px]'
                                                : 'pt-[22.5px]' }}">

                                    <p class="text-xs font-bold uppercase tracking-[0.3px] leading-4 {{ $style['label'] }}">

                                        @if ($status['key'] === 'dibatalkan_ditolak')
                                            DIBATALKAN/<br>DITOLAK
                                        @else
                                            {{ $status['label'] }}
                                        @endif

                                    </p>

                                    <p class="font-extrabold text-[30px] leading-9 pt-2 {{ $style['value'] }}">
                                        {{ $status['value'] }}
                                    </p>

                                    <p class="text-[11px] {{ $style['desc'] }}">
                                        {{ $status['desc'] }}
                                    </p>

                                </div>

                            @endforeach

                        </div>      
                    </div>
                </div>

                {{-- Right column --}}
                <div class="flex flex-col gap-6">

                    {{-- Monthly Mini Calendar --}}
                    <div class="bg-white border border-[#e2ebe9] rounded-2xl drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] p-[21px]">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-bold text-base text-[#19183b] leading-6">
                                {{ $calendarMonthLabel ?? 'April 2026' }}
                            </h3>
                            <div class="flex items-center gap-1">
                                <a href="{{ route('petugas.reservasi.dashboard', ['month' => $previousMonth]) }}"
                                class="rounded-lg p-1.5 hover:bg-[#eef4f3] transition">
                                    <svg class="size-4 text-[#708993]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15.75 19.5L8.25 12l7.5-7.5" />
                                    </svg>
                                </a>
                                <a href="{{ route('petugas.reservasi.dashboard', ['month' => $nextMonth]) }}"
                                class="rounded-lg p-1.5 hover:bg-[#eef4f3] transition">

                                    <svg class="size-4 text-[#708993]"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>

                                </a>
                            </div>
                        </div>

                        <div class="grid grid-cols-7 pt-2 gap-x-1">
                            @foreach (['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $dayName)
                                <p class="text-[10px] sm:text-xs font-bold text-[#708993] text-center">{{ $dayName }}</p>
                            @endforeach
                        </div>

                        {{-- $calendarWeeks: array of weeks, each a list of days:
                             ['number' => 13, 'muted' => false, 'active' => true, 'dots' => ['disetujui','menunggu']] --}}
                        @php
                            $dotColors = [
                                'disetujui' => 'bg-[#10b981]',
                                'menunggu' => 'bg-[#f59e0b]',
                                'ditolak' => 'bg-[#f43f5e]',
                            ];
                        @endphp

                        <div class="grid grid-cols-7 gap-y-2 gap-x-1 pb-2">
                            @foreach ($calendarWeeks as $week)
                                @foreach ($week as $day)
                                    <div class="flex flex-col items-center justify-center gap-1 py-1.5 min-h-[40px]">
                                        @if (!empty($day['active']))
                                            <span class="bg-[#19183b] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-full size-7 flex items-center justify-center text-xs font-bold text-white">
                                                {{ $day['n'] }}
                                            </span>
                                        @else
                                            <span class="text-xs font-medium {{ !empty($day['muted']) ? 'text-[#cbd5e1]' : 'text-[#334155]' }}">
                                                {{ $day['n'] }}
                                            </span>
                                        @endif

                                        @if (!empty($day['dots']))
                                            <div class="flex items-center gap-0.5">
                                                @foreach ($day['dots'] as $dot)
                                                    <span class="size-1 rounded-full {{ $dotColors[$dot] ?? 'bg-[#708993]' }}"></span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endforeach
                        </div>

                        <div class="border-t border-[#e2ebe9] flex items-center justify-center gap-4 pt-[13px]">
                            <div class="flex items-center gap-1.5">
                                <span class="bg-[#10b981] rounded-full size-2"></span>
                                <span class="text-[10px] font-semibold text-[#708993]">Disetujui</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="bg-[#f59e0b] rounded-full size-2"></span>
                                <span class="text-[10px] font-semibold text-[#708993]">Menunggu</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="bg-[#f43f5e] rounded-full size-2"></span>
                                <span class="text-[10px] font-semibold text-[#708993]">Ditolak/Dibatalkan</span>
                            </div>
                        </div>
                    </div>

                    {{-- Daily Schedule --}}
                    <div class="flex flex-col gap-3">
                        <div class="bg-gradient-to-r from-[#19183b] to-[#2e2c58] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl flex items-center justify-between pl-4 pr-4 py-4">
                            <div class="flex items-center gap-2.5">
                                <span class="bg-[#a1c2bd] rounded-full size-2.5"></span>
                                <div>
                                    <h3 class="text-sm font-bold text-white leading-5">
                                        {{ $scheduleDateLabel }}
                                    </h3>
                                    <p class="text-[11px] font-normal text-[#a1c2bd] leading-4">
                                        {{ $todaySchedule->count() }} Reservasi terjadwal hari ini
                                    </p>
                                </div>
                            </div>
                            <a href="{{ Route::has('petugas.jadwal.index') ? route('petugas.jadwal.index') : '#' }}"
                               class="bg-white/10 rounded-lg p-1.5">
                                <svg class="size-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </div>
                        @forelse ($todaySchedule as $reservation)
                            <div class="bg-white border border-[#e2ebe9] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl p-[17px] flex flex-col gap-3">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span class="bg-[#eef4f3] border border-[#bacdc9] rounded-md px-[11px] py-[5px] text-xs font-bold text-[#19183b]">
                                        {{ $reservation->start_time->format('H.i') }}
                                        -
                                        {{ $reservation->end_time->format('H.i') }}
                                    </span>
                                    <x-petugas.status-badge :status="$reservation->status" />
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-[#19183b] leading-5">
                                        {{ $reservation->details->pluck('facility.name')->join(', ') }}
                                    </h4>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="size-3.5 text-[#708993]"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                        <span class="text-xs font-medium text-[#708993]">
                                            {{ $reservation->user->name }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white border border-[#e2ebe9] rounded-2xl p-5 text-center">
                                <p class="text-sm font-medium text-[#708993]">
                                    Tidak ada reservasi yang disetujui hari ini.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
@endsection
