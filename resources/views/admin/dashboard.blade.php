@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Route;

    $firstRoute = function (array $names) {
        foreach ($names as $name) {
            if (Route::has($name)) return route($name);
        }
        return '#';
    };

    $urlDashboard = $firstRoute(['admin.dashboard', 'admin']);
    $urlFasilitas = $firstRoute(['admin.fasilitas.index', 'admin.fasilitas', 'fasilitas.index']);
    $urlPengguna  = $firstRoute(['admin.pengguna.index', 'admin.pengguna', 'admin.users.index', 'admin.users']);
    $urlLaporan   = $firstRoute(['admin.rekap', 'admin.laporan.index', 'admin.laporan']);

    $totalFasilitas   = $totalFasilitas   ?? 7;
    $fasilitasAktif   = $fasilitasAktif   ?? 0;
    $menungguVerif    = $menungguVerif    ?? 5;
    $laporanKerusakan = $laporanKerusakan ?? 3;

    $penggunaMenunggu = $penggunaMenunggu ?? collect([
        (object) ['name' => 'Pengguna 1', 'email' => 'pengguna@email.com'],
    ]);
@endphp

@section('content')

{{-- Grid Statistik --}}
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    @foreach ([
        ['label'=>'Total Fasilitas',      'val'=>$totalFasilitas,   'sub'=>'Kelola fasilitas →',          'href'=>$urlFasilitas, 'color'=>'text-brand-primary', 'icon'=>'🏢'],
        ['label'=>'Fasilitas Aktif',      'val'=>$fasilitasAktif,   'sub'=>'Fasilitas dapat digunakan',   'href'=>null,          'color'=>'text-green-600',     'icon'=>'✓'],
        ['label'=>'Menunggu Verifikasi',  'val'=>$menungguVerif,    'sub'=>'Periksa pengguna →',          'href'=>$urlPengguna,  'color'=>'text-amber-600',     'icon'=>'👤'],
        ['label'=>'Laporan Kerusakan',    'val'=>$laporanKerusakan, 'sub'=>'Lihat laporan →',             'href'=>$urlLaporan,   'color'=>'text-red-500',       'icon'=>'🔧'],
    ] as $s)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex justify-between items-start">
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold">{{ $s['label'] }}</p>
            <p class="text-3xl font-bold mt-1 mb-3 {{ $s['color'] }}">{{ $s['val'] }}</p>
            @if($s['href'])
                <a href="{{ $s['href'] }}" class="text-xs {{ $s['color'] }} font-medium">{{ $s['sub'] }}</a>
            @else
                <span class="text-xs {{ $s['color'] }} font-medium">{{ $s['sub'] }}</span>
            @endif
        </div>
        <div class="text-2xl opacity-60">{{ $s['icon'] }}</div>
    </div>
    @endforeach
</div>

{{-- Aksi Cepat --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
    <h2 class="font-semibold text-base mb-4">Aksi Cepat</h2>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        @foreach ([
            ['href'=>$urlFasilitas, 'title'=>'+ Kelola Fasilitas',    'sub'=>'Tambah, ubah, atau nonaktifkan fasilitas.'],
            ['href'=>$urlPengguna,  'title'=>'✓ Verifikasi Pengguna', 'sub'=>'Periksa pengguna yang menunggu verifikasi.'],
            ['href'=>$urlLaporan,   'title'=>'📊 Lihat Rekap',        'sub'=>'Lihat penggunaan dan kerusakan fasilitas.'],
        ] as $q)
        <a href="{{ $q['href'] }}" class="border border-gray-200 rounded-xl p-4 hover:border-brand-primary hover:bg-brand-neutral transition block">
            <p class="font-semibold text-sm text-brand-primary">{{ $q['title'] }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $q['sub'] }}</p>
        </a>
        @endforeach
    </div>
</div>

{{-- Tabel Pengguna Menunggu --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
    <div class="flex justify-between items-start mb-5">
        <div>
            <h2 class="font-semibold text-base">Pengguna Menunggu Verifikasi</h2>
            <p class="text-xs text-gray-400 mt-0.5">Pengguna yang perlu diperiksa oleh admin.</p>
        </div>
        <span class="bg-amber-50 text-amber-600 text-xs font-semibold px-3 py-1.5 rounded-full">{{ $menungguVerif }} pengguna</span>
    </div>

    @if($penggunaMenunggu->count())
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-xs text-gray-400 uppercase tracking-wide border-b border-gray-100">
                    <th class="pb-3 text-left font-semibold">Nama</th>
                    <th class="pb-3 text-left font-semibold">Email</th>
                    <th class="pb-3 text-left font-semibold">Status</th>
                    <th class="pb-3 text-right font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penggunaMenunggu as $u)
                <tr class="border-b border-gray-50 last:border-0">
                    <td class="py-3.5 font-semibold text-brand-primary">{{ $u->name }}</td>
                    <td class="py-3.5 text-gray-400">{{ $u->email }}</td>
                    <td class="py-3.5"><span class="bg-amber-50 text-amber-600 text-xs font-semibold px-2.5 py-1 rounded-full">Menunggu</span></td>
                    <td class="py-3.5 text-right">
                        <a href="{{ $urlPengguna }}" class="bg-brand-primary text-white text-xs font-bold px-4 py-2 rounded-lg hover:opacity-90 transition">Periksa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p class="text-sm text-gray-400">Tidak ada pengguna yang menunggu verifikasi.</p>
    @endif
</div>

@endsection