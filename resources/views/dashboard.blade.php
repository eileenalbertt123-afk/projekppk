@extends('layouts.app')

@section('content')

<!-- Header Selamat Datang -->
<div class="mb-8">
    <h2 class="text-brand-primary" style="font-size: 30px; font-style: normal; font-weight: 800; line-height: 36px; letter-spacing: -0.75px;">
        Beranda
    </h2>
    <p class="text-sm text-brand-secondary mt-1">
        Selamat datang, {{ Auth::user()->name }} 👋 &middot; Cari fasilitas, buat reservasi, dan lihat aktivitas Anda di sini.
    </p>
</div>

<!-- Card Cari & Lihat Fasilitas -->
<div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs mb-6">
    <h3 class="font-bold text-lg text-brand-primary">Cari &amp; Lihat Fasilitas</h3>
    <p class="text-sm text-brand-secondary mb-5">Filter berdasarkan tipe, lokasi, dan kapasitas.</p>

    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-brand-primary hover:opacity-90 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition shadow-xs">
        Lihat Semua Fasilitas <span>→</span>
    </a>
</div>

<div x-data="{ tab: 'semua' }">

    <!-- Ringkasan Aktivitas (3 CARD CLICKABLE) -->
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Card 1: Reservasi Aktif -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] text-brand-secondary uppercase tracking-wider block">Reservasi Aktif</span>
                <span class="font-bold text-brand-primary text-2xl mt-1 block">{{ $activeReservations ?? 0 }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-[#F4F8F7] text-brand-primary flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>

        <!-- Card 2: Menunggu Validasi -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] text-brand-secondary uppercase tracking-wider block">Menunggu Validasi</span>
                <span class="font-bold text-brand-primary text-2xl mt-1 block">{{ $pendingReservations ?? 0 }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Card 3: Laporan Kerusakan -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] text-brand-secondary uppercase tracking-wider block">Laporan Kerusakan</span>
                <span class="font-bold text-brand-primary text-2xl mt-1 block">{{ $reportsCount ?? 0 }}</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- SECTION 1: RIWAYAT RESERVASI & LAPORAN -->
    @php
        $all = collect($reservations ?? []);
        $countSemua     = $all->count();
        $countDisetujui = $all->where('status', 'disetujui')->count();
        $countMenunggu  = $all->where('status', 'menunggu')->count();
        $countLainnya   = $all->whereNotIn('status', ['disetujui', 'menunggu'])->count();
        $countLaporan   = collect($reports ?? [])->count();
    @endphp

    <div id="riwayat-reservasi" class="mt-8 scroll-mt-6">
        <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
            <h3 class="font-bold text-lg text-brand-primary" x-text="tab === 'laporan' ? 'Riwayat Laporan Kerusakan' : 'Riwayat Reservasi'"></h3>

            <!-- Tab Filter -->
            <div class="flex gap-2 flex-wrap">
                <button type="button" @click="tab = 'semua'"
                    :class="tab === 'semua' ? 'bg-brand-primary text-white' : 'bg-white border border-gray-300 text-brand-primary hover:bg-gray-50'"
                    class="px-4 py-1.5 rounded-xl text-xs font-semibold transition">
                    Semua ({{ $countSemua }})
                </button>
                <button type="button" @click="tab = 'disetujui'"
                    :class="tab === 'disetujui' ? 'bg-brand-primary text-white' : 'bg-white border border-gray-300 text-brand-primary hover:bg-gray-50'"
                    class="px-4 py-1.5 rounded-xl text-xs font-semibold transition">
                    Disetujui ({{ $countDisetujui }})
                </button>
                <button type="button" @click="tab = 'menunggu'"
                    :class="tab === 'menunggu' ? 'bg-brand-primary text-white' : 'bg-white border border-gray-300 text-brand-primary hover:bg-gray-50'"
                    class="px-4 py-1.5 rounded-xl text-xs font-semibold transition">
                    Menunggu ({{ $countMenunggu }})
                </button>
                <button type="button" @click="tab = 'lainnya'"
                    :class="tab === 'lainnya' ? 'bg-brand-primary text-white' : 'bg-white border border-gray-300 text-brand-primary hover:bg-gray-50'"
                    class="px-4 py-1.5 rounded-xl text-xs font-semibold transition">
                    Lainnya ({{ $countLainnya }})
                </button>
                <button type="button" @click="tab = 'laporan'"
                    :class="tab === 'laporan' ? 'bg-brand-primary text-white' : 'bg-white border border-gray-300 text-brand-primary hover:bg-gray-50'"
                    class="px-4 py-1.5 rounded-xl text-xs font-semibold transition border-l border-gray-300">
                    Laporan Kerusakan ({{ $countLaporan }})
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-sm font-semibold">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- DAFTAR RESERVASI (Sembunyi kalau tab = 'laporan') -->
        <div x-show="tab !== 'laporan'">
            @forelse($reservations ?? [] as $reservation)
                @php
                    $facility = $reservation->facility ?? ($reservation->details->first()->facility ?? null);
                    $canCancel = in_array($reservation->status, ['menunggu', 'disetujui'])
                        && now()->addHours(24)->lte($reservation->start_time);

                    $statusLabel = [
                        'menunggu'   => 'Menunggu',
                        'disetujui'  => 'Disetujui',
                        'ditolak'    => 'Ditolak',
                        'dibatalkan' => 'Dibatalkan',
                        'selesai'    => 'Selesai',
                    ][$reservation->status] ?? $reservation->status;

                    $statusColor = [
                        'menunggu'   => 'bg-amber-50 text-amber-700 border-amber-200',
                        'disetujui'  => 'bg-brand-tertiary/30 text-brand-primary border-brand-tertiary',
                        'ditolak'    => 'bg-rose-50 text-rose-700 border-rose-200',
                        'dibatalkan' => 'bg-gray-100 text-gray-500 border-gray-200',
                        'selesai'    => 'bg-blue-50 text-blue-700 border-blue-200',
                    ][$reservation->status] ?? 'bg-gray-100 text-gray-500 border-gray-200';

                    $tabGroup = $reservation->status === 'disetujui' ? 'disetujui'
                        : ($reservation->status === 'menunggu' ? 'menunggu' : 'lainnya');
                @endphp

                <div x-show="tab === 'semua' || tab === '{{ $tabGroup }}'" class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs mb-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider">{{ $reservation->reservation_code }}</p>
                            <h4 class="font-bold text-brand-primary text-base mt-0.5">
                                {{ $facility->name ?? 'Fasilitas tidak diketahui' }}
                            </h4>
                            <p class="text-sm text-brand-secondary mt-1">{{ $reservation->purpose }}</p>
                            <p class="text-xs text-brand-secondary mt-2">
                                📅 {{ \Carbon\Carbon::parse($reservation->start_time)->translatedFormat('d M Y, H:i') }}
                                &ndash;
                                {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }} WIB
                            </p>
                            @if($reservation->activity_description)
                                <p class="text-xs text-brand-secondary mt-1">{{ $reservation->activity_description }}</p>
                            @endif
                            <p class="text-xs text-brand-secondary mt-1">Jumlah peserta: {{ $reservation->participant_count }}</p>
                        </div>

                        <span class="text-xs font-bold px-3 py-1.5 rounded-full border whitespace-nowrap {{ $statusColor }}">
                            {{ strtoupper($statusLabel) }}
                        </span>
                    </div>

                    @if($canCancel)
                        <form id="cancel-form-{{ $reservation->id }}" action="{{ route('reservations.cancel', $reservation) }}" method="POST" class="mt-4">
                            @csrf
                            @method('PATCH')
                            <button
                                type="button"
                                @click="$dispatch('open-cancel-modal', { formId: 'cancel-form-{{ $reservation->id }}', code: '{{ $reservation->reservation_code }}' })"
                                class="text-xs font-bold text-rose-600 border border-rose-200 hover:bg-rose-50 px-4 py-2 rounded-xl transition cursor-pointer">
                                Batalkan Reservasi
                            </button>
                        </form>
                    @elseif(in_array($reservation->status, ['menunggu', 'disetujui']))
                        <p class="text-xs text-gray-400 mt-4">Sudah melewati batas waktu pembatalan (24 jam sebelum mulai).</p>
                    @endif
                </div>
            @empty
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs text-sm text-brand-secondary">
                    Belum ada reservasi.
                </div>
            @endforelse
        </div>

        <!-- DAFTAR LAPORAN KERUSAKAN (Hanya muncul jika tab = 'laporan') -->
        <div x-show="tab === 'laporan'">
            @forelse($reports ?? [] as $report)
                <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs mb-3 flex items-center justify-between gap-4">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-brand-secondary uppercase bg-brand-neutral px-2 py-0.5 rounded border border-gray-200">{{ $report->category }}</span>
                        <h4 class="text-sm font-bold text-brand-primary">{{ $report->facility->name ?? 'Fasilitas' }}</h4>
                        <p class="text-xs text-brand-secondary">{{ $report->description }}</p>
                        <span class="text-[10px] text-gray-400 block mt-1">
                            Dilaporkan: {{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('d M Y, H:i') }} WIB
                        </span>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider shrink-0
                        {{ $report->status === 'selesai' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($report->status === 'diproses' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-amber-50 text-amber-700 border border-amber-200') }}">
                        {{ $report->status }}
                    </span>
                </div>
            @empty
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs text-sm text-brand-secondary">
                    Belum ada riwayat laporan kerusakan.
                </div>
            @endforelse
        </div>

    </div>

</div><!-- /x-data tab -->

<!-- Modal Konfirmasi Cancel -->
<div
    x-data="{ show: false, formId: null, code: '' }"
    x-on:open-cancel-modal.window="show = true; formId = $event.detail.formId; code = $event.detail.code"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-[100] flex items-center justify-center p-4"
>
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/40" @click="show = false"></div>

    <!-- Modal Box -->
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        class="relative bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm"
    >
        <h3 class="font-bold text-lg text-brand-primary mb-2">Batalkan Reservasi?</h3>
        <p class="text-sm text-brand-secondary mb-6">
            Reservasi <span class="font-semibold" x-text="code"></span> akan dibatalkan dan tidak bisa dikembalikan. Yakin ingin melanjutkan?
        </p>

        <div class="flex justify-end gap-3">
            <button
                type="button"
                @click="show = false"
                class="text-sm font-semibold text-brand-secondary hover:text-brand-primary px-4 py-2 rounded-xl transition"
            >
                Batal
            </button>
            <button
                type="button"
                @click="document.getElementById(formId).submit(); show = false"
                class="text-sm font-bold bg-rose-600 hover:bg-rose-700 text-white px-5 py-2 rounded-xl transition"
            >
                Ya, Batalkan
            </button>
        </div>
    </div>
</div>

@endsection