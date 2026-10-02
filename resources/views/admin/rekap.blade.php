@extends('layouts.admin')

@section('content')

{{-- HEADER --}}
<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-8">

    <div>
        <h1 class="font-extrabold text-[30px] tracking-[-0.75px] text-[#19183b]">
            Laporan Penggunaan Fasilitas
        </h1>

        <p class="text-sm text-[#708993] mt-1">
            Lihat rekap penggunaan dan kerusakan fasilitas berdasarkan periode.
        </p>
    </div>

    {{-- EXPORT --}}
    <div class="flex items-center gap-2 flex-wrap">

        <a
            href="{{ route('admin.rekap.export.csv', [
                    'tanggal_mulai' => $tanggalMulai,
                    'tanggal_akhir' => $tanggalAkhir
                ]) }}"
            class="inline-flex items-center gap-2 h-10 px-4 rounded-lg border border-[#dfe7e6] bg-white text-[#52656d] text-xs font-semibold hover:bg-[#f7f9f9] transition">

            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 3v12m0 0l4-4m-4 4l-4-4M5 21h14a2 2 0 002-2v-3" />
            </svg>

            Export CSV
        </a>

        <a
            href="{{ route('admin.rekap.export.excel', [
                    'tanggal_mulai' => $tanggalMulai,
                    'tanggal_akhir' => $tanggalAkhir
                ]) }}"
            class="inline-flex items-center gap-2 h-10 px-4 rounded-lg bg-[#24865b] text-white text-xs font-semibold hover:bg-[#1f754f] transition">

            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 3v12m0 0l4-4m-4 4l-4-4M5 21h14a2 2 0 002-2v-3" />
            </svg>

            Export Excel
        </a>

        <a
            href="{{ route('admin.rekap.export.pdf', [
                    'tanggal_mulai' => $tanggalMulai,
                    'tanggal_akhir' => $tanggalAkhir
                ]) }}"
            class="inline-flex items-center gap-2 h-10 px-4 rounded-lg bg-[#19183b] text-white text-xs font-semibold hover:bg-[#252451] transition">

            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 3v12m0 0l4-4m-4 4l-4-4M5 21h14a2 2 0 002-2v-3" />
            </svg>

            Export PDF
        </a>

    </div>

</div>


{{-- =========================================================
         REKAP PENGGUNAAN
    ========================================================== --}}
<div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-sm overflow-hidden">

    {{-- FILTER --}}
    <div class="px-5 py-4 border-b border-[#eef1f1]">

        <form action="{{ route('admin.rekap') }}" method="GET">

            <div class="flex items-end gap-3 flex-wrap">

                <div>
                    <label
                        for="tanggal_mulai"
                        class="block text-[11px] font-semibold text-[#708993] mb-1.5">
                        Tanggal Mulai
                    </label>

                    <input
                        type="date"
                        id="tanggal_mulai"
                        name="tanggal_mulai"
                        value="{{ $tanggalMulai }}"
                        class="h-10 px-3 rounded-lg border border-[#e2e8e7] text-[13px] text-[#19183b] focus:outline-none focus:ring-1 focus:ring-[#19183b] focus:border-[#19183b]">
                </div>

                <div>
                    <label
                        for="tanggal_akhir"
                        class="block text-[11px] font-semibold text-[#708993] mb-1.5">
                        Tanggal Akhir
                    </label>

                    <input
                        type="date"
                        id="tanggal_akhir"
                        name="tanggal_akhir"
                        value="{{ $tanggalAkhir }}"
                        class="h-10 px-3 rounded-lg border border-[#e2e8e7] text-[13px] text-[#19183b] focus:outline-none focus:ring-1 focus:ring-[#19183b] focus:border-[#19183b]">
                </div>

                <button
                    type="submit"
                    class="h-10 px-4 rounded-lg bg-[#19183b] text-white text-xs font-semibold hover:bg-[#252451] transition">
                    Tampilkan
                </button>

                @if($tanggalMulai || $tanggalAkhir)
                <a
                    href="{{ route('admin.rekap') }}"
                    class="h-10 px-4 rounded-lg border border-[#dfe7e6] text-xs font-medium text-[#52656d] hover:bg-[#f7f9f9] flex items-center">
                    Reset
                </a>
                @endif

            </div>

        </form>

    </div>


    {{-- TABLE PENGGUNAAN --}}
    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-[#fbfcfc]">

                <tr>

                    <th class="px-5 py-4 text-left text-[11px] uppercase tracking-wide font-bold text-[#93a3aa]">
                        Fasilitas
                    </th>

                    <th class="px-5 py-4 text-left text-[11px] uppercase tracking-wide font-bold text-[#93a3aa]">
                        Tipe
                    </th>

                    <th class="px-5 py-4 text-left text-[11px] uppercase tracking-wide font-bold text-[#93a3aa]">
                        Lokasi
                    </th>

                    <th class="px-5 py-4 text-left text-[11px] uppercase tracking-wide font-bold text-[#93a3aa]">
                        Jumlah Penggunaan
                    </th>

                    <th class="px-5 py-4 text-left text-[11px] uppercase tracking-wide font-bold text-[#93a3aa]">
                        Status
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-[#eef1f1]">

                @forelse($rekap as $item)

                <tr class="hover:bg-[#fafcfc] transition">

                    <td class="px-5 py-4">

                        <div class="flex items-center gap-3">

                            <div class="size-9 rounded-full bg-[#eef2ff] text-[#5965c4] flex items-center justify-center shrink-0">

                                <svg
                                    class="size-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 21h18M5 21V5a2 2 0 012-2h6a2 2 0 012 2v16M15 9h2a2 2 0 012 2v10M9 7h2m-2 4h2m-2 4h2" />

                                </svg>

                            </div>

                            <p class="font-bold text-[14px] text-[#19183b]">
                                {{ $item->name }}
                            </p>

                        </div>

                    </td>


                    <td class="px-5 py-4">

                        @if($item->type === 'ruangan')

                        <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-blue-50 text-blue-700 border border-blue-100">
                            Ruangan
                        </span>

                        @elseif($item->type === 'laboratorium')

                        <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-purple-50 text-purple-700 border border-purple-100">
                            Laboratorium
                        </span>

                        @elseif($item->type === 'area_olahraga')

                        <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-green-50 text-green-700 border border-green-100">
                            Area Olahraga
                        </span>

                        @elseif($item->type === 'peralatan_presentasi')

                        <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-orange-50 text-orange-700 border border-orange-100">
                            Peralatan Presentasi
                        </span>

                        @elseif($item->type === 'audio_multimedia')

                        <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-pink-50 text-pink-700 border border-pink-100">
                            Audio & Multimedia
                        </span>

                        @else

                        <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-gray-50 text-gray-600 border border-gray-100">
                            Lainnya
                        </span>

                        @endif

                    </td>


                    <td class="px-5 py-4 text-[13px] font-medium text-[#52656d]">
                        {{ $item->location }}
                    </td>


                    <td class="px-5 py-4">

                        <span class="font-bold text-[14px] text-[#19183b]">
                            {{ $item->jumlah_penggunaan }}
                        </span>

                        <span class="text-[12px] font-medium text-[#708993] ml-1">
                            kali
                        </span>

                    </td>


                    <td class="px-5 py-4">

                        @if($item->status === 'tersedia')

                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium bg-[#f0faf5] text-[#24865b] border border-[#d4eee1]">

                            <span class="size-1.5 rounded-full bg-[#55b985]"></span>

                            Tersedia

                        </span>

                        @elseif($item->status === 'dalam_perbaikan')

                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium bg-[#fffaf0] text-[#b77900] border border-[#f3e4b7]">

                            <span class="size-1.5 rounded-full bg-[#e6a51d]"></span>

                            Dalam Perbaikan

                        </span>

                        @else

                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium bg-[#fff4f5] text-[#c94b5b] border border-[#f2d8dc]">

                            <span class="size-1.5 rounded-full bg-[#d86673]"></span>

                            Nonaktif

                        </span>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="px-6 py-12 text-center">

                        <div class="flex flex-col items-center">

                            <div class="size-12 rounded-full bg-[#f4f8f7] flex items-center justify-center mb-3">

                                <svg
                                    class="size-5 text-[#9aaab0]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 17v-2m3 2v-4m3 4v-6M4 19h16M5 5h14a1 1 0 011 1v13H4V6a1 1 0 011 1z" />

                                </svg>

                            </div>

                            <p class="text-sm font-semibold text-[#19183b]">
                                Belum ada data laporan
                            </p>

                            <p class="text-xs font-medium text-[#52656d] mt-1">
                                Belum ada penggunaan fasilitas pada periode yang dipilih.
                            </p>

                        </div>

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- FOOTER PENGGUNAAN --}}
    <div class="px-5 py-3 border-t border-[#eef1f1] flex items-center justify-between gap-4">

        <p class="text-xs font-medium text-[#52656d]">
            Menampilkan
            <span class="font-semibold text-[#19183b]">
                {{ $rekap->count() }}
            </span>
            fasilitas
        </p>

        @if($tanggalMulai || $tanggalAkhir)

        <p class="text-xs font-medium text-[#52656d]">

            Periode:

            <span class="font-medium text-[#19183b]">
                {{ $tanggalMulai ?: 'Awal' }} - {{ $tanggalAkhir ?: 'Sekarang' }}
            </span>

        </p>

        @endif

    </div>

</div>


{{-- =========================================================
         REKAP KERUSAKAN
    ========================================================== --}}
<div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-sm overflow-hidden mt-6">

    {{-- HEADER --}}
    <div class="px-6 py-5 border-b border-[#eef1f1]">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <h2 class="font-bold text-[18px] text-[#19183b]">
                    Rekap Frekuensi Kerusakan Fasilitas
                </h2>

                <p class="text-xs text-[#708993] mt-2">
                    Rekap jumlah laporan kerusakan pada setiap fasilitas.
                </p>

            </div>


            <div class="shrink-0 px-4 py-3 rounded-xl bg-[#f8faf9] border border-[#e8eeee]">

                <p class="text-[10px] uppercase tracking-wide font-bold text-[#708993]">
                    Total laporan
                </p>

                <p class="text-xl font-extrabold text-[#19183b] leading-none mt-1">
                    {{ $rekapKerusakan->sum('jumlah_kerusakan') }}
                </p>

            </div>

        </div>

    </div>


    {{-- HEADER SUMMARY --}}
    <div class="hidden md:grid md:grid-cols-[minmax(0,1fr)_250px_150px] gap-6 px-6 py-3 bg-[#fbfcfc] border-b border-[#eef1f1]">

        <p class="text-[10px] uppercase tracking-wide font-bold text-[#708993]">
            Fasilitas
        </p>

        <p class="text-[10px] uppercase tracking-wide font-bold text-[#708993]">
            Lokasi
        </p>

        <p class="text-[10px] uppercase tracking-wide font-bold text-[#93a3aa] text-right">
            Frekuensi
        </p>

    </div>


    {{-- DAFTAR FASILITAS --}}
    <div class="divide-y divide-[#eef1f1]">

        @forelse($rekapKerusakan as $item)

        <details class="group">

            {{-- SUMMARY FASILITAS --}}
            <summary class="list-none cursor-pointer px-6 py-5 hover:bg-[#fcfdfd] transition">

                <div class="grid grid-cols-1 md:grid-cols-[minmax(0,1fr)_250px_150px] gap-4 md:gap-6 items-center">

                    {{-- FASILITAS --}}
                    <div class="min-w-0">

                        <div class="flex items-center gap-3">

                            {{-- WARNING TRIANGLE --}}
                            <div class="size-10 rounded-xl bg-[#fff4f5] text-[#c45b68] border border-[#f1d8dc] flex items-center justify-center shrink-0">

                                <svg
                                    class="size-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 3.75L21 19.5H3L12 3.75z" />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 9v4.5" />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 16.5h.01" />

                                </svg>

                            </div>


                            <div class="min-w-0">

                                <p class="font-bold text-[14px] text-[#19183b] truncate">
                                    {{ $item->nama_fasilitas }}
                                </p>

                                <p class="text-xs text-[#93a3aa] mt-0.5">
                                    {{ $item->jumlah_kerusakan }} laporan kerusakan
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- LOKASI --}}
                    <div class="md:border-l md:border-[#eef1f1] md:pl-5">

                        <p class="text-xs text-[#93a3aa] md:hidden mb-1">
                            Lokasi
                        </p>

                        <p class="text-[13px] font-semibold text-[#52656d]">
                            {{ $item->lokasi }}
                        </p>

                    </div>


                    {{-- FREKUENSI + DROPDOWN --}}
                    <div class="flex items-center justify-between md:justify-end gap-3">

                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[11px] font-semibold bg-[#fff4f5] text-[#c94b5b] border border-[#f2d8dc]">
                            {{ $item->jumlah_kerusakan }} kali
                        </span>


                        {{-- IKON DETAIL --}}
                        <span class="inline-flex items-center justify-center size-9 rounded-xl bg-[#eef8f3] text-[#24865b] border border-[#d4eee1] transition-transform duration-200 group-open:rotate-180">

                            <svg
                                class="size-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 9l6 6 6-6" />

                            </svg>

                        </span>

                    </div>

                </div>

            </summary>


            {{-- DETAIL LAPORAN --}}
            <div class="px-6 pb-6 pt-1 bg-[#fcfdfd]">

                <div class="md:ml-[52px]">

                    {{-- DETAIL HEADER --}}
                    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2 pb-4">

                        <div>

                            <p class="text-sm font-bold text-[#19183b]">
                                Detail laporan kerusakan
                            </p>

                            <p class="text-[11px] font-medium text-[#708993] mt-1">
                                {{ $item->nama_fasilitas }} · {{ $item->lokasi }}
                            </p>

                        </div>

                        <p class="text-[11px] font-semibold text-[#52656d]">
                            {{ $item->jumlah_kerusakan }} laporan
                        </p>

                    </div>


                    {{-- TABEL DETAIL --}}
                    <div class="overflow-x-auto rounded-xl border border-[#e3eaea] bg-white">

                        <table class="w-full min-w-[900px] text-sm">

                            <thead class="bg-[#f8faf9] border-b border-[#e3eaea]">

                                <tr>

                                    <th class="w-[105px] px-4 py-3 text-left text-[10px] uppercase tracking-wide font-bold text-[#708993]">
                                        Laporan
                                    </th>

                                    <th class="w-[120px] px-4 py-3 text-left text-[10px] uppercase tracking-wide font-bold text-[#708993]">
                                        Tanggal
                                    </th>

                                    <th class="w-[150px] px-4 py-3 text-left text-[10px] uppercase tracking-wide font-bold text-[#708993]">
                                        Kategori
                                    </th>

                                    <th class="px-4 py-3 text-left text-[10px] uppercase tracking-wide font-bold text-[#708993]">
                                        Deskripsi
                                    </th>

                                    <th class="w-[230px] px-4 py-3 text-left text-[10px] uppercase tracking-wide font-bold text-[#708993]">
                                        Pelapor
                                    </th>

                                    <th class="w-[110px] px-4 py-3 text-left text-[10px] uppercase tracking-wide font-bold text-[#708993]">
                                        Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-[#eef1f1]">

                                @foreach($item->laporan as $index => $laporan)

                                <tr class="hover:bg-[#fafcfc] transition align-top">

                                    {{-- LAPORAN --}}
                                    <td class="px-4 py-4">

                                        <p class="text-[11px] uppercase tracking-wide font-bold text-[#52656d]">
                                            Laporan {{ $index + 1 }}
                                        </p>

                                    </td>


                                    {{-- TANGGAL --}}
                                    <td class="px-4 py-4 whitespace-nowrap">

                                        @if($laporan->created_at)

                                        <p class="text-[12px] font-medium text-[#52656d]">
                                            {{ $laporan->created_at->format('d/m/Y') }}
                                        </p>

                                        @else

                                        <span class="text-[12px] text-[#93a3aa]">
                                            -
                                        </span>

                                        @endif

                                    </td>


                                    {{-- KATEGORI --}}
                                    <td class="px-4 py-4">

                                        @if($laporan->category)

                                        <span class="inline-flex px-2.5 py-1 rounded-md text-[10px] font-semibold bg-[#fff4f5] text-[#c94b5b] border border-[#f2d8dc] whitespace-nowrap">
                                            {{ str_replace('_', ' ', ucfirst($laporan->category)) }}
                                        </span>

                                        @else

                                        <span class="text-[12px] text-[#93a3aa]">
                                            -
                                        </span>

                                        @endif

                                    </td>


                                    {{-- DESKRIPSI --}}
                                    <td class="px-4 py-4 min-w-[220px]">

                                        <p class="text-[13px] font-medium text-[#52656d] leading-relaxed">
                                            {{ $laporan->description ?: 'Tidak ada deskripsi kerusakan.' }}
                                        </p>

                                    </td>


                                    {{-- PELAPOR --}}
                                    <td class="px-4 py-4">

                                        <div class="flex items-center gap-2.5 min-w-0">

                                            <div class="size-8 rounded-full bg-[#eef4f3] text-[#526f76] flex items-center justify-center shrink-0 text-xs font-bold">
                                                {{ strtoupper(substr($laporan->user->name ?? 'U', 0, 1)) }}
                                            </div>

                                            <div class="min-w-0">

                                                <p class="text-xs font-bold text-[#19183b] truncate">
                                                    {{ $laporan->user->name ?? 'Pengguna tidak ditemukan' }}
                                                </p>

                                                @if($laporan->user?->email)

                                                <p class="text-[11px] font-medium text-[#708993] truncate">
                                                    {{ $laporan->user->email }}
                                                </p>

                                                @endif

                                            </div>

                                        </div>

                                    </td>


                                    {{-- STATUS --}}
                                    <td class="px-4 py-4">

                                        @if($laporan->status)

                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-semibold bg-[#f4f8f7] text-[#526f76] border border-[#dfe9e7] whitespace-nowrap">
                                            {{ str_replace('_', ' ', ucfirst($laporan->status)) }}
                                        </span>

                                        @else

                                        <span class="text-[11px] font-medium text-[#93a3aa]">
                                            Belum ada status
                                        </span>

                                        @endif

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </details>

        @empty

        <div class="px-6 py-14 text-center">

            <div class="size-12 rounded-full bg-[#f4f8f7] flex items-center justify-center mx-auto mb-3">

                <svg
                    class="size-5 text-[#9aaab0]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 17v-2m3 2v-4m3 4v-6M4 19h16M5 5h14a1 1 0 011 1v13H4V6a1 1 0 011 1z" />

                </svg>

            </div>

            <p class="text-sm font-semibold text-[#19183b]">
                Belum ada laporan kerusakan
            </p>

            <p class="text-xs font-medium text-[#52656d] mt-1">
                Tidak ada laporan kerusakan pada periode yang dipilih.
            </p>

        </div>

        @endforelse

    </div>


    {{-- FOOTER KERUSAKAN --}}
    <div class="px-6 py-3.5 border-t border-[#eef1f1] bg-[#fbfcfc]">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">

            <p class="text-xs font-medium text-[#52656d]">

                Menampilkan

                <span class="font-semibold text-[#19183b]">
                    {{ $rekapKerusakan->count() }}
                </span>

                fasilitas dengan

                <span class="font-semibold text-[#19183b]">
                    {{ $rekapKerusakan->sum('jumlah_kerusakan') }}
                </span>

                laporan kerusakan.

            </p>


            @if($tanggalMulai || $tanggalAkhir)

            <p class="text-xs font-medium text-[#52656d]">

                Periode:

                <span class="font-medium text-[#19183b]">
                    {{ $tanggalMulai ?: 'Awal' }} - {{ $tanggalAkhir ?: 'Sekarang' }}
                </span>

            </p>

            @endif

        </div> 

    </div>

</div>

@endsection