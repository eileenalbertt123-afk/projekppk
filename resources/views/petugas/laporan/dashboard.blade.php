@extends('layouts.petugas')

@section('content')

<main class="px-8 py-8">

    {{-- ===========================
        TITLE SECTION
    ============================ --}}

    <div class="flex items-center justify-between mb-[56px]">

        <div>
            <h1 class="font-extrabold text-[30px] tracking-[-0.75px] text-[#19183b] leading-9">
                Laporan
            </h1>

            <p class="text-sm font-normal text-[#708993] leading-5">
                Manajemen & Pemantauan Perbaikan Fasilitas Kampus Terpadu
            </p>
        </div>


        <div class="bg-[#d1fae5] border border-[#a7f3d0] rounded-lg px-[13px] py-[7px] flex items-center gap-1.5">

            <span class="bg-[#059669] rounded-full size-2"></span>

            <span class="text-xs font-semibold text-[#065f46]">
                Semester Genap 2026
            </span>

        </div>

    </div>



    {{-- ===========================
        KPI CARDS
    ============================ --}}

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 mb-8">


        {{-- TOTAL LAPORAN --}}
        <div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-sm p-[21px]">

            <div class="flex justify-between items-center">

                <p class="text-sm font-semibold text-[#708993]">
                    Total Laporan
                </p>

                <div class="bg-[#eef4f3] rounded-xl size-9 flex items-center justify-center">

                    <svg
                        class="size-5 text-[#19183b]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 5.25H7.5A2.25 2.25 0 005.25 7.5v11.25A2.25 2.25 0 007.5 21h9a2.25 2.25 0 002.25-2.25V7.5a2.25 2.25 0 00-2.25-2.25H15M9 5.25a3 3 0 006 0M9 5.25a3 3 0 016 0M9.75 12h.008v.008H9.75V12zm0 3h.008v.008H9.75V15zm0 3h.008v.008H9.75V18zM12.75 12H15m-2.25 3H15m-2.25 3H15"
                        />
                    </svg>

                </div>

            </div>


            <div class="mt-[26px] flex items-center gap-2">

                <p class="font-extrabold text-[30px] text-[#19183b]">
                    {{ $totalLaporan ?? 0 }}
                </p>


                @if($laporanGrowth !== null)

                    <span class="bg-[#d1fae5] border border-[#a7f3d0]
                                 rounded-full px-3 py-1
                                 text-xs font-bold text-[#065f46]">

                        {{ $laporanGrowth > 0 ? '+' : '' }}
                        {{ $laporanGrowth }}%

                        vs bulan lalu

                    </span>

                @endif

            </div>

        </div>



        {{-- RATA RATA PERBAIKAN --}}
        <div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-sm p-[21px]">


            <div class="flex justify-between items-center">

                <p class="text-sm font-semibold text-[#708993]">
                    Rata-rata Waktu Perbaikan
                </p>


                <div class="bg-[#fef3c7] rounded-xl size-9 flex items-center justify-center">

                    <svg
                        class="size-5 text-[#b45309]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">
                        <circle
                            cx="12"
                            cy="12"
                            r="8.5"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 7.5V12l3 2"
                        />
                    </svg>
                </div>

            </div>


            <div class="mt-[26px] flex items-end gap-2">

                <span class="font-extrabold text-[30px] text-[#19183b]">
                    {{ number_format($rataRataPerbaikan ?? 0,1,',','.') }}
                </span>


                <span class="text-lg font-bold text-[#708993]">
                    jam
                </span>

            </div>

        </div>

        {{-- MENUNGGU VERIFIKASI --}}
        <div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-sm p-[21px]">


            <div class="flex justify-between items-center">

                <p class="text-sm font-semibold text-[#708993]">
                    Menunggu Verifikasi
                </p>


                <div class="bg-[#eff6ff] rounded-xl size-12 flex items-center justify-center">

                    <svg
                        class="size-5 text-[#2563eb]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6.75 7.5h10.5a2.25 2.25 0 012.25 2.25v8.25a2.25 2.25 0 01-2.25 2.25H6.75a2.25 2.25 0 01-2.25-2.25V9.75a2.25 2.25 0 012.25-2.25z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8.25 7.5V6a2.25 2.25 0 012.25-2.25h3a2.25 2.25 0 012.25 2.25v1.5"
                        />

                    </svg>

                </div>

            </div>


            <div class="mt-[26px] flex items-center gap-2">

                <span class="font-extrabold text-[30px] text-[#19183b]">
                    {{ $laporanBaruCount ?? 0 }}
                </span>


                <span class="bg-[#fee2e2]
                             rounded-full px-3 py-1
                             text-xs font-bold text-[#991b1b]">

                    Perlu aksi segera

                </span>

            </div>

        </div>

    </div>

    
    {{-- ===========================
        CONTENT GRID
    ============================ --}}

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">


        {{-- ===========================
            LEFT COLUMN
        ============================ --}}

        <div class="xl:col-span-2 flex flex-col gap-6">



            {{-- ===========================
                INCOMING REPORTS
            ============================ --}}

            <div class="bg-white border border-[#e2ebe9]
                        rounded-2xl shadow-sm overflow-hidden">


                {{-- Header --}}
                <div class="border-b border-[#e2ebe9]
                            flex items-center justify-between
                            px-6 py-4">


                    <div class="flex items-center gap-2.5">

                        <span class="bg-[#f97316] rounded-full size-2.5"></span>


                        <h2 class="font-bold text-base text-[#19183b]">
                            Incoming Reports
                        </h2>


                        <span class="bg-[#eef4f3]
                                    rounded-full px-2.5 py-1
                                    text-xs font-semibold text-[#708993]">

                            {{ $incomingReports->count() ?? 0 }}
                            laporan

                        </span>


                    </div>


                    <a href=""
                    class="text-xs font-bold text-[#19183b]">

                        Lihat Semua →
                        
                    </a>


                </div>



                {{-- Table --}}
                <table class="w-full table-fixed">


                    <thead class="bg-[#f8fafc] border-b border-[#e2ebe9]">

                        <tr>


                            <th class="w-[15%]
                                    px-6 py-3
                                    text-left text-[11px]
                                    uppercase tracking-wide
                                    text-[#708993]">

                                ID

                            </th>



                            <th class="w-[25%]
                                    px-6 py-3
                                    text-left text-[11px]
                                    uppercase tracking-wide
                                    text-[#708993]">

                                Pelapor

                            </th>



                            <th class="w-[28%]
                                    px-6 py-3
                                    text-left text-[11px]
                                    uppercase tracking-wide
                                    text-[#708993]">

                                Fasilitas

                            </th>



                            <th class="w-[20%]
                                    px-6 py-3
                                    text-left text-[11px]
                                    uppercase tracking-wide
                                    text-[#708993]">

                                Kategori

                            </th>



                            <th class="w-[17%]
                                    px-6 py-3
                                    text-left text-[11px]
                                    uppercase tracking-wide
                                    text-[#708993]">

                                Status

                            </th>


                        </tr>

                    </thead>



                    <tbody class="divide-y divide-[#e2ebe9]">


                    @forelse($incomingReports as $report)


                        @php

                            $categoryMap = [

                                'elektronik_av'
                                    => 'Elektronik & AV',

                                'struktur_bangunan'
                                    => 'Struktur & Bangunan',

                                'mekanikal_utilitas'
                                    => 'Mekanikal & Utilitas',

                                'furnitur'
                                    => 'Furnitur',

                                'jaringan_it'
                                    => 'Jaringan/IT',

                                'kebersihan'
                                    => 'Kebersihan',

                                'lainnya'
                                    => 'Lainnya',

                            ];

                        @endphp



                        <tr>


                            {{-- ID --}}
                            <td class="px-6 py-5">

                                <span class="text-sm font-bold text-[#19183b]">

                                    LP{{ str_pad(
                                        $report->id,
                                        3,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}

                                </span>

                            </td>



                            {{-- PELAPOR --}}
                            <td class="px-6 py-5">


                                <div class="flex items-center gap-3">


                                    <div
                                        class="size-9 rounded-full
                                            bg-[#eef4f3]
                                            flex items-center justify-center
                                            text-xs font-bold
                                            text-[#19183b]"
                                    >

                                        {{ strtoupper(
                                            substr(
                                                $report->user->name ?? '-',
                                                0,
                                                1
                                            )
                                        ) }}

                                    </div>


                                    <span class="text-sm font-semibold text-[#19183b]">

                                        {{ \Illuminate\Support\Str::title(
                                            $report->user->name ?? '-'
                                        ) }}

                                    </span>


                                </div>


                            </td>




                            {{-- FASILITAS --}}
                            <td class="px-6 py-5">


                                <span class="text-sm text-[#708993]">

                                    {{ $report->facility->name ?? '-' }}

                                </span>


                            </td>




                            {{-- KATEGORI --}}
                            <td class="px-6 py-5">


                                <span
                                    class="inline-flex
                                        bg-[#f1f5f9]
                                        border border-[#e2e8f0]
                                        rounded-lg
                                        px-3 py-1.5
                                        text-xs
                                        font-medium
                                        text-[#475569]"
                                >

                                    {{ $categoryMap[$report->category] ?? '-' }}

                                </span>


                            </td>




                            {{-- STATUS --}}
                            <td class="px-6 py-5">


                                <x-petugas.status-laporan-badge
                                    :status="$report->status"
                                />


                            </td>



                        </tr>


                    @empty


                        <tr>

                            <td colspan="5"
                                class="px-6 py-8 text-center text-sm text-[#708993]">

                                Belum ada laporan masuk.

                            </td>

                        </tr>


                    @endforelse


                    </tbody>


                </table>


            </div>




            {{-- ===========================
                THIS MONTH
            ============================ --}}

            <div class="bg-white border border-[#e2ebe9]
                        rounded-2xl shadow-sm p-6">


                <div class="flex items-center gap-3 mb-5">


                    <div class="bg-[#eef4f3] rounded-lg p-2">

                        <svg class="size-5 text-[#19183b]"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>

                        </svg>

                    </div>


                    <div>

                        <h2 class="font-bold text-base text-[#19183b]">
                            This Month
                        </h2>

                        <p class="text-xs text-[#708993]">
                            Ringkasan status laporan periode berjalan
                        </p>

                    </div>


                </div>
                <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
                    @foreach($statusSummary as $status)
                        @php

                            $colors = [

                                'baru'=>[
                                    'bg'=>'bg-[#fffbeb]',
                                    'border'=>'border-[#fde68a]',
                                    'text'=>'text-[#b45309]',
                                ],


                                'diproses'=>[
                                    'bg'=>'bg-[#f3e8ff]',
                                    'border'=>'border-[#ddd6fe]',
                                    'text'=>'text-[#6d28d9]',
                                ],


                                'ditolak'=>[
                                    'bg'=>'bg-[#fff1f2]',
                                    'border'=>'border-[#fecdd3]',
                                    'text'=>'text-[#be123c]',
                                ],


                                'selesai'=>[
                                    'bg'=>'bg-[#bae6fd]',
                                    'border'=>'border-[#7dd3fc]',
                                    'text'=>'text-[#0369a1]',
                                ],

                            ];


                            $style =
                            $colors[$status['key']]
                            ??
                            $colors['baru'];

                        @endphp
                        <div     class="{{ $style['bg'] }}
                        {{ $style['border'] }}
                        border
                        rounded-xl
                        p-5
                        text-center">

                            <p class="text-xs font-bold uppercase
                                      {{ $style['text'] }}">

                                {{ $status['label'] }}

                            </p>


                            <p class="text-3xl font-extrabold
                                      {{ $style['text'] }} mt-2">

                                {{ $status['value'] }}

                            </p>


                            <p class="text-xs text-[#708993] mt-1">

                                {{ $status['desc'] }}

                            </p>


                        </div>


                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-6">

            {{-- ============================= CARD 1 — DALAM PERBAIKAN ============================= --}}
            <div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-sm p-6">
                <div class="flex items-center justify-between gap-2 mb-1">
                    <div class="flex items-center gap-3">

                        <span
                            class="flex items-center justify-center
                                    w-14 h-12
                                    rounded-xl
                                    bg-[#fee2e2]"
                        >

                            <svg
                                class="size-5 text-[#dc2626]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v3m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"
                                />
                            </svg>

                        </span>


                        <h3 class="text-sm font-bold text-[#19183b]">
                            Dalam Perbaikan
                        </h3>

                    </div>
                    <span class="bg-[#fecdd3] text-[11px] font-bold text-[#be123c] px-[10px] py-[3px] rounded-full whitespace-nowrap">
                        {{ $facilitiesUnderRepair->count() }} Fasilitas
                    </span>
                </div>

                <p class="text-xs text-[#708993] leading-[18px] mb-4">
                    Fasilitas terkunci otomatis dari reservasi baru hingga perbaikan selesai.
                </p>

                <div class="flex flex-col gap-3">
                    @forelse ($facilitiesUnderRepair as $facility)
                        @php
                            $activeReport = $facility->activeReport ?? null;
                        @endphp
                        <div class="bg-white border border-[#e2ebe9] rounded-xl p-3">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <p class="text-sm font-bold text-[#19183b] leading-5">
                                    {{ $facility->name }}
                                </p>

                                {{-- No existing reusable badge covers the facility status "dalam_perbaikan" —
                                    see note below the code. Styled to match status-laporan-badge / status-badge. --}}
                                <span class="inline-flex items-center gap-[6px] bg-[#fef3c7] border border-[#fde68a] px-[11px] py-[5px] rounded-full shrink-0">
                                    <span class="size-[6px] rounded-full bg-[#f59e0b]"></span>
                                    <span class="text-[11px] font-semibold text-[#b45309] whitespace-nowrap">Dalam Perbaikan</span>
                                </span>
                            </div>

                            @if ($activeReport?->description)
                                <p class="text-xs text-[#708993] leading-[18px]">
                                    {{ $activeReport->description }}
                                    @if ($activeReport->code)
                                        <span class="text-[#708993]">({{ $activeReport->code }})</span>
                                    @endif
                                </p>
                            @endif

                            <div class="flex items-center gap-[6px] mt-1">
                                @if ($activeReport?->technician_name)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5 text-[#708993]" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6Zm-7 9a7 7 0 1114 0H3Z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs text-[#708993]">Teknisi: {{ $activeReport->technician_name }}</span>
                                @elseif ($activeReport?->vendor_name)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5 text-[#708993]" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 00-1 1v15a1 1 0 001 1h4v-3a1 1 0 011-1h2a1 1 0 011 1v3h4a1 1 0 001-1V8.414a1 1 0 00-.293-.707l-4.414-4.414A1 1 0 0011.586 3H12V2a1 1 0 00-1-1H4Zm2 4h2v2H6V6Zm4 0h2v2h-2V6Zm-4 4h2v2H6v-2Zm4 0h2v2h-2v-2Z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs text-[#708993]">Vendor: {{ $activeReport->vendor_name }}</span>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5 text-[#708993]" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6Zm-7 9a7 7 0 1114 0H3Z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs text-[#708993]">Teknisi belum ditentukan</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-[#708993] italic">Tidak ada fasilitas dalam perbaikan saat ini.</p>
                    @endforelse
                </div>
            </div>

            {{-- ============================= CARD 2 — SOP PETUGAS FASILITAS ============================= --}}

            <div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-sm p-5">
                {{-- Header --}}
                <div class="flex items-center gap-2 mb-3">

                    <span class="size-[6px] rounded-full bg-[#19183b]"></span>

                    <span class="text-[11px] font-bold uppercase tracking-wide text-[#19183b]">
                        SOP PETUGAS FASILITAS
                    </span>

                </div>



                {{-- Title --}}
                <h3 class="text-base font-bold text-[#19183b] leading-6 mb-2">
                    Protokol Verifikasi Laporan
                </h3>



                {{-- Description --}}
                <p class="text-xs text-[#708993] leading-[18px] mb-5">
                    Pastikan setiap permohonan laporan
                    ditangani sesuai alur operasional.
                </p>



                {{-- Steps --}}
                <ol class="flex flex-col gap-4 mb-6">


                    {{-- Step 1 --}}
                    <li class="flex items-start gap-3">

                        <span
                            class="flex items-center justify-center
                                shrink-0
                                size-7
                                rounded-full
                                border border-[#e2ebe9]
                                text-xs
                                font-semibold
                                text-[#19183b]"
                        >
                            1
                        </span>


                        <p class="text-xs text-[#708993] leading-[18px] pt-1">
                            Verifikasi keluhan fisik bersama pelapor / saksi.
                        </p>

                    </li>



                    {{-- Step 2 --}}
                    <li class="flex items-start gap-3">

                        <span
                            class="flex items-center justify-center
                                shrink-0
                                size-7
                                rounded-full
                                border border-[#e2ebe9]
                                text-xs
                                font-semibold
                                text-[#19183b]"
                        >
                            2
                        </span>


                        <p class="text-xs text-[#708993] leading-[18px] pt-1">
                            Ubah status ke
                            <span class="font-bold text-[#19183b]">
                                Diproses
                            </span>
                            saat teknisi lapangan ditugaskan.
                        </p>

                    </li>




                    {{-- Step 3 --}}
                    <li class="flex items-start gap-3">

                        <span
                            class="flex items-center justify-center
                                shrink-0
                                size-7
                                rounded-full
                                border border-[#e2ebe9]
                                text-xs
                                font-semibold
                                text-[#19183b]"
                        >
                            3
                        </span>


                        <p class="text-xs text-[#708993] leading-[18px] pt-1">

                            Tandai fasilitas
                            <span class="font-bold text-[#19183b]">
                                Dalam Perbaikan
                            </span>
                            agar terblokir dari reservasi.
                        </p>

                    </li>


                </ol>




                {{-- Button --}}
                <a
                    href=""
                    class="flex items-center justify-center gap-3
                        bg-[#19183b]
                        hover:bg-[#19183b]/90
                        transition-colors
                        text-white
                        text-xs
                        font-semibold
                        rounded-xl
                        px-4
                        py-3
                        w-full
                        whitespace-nowrap"
                >

                    <span> Buka Daftar Laporan Lengkap</span>
                    <svg
                        class="size-5 shrink-0"
                        fill="none"
                        viewBox="0 0 22 22"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 12h14M13 6l6 6-6 6"
                        />
                    </svg>
                </a>


            </div>

        </div>
@endsection