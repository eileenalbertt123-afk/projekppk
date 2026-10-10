@forelse($reports as $report)
@php
$statusStyle = [
'baru' => 'bg-amber-50 text-amber-700 border-amber-200',
'menunggu' => 'bg-amber-50 text-amber-700 border-amber-200',
'diproses' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
'ditolak' => 'bg-rose-50 text-rose-700 border-rose-200',
][$report->status] ?? 'bg-gray-100 text-gray-600 border-gray-200';
@endphp

<article class="p-5 rounded-2xl border border-gray-200 shadow-card mb-4">
    <div class="flex items-start justify-between gap-4 flex-wrap">
        <div>
            <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">
                {{ $report->report_code ?? 'LP-' . $report->id }}
            </p>

            <h4 class="font-bold text-brand-primary text-base mt-1">
                {{ $report->category ?? 'Laporan Kerusakan' }}
            </h4>

            <p class="text-sm text-brand-secondary mt-1">
                Fasilitas: {{ $report->facility->name ?? 'Tidak diketahui' }}
            </p>
        </div>

        <span class="text-xs font-bold px-3 py-1.5 rounded-full border whitespace-nowrap {{ $statusStyle }}">
            {{ ucfirst($report->status ?? 'belum ada status') }}
        </span>
    </div>

    <p class="text-sm text-gray-700 mt-4 whitespace-pre-line">
        {{ $report->description }}
    </p>

    <div class="flex items-center justify-between gap-4 mt-4">
        <p class="text-xs text-brand-secondary">
            Dibuat: {{ $report->created_at?->translatedFormat('d M Y, H:i') ?? '-' }}
        </p>

        <a href="{{ route('reports.show', $report) }}" class="text-sm font-semibold text-brand-primary hover:text-brand-secondary whitespace-nowrap">
            Detail selengkapnya →
        </a>
    </div>

    @if($report->resolution_note)
    <div class="mt-4 p-4 rounded-xl bg-gray-50 border border-gray-200">
        <p class="text-xs font-bold text-brand-primary mb-1">
            Catatan Penyelesaian
        </p>
        <p class="text-sm text-gray-700 whitespace-pre-line">
            {{ $report->resolution_note }}
        </p>
    </div>
    @endif
</article>
@empty
<div class="p-6 rounded-2xl border border-gray-200 text-sm text-brand-secondary">
    Tidak ada laporan pada status ini.
</div>
@endforelse