@extends('layouts.petugas')

@section('content')
    <div class="px-8 py-8">

        {{-- ==================== TOP BAR: HEADER & CONTROLS ==================== --}}
        <div class="flex items-start justify-between gap-6 flex-wrap mb-6">
            <div class="max-w-[480px]">
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="font-bold text-2xl tracking-[-0.6px] text-[#19183b] leading-8">
                        {{ $pageTitle ?? 'Jadwal Reservasi' }}
                    </h1>
                    <span
                        class="bg-[#ecfdf5] border border-[rgba(167,243,208,0.6)] rounded-full px-[11px] py-[3px] flex items-center gap-1.5">
                        <span class="bg-[#059669] rounded-full size-1.5"></span>
                        <span class="text-xs font-semibold text-[#065f46] leading-4 whitespace-nowrap">
                            {{ $activePeriod ?? 'Semester Genap 2026' }}
                        </span>
                    </span>
                </div>
                <p class="text-sm font-normal text-[#64748b] leading-5 pt-1">
                    {{ $pageSubtitle ?? 'Pantau ketersediaan dan jadwal penggunaan fasilitas kampus mingguan secara real-time.' }}
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap justify-end">
                {{-- Week navigation --}}
                <div
                    class="bg-white border border-[rgba(226,232,240,0.8)] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-xl p-[5px] flex items-center gap-1 shrink-0">
                    <button type="button"
                        class="bg-[#f1f5f9] rounded-lg px-3.5 py-1.5 text-xs font-semibold text-[#19183b] whitespace-nowrap">
                        Minggu Ini
                    </button>
                    <div class="flex items-center pl-1">
                        <a href="{{ url()->current() }}?week=prev"
                            class="size-7 flex items-center justify-center rounded-lg" aria-label="Minggu sebelumnya">
                            <svg class="size-3 text-[#334155]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.5L8.25 12l6.75-7.5" />
                            </svg>
                        </a>
                        <span class="flex items-center gap-1.5 px-3 text-xs font-medium text-[#334155] whitespace-nowrap">
                            <svg class="size-3 text-[#334155]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            {{ $weekRangeLabel ?? '7 – 13 September 2026' }}
                        </span>
                        <a href="{{ url()->current() }}?week=next"
                            class="size-7 flex items-center justify-center rounded-lg" aria-label="Minggu berikutnya">
                            <svg class="size-3 text-[#334155]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Semua Tipe --}}
                <div class="relative shrink-0">
                    <span class="absolute left-[15px] top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg class="size-3.5 text-[#1e293b]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                    </span>
                    <select
                        class="w-[180px] appearance-none bg-white border border-[rgba(226,232,240,0.8)] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-xl pl-9 pr-8 py-[9px] text-xs font-medium text-[#1e293b] focus:outline-none">
                        @php
                            $facilityTypes = $facilityTypes ?? [
                                'Semua Tipe',
                                'Ruangan',
                                'Laboratorium',
                                'Area Olahraga',
                                'Peralatan',
                                'Fasilitas Umum',
                            ];
                        @endphp
                        @foreach ($facilityTypes as $type)
                            <option>{{ $type }}</option>
                        @endforeach
                    </select>
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg class="size-2.5 text-[#334155]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </span>
                </div>

                {{-- Semua Fasilitas --}}
                <div class="relative shrink-0">
                    <span class="absolute left-[15px] top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg class="size-3.5 text-[#1e293b]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                    </span>
                    <select
                        class="w-[220px] appearance-none bg-white border border-[rgba(226,232,240,0.8)] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-xl pl-9 pr-8 py-[9px] text-xs font-medium text-[#1e293b] focus:outline-none">
                        @php

                            $facilities = $facilities ?? [
                                'Semua Fasilitas',
                                'Ruang A101 (Auditorium)',
                                'Laboratorium Komputer 1',
                                'Lapangan Futsal Indoor',
                                'Gedung Serbaguna',
                            ];
                        @endphp
                        @foreach ($facilities as $facility)
                            <option>{{ $facility }}</option>
                        @endforeach
                    </select>
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg class="size-2.5 text-[#334155]" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>

        {{-- Calendar --}}
        <div class="flex items-center justify-start gap-x-6 gap-y-3 mb-4 text-xs font-medium text-[#475569] flex-wrap">

            <div class="flex items-center gap-2 whitespace-nowrap">
                <span class="size-3 rounded-full bg-[#6366F1]"></span>
                Ruangan
            </div>

            <div class="flex items-center gap-2 whitespace-nowrap">
                <span class="size-3 rounded-full bg-[#10B981]"></span>
                Laboratorium
            </div>

            <div class="flex items-center gap-2 whitespace-nowrap">
                <span class="size-3 rounded-full bg-[#F43F5E]"></span>
                Area Olahraga
            </div>

            <div class="flex items-center gap-2 whitespace-nowrap">
                <span class="size-3 rounded-full bg-[#3B82F6]"></span>
                Gedung/Auditorium
            </div>

            <div class="flex items-center gap-2 whitespace-nowrap">
                <span class="size-3 rounded-full bg-[#F59E0B]"></span>
                Peralatan
            </div>

            <div class="flex items-center gap-2 whitespace-nowrap">
                <span class="size-3 rounded-full bg-[#64748B]"></span>
                Fasilitas Umum
            </div>
        </div>

        {{-- ==================== WEEKLY TIME-GRID CALENDAR ==================== --}}
        @php
            $weekDays = $weekDays ?? [
                ['index' => 0, 'name' => 'Senin', 'date_label' => '7 Sep', 'is_today' => false],
                ['index' => 1, 'name' => 'Selasa', 'date_label' => '8 Sep', 'is_today' => false],
                ['index' => 2, 'name' => 'Rabu', 'date_label' => '9 Sep', 'is_today' => true],
                ['index' => 3, 'name' => 'Kamis', 'date_label' => '10 Sep', 'is_today' => false],
                ['index' => 4, 'name' => 'Jumat', 'date_label' => '11 Sep', 'is_today' => false],
                ['index' => 5, 'name' => 'Sabtu', 'date_label' => '12 Sep', 'is_today' => false],
                ['index' => 6, 'name' => 'Minggu', 'date_label' => '13 Sep', 'is_today' => false],
            ];

            $timeSlots = [];
            $slotHeight = 42;
            $startMinutes = 7 * 60;
            for ($i = 0; $i < 27; $i++) {
                $minutes = $startMinutes + $i * 30;
                $hour = intdiv($minutes, 60);
                $minute = $minutes % 60;
                $timeSlots[] = [
                    'label' => sprintf('%02d:%02d', $hour, $minute),
                    'is_hour' => $minute === 0,
                    'is_lunch' => $hour === 12,
                ];
            }

            $scheduleByDay = $scheduleByDay ?? [
                0 => [
                    [
                        'facility' => 'Laboratorium Komputer 1',
                        'type' => 'Laboratorium',
                        'start' => '07.30',
                        'end' => '09.30',
                        'borrower' => 'Andi Pratama',
                    ],
                    [
                        'facility' => 'Gedung Serbaguna',
                        'type' => 'Gedung/Auditorium',
                        'start' => '13.30',
                        'end' => '16.00',
                        'borrower' => 'Kevin Sanjaya',
                    ],
                ],
                1 => [
                    [
                        'facility' => 'Ruang Rapat Senat',
                        'type' => 'Ruangan',
                        'start' => '09.00',
                        'end' => '11.30',
                        'borrower' => 'Dimas Arya Putra',
                    ],
                ],
                2 => [
                    [
                        'facility' => 'Auditorium A101',
                        'type' => 'Gedung/Auditorium',
                        'start' => '08.00',
                        'end' => '10.30',
                        'borrower' => 'Meichan Lestari',
                    ],
                    [
                        'facility' => 'Ruang Teater A102',
                        'type' => 'Ruangan',
                        'start' => '13.00',
                        'end' => '15.00',
                        'borrower' => 'Jimmy Gunawan',
                    ],
                ],
                3 => [
                    [
                        'facility' => 'Lab Bahasa Inggris',
                        'type' => 'Laboratorium',
                        'start' => '08.00',
                        'end' => '10.30',
                        'borrower' => 'Siti Nurhaliza',
                    ],
                    [
                        'facility' => 'Lapangan Futsal Indoor',
                        'type' => 'Area Olahraga',
                        'start' => '14.00',
                        'end' => '16.30',
                        'borrower' => 'Farhan Ramadhan',
                    ],
                ],
                4 => [
                    [
                        'facility' => 'Gedung Serbaguna Utama',
                        'type' => 'Gedung/Auditorium',
                        'start' => '09.00',
                        'end' => '13.00',
                        'borrower' => 'Aprilia Maharani',
                    ],
                    [
                        'facility' => 'Ruang Seminar MIPA',
                        'type' => 'Ruangan',
                        'start' => '14.00',
                        'end' => '16.00',
                        'borrower' => 'Dr. Hendra Pratama',
                    ],
                ],
                5 => [
                    [
                        'facility' => 'Proyektor Portable',
                        'type' => 'Peralatan',
                        'start' => '09.00',
                        'end' => '15.00',
                        'borrower' => 'BEM Universitas',
                    ],
                ],
                6 => [],
            ];

            $facilityColors = [
                'Ruangan' => [
                    'bg' => 'rgba(238,242,255,0.8)',
                    'border' => '#6366F1',
                    'time' => '#4338CA',
                ],

                'Laboratorium' => [
                    'bg' => 'rgba(236,253,245,0.8)',
                    'border' => '#10B981',
                    'time' => '#047857',
                ],

                'Area Olahraga' => [
                    'bg' => 'rgba(255,241,242,0.8)',
                    'border' => '#F43F5E',
                    'time' => '#BE123C',
                ],

                'Peralatan' => [
                    'bg' => 'rgba(255,247,237,0.8)',
                    'border' => '#F59E0B',
                    'time' => '#B45309',
                ],

                'Fasilitas Umum' => [
                    'bg' => 'rgba(241,245,249,0.8)',
                    'border' => '#64748B',
                    'time' => '#475569',
                ],

                'Gedung/Auditorium' => [
                    'bg' => 'rgba(239,246,255,0.8)',
                    'border' => '#3B82F6',
                    'time' => '#1D4ED8',
                ],
            ];

            $toSlotIndex = function (string $time) use ($startMinutes) {
                [$h, $m] = array_map('intval', explode('.', $time));
                return ($h * 60 + $m - $startMinutes) / 30;
            };
        @endphp

        <div
            class="bg-white border border-[rgba(226,232,240,0.8)] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-2xl p-[25px]">
            <div class="border border-[rgba(226,232,240,0.8)] rounded-xl overflow-hidden">

                {{-- Grid column headers: day names & dates --}}
                <div class="flex bg-white border-b border-[rgba(226,232,240,0.8)]">
                    <div class="w-[70px] shrink-0 border-r border-[#f1f5f9] flex items-center justify-center py-[23px]">
                        <span class="text-[11px] font-bold uppercase tracking-[0.55px] text-[#94a3b8]">Waktu</span>
                    </div>
                    @foreach ($weekDays as $day)
                        <div
                            class="flex-1 min-w-[130px]{{ !$loop->last ? 'border-r border-[#f1f5f9]' : '' }} flex items-center justify-center py-2.5 px-2.5">
                            @if ($day['is_today'])
                                <div
                                    class="bg-[#19183b] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] rounded-xl px-5 py-2.5 flex flex-col items-center gap-0.5 min-w-[120px]">
                                    <span class="flex items-center gap-2">
                                        <span
                                            class="text-[11px] font-semibold uppercase tracking-[0.5px] text-[#e2e8f0] whitespace-nowrap">{{ $day['name'] }}</span>
                                        <span class="bg-[#34d399] rounded-full size-2"></span>
                                    </span>
                                    <span
                                        class="text-lg font-bold text-white whitespace-nowrap">{{ $day['date_label'] }}</span>
                                </div>
                            @else
                                <div class="flex flex-col items-center gap-0.5">
                                    <span
                                        class="text-[11px] font-semibold uppercase tracking-[0.55px] text-[#94a3b8] whitespace-nowrap">{{ $day['name'] }}</span>
                                    <span
                                        class="text-sm font-bold text-[#1e293b] whitespace-nowrap">{{ $day['date_label'] }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Grid body: time gutter + 7 day columns --}}
                <div class="flex">
                    {{-- Time gutter --}}
                    <div class="w-[70px] shrink-0 border-r border-[rgba(226,232,240,0.7)]">
                        @foreach ($timeSlots as $slot)
                            <div
                                class="h-[42px] flex items-start justify-end px-2 pt-1.5 {{ $slot['is_lunch'] ? 'bg-[rgba(241,245,249,0.7)]' : '' }}">
                                @if ($slot['is_hour'])
                                    <span
                                        class="text-xs font-semibold text-[#64748b] leading-4">{{ $slot['label'] }}</span>
                                @else
                                    <span
                                        class="text-[11px] font-normal text-[#94a3b8] leading-[16.5px]">{{ $slot['label'] }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Day columns --}}
                    <div class="overflow-x-auto flex-1">
                        <div class="min-w-[1000px] flex">

                            @foreach ($weekDays as $day)
                                <div
                                    class="flex-1 min-w-[130px] relative {{ !$loop->last ? 'border-r border-[rgba(226,232,240,0.7)]' : '' }}">

                                    {{-- Background hour stripes --}}
                                    @foreach ($timeSlots as $slot)
                                        <div
                                            class="h-[42px] {{ $slot['is_lunch'] ? 'bg-[rgba(241,245,249,0.7)]' : '' }} border-b border-[rgba(241,245,249,0.7)] last:border-b-0">
                                        </div>
                                    @endforeach


                                    {{-- Reservation blocks --}}
                                    @foreach ($scheduleByDay[$day['index']] ?? [] as $item)
                                        @php
                                            $startSlot = $toSlotIndex($item['start']);
                                            $endSlot = $toSlotIndex($item['end']);

                                            $top = $startSlot * $slotHeight;
                                            $height = ($endSlot - $startSlot) * $slotHeight - 4;

                                            $color = $facilityColors[$item['type']] ?? $facilityColors['Ruangan'];
                                        @endphp


                                        <div class="absolute left-1.5 right-1.5 min-w-[110px] rounded-lg shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] border-l-4 px-3 pt-[11px] pb-3 flex flex-col justify-between overflow-hidden"
                                            style="
                            top: {{ $top }}px;
                            height: {{ $height }}px;
                            background-color: {{ $color['bg'] }};
                            border-color: {{ $color['border'] }};
                        ">

                                            <div>
                                                <p class="text-xs font-bold text-[#19183b] leading-[16.5px]">
                                                    {{ $item['facility'] }}
                                                </p>

                                                <p class="text-[11px] font-semibold leading-[16.5px] pt-[3px] whitespace-nowrap"
                                                    style="color: {{ $color['time'] }}">
                                                    {{ $item['start'] }} – {{ $item['end'] }}
                                                </p>
                                            </div>


                                            <p class="text-[11px] font-medium text-[#475569] leading-[16.5px] truncate">
                                                {{ $item['borrower'] }}
                                            </p>

                                        </div>
                                    @endforeach

                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
