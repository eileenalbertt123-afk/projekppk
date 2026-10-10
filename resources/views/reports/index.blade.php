@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-brand-primary">Laporan Kerusakan Fasilitas</h1>
            <p class="text-sm text-brand-secondary mt-1">Pantau status laporan kendala atau kerusakan fasilitas yang Anda kirimkan.</p>
        </div>
        <a href="{{ route('reports.create') }}" class="bg-brand-primary hover:opacity-90 text-white font-bold px-4 py-2.5 rounded-xl text-xs transition shadow-card hover:shadow-card-hover">
            + Buat Laporan Baru
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-semibold">
        {{ session('success') }}
    </div>
    @endif

    <div class="space-y-4 bg-white rounded-3xl border border-gray-200/80 shadow-panel p-5 sm:p-8">
        @forelse($reports as $report)
        <div style="animation-delay: {{ min($loop->index, 8) * 80 }}ms" class="animate-fade-up bg-white rounded-2xl border border-gray-200 p-5 shadow-card flex flex-col md:flex-row justify-between gap-4">
            <div class="space-y-2 flex-1">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-brand-neutral text-brand-primary border border-gray-200">
                        {{ [
                                'elektronik_av' => 'Elektronik / AV',
                                'struktur_bangunan' => 'Struktur Bangunan',
                                'mekanikal_utilitas' => 'Mekanikal / Utilitas',
                                'furnitur' => 'Furnitur',
                                'jaringan_it' => 'Jaringan / IT',
                                'kebersihan' => 'Kebersihan',
                                'lainnya' => 'Lainnya',
                            ][$report->category] ?? $report->category }}
                    </span>
                    <h3 class="text-base font-bold text-brand-primary">{{ $report->facility->name ?? 'Fasilitas' }}</h3>
                </div>
                <p class="text-sm text-brand-secondary leading-relaxed">{{ \Illuminate\Support\Str::limit($report->description, 120) }}</p>
                <span class="text-[11px] text-gray-400 block">
                    Dilaporkan pada {{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('d F Y, H:i') }} WIB
                </span>
            </div>

            <div class="flex flex-col md:items-end justify-between shrink-0">
                @php
                $statusLabel = [
                'baru' => 'Baru',
                'diproses' => 'Diproses',
                'selesai' => 'Selesai',
                'ditolak' => 'Ditolak',
                ][$report->status] ?? $report->status;

                $statusColor = [
                'baru' => 'bg-amber-50 text-amber-600 border border-amber-200',
                'diproses' => 'bg-blue-50 text-blue-600 border border-blue-200',
                'selesai' => 'bg-emerald-50 text-emerald-600 border border-emerald-200',
                'ditolak' => 'bg-rose-50 text-rose-600 border border-rose-200',
                ][$report->status] ?? 'bg-gray-100 text-gray-500 border border-gray-200';
                @endphp
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $statusColor }}">
                    Status: {{ $statusLabel }}
                </span>

                <a href="{{ route('reports.show', $report) }}" class="mt-4 md:mt-0 text-xs font-bold text-brand-primary hover:underline">
                    Detail &rarr;
                </a>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center text-brand-secondary shadow-card">
            <p class="text-sm font-semibold">Belum ada laporan kerusakan yang dikirimkan.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection