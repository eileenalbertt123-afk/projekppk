@props([
    'status' => 'baru',
])

@php
    $map = [
        'baru' => [
            'label' => 'Baru',
            'bg' => 'bg-[#fffbeb]',
            'border' => 'border-[#fde68a]',
            'text' => 'text-[#b45309]',
            'dot' => 'bg-[#f59e0b]',
        ],
        'diproses' => [
            'label' => 'Diproses',
            'bg' => 'bg-[#ede9fe]',
            'border' => 'border-[#ddd6fe]',
            'text' => 'text-[#5b21b6]',
            'dot' => 'bg-[#7c3aed]',
        ],
        'ditolak' => [
            'label' => 'Ditolak',
            'bg' => 'bg-[#fff1f2]',
            'border' => 'border-[rgba(254,205,211,0.6)]',
            'text' => 'text-[#be123c]',
            'dot' => 'bg-[#f43f5e]',
        ],
        'selesai' => [
            'label' => 'Selesai',
            'bg' => 'bg-[#e0f2fe]',
            'border' => 'border-[#7dd3fc]',
            'text' => 'text-[#0369a1]',
            'dot' => 'bg-[#0ea5e9]',
        ],
    ];

    $key = strtolower($status);
    $style = $map[$key] ?? $map['baru'];
@endphp

<span
    {{ $attributes->merge([
        'class' => "inline-flex items-center gap-[6px] {$style['bg']} border {$style['border']} px-[11px] py-[5px] rounded-full"
    ]) }}
>
    <span class="size-[6px] rounded-full {{ $style['dot'] }}"></span>
    <span class="text-[11px] font-semibold {{ $style['text'] }} whitespace-nowrap">
        {{ $style['label'] }}
    </span>
</span>