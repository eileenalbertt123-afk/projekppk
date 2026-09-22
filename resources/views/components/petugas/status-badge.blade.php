@props([
    // One of: 'menunggu', 'disetujui', 'dibatalkan', 'ditolak', 'selesai'
    'status' => 'menunggu',
])
 
@php
    $map = [
        'menunggu' => [
            'label' => 'Menunggu',
            'bg' => 'bg-[#fffbeb]',
            'border' => 'border-[#fde68a]',
            'text' => 'text-[#b45309]',
            'dot' => 'bg-[#f59e0b]',
        ],
        'disetujui' => [
            'label' => 'Disetujui',
            'bg' => 'bg-[#ecfdf5]',
            'border' => 'border-[#a7f3d0]',
            'text' => 'text-[#047857]',
            'dot' => 'bg-[#10b981]',
        ],
        'dibatalkan' => [
            'label' => 'Dibatalkan',
            'bg' => 'bg-[#fdf2f8]',
            'border' => 'border-[rgba(251,207,232,0.6)]',
            'text' => 'text-[#be185d]',
            'dot' => 'bg-[#ec4899]',
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
            'bg' => 'bg-[#bae6fd]',
            'border' => 'border-[rgba(14,165,233,0.6)]',
            'text' => 'text-[#0369a1]',
            'dot' => 'bg-[#0ea5e9]',
        ],
    ];
 
    $key = strtolower($status);
    $style = $map[$key] ?? $map['menunggu'];
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