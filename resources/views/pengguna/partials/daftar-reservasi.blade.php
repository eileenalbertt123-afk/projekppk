@forelse($filteredReservations as $reservation)
@php
$facility = $reservation->facility
?? ($reservation->details->first()->facility ?? null);

$statusColor = [
'menunggu' => 'bg-amber-50 text-amber-700 border-amber-200',
'disetujui' => 'bg-brand-tertiary/30 text-brand-primary border-brand-tertiary',
'ditolak' => 'bg-rose-50 text-rose-700 border-rose-200',
'dibatalkan' => 'bg-gray-100 text-gray-500 border-gray-200',
'selesai' => 'bg-blue-50 text-blue-700 border-blue-200',
][$reservation->status] ?? 'bg-gray-100 text-gray-500 border-gray-200';

$canCancel = in_array($reservation->status, ['menunggu', 'disetujui'])
&& now()->addHours(24)->lte($reservation->start_time);
@endphp

<div
    x-show="status === 'semua' || status === '{{ $reservation->status }}'"
    class="bg-white p-5 rounded-2xl border border-gray-200 shadow-card mb-4">

    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">
                {{ $reservation->reservation_code }}
            </p>

            <h4 class="font-bold text-brand-primary text-base mt-1">
                {{ $facility->name ?? 'Fasilitas tidak diketahui' }}
            </h4>

            <p class="text-sm text-brand-secondary mt-1">
                {{ $reservation->purpose }}
            </p>

            <p class="text-xs text-brand-secondary mt-2">
                📅 {{ \Carbon\Carbon::parse($reservation->start_time)->translatedFormat('d M Y, H:i') }}
                – {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }} WIB
            </p>

            <p class="text-xs text-brand-secondary mt-2">
                Dibuat:
                {{ \Carbon\Carbon::parse($reservation->created_at)->translatedFormat('d M Y, H:i') }}
            </p>

            <p class="text-xs text-brand-secondary mt-1">
                Jumlah peserta: {{ $reservation->participant_count }}
            </p>
        </div>

        <span class="text-xs font-bold px-3 py-1.5 rounded-full border whitespace-nowrap {{ $statusColor }}">
            {{ strtoupper($reservation->status) }}
        </span>
    </div>

    <div class="mt-4 flex items-center justify-between gap-4 flex-wrap">
        @if($canCancel)
        <form
            id="cancel-form-{{ $reservation->id }}"
            action="{{ route('reservations.cancel', $reservation) }}"
            method="POST">
            @csrf
            @method('PATCH')

            <button
                type="button"
                @click="$dispatch('open-cancel-modal', {
                                    formId: 'cancel-form-{{ $reservation->id }}',
                                    code: '{{ $reservation->reservation_code }}'
                                })"
                class="text-xs font-bold text-rose-600 border border-rose-200 hover:bg-rose-50 px-4 py-2 rounded-xl transition">
                Batalkan Reservasi
            </button>
        </form>
        @endif

        <a
            href="{{ route('reservations.detail', $reservation) }}"
            class="text-sm font-semibold text-brand-primary hover:text-brand-secondary ml-auto">
            Detail selengkapnya →
        </a>
    </div>
</div>
@empty
<div class="bg-white p-6 rounded-2xl border border-gray-200 text-sm text-brand-secondary">
    Belum ada riwayat reservasi.
</div>
@endforelse