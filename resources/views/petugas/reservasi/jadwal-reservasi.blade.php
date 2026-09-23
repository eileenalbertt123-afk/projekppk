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
                    class="bg-white border border-[rgba(226,232,240,0.8)]
                        drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)]
                        rounded-xl p-[5px] flex items-center gap-1 shrink-0">

                    {{-- Tombol Minggu Ini --}}
                    <a
                        href="{{ route('petugas.reservasi.jadwal', array_filter([
                            'week' => now()->format('Y-m-d'),
                            'type' => $selectedType,
                            'facility' => $selectedFacility,
                        ])) }}"
                        class="bg-[#f1f5f9] rounded-lg px-3.5 py-1.5
                            text-xs font-semibold text-[#19183b]
                            whitespace-nowrap hover:bg-[#e2e8f0] transition"
                    >
                        Minggu Ini
                    </a>


                    <div class="flex items-center pl-1">

                        {{-- Minggu sebelumnya --}}
                        <a
                            href="{{ route('petugas.reservasi.jadwal', array_filter([
                                'week' => $previousWeek,
                                'type' => $selectedType,
                                'facility' => $selectedFacility,
                            ])) }}"
                            class="size-7 flex items-center justify-center rounded-lg
                                hover:bg-[#f1f5f9] transition"
                            aria-label="Minggu sebelumnya"
                        >
                            <svg
                                class="size-3 text-[#334155]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2.5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 19.5L8.25 12l6.75-7.5"
                                />
                            </svg>
                        </a>


                        {{-- Range minggu --}}
                        <span
                            class="flex items-center gap-1.5 px-3
                                text-xs font-medium text-[#334155]
                                whitespace-nowrap"
                        >

                            <svg
                                class="size-3 text-[#334155]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"
                                />
                            </svg>

                            {{ $weekStart->locale('id')->translatedFormat('d M') }}
                            –
                            {{ $weekEnd->locale('id')->translatedFormat('d M Y') }}

                        </span>


                        {{-- Minggu berikutnya --}}
                        <a
                            href="{{ route('petugas.reservasi.jadwal', array_filter([
                                'week' => $nextWeek,
                                'type' => $selectedType,
                                'facility' => $selectedFacility,
                            ])) }}"
                            class="size-7 flex items-center justify-center rounded-lg
                                hover:bg-[#f1f5f9] transition"
                            aria-label="Minggu berikutnya"
                        >
                            <svg
                                class="size-3 text-[#334155]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2.5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8.25 4.5l7.5 7.5-7.5 7.5"
                                />
                            </svg>
                        </a>

                    </div>

                </div>

                {{-- Tipe Fasilitas --}}
                <form
                    method="GET"
                    action="{{ route('petugas.reservasi.jadwal') }}"
                    class="shrink-0">
                    {{-- Pertahankan minggu aktif --}}
                    <input
                        type="hidden"
                        name="week"
                        value="{{ $weekStart->format('Y-m-d') }}"
                    >

                    <select
                        name="type"
                        onchange="this.form.submit()"
                        class="bg-white border border-[#e2e8f0]
                            rounded-xl px-4 py-2.5
                            text-xs font-semibold text-[#334155]
                            min-w-[160px]
                            focus:outline-none focus:ring-2 focus:ring-[#19183b]/10"
                    >
                        <option value="">
                            Semua Tipe
                        </option>

                        @foreach ($facilityTypes as $type)
                            <option
                                value="{{ $type }}"
                                @selected($selectedType === $type)
                            >
                                {{ ucwords(str_replace('_', ' ', $type)) }}
                            </option>
                        @endforeach
                    </select>
                </form>

                {{-- Pilih Fasilitas --}}
                <form
                    method="GET"
                    action="{{ route('petugas.reservasi.jadwal') }}"
                    class="shrink-0"
                >
                    {{-- Pertahankan minggu aktif --}}
                    <input
                        type="hidden"
                        name="week"
                        value="{{ $weekStart->format('Y-m-d') }}"
                    >

                    {{-- Pertahankan tipe yang sedang dipilih --}}
                    @if ($selectedType)
                        <input
                            type="hidden"
                            name="type"
                            value="{{ $selectedType }}"
                        >
                    @endif

                    <select
                        name="facility"
                        onchange="this.form.submit()"
                        class="bg-white border border-[#e2e8f0]
                            rounded-xl px-4 py-2.5
                            text-xs font-semibold text-[#334155]
                            min-w-[220px]
                            focus:outline-none focus:ring-2 focus:ring-[#19183b]/10"
                    >
                        <option value="">
                            Semua Fasilitas
                        </option>

                        @foreach ($facilities as $facility)
                            <option
                                value="{{ $facility->id }}"
                                @selected((string) $selectedFacility === (string) $facility->id)
                            >
                                {{ $facility->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
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
                Peralatan Presentasi
            </div>

            <div class="flex items-center gap-2 whitespace-nowrap">
                <span class="size-3 rounded-full bg-[#F59E0B]"></span>
                Audio Multimedia
            </div>

            <div class="flex items-center gap-2 whitespace-nowrap">
                <span class="size-3 rounded-full bg-[#64748B]"></span>
                Lainnya
            </div>
        </div>

        {{-- ==================== WEEKLY TIME-GRID CALENDAR ==================== --}}
        @php

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

            $facilityColors = [
                'ruangan' => [
                    'bg' => 'rgba(238,242,255,0.8)',
                    'border' => '#6366F1',
                    'time' => '#4338CA',
                ],

                'laboratorium' => [
                    'bg' => 'rgba(236,253,245,0.8)',
                    'border' => '#10B981',
                    'time' => '#047857',
                ],

                'area_olahraga' => [
                    'bg' => 'rgba(255,241,242,0.8)',
                    'border' => '#F43F5E',
                    'time' => '#BE123C',
                ],

                'peralatan_presentasi' => [
                    'bg' => 'rgba(255,247,237,0.8)',
                    'border' => '#F59E0B',
                    'time' => '#B45309',
                ],

                'audio_multimedia' => [
                    'bg' => 'rgba(241,245,249,0.8)',
                    'border' => '#64748B',
                    'time' => '#475569',
                ],
                'lainnya' => [
                    'bg' => 'rgba(241,245,249,0.8)',
                    'border' => '#64748B',
                    'time' => '#475569',
                ],
            ];

            $toSlotIndex = function (string $time) use ($startMinutes) {
                    [$h, $m] = array_map('intval', explode('.', $time));

                    return ($h * 60 + $m - $startMinutes) / 30;
            };
        @endphp

        <div class="border border-[rgba(226,232,240,0.8)] rounded-xl overflow-hidden">
            <div
                class="bg-white border border-[rgba(226,232,240,0.8)]
                    drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)]
                    rounded-2xl p-[25px]"
            >

                <div
                    class="border border-[rgba(226,232,240,0.8)]
                        rounded-xl overflow-hidden"
                >

                    {{-- Satu scroll container untuk HEADER + BODY --}}
                    <div class="overflow-x-auto">

                        <div class="min-w-[1000px]">

                            {{-- ================= HEADER ================= --}}
                            <div class="flex bg-white border-b border-[rgba(226,232,240,0.8)]">

                                {{-- Kolom Waktu --}}
                                <div
                                    class="w-[70px] shrink-0
                                        border-r border-[#f1f5f9]
                                        flex items-center justify-center
                                        py-[23px]"
                                >
                                    <span
                                        class="text-[11px] font-bold uppercase
                                            tracking-[0.55px] text-[#94a3b8]"
                                    >
                                        Waktu
                                    </span>
                                </div>

                                {{-- Hari --}}
                                <div class="flex flex-1">

                                    @foreach ($weekDays as $day)

                                        <div
                                            class="flex-1 min-w-[130px]
                                                {{ !$loop->last ? 'border-r border-[#f1f5f9]' : '' }}
                                                flex items-center justify-center
                                                py-2.5 px-2.5"
                                        >

                                            @if ($day['is_today'])

                                                <div
                                                    class="w-full mx-2
                                                        bg-[#19183b]
                                                        rounded-xl
                                                        px-3 py-2.5
                                                        flex flex-col items-center gap-0.5"
                                                >

                                                    <span class="flex items-center gap-2">

                                                        <span
                                                            class="text-[11px] font-semibold uppercase
                                                                tracking-[0.5px]
                                                                text-[#e2e8f0]
                                                                whitespace-nowrap"
                                                        >
                                                            {{ $day['name'] }}
                                                        </span>

                                                        <span class="bg-[#34d399] rounded-full size-2"></span>

                                                    </span>

                                                    <span
                                                        class="text-lg font-bold text-white whitespace-nowrap"
                                                    >
                                                        {{ $day['date_label'] }}
                                                    </span>

                                                </div>

                                            @else

                                                <div class="flex flex-col items-center gap-0.5">

                                                    <span
                                                        class="text-[11px] font-semibold uppercase
                                                            tracking-[0.55px]
                                                            text-[#94a3b8]
                                                            whitespace-nowrap"
                                                    >
                                                        {{ $day['name'] }}
                                                    </span>

                                                    <span
                                                        class="text-sm font-bold
                                                            text-[#1e293b]
                                                            whitespace-nowrap"
                                                    >
                                                        {{ $day['date_label'] }}
                                                    </span>

                                                </div>

                                            @endif

                                        </div>

                                    @endforeach

                                </div>

                            </div>


                            {{-- ================= BODY ================= --}}
                            <div class="flex">

                                {{-- TIME GUTTER --}}
                                <div
                                    class="w-[70px] shrink-0
                                        border-r border-[rgba(226,232,240,0.7)]"
                                >

                                    @foreach ($timeSlots as $slot)

                                        <div
                                            class="h-[42px]
                                                flex items-start justify-end
                                                px-2 pt-1.5
                                                {{ $slot['is_lunch']
                                                        ? 'bg-[rgba(241,245,249,0.7)]'
                                                        : ''
                                                }}"
                                        >

                                            @if ($slot['is_hour'])

                                                <span
                                                    class="text-xs font-semibold
                                                        text-[#64748b] leading-4"
                                                >
                                                    {{ $slot['label'] }}
                                                </span>

                                            @else

                                                <span
                                                    class="text-[11px]
                                                        font-normal
                                                        text-[#94a3b8]
                                                        leading-[16.5px]"
                                                >
                                                    {{ $slot['label'] }}
                                                </span>

                                            @endif

                                        </div>

                                    @endforeach

                                </div>


                                {{-- DAY COLUMNS --}}
                                <div class="flex flex-1">

                                    @foreach ($weekDays as $day)

                                        <div
                                            class="flex-1 min-w-[130px] relative
                                                {{ !$loop->last
                                                        ? 'border-r border-[rgba(226,232,240,0.7)]'
                                                        : ''
                                                }}"
                                        >

                                            {{-- Background rows --}}
                                            @foreach ($timeSlots as $slot)

                                                <div
                                                    class="h-[42px]
                                                        {{ $slot['is_lunch']
                                                                ? 'bg-[rgba(241,245,249,0.7)]'
                                                                : ''
                                                        }}
                                                        border-b
                                                        border-[rgba(241,245,249,0.7)]
                                                        last:border-b-0"
                                                ></div>

                                            @endforeach


                                            {{-- Reservation blocks --}}
                                            @foreach ($scheduleByDay[$day['index']] ?? [] as $item)

                                                @php
                                                    $startSlot = $toSlotIndex($item['start']);
                                                    $endSlot = $toSlotIndex($item['end']);

                                                    $top = $startSlot * $slotHeight;
                                                    $height = ($endSlot - $startSlot) * $slotHeight - 4;

                                                    $typeKey = strtolower(trim($item['type'] ?? ''));

                                                    $color = $facilityColors[$typeKey]
                                                        ?? $facilityColors['lainnya'];
                                                @endphp

                                                <div
                                                    class="absolute left-1.5 right-1.5
                                                        min-w-[110px]
                                                        rounded-lg
                                                        shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)]
                                                        border-l-4
                                                        px-3 pt-[11px] pb-3
                                                        flex flex-col justify-between
                                                        overflow-hidden"

                                                    style="
                                                        top: {{ $top }}px;
                                                        height: {{ $height }}px;
                                                        background-color: {{ $color['bg'] }};
                                                        border-color: {{ $color['border'] }};
                                                    "
                                                >

                                                    <div>

                                                        <p
                                                            class="text-xs font-bold
                                                                text-[#19183b]
                                                                leading-[16.5px]"
                                                        >
                                                            {{ $item['facility'] }}
                                                        </p>

                                                        <p
                                                            class="text-[11px]
                                                                font-semibold
                                                                leading-[16.5px]
                                                                pt-[3px]
                                                                whitespace-nowrap"

                                                            style="color: {{ $color['time'] }}"
                                                        >
                                                            {{ $item['start'] }}
                                                            –
                                                            {{ $item['end'] }}
                                                        </p>

                                                    </div>

                                                    <p
                                                        class="text-[11px]
                                                            font-medium
                                                            text-[#475569]
                                                            leading-[16.5px]
                                                            truncate"
                                                    >
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

        </div>
@endsection
