@props([
    // tersedia | dalam_perbaikan | nonaktif
    'status' => 'tersedia',
])


@php

$map = [

    'tersedia' => [
        'label' => 'Tersedia',
        'bg' => 'bg-[#ecfdf5]',
        'border' => 'border-[rgba(167,243,208,0.6)]',
        'text' => 'text-[#047857]',
        'dot' => 'bg-[#10b981]',
    ],


    'dalam_perbaikan' => [
        'label' => 'Dalam Perbaikan',
        'bg' => 'bg-[#fffbeb]',
        'border' => 'border-[rgba(253,230,138,0.6)]',
        'text' => 'text-[#b45309]',
        'dot' => 'bg-[#f59e0b]',
    ],


    'nonaktif' => [
        'label' => 'Nonaktif',
        'bg' => 'bg-[#fff1f2]',
        'border' => 'border-[rgba(254,205,211,0.6)]',
        'text' => 'text-[#be123c]',
        'dot' => 'bg-[#f43f5e]',
    ],


];


$key = strtolower($status);

$style = $map[$key] ?? $map['tersedia'];

@endphp



<span
    {{ $attributes->merge([
        'class' =>
        "inline-flex items-center gap-[6px]
        {$style['bg']}
        border
        {$style['border']}
        rounded-full
        px-[11px]
        py-[5px]"
    ]) }}
>

    <span class="size-[6px] rounded-full {{ $style['dot'] }}">
    </span>


    <span class="text-[12px] font-semibold {{ $style['text'] }} whitespace-nowrap">

        {{ $style['label'] }}

    </span>

</span>