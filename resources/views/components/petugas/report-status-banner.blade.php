@props([
    'type' => 'new',
    'title' => null,
    'description' => null,
])

@php
$config = match ($type) {

    'maintenance' => [
        'wrapperClass' => 'bg-[#ede9fe] border border-[#c4b5fd]',
        'iconBgClass' => 'bg-[#ddd6fe]',
        'titleColorClass' => 'text-[#4b21b6]',
        'descColorClass' => 'text-[#4b21b6]',
        'defaultTitle' => 'Fasilitas Dalam Perbaikan',
        'defaultDesc' => 'Fasilitas sedang dalam proses perbaikan dan sementara tidak tersedia untuk reservasi baru.',
        'icon' => '
            <svg xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                viewBox="0 0 24 24"
                fill="none"
                stroke="#4b21b6"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94z"/>
            </svg>
        ',
    ],


    'conflict' => [
        'wrapperClass' => 'bg-[#fff7ed] border border-[#fb923c]',
        'iconBgClass' => 'bg-[#ffedd5]',
        'titleColorClass' => 'text-[#ea580c]',
        'descColorClass' => 'text-[#ea580c]',
        'defaultTitle' => 'Reservasi Mendatang Berpotensi Terdampak',
        'defaultDesc' => 'Terdapat reservasi yang telah disetujui pada fasilitas ini.',
        'icon' => '',
    ],


    'resolved' => [
        'wrapperClass' => 'bg-[#bae6fd] border border-[#0ea5e9]',
        'iconBgClass' => 'bg-[#7dd3fc]',
        'titleColorClass' => 'text-[#0369a1]',
        'descColorClass' => 'text-[#0369a1]',
        'defaultTitle' => 'Laporan Selesai',
        'defaultDesc' => 'Penanganan laporan telah selesai dan fasilitas telah tersedia kembali.',
        'icon' => '',
    ],


    'rejected' => [
        'wrapperClass' => 'bg-[#fff1f2] border border-[#fb7185]',
        'iconBgClass' => 'bg-[#ffe4e6]',
        'titleColorClass' => 'text-[#9f1239]',
        'descColorClass' => 'text-[#9f1239]',
        'defaultTitle' => 'Laporan Ditolak',
        'defaultDesc' => 'Laporan telah ditolak oleh petugas.',
        'icon' => '',
    ],


    default => [
        'wrapperClass' => 'bg-[#fffbeb] border border-[#f59e0b]',
        'iconBgClass' => 'bg-[#fde68a]',
        'titleColorClass' => 'text-[#b45309]',
        'descColorClass' => 'text-[#b45309]',
        'defaultTitle' => 'Laporan Baru',
        'defaultDesc' => 'Laporan telah diterima dan menunggu proses penanganan oleh petugas.',
        'icon' => '
            <svg xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                viewBox="0 0 24 24"
                fill="none"
                stroke="#b45309"
                stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        ',
    ],
};

$title = $title ?? $config['defaultTitle'];
$description = $description ?? $config['defaultDesc'];

@endphp


<div class="w-full {{ $config['wrapperClass'] }} border-solid flex items-center justify-between p-[15px] rounded-[12px]">

    <div class="flex items-center gap-[10px]">

        <div class="{{ $config['iconBgClass'] }} flex items-center justify-center rounded-[8px] size-[28px]">
            {!! $config['icon'] !!}
        </div>


        <div class="flex flex-col">

            <span class="font-extrabold text-[14px] {{ $config['titleColorClass'] }}">
                {{ $title }}
            </span>

            <span class="text-[12px] {{ $config['descColorClass'] }}">
                {{ $description }}
            </span>

        </div>

    </div>


    {{ $slot }}

</div>