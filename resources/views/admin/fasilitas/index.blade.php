<x-app-layout>

    <div class="min-h-screen bg-[#f5f7f7]">

        <div class="flex min-h-screen">

            {{-- =========================================================
                SIDEBAR
            ========================================================== --}}
            <aside class="w-[290px] shrink-0 bg-white border-r border-[#e2ebe9] flex flex-col justify-between">

                <div>

                    {{-- BRAND --}}
                    <div class="h-[80px] px-6 border-b border-[#e2ebe9] flex items-center gap-3">

                        <div class="size-10 rounded-xl bg-[#19183b] flex items-center justify-center">

                            <svg class="size-5 text-white"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M6.75 3v2.25M17.25 3v2.25M3 8.25h18M5.25 5.25h13.5A2.25 2.25 0 0121 7.5v11.25A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75V7.5a2.25 2.25 0 012.25-2.25z" />
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
                        <a href="{{ route('admin') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1
                           {{ request()->routeIs('admin')
                                ? 'bg-[#19183b] text-white'
                                : 'text-[#708993] hover:bg-[#f4f8f7]' }}">

                            <svg class="size-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 018.25 20.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                            </svg>

                            <span class="text-sm font-semibold">
                                Dashboard
                            </span>

                        </a>


                        {{-- FASILITAS --}}
                        <a href="{{ route('admin.facilities.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1
                           {{ request()->routeIs('admin.facilities.*')
                                ? 'bg-[#19183b] text-white'
                                : 'text-[#708993] hover:bg-[#f4f8f7]' }}">

                            <svg class="size-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M2.25 21h19.5M4.5 21V4.5A1.5 1.5 0 016 3h4.5a1.5 1.5 0 011.5 1.5V21m0-12h6a1.5 1.5 0 011.5 1.5V21M7.5 6h1.5m-1.5 3h1.5m-1.5 3h1.5m4.5-3h1.5m-1.5 3h1.5" />
                            </svg>

                            <span class="text-sm font-medium">
                                Fasilitas
                            </span>

                        </a>


                        {{-- PENGGUNA --}}
                        <a href="{{ route('admin.pengguna.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1
                           {{ request()->routeIs('admin.pengguna.*')
                                ? 'bg-[#19183b] text-white'
                                : 'text-[#708993] hover:bg-[#f4f8f7]' }}">

                            <svg class="size-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M4.5 20.25a7.5 7.5 0 0115 0" />
                            </svg>

                            <span class="text-sm font-medium">
                                Pengguna
                            </span>

                        </a>


                        {{-- LAPORAN --}}
                        <a href="{{ route('admin.rekap') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl
                           {{ request()->routeIs('admin.rekap')
                                ? 'bg-[#19183b] text-white'
                                : 'text-[#708993] hover:bg-[#f4f8f7]' }}">

                            <svg class="size-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
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


            {{-- =========================================================
                MAIN CONTENT
            ========================================================== --}}
            <main class="flex-1 min-w-0 px-8 py-8">

                {{-- HEADER --}}
                <div class="flex items-center justify-between mb-8">

                    <div>

                        <h1 class="font-extrabold text-[30px] tracking-[-0.75px] text-[#19183b]">
                            Kelola Fasilitas
                        </h1>

                        <p class="text-[14px] text-[#708993] mt-1">
                            Kelola data fasilitas yang tersedia di kampus.
                        </p>

                    </div>


                    {{-- TOMBOL TAMBAH --}}
                    <a href="{{ route('admin.facilities.create') }}"
                       class="inline-flex items-center gap-2
                              bg-[#19183b] text-white
                              px-4 py-2.5 rounded-xl
                              text-[13px] font-semibold
                              hover:opacity-90 transition">

                        <span class="text-lg leading-none">
                            +
                        </span>

                        Tambah Fasilitas

                    </a>

                </div>


                {{-- =====================================================
                    DAFTAR FASILITAS
                ====================================================== --}}
                <div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-sm overflow-hidden">


                    {{-- SEARCH + FILTER --}}
                    <div class="px-6 py-5 border-b border-[#eef1f1]">

                        <div class="flex flex-wrap items-center gap-2">


                            {{-- SEARCH --}}
                            <div class="relative flex-1 min-w-[280px]">

                                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 size-4 text-[#9aa9ad]"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="m21 21-4.35-4.35m1.35-5.15a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />

                                </svg>


                                <input
                                    type="text"
                                    id="searchFasilitas"
                                    placeholder="Cari ID, nama fasilitas, atau lokasi..."
                                    class="w-full h-11 pl-10 pr-4
                                           rounded-xl
                                           border border-[#e2ebe9]
                                           bg-white
                                           text-[14px] text-[#19183b]
                                           placeholder:text-[#9aa9ad]
                                           focus:border-[#19183b]
                                           focus:ring-0"
                                >

                            </div>


                            {{-- SEMUA --}}
                            <button
                                type="button"
                                data-filter="semua"
                                class="filter-status h-11 px-5 rounded-xl
                                       bg-[#19183b] text-white
                                       text-[13px] font-semibold
                                       transition">

                                Semua

                            </button>


                            {{-- TERSEDIA --}}
                            <button
                                type="button"
                                data-filter="tersedia"
                                class="filter-status h-11 px-5 rounded-xl
                                       bg-[#eef4f3] text-[#39735d]
                                       text-[13px] font-medium
                                       hover:bg-[#dff0ea]
                                       transition">

                                Tersedia

                            </button>


                            {{-- DALAM PERBAIKAN --}}
                            <button
                                type="button"
                                data-filter="dalam_perbaikan"
                                class="filter-status h-11 px-5 rounded-xl
                                       bg-[#fff7e5] text-[#a56a00]
                                       text-[13px] font-medium
                                       hover:bg-[#ffefc9]
                                       transition">

                                Dalam Perbaikan

                            </button>


                            {{-- NONAKTIF --}}
                            <button
                                type="button"
                                data-filter="nonaktif"
                                class="filter-status h-11 px-5 rounded-xl
                                       bg-[#f5f5f6] text-[#6b7280]
                                       text-[13px] font-medium
                                       hover:bg-[#e9e9eb]
                                       transition">

                                Nonaktif

                            </button>

                        </div>

                    </div>


                    {{-- =====================================================
                        TABEL
                    ====================================================== --}}
                    <div class="overflow-x-auto">

                        <table class="w-full text-[14px]">

                            <thead class="bg-[#fafbfb] border-b border-[#eef1f1]">

                                <tr class="text-left">

                                    <th class="px-6 py-4 text-[12px] font-bold uppercase tracking-wide text-[#8b9aa0]">
                                        ID Fasilitas
                                    </th>

                                    <th class="px-6 py-4 text-[12px] font-bold uppercase tracking-wide text-[#8b9aa0]">
                                        Fasilitas
                                    </th>

                                    <th class="px-6 py-4 text-[12px] font-bold uppercase tracking-wide text-[#8b9aa0]">
                                        Jenis
                                    </th>

                                    <th class="px-6 py-4 text-[12px] font-bold uppercase tracking-wide text-[#8b9aa0]">
                                        Lokasi
                                    </th>

                                    <th class="px-6 py-4 text-[12px] font-bold uppercase tracking-wide text-[#8b9aa0]">
                                        Kapasitas
                                    </th>

                                    <th class="px-6 py-4 text-[12px] font-bold uppercase tracking-wide text-[#8b9aa0]">
                                        Status
                                    </th>

                                    <th class="px-6 py-4 text-[12px] font-bold uppercase tracking-wide text-[#8b9aa0] text-center">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody id="tabelFasilitas"
                                   class="divide-y divide-[#eef1f1]">

                                @forelse ($fasilitas as $item)

                                    <tr
                                        class="baris-fasilitas hover:bg-[#fafcfc] transition"
                                        data-status="{{ $item->status }}"
                                        data-search="{{ strtolower($item->id . ' ' . $item->name . ' ' . $item->type . ' ' . $item->location) }}"
                                    >

                                        {{-- ID --}}
                                        <td class="px-6 py-5">

                                            <span class="font-semibold text-[14px] text-[#19183b]">
                                                F{{ str_pad($item->id, 2, '0', STR_PAD_LEFT) }}
                                            </span>

                                        </td>


                                        {{-- FASILITAS --}}
                                        <td class="px-6 py-5">

                                            <div class="flex items-center gap-3">

                                                <div class="size-10 rounded-full bg-[#e8eefc]
                                                            flex items-center justify-center
                                                            text-[13px] font-bold text-[#5269a8]">

                                                    {{ strtoupper(substr($item->name, 0, 1)) }}

                                                </div>

                                                <div>

                                                    <p class="font-semibold text-[14px] text-[#19183b]">
                                                        {{ $item->name }}
                                                    </p>

                                                    @if($item->description)

                                                        <p class="text-[12px] text-[#8b9aa0] mt-0.5 max-w-[240px] truncate">
                                                            {{ $item->description }}
                                                        </p>

                                                    @endif

                                                </div>

                                            </div>

                                        </td>


                                        {{-- JENIS --}}
                                        <td class="px-6 py-5 text-[14px] text-[#52636a] capitalize">

                                            {{ str_replace('_', ' ', $item->type) }}

                                        </td>


                                        {{-- LOKASI --}}
                                        <td class="px-6 py-5 text-[14px] text-[#52636a]">

                                            {{ $item->location }}

                                        </td>


                                        {{-- KAPASITAS --}}
                                        <td class="px-6 py-5 text-[14px] text-[#52636a]">

                                            {{ $item->capacity }} orang

                                        </td>


                                        {{-- STATUS --}}
                                        <td class="px-6 py-5">

                                            @if($item->status === 'tersedia')

                                                <span class="inline-flex items-center gap-1.5
                                                             px-3 py-1.5
                                                             rounded-full
                                                             bg-[#edf9f3]
                                                             border border-[#d4f0e1]
                                                             text-[#32966b]
                                                             text-[12px] font-semibold">

                                                    <span class="size-1.5 rounded-full bg-[#52b788]"></span>

                                                    Tersedia

                                                </span>

                                            @elseif($item->status === 'dalam_perbaikan')

                                                <span class="inline-flex items-center gap-1.5
                                                             px-3 py-1.5
                                                             rounded-full
                                                             bg-[#fff8e8]
                                                             border border-[#f9e9b8]
                                                             text-[#a56a00]
                                                             text-[12px] font-semibold">

                                                    <span class="size-1.5 rounded-full bg-[#e8a51b]"></span>

                                                    Perbaikan

                                                </span>

                                            @else

                                                <span class="inline-flex items-center gap-1.5
                                                             px-3 py-1.5
                                                             rounded-full
                                                             bg-[#f8f8f9]
                                                             border border-[#e8e8ea]
                                                             text-[#777b83]
                                                             text-[12px] font-semibold">

                                                    <span class="size-1.5 rounded-full bg-[#9ca3af]"></span>

                                                    Nonaktif

                                                </span>

                                            @endif

                                        </td>


                                        {{-- AKSI --}}
                                        <td class="px-6 py-5 text-center">

                                            <a href="{{ route('admin.facilities.edit', $item->id) }}"
                                               class="inline-flex items-center justify-center
                                                      px-3.5 py-2
                                                      rounded-lg
                                                      border border-[#e2ebe9]
                                                      bg-white
                                                      text-[12px] font-semibold
                                                      text-[#35454b]
                                                      hover:bg-[#f4f8f7]
                                                      transition">

                                                Detail

                                            </a>

                                        </td>

                                    </tr>


                                @empty

                                    <tr id="dataKosong">

                                        <td colspan="7"
                                            class="px-6 py-14 text-center">

                                            <p class="text-[15px] font-semibold text-[#19183b]">
                                                Belum ada data fasilitas.
                                            </p>

                                            <p class="text-[13px] text-[#708993] mt-1">
                                                Tambahkan fasilitas baru untuk menampilkannya di sini.
                                            </p>

                                        </td>

                                    </tr>

                                @endforelse


                                {{-- HASIL PENCARIAN KOSONG --}}
                                <tr id="hasilKosong" class="hidden">

                                    <td colspan="7"
                                        class="px-6 py-14 text-center">

                                        <p class="text-[15px] font-semibold text-[#19183b]">
                                            Fasilitas tidak ditemukan.
                                        </p>

                                        <p class="text-[13px] text-[#708993] mt-1">
                                            Coba gunakan kata kunci atau filter yang berbeda.
                                        </p>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>


                    {{-- =====================================================
                        FOOTER
                    ====================================================== --}}
                    <div class="px-6 py-5 border-t border-[#eef1f1]
                                flex items-center justify-between">

                        <p id="jumlahData"
                           class="text-[13px] text-[#708993]">

                            Menampilkan {{ $fasilitas->count() }} fasilitas

                        </p>


                        <div class="flex items-center gap-1">

                            <button
                                type="button"
                                class="size-9 rounded-lg
                                       border border-[#e2ebe9]
                                       text-[#9aa9ad]
                                       text-[14px]
                                       flex items-center justify-center">

                                ‹

                            </button>


                            <button
                                type="button"
                                class="size-9 rounded-lg
                                       bg-[#19183b] text-white
                                       text-[13px] font-semibold
                                       flex items-center justify-center">

                                1

                            </button>


                            <button
                                type="button"
                                class="size-9 rounded-lg
                                       border border-[#e2ebe9]
                                       text-[#52636a]
                                       text-[14px]
                                       flex items-center justify-center">

                                ›

                            </button>

                        </div>

                    </div>

                </div>

            </main>

        </div>

    </div>


    {{-- =========================================================
        SEARCH & FILTER
    ========================================================== --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const searchInput = document.getElementById('searchFasilitas');
            const filterButtons = document.querySelectorAll('.filter-status');
            const rows = document.querySelectorAll('.baris-fasilitas');
            const hasilKosong = document.getElementById('hasilKosong');
            const jumlahData = document.getElementById('jumlahData');

            let filterAktif = 'semua';


            function tampilkanData() {

                const keyword = searchInput.value.toLowerCase().trim();

                let jumlahTampil = 0;


                rows.forEach(function (row) {

                    const status = row.dataset.status;
                    const searchData = row.dataset.search;

                    const cocokSearch =
                        keyword === '' || searchData.includes(keyword);

                    const cocokFilter =
                        filterAktif === 'semua' ||
                        status === filterAktif;


                    if (cocokSearch && cocokFilter) {

                        row.classList.remove('hidden');

                        jumlahTampil++;

                    } else {

                        row.classList.add('hidden');

                    }

                });


                if (jumlahTampil === 0) {

                    hasilKosong.classList.remove('hidden');

                } else {

                    hasilKosong.classList.add('hidden');

                }


                jumlahData.textContent =
                    'Menampilkan ' + jumlahTampil + ' fasilitas';

            }


            searchInput.addEventListener('input', tampilkanData);


            filterButtons.forEach(function (button) {

                button.addEventListener('click', function () {

                    filterAktif = this.dataset.filter;


                    filterButtons.forEach(function (btn) {

                        btn.classList.remove(
                            'bg-[#19183b]',
                            'text-white'
                        );


                        if (btn.dataset.filter === 'tersedia') {

                            btn.classList.add(
                                'bg-[#eef4f3]',
                                'text-[#39735d]'
                            );

                        } else if (btn.dataset.filter === 'dalam_perbaikan') {

                            btn.classList.add(
                                'bg-[#fff7e5]',
                                'text-[#a56a00]'
                            );

                        } else if (btn.dataset.filter === 'nonaktif') {

                            btn.classList.add(
                                'bg-[#f5f5f6]',
                                'text-[#6b7280]'
                            );

                        }

                    });


                    this.classList.remove(
                        'bg-[#eef4f3]',
                        'text-[#39735d]',
                        'bg-[#fff7e5]',
                        'text-[#a56a00]',
                        'bg-[#f5f5f6]',
                        'text-[#6b7280]'
                    );


                    this.classList.add(
                        'bg-[#19183b]',
                        'text-white'
                    );


                    tampilkanData();

                });

            });

        });

    </script>

</x-app-layout>