@props([
    // One of: 'waiting', 'approved', 'cancellation_form', 'cancelled',
    //         'waiting_conflict', 'rejection_form', 'rejected'
    'state' => 'waiting',

    'rejectCategoryOptions' => [
        'Jadwal Tidak Memungkinkan',
        'Fasilitas Tidak Tersedia',
        'Dokumen Tidak Lengkap',
        'Tujuan Penggunaan Tidak Sesuai',
        'Kapasitas Tidak Memadai',
        'Lainnya',
    ],

    'cancelCategoryOptions' => [
        'Kerusakan Fasilitas Mendadak',
        'Kepentingan Prioritas Kampus',
        'Perubahan Ketersediaan Fasilitas',
        'Kondisi Operasional',
        'Lainnya',
    ],
 
    'officerName' => '-',

    'checklist' => [
        'Data pemohon sesuai dan dapat diverifikasi',
        'Jadwal penggunaan tidak bentrok dengan reservasi lain',
        'Fasilitas tersedia dan dapat digunakan',
    ],
 
    'approvedBy' => '-',
    'approvedAt' => '-',

    'cancelledBy' => '-',
    'cancelledAt' => '-',
    'cancelReasonDetail' => null,

    'rejectedBy' => '-',
    'rejectedAt' => '-',
    'rejectReasonDetail' => null,

    'approveAction' => null,
    'rejectAction' => null,
    'cancelAction' => null,

    'reservationId' => null,
])
 
@php
    $footnotes = [
        'waiting' => 'Pastikan seluruh checklist verifikasi telah terpenuhi sebelum memberikan keputusan persetujuan atau penolakan reservasi.',
        'waiting_conflict' => 'Setujui dikunci sistem karena terdapat bentrok jadwal.',
        'approved' => 'Reservasi akan tetap berjalan sesuai persetujuan. Lakukan pembatalan hanya apabila diperlukan dengan menyertakan alasan yang jelas.',
        'cancellation_form' => 'Pastikan alasan pembatalan telah sesuai sebelum konfirmasi. Tindakan ini akan tercatat pada riwayat reservasi.',
        'cancelled' => 'Reservasi ini tidak dapat dilanjutkan dan memerlukan pengajuan baru apabila ingin melakukan reservasi kembali.',
        'rejection_form' => 'Pastikan alasan penolakan telah sesuai sebelum konfirmasi. Tindakan ini akan tercatat pada riwayat reservasi.',
        'rejected' => 'Reservasi ini tidak dapat dilanjutkan dan memerlukan pengajuan baru apabila ingin melakukan reservasi kembali.',
    ];
    $footnote = $footnotes[$state] ?? $footnotes['waiting'];

    $displayOfficerName = \Illuminate\Support\Str::title($officerName);
    $displayApprovedBy = \Illuminate\Support\Str::title($approvedBy);
    $displayCancelledBy = \Illuminate\Support\Str::title($cancelledBy);
    $displayRejectedBy = \Illuminate\Support\Str::title($rejectedBy);
@endphp
 
<div {{ $attributes->merge(['class' => 'relative bg-white border-2 border-[#e0e7ff] rounded-2xl shadow-lg p-[26px] w-full overflow-hidden']) }}>
    {{-- top accent bar --}}
    <div class="absolute inset-x-0 top-0 h-[6px] bg-[#19183b]"></div>
 
    {{-- header --}}
    <div class="flex items-center gap-[10px] border-b border-[#f1f5f9] pb-[17px] mb-4">
        <span class="flex items-center justify-center shrink-0 size-8 rounded-lg bg-[#19183b]">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1Zm3 8V5.5a3 3 0 10-6 0V9h6Z" clip-rule="evenodd" />
            </svg>
        </span>
        <div>
            <h2 class="text-base font-bold text-[#19183b] leading-6">Panel Aksi Petugas</h2>
            <p class="text-xs text-[#94a3b8] leading-4">Keputusan persetujuan &amp; verifikasi</p>
        </div>
    </div>
 
    <div class="flex flex-col gap-[15px]">
        @switch($state)
 
            {{-- ============================= WAITING ============================= --}}
            @case('waiting')

                <div class="flex items-center justify-between bg-[#fffbeb] border border-[#fde68a] rounded-xl p-[13px]">
                    <div class="flex items-center gap-2">
                        <span class="size-2 rounded-full bg-[#f59e0b]"></span>
                        <span class="text-xs font-bold text-[#92400e]">Menunggu</span>
                    </div>

                    <span class="text-[11px] text-[#b45309] text-right">
                        Menunggu persetujuan petugas
                    </span>
                </div>

                <form
                    method="POST"
                    action="{{ $approveAction }}"
                    class="flex flex-col gap-4"
                >
                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="status" value="disetujui">

                    {{-- CHECKLIST --}}
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide text-[#0f172a] mb-3">
                            Checklist Verifikasi
                        </p>

                        <div class="space-y-2">

                            @foreach ($checklist as $i => $item)

                                <label class="flex items-center gap-3 bg-[#f8fafc] border border-[#e2e8f0] rounded-xl px-3 py-2.5">

                                    <input
                                        type="checkbox"
                                        name="verification[]"
                                        value="{{ $i }}"
                                        class="size-4 rounded border-[#94a3b8]"
                                    >

                                    <span class="text-xs text-[#475569] leading-5">
                                        {{ $item }}
                                    </span>

                                </label>

                            @endforeach

                        </div>

                        @error('verification')
                            <p class="mt-2 text-xs font-semibold text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- ACTION --}}
                    <div class="flex items-center gap-3">

                        <button
                            type="submit"
                            class="flex-1 inline-flex items-center justify-center gap-[6px]
                                bg-[#059669] hover:bg-[#047857]
                                text-white text-sm font-bold
                                rounded-xl px-3 py-[11px]"
                        >
                            ✓ Setujui
                        </button>

                        <a
                            href="{{ route('petugas.reservasi.detail', $reservationId) }}?action=reject"
                            class="flex-1 inline-flex items-center justify-center gap-[6px]
                                bg-white border border-[#f43f5e]
                                hover:bg-[#fff1f2]
                                text-[#be123c] text-sm font-bold
                                rounded-xl px-3 py-[11px]"
                        >
                            × Tolak
                        </a>

                    </div>

                </form>

            @break
 
            {{-- ======================= WAITING - CONFLICT ======================= --}}
            @case('waiting_conflict')

                <div class="flex items-center justify-between bg-[#fff1f2] border border-[#fecdd3] rounded-xl p-[13px]">
                    <div class="flex items-center gap-2">
                        <span class="size-2 rounded-full bg-[#f43f5e]"></span>

                        <span class="text-xs font-bold text-[#9f1239]">
                            Menunggu
                        </span>
                    </div>

                    <span class="text-[11px] text-[#be123c] text-right">
                        Terdapat bentrok jadwal
                    </span>
                </div>

                <x-petugas.action-panel-parts.checklist :items="$checklist" />

                <div class="flex items-center gap-3">

                    <button
                        type="button"
                        disabled
                        class="flex-1 inline-flex items-center justify-center gap-[6px]
                            bg-[#e2e8f0]
                            border border-[#cbd5e1]
                            cursor-not-allowed
                            text-[#94a3b8]
                            text-sm font-bold
                            rounded-xl px-3 py-[11px]"
                    >
                        🔒 Setujui
                    </button>

                    <a
                        href="{{ route('petugas.reservasi.detail', $reservationId) }}?action=reject"
                        class="flex-1 inline-flex items-center justify-center gap-[6px]
                            bg-white border border-[#f43f5e]
                            hover:bg-[#fff1f2]
                            text-[#be123c] text-sm font-bold
                            rounded-xl px-3 py-[11px]"
                    >
                        × Tolak
                    </a>

                </div>

            @break
 
            {{-- ============================= APPROVED ============================= --}}
            @case('approved')

                <div class="flex flex-col gap-1 bg-[#ecfdf5] border border-[#a7f3d0] rounded-xl p-[15px]">

                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-2">
                            <span class="size-2 rounded-full bg-[#10b981]"></span>

                            <span class="text-sm font-bold text-[#065f46]">
                                Disetujui
                            </span>
                        </div>

                        <span class="bg-[#d1fae5] text-[10px] font-bold uppercase text-[#065f46] px-2 py-0.5 rounded-full">
                            Aktif
                        </span>

                    </div>

                    <p class="text-[11px] text-[#047857]">
                        Disetujui oleh
                        <span class="font-bold">
                            {{ $displayApprovedBy }}
                        </span>,
                        {{ $approvedAt }}
                    </p>

                </div>


                <a
                    href="{{ route('petugas.reservasi.detail', $reservationId) }}?action=cancel"
                    class="w-full inline-flex items-center justify-center gap-[6px]
                        bg-[#e11d48] hover:bg-[#be123c]
                        text-white text-sm font-bold
                        rounded-xl px-3 py-[11px]"
                >
                    Batalkan Reservasi
                </a>

            @break
 
            {{-- ======================= CANCELLATION FORM ======================= --}}
            @case('cancellation_form')

                <p class="text-xs font-bold uppercase tracking-wide text-[#0f172a]">
                    Formulir Pembatalan Petugas
                </p>

                <form
                    method="POST"
                    action="{{ $cancelAction }}"
                    class="flex flex-col gap-3 bg-[#f8fafc]/70 border border-[#e2e8f0] rounded-xl p-[17px]"
                >
                    @csrf
                    @method('PATCH')

                    <input
                        type="hidden"
                        name="status"
                        value="dibatalkan"
                    >

                    {{-- KATEGORI PEMBATALAN --}}
                    <div class="flex flex-col gap-1">

                        <label class="text-[11px] font-semibold uppercase tracking-wide text-[#475569]">
                            Kategori Alasan Pembatalan
                        </label>

                        <select
                            name="reason_category"
                            required
                            class="w-full bg-white border border-[#cbd5e1] rounded-lg
                                px-[15px] py-[11px]
                                text-xs font-semibold text-[#1e293b]"
                        >
                            <option value="">
                                Pilih kategori
                            </option>

                            @foreach ($cancelCategoryOptions as $option)
                                <option value="{{ $option }}">
                                    {{ $option }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- ALASAN TERPERINCI --}}
                    <div class="flex flex-col gap-1">

                        <label class="text-[11px] font-semibold uppercase tracking-wide text-[#475569]">
                            Alasan Terperinci
                        </label>

                        <textarea
                            name="reason"
                            rows="3"
                            required
                            class="w-full bg-white border border-[#cbd5e1] rounded-lg p-[11px]
                                text-xs text-[#1e293b]
                                placeholder:text-[#94a3b8]"
                            placeholder="Tuliskan alasan spesifik pembatalan..."
                        ></textarea>

                    </div>


                    {{-- INFO PETUGAS --}}
                    <div class="flex gap-[6px] bg-[#fffbeb] border border-[#fde68a] rounded-lg p-[9px]">

                        <p class="text-[10px] leading-[15px] text-[#92400e]">
                            Tindakan akan dicatat atas nama
                            <span class="font-bold">
                                {{ $displayOfficerName }}
                            </span>
                            dengan timestamp otomatis.
                        </p>

                    </div>


                    {{-- ACTION --}}
                    <div class="flex gap-2">

                        <button
                            type="submit"
                            class="flex-1 bg-[#e11d48]
                                hover:bg-[#be123c]
                                text-white text-xs font-bold
                                rounded-lg px-3 py-2"
                        >
                            Konfirmasi Pembatalan
                        </button>

                        <a
                            href="{{ route('petugas.reservasi.detail', $reservationId) }}"
                            class="flex-1 inline-flex items-center justify-center
                                bg-white border border-[#cbd5e1]
                                hover:bg-slate-50
                                text-[#334155] text-xs font-bold
                                rounded-lg px-3 py-2"
                        >
                            Tutup
                        </a>

                    </div>

                </form>

            @break
 
            {{-- ============================= CANCELLED ============================= --}}
            @case('cancelled')

                <div class="flex items-center justify-between bg-[#fdf2f8] border border-[#fecdd3] rounded-xl p-[13px]">

                    <div class="flex items-center gap-2">

                        <span class="size-2 rounded-full bg-[#ec4899]"></span>

                        <span class="text-xs font-bold text-[#be185d]">
                            Dibatalkan
                        </span>

                    </div>

                    <span class="text-[11px] font-medium text-[#be185d] text-right">
                        Dibatalkan oleh {{ $displayCancelledBy }}
                        <br>
                        {{ $cancelledAt }}
                    </span>

                </div>


                @if ($cancelReasonDetail)

                    <div class="bg-[#fdf2f8]/80 border border-[#fecdd3] rounded-xl p-[17px]">

                        <p class="text-xs font-bold uppercase tracking-wide text-[#be185d] mb-2">
                            Alasan Pembatalan
                        </p>

                        <p class="text-xs text-[#be185d]">
                            {{ $cancelReasonDetail }}
                        </p>

                    </div>

                @endif

            @break
 
            {{-- ========================= REJECTION FORM ========================= --}}
            @case('rejection_form')

                <p class="text-xs font-bold uppercase tracking-wide text-[#0f172a]">
                    Formulir Penolakan Petugas
                </p>

                <form
                    method="POST"
                    action="{{ $rejectAction }}"
                    class="flex flex-col gap-3 bg-[#f8fafc]/70 border border-[#e2e8f0] rounded-xl p-[17px]"
                >
                    @csrf
                    @method('PATCH')

                    <input
                        type="hidden"
                        name="status"
                        value="ditolak"
                    >

                    {{-- KATEGORI PENOLAKAN --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-[11px] font-semibold uppercase tracking-wide text-[#475569]">
                            Kategori Alasan Penolakan
                        </label>

                        <select
                            name="reason_category"
                            required
                            class="w-full bg-white border border-[#cbd5e1] rounded-lg
                                px-[15px] py-[11px]
                                text-xs font-semibold text-[#1e293b]"
                        >
                            <option value="">Pilih kategori</option>

                            @foreach ($rejectCategoryOptions as $option)
                                <option value="{{ $option }}">
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ALASAN TERPERINCI --}}
                    <div class="flex flex-col gap-1">
                        <label class="text-[11px] font-semibold uppercase tracking-wide text-[#475569]">
                            Alasan Terperinci
                        </label>

                        <textarea
                            name="reason"
                            rows="3"
                            required
                            class="w-full bg-white border border-[#cbd5e1] rounded-lg p-[11px]
                                text-xs text-[#1e293b]
                                placeholder:text-[#94a3b8]"
                            placeholder="Tuliskan alasan spesifik penolakan..."
                        ></textarea>
                    </div>

                    {{-- info petugas --}}
                    <div class="flex gap-[6px] bg-[#fffbeb] border border-[#fde68a] rounded-lg p-[9px]">
                        <p class="text-[10px] leading-[15px] text-[#92400e]">
                            Tindakan akan dicatat atas nama
                            <span class="font-bold">{{ $displayOfficerName }}</span>
                            dengan timestamp otomatis.
                        </p>
                    </div>

                    {{-- tombol --}}
                    <div class="flex gap-2">
                        <button
                            type="submit"
                            class="flex-1 bg-[#e11d48] hover:bg-[#be123c]
                                text-white text-xs font-bold
                                rounded-lg px-3 py-2"
                        >
                            Konfirmasi Penolakan
                        </button>

                        <a
                            href="{{ route('petugas.reservasi.detail', $reservationId) }}"
                            class="flex-1 inline-flex items-center justify-center
                                bg-white border border-[#cbd5e1]
                                hover:bg-slate-50
                                text-[#334155] text-xs font-bold
                                rounded-lg px-3 py-2"
                        >
                            Tutup
                        </a>
                    </div>

                </form>

            @break
 
            {{-- ============================= REJECTED ============================= --}}
            @case('rejected')

                <div class="flex items-center justify-between bg-[#fff1f2] border border-[#fecdd3] rounded-xl p-[13px]">

                    <div class="flex items-center gap-2">

                        <span class="size-2 rounded-full bg-[#f43f5e]"></span>

                        <span class="text-xs font-bold text-[#9f1239]">
                            Ditolak
                        </span>

                    </div>

                    <span class="text-[11px] font-medium text-[#be123c] text-right">
                        Ditolak oleh {{ $displayRejectedBy }}
                        <br>
                        {{ $rejectedAt }}
                    </span>

                </div>


                @if ($rejectReasonDetail)

                    <div class="bg-[#fff1f2]/80 border border-[#fecdd3] rounded-xl p-[17px]">

                        <p class="text-xs font-bold uppercase tracking-wide text-[#881337] mb-2">
                            Alasan Penolakan
                        </p>

                        <p class="text-xs text-[#881337]">
                            {{ $rejectReasonDetail }}
                        </p>

                    </div>

                @endif

            @break
        @endswitch
        <p class="text-[11px] italic text-[#64748b] leading-[17.88px]">{{ $footnote }}</p>
    </div>
</div>