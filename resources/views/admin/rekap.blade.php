<x-admin-layout>

    <div class="min-h-screen bg-[#f5f7f7]">

        <div class="flex min-h-screen">

            {{-- SIDEBAR --}}
            <aside class="w-[290px] shrink-0 bg-white border-r border-[#e2ebe9] flex flex-col justify-between">

                <div>

                    {{-- BRAND --}}
                    <div class="h-[80px] px-6 border-b border-[#e2ebe9] flex items-center gap-3">

                        <div class="size-10 rounded-xl bg-[#19183b] flex items-center justify-center">

                            <svg
                                class="size-5 text-white"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M5.25 5.25h13.5A2.25 2.25 0 0121 7.5v11.25A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75V7.5A2.25 2.25 0 015.25 5.25z" />

                            </svg>

                        </div>

                        <div>

                            <div class="flex items-center gap-1.5">

                                <span class="font-extrabold text-[20px] text-[#19183b]">
                                    Book<span class="text-[#708993]">&amp;</span>Fix
                                </span>

                                <span class="px-2 py-0.5 rounded border border-[#bacdc9] bg-[#eef4f3] text-[10px] font-bold uppercase text-[#19183b]">
                                    Admin
                                </span>

                            </div>

                            <p class="text-[11px] text-[#708993]">
                                Campus Facility Management
                            </p>

                        </div>

                    </div>


                    {{-- MENU --}}
                    <nav class="px-4 pt-4">

                        <p class="px-3 mb-3 text-[11px] font-bold uppercase tracking-wide text-[#708993]">
                            Menu Utama
                        </p>


                        {{-- DASHBOARD --}}
                        <a
                            href="{{ route('admin') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1
                            {{ request()->routeIs('admin')
                                ? 'bg-[#19183b] text-white'
                                : 'text-[#708993] hover:bg-[#f4f8f7]' }}">

                            <svg
                                class="size-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 8.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 018.25 20.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25A2.25 2.25 0 0113.5 8.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />

                            </svg>

                            <span class="text-sm font-semibold">
                                Dashboard
                            </span>

                        </a>


                        {{-- FASILITAS --}}
                        <a
                            href="{{ route('admin.facilities.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1
                            {{ request()->routeIs('admin.facilities.*')
                                ? 'bg-[#19183b] text-white'
                                : 'text-[#708993] hover:bg-[#f4f8f7]' }}">

                            <svg
                                class="size-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.25 21h19.5M4.5 21V4.5A1.5 1.5 0 016 3h4.5a1.5 1.5 0 011.5 1.5V21m0-12h6a1.5 1.5 0 011.5 1.5V21M7.5 6h1.5m-1.5 3h1.5m-1.5 3h1.5m4.5-3h1.5m-1.5 3h1.5" />

                            </svg>

                            <span class="text-sm font-medium">
                                Fasilitas
                            </span>

                        </a>


                        {{-- PENGGUNA --}}
                        <a
                            href="{{ route('admin.pengguna.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1
                            {{ request()->routeIs('admin.pengguna.*')
                                ? 'bg-[#19183b] text-white'
                                : 'text-[#708993] hover:bg-[#f4f8f7]' }}">

                            <svg
                                class="size-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4.5 20.25a7.5 7.5 0 0115 0" />

                            </svg>

                            <span class="text-sm font-medium">
                                Pengguna
                            </span>

                        </a>


                        {{-- LAPORAN --}}
                        <a
                            href="{{ route('admin.rekap') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-xl
                            {{ request()->routeIs('admin.rekap')
                                ? 'bg-[#19183b] text-white'
                                : 'text-[#708993] hover:bg-[#f4f8f7]' }}">

                            <svg
                                class="size-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 3v18h18M7 16v-5m5 5V7m5 9v-8" />

                            </svg>

                            <span class="text-sm font-medium">
                                Laporan
                            </span>

                        </a>

                    </nav>

                </div>


                {{-- STATUS --}}
                <div class="p-4">

                    <div class="bg-[#eef4f3] border border-[#e2ebe9] rounded-2xl p-4 flex items-center gap-3">

                        <span class="size-3 rounded-full bg-[#59b88a]"></span>

                        <div>

                            <p class="text-xs font-semibold text-[#19183b]">
                                Sistem Booking Aktif
                            </p>

                            <p class="text-[11px] text-[#708993]">
                                Server Kampus Normal
                            </p>

                        </div>

                    </div>

                </div>

            </aside>


            {{-- MAIN --}}
            <main class="flex-1 min-w-0 px-8 py-8">

                {{-- HEADER --}}
                <div class="flex items-center justify-between mb-8">

                    <div>

                        <h1 class="font-extrabold text-[30px] tracking-[-0.75px] text-[#19183b]">
                            Laporan Penggunaan Fasilitas
                        </h1>

                        <p class="text-sm text-[#708993] mt-1">
                            Lihat rekap penggunaan dan kerusakan fasilitas berdasarkan periode.
                        </p>

                    </div>


                    {{-- EXPORT --}}
                    <div class="flex items-center gap-2">

                        {{-- EXPORT CSV --}}
                        <a
                            href="{{ route('admin.rekap.export.csv', [
                                'tanggal_mulai' => $tanggalMulai,
                                'tanggal_akhir' => $tanggalAkhir
                            ]) }}"
                            class="inline-flex items-center gap-2
                                   h-10 px-4 rounded-lg
                                   border border-[#dfe7e6]
                                   bg-white text-[#52656d]
                                   text-xs font-semibold
                                   hover:bg-[#f7f9f9]
                                   transition">

                            <svg
                                class="size-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3v12m0 0l4-4m-4 4l-4-4M5 21h14a2 2 0 002-2v-3" />

                            </svg>

                            Export CSV

                        </a>


                        {{-- EXPORT EXCEL --}}
                        <a
                            href="{{ route('admin.rekap.export.excel', [
                                'tanggal_mulai' => $tanggalMulai,
                                'tanggal_akhir' => $tanggalAkhir
                            ]) }}"
                            class="inline-flex items-center gap-2
                                   h-10 px-4 rounded-lg
                                   bg-[#24865b] text-white
                                   text-xs font-semibold
                                   hover:bg-[#1f754f]
                                   transition">

                            <svg
                                class="size-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3v12m0 0l4-4m-4 4l-4-4M5 21h14a2 2 0 002-2v-3" />

                            </svg>

                            Export Excel

                        </a>


                        {{-- EXPORT PDF --}}
                        <a
                            href="{{ route('admin.rekap.export.pdf', [
                                'tanggal_mulai' => $tanggalMulai,
                                'tanggal_akhir' => $tanggalAkhir
                            ]) }}"
                            class="inline-flex items-center gap-2
                                   h-10 px-4 rounded-lg
                                   bg-[#19183b] text-white
                                   text-xs font-semibold
                                   hover:bg-[#252451]
                                   transition">

                            <svg
                                class="size-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3v12m0 0l4-4m-4 4l-4-4M5 21h14a2 2 0 002-2v-3" />

                            </svg>

                            Export PDF

                        </a>

                    </div>

                </div>


                {{-- CARD REKAP PENGGUNAAN --}}
                <div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-sm overflow-hidden">


                    {{-- FILTER --}}
                    <div class="px-5 py-4 border-b border-[#eef1f1]">

                        <form
                            action="{{ route('admin.rekap') }}"
                            method="GET">

                            <div class="flex items-end gap-3 flex-wrap">


                                {{-- TANGGAL MULAI --}}
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
                                        class="h-10 px-3 rounded-lg
                                               border border-[#e2e8e7]
                                               text-[13px] text-[#19183b]
                                               focus:outline-none
                                               focus:ring-1 focus:ring-[#19183b]
                                               focus:border-[#19183b]">

                                </div>


                                {{-- TANGGAL AKHIR --}}
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
                                        class="h-10 px-3 rounded-lg
                                               border border-[#e2e8e7]
                                               text-[13px] text-[#19183b]
                                               focus:outline-none
                                               focus:ring-1 focus:ring-[#19183b]
                                               focus:border-[#19183b]">

                                </div>


                                {{-- TAMPILKAN --}}
                                <button
                                    type="submit"
                                    class="h-10 px-4 rounded-lg
                                           bg-[#19183b] text-white
                                           text-xs font-semibold
                                           hover:bg-[#252451]
                                           transition">

                                    Tampilkan

                                </button>


                                {{-- RESET --}}
                                @if($tanggalMulai || $tanggalAkhir)

                                    <a
                                        href="{{ route('admin.rekap') }}"
                                        class="h-10 px-4 rounded-lg
                                               border border-[#dfe7e6]
                                               text-xs font-medium text-[#52656d]
                                               hover:bg-[#f7f9f9]
                                               flex items-center">

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


                                        {{-- FASILITAS --}}
                                        <td class="px-5 py-4">

                                            <div class="flex items-center gap-3">

                                                <div class="size-9 rounded-full
                                                            bg-[#eef2ff]
                                                            text-[#5965c4]
                                                            flex items-center justify-center
                                                            shrink-0">

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

                                                <div>

                                                    <p class="font-semibold text-[14px] text-[#19183b]">
                                                        {{ $item->name }}
                                                    </p>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- TIPE --}}
                                        <td class="px-5 py-4">

                                            @if($item->type === 'ruangan')

                                                <span class="px-2.5 py-1 rounded-full
                                                             text-[11px] font-medium
                                                             bg-blue-50 text-blue-700
                                                             border border-blue-100">

                                                    Ruangan

                                                </span>

                                            @elseif($item->type === 'laboratorium')

                                                <span class="px-2.5 py-1 rounded-full
                                                             text-[11px] font-medium
                                                             bg-purple-50 text-purple-700
                                                             border border-purple-100">

                                                    Laboratorium

                                                </span>

                                            @elseif($item->type === 'area_olahraga')

                                                <span class="px-2.5 py-1 rounded-full
                                                             text-[11px] font-medium
                                                             bg-green-50 text-green-700
                                                             border border-green-100">

                                                    Area Olahraga

                                                </span>

                                            @elseif($item->type === 'peralatan_presentasi')

                                                <span class="px-2.5 py-1 rounded-full
                                                             text-[11px] font-medium
                                                             bg-orange-50 text-orange-700
                                                             border border-orange-100">

                                                    Peralatan Presentasi

                                                </span>

                                            @elseif($item->type === 'audio_multimedia')

                                                <span class="px-2.5 py-1 rounded-full
                                                             text-[11px] font-medium
                                                             bg-pink-50 text-pink-700
                                                             border border-pink-100">

                                                    Audio & Multimedia

                                                </span>

                                            @else

                                                <span class="px-2.5 py-1 rounded-full
                                                             text-[11px] font-medium
                                                             bg-gray-50 text-gray-600
                                                             border border-gray-100">

                                                    Lainnya

                                                </span>

                                            @endif

                                        </td>


                                        {{-- LOKASI --}}
                                        <td class="px-5 py-4 text-[13px] text-[#708993]">

                                            {{ $item->location }}

                                        </td>


                                        {{-- JUMLAH PENGGUNAAN --}}
                                        <td class="px-5 py-4">

                                            <span class="font-semibold text-[14px] text-[#19183b]">

                                                {{ $item->jumlah_penggunaan }}

                                            </span>

                                            <span class="text-[12px] text-[#9aaab0] ml-1">
                                                kali
                                            </span>

                                        </td>


                                        {{-- STATUS --}}
                                        <td class="px-5 py-4">

                                            @if($item->status === 'tersedia')

                                                <span class="inline-flex items-center gap-1.5
                                                             px-2.5 py-1 rounded-full
                                                             text-[11px] font-medium
                                                             bg-[#f0faf5] text-[#24865b]
                                                             border border-[#d4eee1]">

                                                    <span class="size-1.5 rounded-full bg-[#55b985]"></span>

                                                    Tersedia

                                                </span>

                                            @elseif($item->status === 'dalam_perbaikan')

                                                <span class="inline-flex items-center gap-1.5
                                                             px-2.5 py-1 rounded-full
                                                             text-[11px] font-medium
                                                             bg-[#fffaf0] text-[#b77900]
                                                             border border-[#f3e4b7]">

                                                    <span class="size-1.5 rounded-full bg-[#e6a51d]"></span>

                                                    Dalam Perbaikan

                                                </span>

                                            @else

                                                <span class="inline-flex items-center gap-1.5
                                                             px-2.5 py-1 rounded-full
                                                             text-[11px] font-medium
                                                             bg-[#fff4f5] text-[#c94b5b]
                                                             border border-[#f2d8dc]">

                                                    <span class="size-1.5 rounded-full bg-[#d86673]"></span>

                                                    Nonaktif

                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="5"
                                            class="px-6 py-12 text-center">

                                            <div class="flex flex-col items-center">

                                                <div class="size-12 rounded-full
                                                            bg-[#f4f8f7]
                                                            flex items-center justify-center
                                                            mb-3">

                                                    <svg
                                                        class="size-5 text-[#9aaab0]"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                        stroke-width="2">

                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M9 17v-2m3 2v-4m3 4v-6M4 19h16M5 5h14a1 1 0 011 1v13H4V6a1 1 0 011-1z" />

                                                    </svg>

                                                </div>

                                                <p class="text-sm font-semibold text-[#19183b]">
                                                    Belum ada data laporan
                                                </p>

                                                <p class="text-xs text-[#708993] mt-1">
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
                    <div class="px-5 py-3 border-t border-[#eef1f1]
                                flex items-center justify-between">

                        <p class="text-xs text-[#708993]">

                            Menampilkan

                            <span class="font-semibold text-[#19183b]">
                                {{ $rekap->count() }}
                            </span>

                            fasilitas

                        </p>


                        @if($tanggalMulai || $tanggalAkhir)

                            <p class="text-xs text-[#708993]">

                                Periode:

                                <span class="font-medium text-[#19183b]">

                                    {{ $tanggalMulai ?: 'Awal' }}

                                    -

                                    {{ $tanggalAkhir ?: 'Sekarang' }}

                                </span>

                            </p>

                        @endif

                    </div>

                </div>


                {{-- REQ 7: REKAP KERUSAKAN --}}
                <div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-sm overflow-hidden mt-6">

                    {{-- HEADER --}}
                    <div class="px-5 py-5 border-b border-[#eef1f1]">

                        <div class="flex items-center justify-between gap-4">

                            <div>

                                <h2 class="font-bold text-[18px] text-[#19183b]">
                                    Rekap Frekuensi Kerusakan Fasilitas
                                </h2>

                                <p class="text-xs text-[#708993] mt-1">
                                    Jumlah laporan kerusakan elektronik dan audio visual berdasarkan fasilitas dan lokasi.
                                </p>

                            </div>


                            {{-- TOTAL --}}
                            <div class="shrink-0 text-right">

                                <p class="text-[11px] text-[#93a3aa] uppercase tracking-wide font-bold">
                                    Total Laporan
                                </p>

                                <p class="text-xl font-extrabold text-[#19183b] mt-0.5">
                                    {{ $rekapKerusakan->sum('jumlah_kerusakan') }}
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- TABLE KERUSAKAN --}}
                    <div class="overflow-x-auto">

                        <table class="w-full text-sm">

                            <thead class="bg-[#fbfcfc]">

                                <tr>

                                    <th class="px-5 py-4 text-left text-[11px] uppercase tracking-wide font-bold text-[#93a3aa]">
                                        Fasilitas
                                    </th>

                                    <th class="px-5 py-4 text-left text-[11px] uppercase tracking-wide font-bold text-[#93a3aa]">
                                        Lokasi
                                    </th>

                                    <th class="px-5 py-4 text-center text-[11px] uppercase tracking-wide font-bold text-[#93a3aa]">
                                        Frekuensi Kerusakan
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-[#eef1f1]">

                                @forelse($rekapKerusakan as $item)

                                    <tr class="hover:bg-[#fafcfc] transition">

                                        {{-- FASILITAS --}}
                                        <td class="px-5 py-4">

                                            <div class="flex items-center gap-3">

                                                <div class="size-9 rounded-full
                                                            bg-[#fff4f5]
                                                            text-[#c94b5b]
                                                            flex items-center justify-center
                                                            shrink-0">

                                                    <svg
                                                        class="size-4"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                        stroke-width="2">

                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M12 9v3.75m0 3.75h.008v.008H12v-.008zM10.5 3.75h3L21 18.75H3L10.5 3.75z" />

                                                    </svg>

                                                </div>

                                                <div>

                                                    <p class="font-semibold text-[14px] text-[#19183b]">
                                                        {{ $item->nama_fasilitas }}
                                                    </p>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- LOKASI --}}
                                        <td class="px-5 py-4 text-[13px] text-[#708993]">

                                            {{ $item->lokasi }}

                                        </td>


                                        {{-- FREKUENSI --}}
                                        <td class="px-5 py-4 text-center">

                                            <span class="inline-flex items-center gap-1.5
                                                         px-2.5 py-1 rounded-full
                                                         text-[11px] font-semibold
                                                         bg-[#fff4f5] text-[#c94b5b]
                                                         border border-[#f2d8dc]">

                                                {{ $item->jumlah_kerusakan }}

                                                kali

                                            </span>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="3"
                                            class="px-6 py-12 text-center">

                                            <div class="flex flex-col items-center">

                                                <div class="size-12 rounded-full
                                                            bg-[#f4f8f7]
                                                            flex items-center justify-center
                                                            mb-3">

                                                    <svg
                                                        class="size-5 text-[#9aaab0]"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                        stroke-width="2">

                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M9 17v-2m3 2v-4m3 4v-6M4 19h16M5 5h14a1 1 0 011 1v13H4V6a1 1 0 011-1z" />

                                                    </svg>

                                                </div>

                                                <p class="text-sm font-semibold text-[#19183b]">
                                                    Belum ada laporan kerusakan
                                                </p>

                                                <p class="text-xs text-[#708993] mt-1">
                                                    Tidak ada laporan kerusakan pada periode yang dipilih.
                                                </p>

                                            </div>

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    {{-- FOOTER KERUSAKAN --}}
                    <div class="px-5 py-3 border-t border-[#eef1f1]">

                        <p class="text-xs text-[#708993]">

                            Menampilkan

                            <span class="font-semibold text-[#19183b]">
                                {{ $rekapKerusakan->count() }}
                            </span>

                            fasilitas dengan laporan kerusakan.

                            @if($tanggalMulai || $tanggalAkhir)

                                <span class="ml-1">

                                    Periode:

                                    <span class="font-medium text-[#19183b]">

                                        {{ $tanggalMulai ?: 'Awal' }}

                                        -

                                        {{ $tanggalAkhir ?: 'Sekarang' }}

                                    </span>

                                </span>

                            @endif

                        </p>

                    </div>

                </div>

            </main>

        </div>

    </div>

</x-admin-layout>