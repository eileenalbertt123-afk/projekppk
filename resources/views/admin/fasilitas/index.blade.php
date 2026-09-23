<x-app-layout>

    <div class="min-h-screen bg-[#f5f7f7]">

        <div class="flex min-h-screen">

            {{-- =========================================================
                SIDEBAR
            ========================================================== --}}
            @include('layouts.admin-sidebar')


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
                                        Foto
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


                                        {{-- FOTO --}}
                                        <td class="px-6 py-5">

                                            @if($item->image)

                                                <img
                                                    src="{{ asset('storage/' . $item->image) }}"
                                                    alt="{{ $item->name }}"
                                                    class="w-14 h-14 rounded-xl object-cover border border-[#e2ebe9]"
                                                >

                                            @else

                                                <div class="w-14 h-14 rounded-xl
                                                            bg-[#eef4f3]
                                                            border border-[#e2ebe9]
                                                            flex items-center justify-center
                                                            text-[#708993]">

                                                    <svg class="w-6 h-6"
                                                         fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke="currentColor"
                                                         stroke-width="1.7">

                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              d="m2.25 15.75 5.159-5.159a2.25 2.25 0 013.182 0l3.159 3.159m0 0 1.5-1.5a2.25 2.25 0 013.182 0L21.75 15.75M3 19.5h18A1.5 1.5 0 0022.5 18V6A1.5 1.5 0 0021 4.5H3A1.5 1.5 0 001.5 6v12A1.5 1.5 0 003 19.5z" />

                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              d="M8.25 9.75h.008v.008H8.25V9.75z" />

                                                    </svg>

                                                </div>

                                            @endif

                                        </td>


                                        {{-- FASILITAS --}}
                                        <td class="px-6 py-5">

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

                                        <td colspan="8"
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

                                    <td colspan="8"
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