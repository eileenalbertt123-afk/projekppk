@props([
    'state' => 'waiting',
    'reportId' => null,

    'completionNote' => null,
    'rejectionReason' => null,

    'affectedReservations' => [],

    'action' => null,
    'method' => 'POST',

    'petugasName' => 'Petugas',

    'cancelUrl' => null,
    'rejectUrl' => null,
    'completeUrl' => null,
])

@php
    /*
    |--------------------------------------------------------------------------
    | BADGE CONFIG
    |--------------------------------------------------------------------------
    */

    $badge = match ($state) {

        'waiting', 'ready' => [
            'dot' => 'bg-[#f59e0b]',
            'bg' => 'bg-[#fffbeb]',
            'border' => 'border-[#fde68a]',
            'label' => 'Baru',
            'labelColor' => 'text-[#92400e]',
            'sub' => 'Menunggu verifikasi petugas',
            'subColor' => 'text-[#b45309]',
        ],

        'repair-pending',
        'repair-ready',
        'facility-conflict' => [
            'dot' => 'bg-[#7c3aed]',
            'bg' => 'bg-[#ede9fe]',
            'border' => 'border-[#ddd6fe]',
            'label' => 'Diproses',
            'labelColor' => 'text-[#4b21b6]',
            'sub' => 'Sedang diproses oleh petugas',
            'subColor' => 'text-[#7c3aed]',
        ],

        'completed' => [
            'dot' => 'bg-[#0ea5e9]',
            'bg' => 'bg-[#e0f2fe]',
            'border' => 'border-[#bae6fd]',
            'label' => 'Selesai',
            'labelColor' => 'text-[#0369a1]',
            'sub' => 'Laporan kerusakan telah selesai dan telah diperbaiki',
            'subColor' => 'text-[#0284c7]',
        ],

        'rejected' => [
            'dot' => 'bg-[#f43f5e]',
            'bg' => 'bg-[#fff1f2]',
            'border' => 'border-[#fecdd3]',
            'label' => 'Ditolak',
            'labelColor' => 'text-[#9f1239]',
            'sub' => 'Ditolak oleh petugas',
            'subColor' => 'text-[#be123c]',
        ],

        default => [
            'dot' => 'bg-slate-400',
            'bg' => 'bg-slate-50',
            'border' => 'border-slate-200',
            'label' => ucfirst($state),
            'labelColor' => 'text-slate-700',
            'sub' => '',
            'subColor' => 'text-slate-500',
        ],
    };

    $hideBadge = in_array($state, [
        'completion-form',
        'rejection-form',
    ]);

    $verificationPanelId =
        'report-verification-' . ($reportId ?? 'default');

    $repairPanelId =
        'report-repair-' . ($reportId ?? 'default');
@endphp


{{-- ============================================================
     OUTER CARD
============================================================ --}}
<div
    class="
        bg-white
        border-2 border-[#e0e7ff]
        flex flex-col gap-4
        p-[26px]
        relative
        rounded-[16px]
        shadow-[0px_4px_6px_-1px_rgba(0,0,0,0.1),0px_2px_4px_-2px_rgba(0,0,0,0.1)]
        w-full
        overflow-hidden
    "
>

    {{-- TOP ACCENT --}}
    <div
        class="
            absolute
            bg-[#19183b]
            h-[6px]
            left-0 right-0 top-0
        "
    ></div>


    {{-- ========================================================
         HEADER
    ========================================================= --}}
    <div class="border-b border-[#f1f5f9] pb-[17px] w-full">

        <div class="flex items-center gap-[10px]">

            <div
                class="
                    bg-[#19183b]
                    flex items-center justify-center
                    rounded-[8px]
                    w-[32px] h-[32px]
                    shrink-0
                "
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="white"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <rect x="2" y="3" width="20" height="14" rx="2"/>
                    <line x1="8" y1="21" x2="16" y2="21"/>
                    <line x1="12" y1="17" x2="12" y2="21"/>
                </svg>
            </div>

            <div>
                <p
                    class="
                        font-bold
                        text-[#19183b]
                        text-[16px]
                        leading-[24px]
                        m-0
                    "
                >
                    Panel Aksi Petugas
                </p>

                <p
                    class="
                        text-[#94a3b8]
                        text-[12px]
                        leading-[16px]
                        m-0
                    "
                >
                    Keputusan persetujuan &amp; verifikasi
                </p>
            </div>

        </div>

    </div>


    {{-- ========================================================
         BODY
    ========================================================= --}}
    <div class="flex flex-col gap-[15px] w-full">


        {{-- STATUS BADGE --}}
        @unless ($hideBadge)

            <div
                class="
                    {{ $badge['bg'] }}
                    border {{ $badge['border'] }}
                    flex items-center justify-between
                    p-[13px]
                    rounded-[12px]
                    w-full
                    gap-4
                "
            >

                <div class="flex items-center gap-[8px]">

                    <span
                        class="
                            {{ $badge['dot'] }}
                            rounded-full
                            w-[8px] h-[8px]
                            shrink-0
                        "
                    ></span>

                    <span
                        class="
                            font-bold
                            {{ $badge['labelColor'] }}
                            text-[12px]
                            leading-[16px]
                        "
                    >
                        {{ $badge['label'] }}
                    </span>

                </div>

                @if ($badge['sub'])

                    <span
                        class="
                            {{ $badge['subColor'] }}
                            text-[11px]
                            leading-[16px]
                            text-right
                        "
                    >
                        {{ $badge['sub'] }}
                    </span>

                @endif

            </div>

        @endunless



        {{-- ====================================================
             STATE 1 / 2
             WAITING / READY
        ===================================================== --}}
        @if (in_array($state, ['waiting', 'ready']))

            @php
                $verificationItems = [
                    'Informasi laporan sesuai dengan kondisi fasilitas',
                    'Bukti/foto kerusakan dapat diverifikasi',
                    'Laporan berkaitan dengan fasilitas yang dipilih',
                ];
            @endphp

            <div
                id="{{ $verificationPanelId }}"
                class="flex flex-col gap-[15px] w-full"
            >

                <div class="flex flex-col gap-[10px]">

                    <p
                        class="
                            font-bold
                            text-[#1e293b]
                            text-[12px]
                            tracking-[0.6px]
                            uppercase
                            m-0
                        "
                    >
                        Checklist Verifikasi
                    </p>

                    <div class="flex flex-col gap-[8px]">

                        @foreach ($verificationItems as $item)

                            <label
                                class="
                                    bg-[#f8fafc]
                                    border border-[#e2e8f0]
                                    flex items-center gap-[10px]
                                    min-h-[50px]
                                    px-[10px]
                                    rounded-[8px]
                                    cursor-pointer
                                "
                            >

                                <input
                                    type="checkbox"
                                    class="
                                        report-verification-checkbox
                                        w-[16px] h-[16px]
                                        accent-[#7c3aed]
                                        cursor-pointer
                                        shrink-0
                                    "
                                    @checked($state === 'ready')
                                >

                                <span
                                    class="
                                        text-[#181c1c]
                                        text-[12px]
                                        leading-[17px]
                                    "
                                >
                                    {{ $item }}
                                </span>

                            </label>

                        @endforeach

                    </div>

                </div>


                {{-- ACTION BUTTONS --}}
                <div class="flex gap-[12px] w-full">

                    {{-- PROSES LAPORAN --}}
                    @if ($action)

                        <form
                            method="POST"
                            action="{{ $action }}"
                            class="w-[48%]"
                            data-process-form
                        >
                            @csrf

                            <button
                                type="submit"
                                data-process-button
                                disabled
                                class="
                                    w-full
                                    min-h-[62px]
                                    flex items-center justify-center
                                    gap-[6px]
                                    rounded-[12px]
                                    font-bold
                                    text-[14px]
                                    transition-all

                                    disabled:bg-[#dfe3e2]
                                    disabled:text-[#78767f]
                                    disabled:opacity-60
                                    disabled:cursor-not-allowed

                                    enabled:bg-[#7c3aed]
                                    enabled:text-white
                                    enabled:cursor-pointer
                                    enabled:shadow-[0px_4px_7px_rgba(124,58,237,0.35)]
                                "
                            >
                                Proses Laporan
                            </button>
                        </form>

                    @else

                        <button
                            type="button"
                            data-process-button
                            disabled
                            class="
                                w-[48%]
                                min-h-[62px]
                                flex items-center justify-center
                                rounded-[12px]
                                font-bold
                                text-[14px]

                                bg-[#dfe3e2]
                                text-[#78767f]
                                opacity-60
                                cursor-not-allowed
                            "
                        >
                            Proses Laporan
                        </button>

                    @endif

                    {{-- TOLAK --}}
                    @if ($rejectUrl)

                        <a
                            href="{{ $rejectUrl }}"
                            class="
                                bg-white
                                border border-[#f43f5e]
                                text-[#be123c]
                                flex flex-1
                                items-center justify-center
                                min-h-[62px]
                                rounded-[12px]
                                font-bold
                                text-[14px]
                                no-underline
                                hover:bg-[#fff1f2]
                                transition-all
                                cursor-pointer
                            "
                        >
                            Tolak
                        </a>

                    @else

                        <button
                            type="button"
                            disabled
                            class="
                                bg-white
                                border border-[#f43f5e]
                                text-[#be123c]
                                flex flex-1
                                items-center justify-center
                                min-h-[62px]
                                rounded-[12px]
                                font-bold
                                text-[14px]
                                opacity-40
                                cursor-not-allowed
                            "
                        >
                            Tolak
                        </button>

                    @endif

                </div>

                <p
                    data-verification-hint
                    class="
                        italic
                        text-[#708993]
                        text-[11px]
                        leading-[18px]
                        m-0
                    "
                >
                    Lengkapi seluruh checklist verifikasi fisik untuk membuka tindakan operasional ini.
                </p>

            </div>


            <script>
                document.addEventListener('DOMContentLoaded', function () {

                    const panel = document.getElementById(
                        @json($verificationPanelId)
                    );

                    if (!panel) return;

                    const checkboxes = panel.querySelectorAll(
                        '.report-verification-checkbox'
                    );

                    const processButton = panel.querySelector(
                        '[data-process-button]'
                    );

                    const hint = panel.querySelector(
                        '[data-verification-hint]'
                    );

                    function updateState() {

                        const allChecked =
                            checkboxes.length > 0 &&
                            [...checkboxes].every(
                                checkbox => checkbox.checked
                            );

                        // HANYA PROSES LAPORAN YANG TERGANTUNG CHECKLIST
                        if (processButton) {

                            if (processButton.tagName === 'BUTTON') {

                                processButton.disabled = !allChecked;

                            } else {

                                processButton.classList.toggle(
                                    'opacity-40',
                                    !allChecked
                                );

                                processButton.classList.toggle(
                                    'pointer-events-none',
                                    !allChecked
                                );
                            }
                        }

                        if (hint) {

                            hint.textContent = allChecked
                                ? 'Seluruh checklist verifikasi telah terpenuhi. Laporan siap diproses.'
                                : 'Lengkapi seluruh checklist verifikasi untuk mengaktifkan Proses Laporan.';
                        }
                    }

                    checkboxes.forEach(function (checkbox) {

                        checkbox.addEventListener(
                            'change',
                            updateState
                        );

                    });

                    updateState();
                });
            </script>



        {{-- ====================================================
             STATE 3 / 4 / 5 / 6
             REPAIR
        ===================================================== --}}
        @elseif (in_array(
            $state,
            [
                'repair-pending',
                'repair-ready',
                'facility-conflict'
            ]
        ))

            {{-- FACILITY CONFLICT --}}
            @if ($state === 'facility-conflict')

                <div
                    class="
                        bg-[#fef7e6]
                        border border-[#f6d992]
                        flex flex-col gap-[8px]
                        p-[13px]
                        rounded-[12px]
                        w-full
                    "
                >

                    <p
                        class="
                            font-bold
                            text-[#8d5b06]
                            text-[12px]
                            m-0
                        "
                    >
                        Reservasi Mendatang Terdampak
                    </p>

                    <p
                        class="
                            text-[#708993]
                            text-[11px]
                            leading-[17px]
                            m-0
                        "
                    >
                        Fasilitas memiliki reservasi yang telah disetujui
                        dan berpotensi terdampak oleh proses perbaikan.
                    </p>


                    @forelse ($affectedReservations as $reservation)

                        <div
                            class="
                                bg-white
                                border border-[#dfe8e6]
                                rounded-[8px]
                                p-[11px]
                            "
                        >

                            <div
                                class="
                                    flex items-center justify-between
                                    gap-3
                                "
                            >

                                <span
                                    class="
                                        font-bold
                                        text-[#19183b]
                                        text-[12px]
                                    "
                                >
                                    {{ $reservation['id'] ?? '-' }}
                                </span>

                                <span
                                    class="
                                        bg-[#e8f5ee]
                                        border border-[#a3d9be]
                                        text-[#1b6343]
                                        font-bold
                                        text-[10px]
                                        px-[9px]
                                        py-[3px]
                                        rounded-full
                                    "
                                >
                                    {{ $reservation['status'] ?? 'Approved' }}
                                </span>

                            </div>

                            <div
                                class="
                                    flex justify-between
                                    gap-3
                                    mt-1
                                "
                            >

                                <span
                                    class="
                                        text-[#708993]
                                        text-[11px]
                                    "
                                >
                                    {{ $reservation['date'] ?? '' }}
                                </span>

                                <span
                                    class="
                                        font-semibold
                                        text-[#19183b]
                                        text-[11px]
                                    "
                                >
                                    {{ $reservation['time'] ?? '' }}
                                </span>

                            </div>

                        </div>

                    @empty

                        <p
                            class="
                                text-[#708993]
                                text-[11px]
                                italic
                                m-0
                            "
                        >
                            Tidak ada reservasi terdampak.
                        </p>

                    @endforelse

                </div>

            @endif


            @php
                $repairItems = [
                    'Kondisi fasilitas sudah diperbaiki',
                    'Fasilitas sudah dapat digunakan kembali',
                ];
            @endphp

            <div
                id="{{ $repairPanelId }}"
                class="flex flex-col gap-[10px] w-full"
            >
                <p
                    class="
                        font-bold
                        text-[#1e293b]
                        text-[12px]
                        tracking-[0.6px]
                        uppercase
                        m-0
                    "
                >
                    Checklist Verifikasi
                </p>

                <div class="flex flex-col gap-[8px] w-full">

                    @foreach ($repairItems as $item)

                        <label
                            class="
                                bg-[#f8fafc]
                                border border-[#e2e8f0]
                                flex items-center gap-[10px]
                                min-h-[50px]
                                px-[10px]
                                rounded-[8px]
                                cursor-pointer
                            "
                        >

                            <input
                                type="checkbox"
                                class="
                                    repair-verification-checkbox
                                    w-[16px] h-[16px]
                                    accent-[#7c3aed]
                                    cursor-pointer
                                "
                            >

                            <span
                                class="
                                    font-medium
                                    text-[#181c1c]
                                    text-[12px]
                                    leading-[15px]
                                "
                            >
                                {{ $item }}
                            </span>

                        </label>

                    @endforeach

                </div>
            </div>


            {{-- SELESAIKAN LAPORAN --}}
            @if ($completeUrl)

                <a
                    href="{{ $completeUrl }}"
                    data-complete-button
                    class="
                        bg-[#dfe3e2]
                        border border-[#dfe8e6]
                        text-[#78767f]
                        opacity-60
                        pointer-events-none
                        cursor-not-allowed

                        flex items-center justify-center
                        min-h-[44px]
                        rounded-[12px]
                        font-bold
                        text-[12px]
                        w-full
                        no-underline
                        transition-all
                    "
                >
                    Selesaikan Laporan
                </a>

            @else

                <button
                    type="button"
                    data-complete-button
                    disabled
                    class="
                        bg-[#dfe3e2]
                        border border-[#dfe8e6]
                        text-[#78767f]
                        opacity-60
                        cursor-not-allowed

                        min-h-[44px]
                        rounded-[12px]
                        font-bold
                        text-[12px]
                        w-full
                    "
                >
                    Selesaikan Laporan
                </button>

            @endif


            <p
                data-repair-hint
                class="
                    font-normal
                    italic
                    text-[#708993]
                    text-[11px]
                    leading-[18px]
                    m-0
                "
            >
                Laporan hanya dapat diselesaikan setelah fasilitas diverifikasi tuntas dan siap digunakan kembali.
            </p>

            <script>
                document.addEventListener('DOMContentLoaded', function () {

                    const panel = document.getElementById(
                        @json($repairPanelId)
                    );

                    if (!panel) return;

                    const checkboxes = panel.querySelectorAll(
                        '.repair-verification-checkbox'
                    );

                    const completeButton = document.querySelector(
                        '[data-complete-button]'
                    );

                    const hint = document.querySelector(
                        '[data-repair-hint]'
                    );


                    function updateRepairState() {

                        const allChecked =
                            checkboxes.length > 0 &&
                            [...checkboxes].every(
                                checkbox => checkbox.checked
                            );


                        if (completeButton) {

                            if (completeButton.tagName === 'A') {

                                completeButton.classList.toggle(
                                    'pointer-events-none',
                                    !allChecked
                                );

                                completeButton.classList.toggle(
                                    'cursor-not-allowed',
                                    !allChecked
                                );

                                completeButton.classList.toggle(
                                    'opacity-60',
                                    !allChecked
                                );

                                completeButton.classList.toggle(
                                    'bg-[#dfe3e2]',
                                    !allChecked
                                );

                                completeButton.classList.toggle(
                                    'text-[#78767f]',
                                    !allChecked
                                );

                                completeButton.classList.toggle(
                                    'bg-[#0ea5e9]',
                                    allChecked
                                );

                                completeButton.classList.toggle(
                                    'text-white',
                                    allChecked
                                );

                                completeButton.classList.toggle(
                                    'cursor-pointer',
                                    allChecked
                                );

                            } else {

                                completeButton.disabled = !allChecked;
                            }
                        }


                        if (hint) {
                            hint.textContent = allChecked
                                ? 'Seluruh verifikasi perbaikan telah terpenuhi. Lanjutkan untuk mencatat penyelesaian laporan.'
                                : 'Laporan hanya dapat diselesaikan setelah fasilitas diverifikasi tuntas dan siap digunakan kembali.';
                        }
                    }


                    checkboxes.forEach(function (checkbox) {
                        checkbox.addEventListener(
                            'change',
                            updateRepairState
                        );
                    });


                    updateRepairState();

                });
            </script>


        {{-- ====================================================
             STATE 7
             COMPLETION FORM
        ===================================================== --}}
        @elseif ($state === 'completion-form')

            <p
                class="
                    font-bold
                    text-[#19183b]
                    text-[12px]
                    tracking-[0.6px]
                    uppercase
                    m-0
                "
            >
                Formulir Penyelesaian
            </p>


            @if ($action)

                <form
                    method="POST"
                    action="{{ $action }}"
                    class="w-full"
                >
                    @csrf

                    @if (strtoupper($method) !== 'POST')
                        @method($method)
                    @endif

            @endif


            <div
                class="
                    bg-[#f8fafc]
                    border border-[#e2e8f0]
                    flex flex-col gap-[12px]
                    p-[17px]
                    rounded-[12px]
                    w-full
                "
            >

                <div>

                    <label
                        for="completion_note"
                        class="
                            block
                            font-semibold
                            text-[#475569]
                            text-[11px]
                            uppercase
                            mb-1
                        "
                    >
                        Catatan Penyelesaian
                    </label>

                    <textarea
                        id="completion_note"
                        name="completion_note"
                        rows="4"
                        required
                        data-completion-note
                        placeholder="Tuliskan catatan penyelesaian untuk menyelesaikan laporan"
                        class="
                            bg-white
                            border border-[#cbd5e1]
                            text-[12px]
                            p-[11px]
                            rounded-[8px]
                            resize-none
                            w-full
                        "
                    >{{ old('completion_note') }}</textarea>

                </div>


                <div
                    class="
                        bg-[#fffbeb]
                        border border-[#fde68a]
                        p-[9px]
                        rounded-[6px]
                    "
                >
                    <p
                        class="
                            text-[#92400e]
                            text-[10px]
                            m-0
                        "
                    >
                        Tindakan dicatat atas nama
                        <strong>{{ $petugasName }}</strong>.
                    </p>
                </div>


                <button
                    type="{{ $action ? 'submit' : 'button' }}"
                    data-completion-submit
                    disabled
                    class="
                        bg-[#dfe3e2]
                        text-[#a1a1aa]
                        opacity-60
                        cursor-not-allowed
                        min-h-[44px]
                        rounded-[8px]
                        font-semibold
                        text-[14px]
                        w-full
                        transition-all
                    "
                >
                    Konfirmasi &amp; Selesaikan
                </button>

            </div>

        @if ($action)
            </form>
        @else
            <p class="text-sm text-slate-500">
                Formulir penyelesaian tidak tersedia.
            </p>
        @endif

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const note = document.querySelector('[data-completion-note]');
                    const button = document.querySelector('[data-completion-submit]');

                    if (!note || !button) return;

                    function updateCompletionButton() {
                        const valid = note.value.trim().length > 0;

                        button.disabled = !valid;
                        button.classList.toggle('opacity-60', !valid);
                        button.classList.toggle('cursor-not-allowed', !valid);
                        button.classList.toggle('bg-[#dfe3e2]', !valid);
                        button.classList.toggle('text-[#a1a1aa]', !valid);

                        button.classList.toggle('bg-[#0ea5e9]', valid);
                        button.classList.toggle('text-white', valid);
                        button.classList.toggle('shadow-[0px_1px_1px_rgba(0,0,0,0.05)]', valid);
                    }

                    note.addEventListener('input', updateCompletionButton);
                    updateCompletionButton();
                });
            </script>


        {{-- ====================================================
             STATE 8
             COMPLETED
        ===================================================== --}}
        @elseif ($state === 'completed')

            <div class="flex flex-col gap-[6px]">

                <p
                    class="
                        font-bold
                        text-[#19183b]
                        text-[11px]
                        uppercase
                        m-0
                    "
                >
                    Catatan Penyelesaian
                </p>

                <div
                    class="
                        bg-[#f4f8f7]
                        border border-[#dfe8e6]
                        p-[13px]
                        rounded-[8px]
                    "
                >
                    <p
                        class="
                            text-[#19183b]
                            text-[13px]
                            leading-[21px]
                            whitespace-pre-line
                            m-0
                        "
                    >
                        {{ $completionNote ?? '—' }}
                    </p>
                </div>

            </div>


            @if ($cancelUrl)

                <a href="{{ route('petugas.laporan.index') }}"
                class="
                    flex items-center justify-center
                    min-h-[44px]
                    rounded-[12px]
                    border border-[#cbd5e1]
                    bg-white
                    text-[#334155]
                    font-bold
                    text-[12px]
                    w-full
                    no-underline
                ">
                    Tutup
                </a>

            @endif

            <p class="font-normal text-[#708993] text-[11px] leading-[17.88px] w-full m-0">
                Laporan telah selesai dan diarsipkan secara permanen pada riwayat audit sistem sarpras.
            </p>


        {{-- ====================================================
             STATE 9
             REJECTION FORM
        ===================================================== --}}
        @elseif ($state === 'rejection-form')

            <p
                class="
                    font-bold
                    text-[#0f172a]
                    text-[12px]
                    uppercase
                    m-0
                "
            >
                Formulir Penolakan Petugas
            </p>


            @if ($action)

                <form
                    method="POST"
                    action="{{ $action }}"
                    class="w-full"
                >
                    @csrf

                    @if (strtoupper($method) !== 'POST')
                        @method($method)
                    @endif

            @endif


            <div
                class="
                    bg-[#f8fafc]
                    border border-[#e2e8f0]
                    flex flex-col gap-[12px]
                    p-[17px]
                    rounded-[12px]
                    w-full
                "
            >

                <div>

                    <label
                        for="rejection_category"
                        class="
                            block
                            font-semibold
                            text-[#475569]
                            text-[11px]
                            uppercase
                            mb-1
                        "
                    >
                        Kategori Alasan Penolakan
                    </label>

                    <select
                        id="rejection_category"
                        name="rejection_category"
                        required
                        data-rejection-category
                        class="
                            w-full
                            rounded-[8px]
                            border border-[#cbd5e1]
                            px-3 py-2
                            text-[12px]
                            bg-white
                        "
                    >

                        <option value="">
                            Pilih alasan penolakan
                        </option>

                        <option value="bukti_tidak_memadai">
                            Bukti kerusakan tidak memadai
                        </option>

                        <option value="laporan_tidak_valid">
                            Laporan tidak valid
                        </option>

                        <option value="duplikat_laporan">
                            Laporan duplikat
                        </option>

                        <option value="bukan_kerusakan_fasilitas">
                            Bukan kerusakan fasilitas
                        </option>

                        <option value="informasi_tidak_lengkap">
                            Informasi laporan tidak lengkap
                        </option>

                        <option value="fasilitas_tidak_sesuai">
                            Fasilitas yang dilaporkan tidak sesuai
                        </option>

                        <option value="lainnya">
                            Lainnya
                        </option>

                    </select>

                </div>


                <div>

                    <label
                        for="rejection_reason"
                        class="
                            block
                            font-semibold
                            text-[#475569]
                            text-[11px]
                            uppercase
                            mb-1
                        "
                    >
                        Alasan Terperinci
                    </label>

                    <textarea
                        id="rejection_reason"
                        name="rejection_reason"
                        rows="4"
                        required
                        data-rejection-reason
                        placeholder="Tuliskan alasan spesifik penolakan untuk arsip sistem..."
                        class="
                            bg-white
                            border border-[#cbd5e1]
                            text-[12px]
                            p-[11px]
                            rounded-[8px]
                            resize-none
                            w-full
                        "
                    >{{ old('rejection_reason') }}</textarea>

                </div>


                <div
                    class="
                        bg-[#fffbeb]
                        border border-[#fde68a]
                        p-[9px]
                        rounded-[6px]
                    "
                >
                    <p
                        class="
                            text-[#92400e]
                            text-[10px]
                            m-0
                        "
                    >
                        Tindakan dicatat atas nama
                        <strong>{{ $petugasName }}</strong>.
                    </p>
                </div>


                <div class="flex gap-[8px]">

                    <button
                        type="{{ $action ? 'submit' : 'button' }}"
                        data-rejection-submit
                        disabled
                        class="
                            bg-[#f1f5f9]
                            text-[#94a3b8]
                            opacity-60
                            cursor-not-allowed
                            flex-1
                            min-h-[44px]
                            rounded-[8px]
                            font-bold
                            text-[12px]
                            transition-all
                        "
                    >
                        Konfirmasi Penolakan
                    </button>


                    @if ($cancelUrl)

                        <a
                            href="{{ $cancelUrl }}"
                            class="
                                bg-white
                                border border-[#cbd5e1]
                                text-[#334155]
                                flex flex-1
                                items-center justify-center
                                min-h-[44px]
                                rounded-[8px]
                                font-bold
                                text-[12px]
                                no-underline
                            "
                        >
                            Batal
                        </a>

                    @endif

                </div>

            </div>

        @if ($action)
            </form>
        @else
            <p class="text-sm text-slate-500">
                Formulir penolakan tidak tersedia.
            </p>
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const category = document.querySelector('[data-rejection-category]');
                const reason = document.querySelector('[data-rejection-reason]');
                const button = document.querySelector('[data-rejection-submit]');

                if (!category || !reason || !button) return;

                function updateRejectionButton() {
                    const valid =
                        category.value.trim() !== '' &&
                        reason.value.trim() !== '';

                    button.disabled = !valid;
                    button.classList.toggle('opacity-60', !valid);
                    button.classList.toggle('cursor-not-allowed', !valid);
                    button.classList.toggle('bg-[#f1f5f9]', !valid);
                    button.classList.toggle('text-[#94a3b8]', !valid);
                    button.classList.toggle('bg-[#e11d48]', valid);
                    button.classList.toggle('text-white', valid);
                }

                category.addEventListener('change', updateRejectionButton);
                reason.addEventListener('input', updateRejectionButton);
                updateRejectionButton();
            });
        </script>

                    if (!category || !reason || !button) return;

                    function updateRejectionButton() {
                        const valid =
                            category.value.trim() !== '' &&
                            reason.value.trim() !== '';

                        button.disabled = !valid;
                        button.classList.toggle('opacity-60', !valid);
                        button.classList.toggle('cursor-not-allowed', !valid);
                        button.classList.toggle('bg-[#f1f5f9]', !valid);
                        button.classList.toggle('text-[#94a3b8]', !valid);

                        button.classList.toggle('bg-[#e11d48]', valid);
                        button.classList.toggle('text-white', valid);
                    }

                    category.addEventListener('change', updateRejectionButton);
                    reason.addEventListener('input', updateRejectionButton);
                    updateRejectionButton();
                });
            </script>


        {{-- ====================================================
             STATE 10
             REJECTED
        ===================================================== --}}
        @elseif ($state === 'rejected')

            <div
                class="
                    bg-[#fff1f2]
                    border border-[#fecdd3]
                    flex flex-col gap-[8px]
                    p-[17px]
                    rounded-[12px]
                    w-full
                "
            >

                <p
                    class="
                        font-bold
                        text-[#881337]
                        text-[12px]
                        uppercase
                        m-0
                    "
                >
                    Alasan Penolakan:
                </p>

                <p
                    class="
                        text-[#881337]
                        text-[12px]
                        leading-[19px]
                        whitespace-pre-line
                        m-0
                    "
                >
                    {{ $rejectionReason ?? '—' }}
                </p>

            </div>
            <a href="{{ route('petugas.laporan.index') }}"
                class="
                    flex items-center justify-center
                    min-h-[44px]
                    rounded-[12px]
                    border border-[#cbd5e1]
                    bg-white
                    text-[#334155]
                    font-bold
                    text-[12px]
                    w-full
                    no-underline
                ">
                    Tutup
            </a>
            <p
                class="
                    italic
                    text-[#708993]
                    text-[12px]
                    leading-[19px]
                    m-0
                "
            >
                Laporan tidak dapat diproses dan memerlukan pengajuan baru apabila ingin melakukan pelaporan kembali.
            </p>

        @endif


        {{-- BOTTOM DIVIDER --}}
        <div class="border-t border-[#f1f5f9] w-full pt-[5px]"></div>

    </div>

</div>