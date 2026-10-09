@extends('layouts.app')

@section('content')

<div class="mb-8">
    <h2 class="text-brand-primary text-3xl font-extrabold tracking-tight">
        Riwayat Reservasi
    </h2>
    <p class="text-sm text-brand-secondary mt-1">
        Pantau status dan riwayat reservasi fasilitas kampus Anda.
    </p>
</div>

<div
    x-data="{
        status: '{{ request('status', 'semua') }}',
        urutan: '{{ request('urutan', 'terbaru') }}',

        async updateReservasi() {
            const params = new URLSearchParams({
                status: this.status,
                urutan: this.urutan,
                ajax: '1'
            });

            try {
                const response = await fetch(
                    '{{ route('riwayat.reservasi') }}?' + params.toString(),
                    {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }
                );

                if (!response.ok) {
                    alert('Gagal memuat daftar reservasi.');
                    return;
                }

               const html = await response.text();
               const daftarLama = document.getElementById('daftar-reservasi');

                if (!daftarLama) {
                    alert('Bagian daftar reservasi tidak ditemukan.');
                    return;
                }

                
                daftarLama.innerHTML = html;

                history.replaceState(
                    {},
                    '',
                    '{{ route('riwayat.reservasi') }}?' +
                    new URLSearchParams({
                        status: this.status,
                        urutan: this.urutan
                    }).toString()
                );
           } catch (error) {
                console.error('Error AJAX reservasi:', error);
                alert('Gagal memuat reservasi. Periksa Console (F12) untuk detail.');
            }
        }
    }">

    {{-- Ringkasan Reservasi --}}
    @php
    $jumlahDisetujui = $reservations->where('status', 'disetujui')->count();
    $jumlahSelesai = $reservations->where('status', 'selesai')->count();
    $jumlahDitolak = $reservations->where('status', 'ditolak')->count();
    $jumlahDibatalkan = $reservations->where('status', 'dibatalkan')->count();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">

        {{-- Reservasi Aktif --}}
        <div class="animate-fade-up bg-white p-5 rounded-2xl border border-gray-200 shadow-card flex items-center justify-between">
            <div>
                <span class="text-[10px] text-brand-secondary uppercase tracking-wider block">
                    Reservasi Aktif
                </span>
                <span class="font-bold text-brand-primary text-2xl mt-1 block">
                    {{ $activeReservations ?? 0 }}
                </span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-brand-neutral flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>

        {{-- Menunggu Validasi --}}
        <div class="animate-fade-up bg-white p-5 rounded-2xl border border-gray-200 shadow-card flex items-center justify-between">
            <div>
                <span class="text-[10px] text-brand-secondary uppercase tracking-wider block">
                    Menunggu Validasi
                </span>
                <span class="font-bold text-amber-600 text-2xl mt-1 block">
                    {{ $pendingReservations ?? 0 }}
                </span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        {{-- Disetujui --}}
        <div class="animate-fade-up bg-white p-5 rounded-2xl border border-gray-200 shadow-card flex items-center justify-between">
            <div>
                <span class="text-[10px] text-brand-secondary uppercase tracking-wider block">
                    Disetujui
                </span>
                <span class="font-bold text-emerald-600 text-2xl mt-1 block">
                    {{ $jumlahDisetujui }}
                </span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>

        {{-- Selesai --}}
        <div class="animate-fade-up bg-white p-5 rounded-2xl border border-gray-200 shadow-card flex items-center justify-between">
            <div>
                <span class="text-[10px] text-brand-secondary uppercase tracking-wider block">
                    Selesai
                </span>
                <span class="font-bold text-blue-600 text-2xl mt-1 block">
                    {{ $jumlahSelesai }}
                </span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5 2a8 8 0 11-16 0 8 8 0 0116 0z" />
                </svg>
            </div>
        </div>

        {{-- Ditolak --}}
        <div class="animate-fade-up bg-white p-5 rounded-2xl border border-gray-200 shadow-card flex items-center justify-between">
            <div>
                <span class="text-[10px] text-brand-secondary uppercase tracking-wider block">
                    Ditolak
                </span>
                <span class="font-bold text-rose-600 text-2xl mt-1 block">
                    {{ $jumlahDitolak }}
                </span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 6l12 12M18 6L6 18" />
                </svg>
            </div>
        </div>

        {{-- Dibatalkan --}}
        <div class="animate-fade-up bg-white p-5 rounded-2xl border border-gray-200 shadow-card flex items-center justify-between">
            <div>
                <span class="text-[10px] text-brand-secondary uppercase tracking-wider block">
                    Dibatalkan
                </span>
                <span class="font-bold text-gray-600 text-2xl mt-1 block">
                    {{ $jumlahDibatalkan }}
                </span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 6l12 12M18 6L6 18" />
                </svg>
            </div>
        </div>

    </div>


    @php
    $statusAktif = request('status', 'semua');

    $statusList = [
    'semua' => 'Semua',
    'menunggu' => 'Menunggu Validasi',
    'disetujui' => 'Disetujui',
    'selesai' => 'Selesai',
    'ditolak' => 'Ditolak',
    'dibatalkan' => 'Dibatalkan',
    ];
    @endphp

    {{-- Kotak Daftar Reservasi --}}
    <div class="bg-white rounded-3xl border border-gray-200 shadow-panel p-5 sm:p-8">

        <div class="flex flex-col gap-5 mb-6">
            {{-- Judul dan Urutan --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h3 class="font-bold text-lg text-brand-primary">
                    Daftar Reservasi
                </h3>


                <div class="flex items-center gap-3">
                    <label for="urutan" class="text-sm font-semibold text-brand-primary">
                        Urutkan:
                    </label>

                    <select
                        id="urutan"
                        x-model="urutan"
                        @change="updateReservasi()"
                        class="border border-gray-300 rounded-xl px-3 py-2 text-sm bg-white">
                        <option value="terbaru">Terbaru</option>
                        <option value="terlama">Terlama</option>
                    </select>
                </div>
            </div>


            {{-- Filter Status --}}
            <div class="flex flex-wrap gap-2">
                @foreach($statusList as $key => $label)
                <button
                    type="button"
                    @click="status = '{{ $key }}'; updateReservasi()"
                    :class="status === '{{ $key }}'
                ? 'bg-brand-primary text-white border-brand-primary'
                : 'bg-white text-brand-secondary border-gray-200 hover:bg-gray-100'"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full border text-sm font-semibold transition">

                    {{ $label }}

                    <span class="text-xs opacity-80">
                        @if($key === 'semua')
                        {{ $reservations->count() }}
                        @else
                        {{ $reservations->where('status', $key)->count() }}
                        @endif
                    </span>
                </button>
                @endforeach
            </div>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-semibold">
            {{ session('success') }}
        </div>
        @endif

        {{-- Kartu-kartu reservasi tetap diletakkan di bawah ini --}}

        <div id="daftar-reservasi">
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
        </div> {{-- penutup #daftar-reservasi --}}

    </div> {{-- penutup kotak Daftar Reservasi --}}
</div> {{-- penutup x-data --}}

{{-- Modal Pembatalan --}}
<div
    x-data="{ show: false, formId: null, code: '' }"
    x-on:open-cancel-modal.window="show = true; formId = $event.detail.formId; code = $event.detail.code"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-[100] flex items-center justify-center p-4">

    <div class="absolute inset-0 bg-black/40" @click="show = false"></div>

    <div
        x-show="show"
        class="relative bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm">

        <h3 class="font-bold text-lg text-brand-primary mb-2">
            Batalkan Reservasi?
        </h3>

        <p class="text-sm text-brand-secondary mb-6">
            Reservasi <strong x-text="code"></strong> akan dibatalkan. Yakin ingin melanjutkan?
        </p>

        <div class="flex justify-end gap-3">
            <button
                type="button"
                @click="show = false"
                class="text-sm font-semibold text-brand-secondary px-4 py-2 rounded-xl">
                Batal
            </button>

            <button
                type="button"
                @click="document.getElementById(formId).submit(); show = false"
                class="text-sm font-bold bg-rose-600 text-white px-5 py-2 rounded-xl">
                Ya, Batalkan
            </button>
        </div>
    </div>
</div>
@endsection