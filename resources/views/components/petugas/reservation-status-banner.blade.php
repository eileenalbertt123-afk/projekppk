@props([
    // One of: 'waiting', 'approved', 'cancellation_pending', 'cancelled', 'conflict', 'rejected'
    'status' => 'waiting',
    'title' => null,
    'description' => null,
    // Only used when status = 'conflict'
    'conflictCode' => null,
    'conflictDescription' => null,
    'conflictLink' => '#',
])
 
@php
    $defaults = [
        'waiting' => [
            'title' => null,
            'description' => 'Tidak ada konflik jadwal terdeteksi pada fasilitas dan slot waktu ini.',
            'bg' => 'bg-[#ecfdf5]',
            'border' => 'border-[#a7f3d0]',
            'iconBg' => 'bg-[#d1fae5]',
            'iconColor' => 'text-[#059669]',
            'titleColor' => 'text-[#065f46]',
            'descColor' => 'text-[#065f46]',
        ],
        'approved' => [
            'title' => 'Reservasi telah disetujui.',
            'description' => 'Reservasi aktif dan telah masuk ke jadwal fasilitas.',
            'bg' => 'bg-[#ecfdf5]',
            'border' => 'border-[#a7f3d0]',
            'iconBg' => 'bg-[#d1fae5]',
            'iconColor' => 'text-[#059669]',
            'titleColor' => 'text-[#047857]',
            'descColor' => 'text-[#047857]',
        ],
        'cancellation_pending' => [
            'title' => null,
            'description' => 'Reservasi ini telah disetujui dan akan berubah status setelah pembatalan dikonfirmasi.',
            'bg' => 'bg-[#ecfdf5]',
            'border' => 'border-[#a7f3d0]',
            'iconBg' => 'bg-[#d1fae5]',
            'iconColor' => 'text-[#059669]',
            'titleColor' => 'text-[#065f46]',
            'descColor' => 'text-[#065f46]',
        ],
        'cancelled' => [
            'title' => 'Reservasi telah dibatalkan.',
            'description' => 'Reservasi telah dibatalkan oleh petugas. Detail alasan tersimpan pada sistem.',
            'bg' => 'bg-[#fbcfe8]',
            'border' => 'border-[#f6aed7]',
            'iconBg' => 'bg-[#f675b5]',
            'iconColor' => 'text-white',
            'titleColor' => 'text-[#be185d]',
            'descColor' => 'text-[#be185d]',
        ],
        'conflict' => [
            'title' => 'Reservasi ini tidak dapat disetujui — bentrok jadwal',
            'description' => null,
            'bg' => 'bg-[#fff1f2]',
            'border' => 'border-[#e11d48]',
            'iconBg' => 'bg-[#ffe4e6]',
            'iconColor' => 'text-[#e11d48]',
            'titleColor' => 'text-[#881337]',
            'descColor' => 'text-[#be123c]',
        ],
        'rejected' => [
            'title' => 'Reservasi telah ditolak.',
            'description' => 'Pengajuan reservasi ditolak karena tidak memenuhi kriteria persetujuan reservasi.',
            'bg' => 'bg-[#f1f5f9]',
            'border' => 'border-[#64748b]',
            'iconBg' => 'bg-[#e2e8f0]',
            'iconColor' => 'text-[#475569]',
            'titleColor' => 'text-[#1e293b]',
            'descColor' => 'text-[#475569]',
        ],
    ];
 
    $key = $defaults[$status] ?? $defaults['waiting'];
    $resolvedTitle = $title ?? $key['title'];
    $resolvedDescription = $description ?? $key['description'];
    $resolvedConflictDescription = $conflictDescription
        ?? "Bentrok dengan #{$conflictCode}. Tolak reservasi ini agar pemohon dapat mengajukan slot lain.";
@endphp
 
<div
    {{ $attributes->merge([
        'class' => "flex items-center justify-between gap-4 {$key['bg']} border {$key['border']} rounded-xl p-[15px] w-full"
    ]) }}
>
    <div class="flex items-center gap-[10px]">
        <span class="flex items-center justify-center shrink-0 size-7 rounded-lg {{ $key['iconBg'] }} {{ $key['iconColor'] }}">
            @switch($status)
                @case('cancelled')
                @case('rejected')
                    {{-- x-circle --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16ZM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
                    </svg>
                    @break
                @case('conflict')
                    {{-- exclamation-triangle --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.198 0l6.928 12c1.155 2-.29 4.5-2.599 4.5H4.072c-2.31 0-3.753-2.5-2.598-4.5l6.927-12ZM10 8a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 8Zm0 8a1 1 0 100-2 1 1 0 000 2Z" clip-rule="evenodd" />
                    </svg>
                    @break
                @default
                    {{-- check-circle --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16Zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5Z" clip-rule="evenodd" />
                    </svg>
            @endswitch
        </span>
 
        <div class="flex flex-col">
            @if ($resolvedTitle)
                <p class="text-sm font-extrabold tracking-tight {{ $key['titleColor'] }} leading-5">
                    {{ $resolvedTitle }}
                </p>
            @endif
            @if ($status === 'conflict')
                <p class="text-xs {{ $key['descColor'] }} leading-[19.5px]">
                    {{ $resolvedConflictDescription }}
                </p>
            @elseif ($resolvedDescription)
                <p class="text-xs font-semibold {{ $key['descColor'] }} leading-[19.5px]">
                    {{ $resolvedDescription }}
                </p>
            @endif
        </div>
    </div>
 
    @if ($status === 'conflict')
        <a
            href="{{ $conflictLink }}"
            class="inline-flex items-center gap-[6px] bg-white border border-[#fda4af] rounded-xl px-[15px] py-[9px] shrink-0"
        >
            <span class="text-xs font-bold text-[#be123c] whitespace-nowrap">Lihat #{{ $conflictCode }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5 text-[#be123c]" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 011.06 0l4.25 4.25a.75.75 0 010 1.06l-4.25 4.25a.75.75 0 01-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 010-1.06Z" clip-rule="evenodd" />
            </svg>
        </a>
    @endif
</div>