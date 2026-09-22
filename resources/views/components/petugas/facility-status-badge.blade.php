@props([
    'status' => null,
])

@php
    $styles = match ($status) {
        'tersedia' => [
            'wrapper' => 'bg-emerald-50 text-emerald-600',
            'dot' => 'bg-emerald-500',
            'label' => 'Tersedia',
        ],

        'dalam_perbaikan' => [
            'wrapper' => 'bg-amber-50 text-amber-600',
            'dot' => 'bg-amber-500',
            'label' => 'Dalam Perbaikan',
        ],

        'nonaktif' => [
            'wrapper' => 'bg-red-50 text-red-600',
            'dot' => 'bg-red-500',
            'label' => 'Nonaktif',
        ],

        default => [
            'wrapper' => 'bg-gray-100 text-gray-500',
            'dot' => 'bg-gray-400',
            'label' => ucfirst(str_replace('_', ' ', $status ?? '-')),
        ],
    };
@endphp

<span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-full {{ $styles['wrapper'] }}">
    <span class="w-1.5 h-1.5 rounded-full {{ $styles['dot'] }}"></span>
    {{ $styles['label'] }}
</span>