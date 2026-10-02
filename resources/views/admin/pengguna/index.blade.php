@extends('layouts.admin')

@section('content')

    <div class="min-h-full">

        <div class="px-8 py-8">

            {{-- HEADER --}}
            <div class="flex items-center justify-between mb-8">

                <div>

                    <h1 class="font-extrabold text-[30px] tracking-[-0.75px] text-[#19183b]">
                        Kelola Pengguna
                    </h1>

                    <p class="text-sm text-[#708993] mt-1">
                        Kelola akun pengguna dalam sistem.
                    </p>

                </div>


                {{-- TAMBAH PETUGAS --}}
                <a
                    href="{{ route('admin.pengguna.create.petugas') }}"
                    class="inline-flex items-center gap-2
                           px-4 py-2.5
                           rounded-xl
                           bg-[#19183b]
                           text-white
                           text-sm font-semibold
                           hover:bg-[#292850]
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
                            d="M12 5v14M5 12h14" />

                    </svg>

                    Tambah Petugas

                </a>

            </div>


            {{-- ALERT --}}
            @if(session('success'))

                <div class="mb-6 rounded-xl bg-green-50 border border-green-200
                            px-4 py-3 text-sm text-green-700">

                    {{ session('success') }}

                </div>

            @endif


            {{-- TABEL PENGGUNA --}}
            <div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-sm overflow-hidden">


                {{-- SEARCH & FILTER --}}
                <div class="px-4 py-4 border-b border-[#eef1f1]">

                    <div class="flex items-center gap-2 flex-wrap">


                        {{-- SEARCH --}}
                        <div class="relative flex-1 min-w-[220px]">

                            <svg
                                class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-[#9aaab0]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m21 21-4.35-4.35m1.35-5.15a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />

                            </svg>

                            <input
                                type="text"
                                id="searchPengguna"
                                placeholder="Cari nama, email, atau tipe pengguna..."
                                class="w-full pl-9 pr-4 py-2.5 rounded-lg
                                       border border-[#e2e8e7]
                                       text-xs text-[#19183b]
                                       placeholder:text-[#9aaab0]
                                       focus:outline-none
                                       focus:ring-1 focus:ring-[#19183b]
                                       focus:border-[#19183b]">

                        </div>


                        {{-- SEMUA --}}
                        <button
                            type="button"
                            data-filter="semua"
                            class="filter-btn px-3 py-2 rounded-lg
                                   bg-[#19183b] text-white
                                   text-xs font-semibold">

                            Semua

                        </button>


                        {{-- MENUNGGU --}}
                        <button
                            type="button"
                            data-filter="menunggu"
                            class="filter-btn px-3 py-2 rounded-lg
                                   bg-[#fffaf0] text-[#b77900]
                                   border border-[#f3e4b7]
                                   text-xs font-medium">

                            Menunggu

                        </button>


                        {{-- DIVERIFIKASI --}}
                        <button
                            type="button"
                            data-filter="diverifikasi"
                            class="filter-btn px-3 py-2 rounded-lg
                                   bg-[#f0faf5] text-[#24865b]
                                   border border-[#d4eee1]
                                   text-xs font-medium">

                            Diverifikasi

                        </button>


                        {{-- DITOLAK --}}
                        <button
                            type="button"
                            data-filter="ditolak"
                            class="filter-btn px-3 py-2 rounded-lg
                                   bg-[#fff4f5] text-[#c94b5b]
                                   border border-[#f2d8dc]
                                   text-xs font-medium">

                            Ditolak

                        </button>


                        {{-- FILTER LANJUTAN --}}
                        <button
                            type="button"
                            class="px-3 py-2 rounded-lg
                                   border border-[#dfe7e6]
                                   text-xs font-medium text-[#52656d]
                                   hover:bg-[#f7f9f9]
                                   flex items-center gap-1.5">

                            <svg
                                class="size-3.5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 5h18M6 12h12m-9 7h6" />

                            </svg>

                            Filter Lanjutan

                        </button>

                    </div>

                </div>


                {{-- TABLE --}}
                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead class="bg-[#fbfcfc]">

                            <tr>

                                <th class="px-5 py-4 text-left text-[11px] uppercase tracking-wide font-bold text-[#93a3aa]">
                                    Nama
                                </th>

                                <th class="px-5 py-4 text-left text-[11px] uppercase tracking-wide font-bold text-[#93a3aa]">
                                    Email
                                </th>

                                <th class="px-5 py-4 text-left text-[11px] uppercase tracking-wide font-bold text-[#93a3aa]">
                                    Tipe Pengguna
                                </th>

                                <th class="px-5 py-4 text-left text-[11px] uppercase tracking-wide font-bold text-[#93a3aa]">
                                    Role
                                </th>

                                <th class="px-5 py-4 text-left text-[11px] uppercase tracking-wide font-bold text-[#93a3aa]">
                                    Status
                                </th>

                                <th class="px-5 py-4 text-left text-[11px] uppercase tracking-wide font-bold text-[#93a3aa]">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody
                            id="penggunaTable"
                            class="divide-y divide-[#eef1f1]">

                            @forelse($pengguna as $item)

                                <tr
                                    class="pengguna-row hover:bg-[#fafcfc] transition"
                                    data-status="{{ $item->status_verifikasi }}"
                                    data-search="{{ strtolower(
                                        $item->name . ' ' .
                                        $item->email . ' ' .
                                        ($item->userType->name ?? '') . ' ' .
                                        $item->role
                                    ) }}">


                                    {{-- NAMA --}}
                                    <td class="px-5 py-4">

                                        <div class="flex items-center gap-3">

                                            <div class="size-9 rounded-full
                                                        bg-[#eef2ff]
                                                        text-[#5965c4]
                                                        flex items-center justify-center
                                                        text-[11px] font-bold shrink-0">

                                                {{ strtoupper(substr($item->name, 0, 2)) }}

                                            </div>

                                            <div>

                                                <p class="font-semibold text-[14px] text-[#19183b]">
                                                    {{ $item->name }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- EMAIL --}}
                                    <td class="px-5 py-4 text-[13px] text-[#708993]">

                                        {{ $item->email }}

                                    </td>


                                    {{-- TIPE PENGGUNA --}}
                                    <td class="px-5 py-4 text-[13px] text-[#708993]">

                                        @if($item->userType)

                                            {{ ucfirst($item->userType->name) }}

                                        @else

                                            -

                                        @endif

                                    </td>


                                    {{-- ROLE --}}
                                    <td class="px-5 py-4">

                                        @if($item->role === 'admin')

                                            <span class="px-2.5 py-1 rounded-full
                                                         text-[11px] font-medium
                                                         bg-purple-50 text-purple-700
                                                         border border-purple-100">

                                                Admin

                                            </span>

                                        @elseif($item->role === 'petugas')

                                            <span class="px-2.5 py-1 rounded-full
                                                         text-[11px] font-medium
                                                         bg-blue-50 text-blue-700
                                                         border border-blue-100">

                                                Petugas

                                            </span>

                                        @else

                                            <span class="px-2.5 py-1 rounded-full
                                                         text-[11px] font-medium
                                                         bg-gray-50 text-gray-600
                                                         border border-gray-100">

                                                Pengguna

                                            </span>

                                        @endif

                                    </td>


                                    {{-- STATUS --}}
                                    <td class="px-5 py-4">

                                        @if($item->status_verifikasi === 'menunggu')

                                            <span class="inline-flex items-center gap-1.5
                                                         px-2.5 py-1 rounded-full
                                                         text-[11px] font-medium
                                                         bg-[#fffaf0] text-[#b77900]
                                                         border border-[#f3e4b7]">

                                                <span class="size-1.5 rounded-full bg-[#e6a51d]"></span>

                                                Menunggu

                                            </span>

                                        @elseif($item->status_verifikasi === 'diverifikasi')

                                            <span class="inline-flex items-center gap-1.5
                                                         px-2.5 py-1 rounded-full
                                                         text-[11px] font-medium
                                                         bg-[#f0faf5] text-[#24865b]
                                                         border border-[#d4eee1]">

                                                <span class="size-1.5 rounded-full bg-[#55b985]"></span>

                                                Diverifikasi

                                            </span>

                                        @else

                                            <span class="inline-flex items-center gap-1.5
                                                         px-2.5 py-1 rounded-full
                                                         text-[11px] font-medium
                                                         bg-[#fff4f5] text-[#c94b5b]
                                                         border border-[#f2d8dc]">

                                                <span class="size-1.5 rounded-full bg-[#d86673]"></span>

                                                Ditolak

                                            </span>

                                        @endif

                                    </td>


                                    {{-- AKSI --}}
                                    <td class="px-5 py-4">

                                        <div class="flex items-center gap-1.5">


                                            {{-- MENUNGGU --}}
                                            @if($item->status_verifikasi === 'menunggu')


                                                {{-- VERIFIKASI --}}
                                                <form
                                                    action="{{ route('admin.pengguna.verifikasi', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin memverifikasi pengguna ini?')">

                                                    @csrf
                                                    @method('PUT')

                                                    <button
                                                        type="submit"
                                                        title="Verifikasi pengguna"
                                                        class="size-9 rounded-lg
                                                               flex items-center justify-center
                                                               bg-green-50 text-green-600
                                                               hover:bg-green-100
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
                                                                d="M5 12.5l4 4L19 7" />

                                                        </svg>

                                                    </button>

                                                </form>


                                                {{-- TOLAK --}}
                                                <form
                                                    action="{{ route('admin.pengguna.tolak', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menolak pengguna ini?')">

                                                    @csrf
                                                    @method('PUT')

                                                    <button
                                                        type="submit"
                                                        title="Tolak pengguna"
                                                        class="size-9 rounded-lg
                                                               flex items-center justify-center
                                                               bg-red-50 text-red-600
                                                               hover:bg-red-100
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
                                                                d="M6 6l12 12M6 18L18 6" />

                                                        </svg>

                                                    </button>

                                                </form>


                                            {{-- DIVERIFIKASI --}}
                                            @elseif($item->status_verifikasi === 'diverifikasi')


                                                <form
                                                    action="{{ route('admin.pengguna.status', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin mengubah status akun ini?')">

                                                    @csrf
                                                    @method('PUT')


                                                    @if($item->status_akun === 'aktif')

                                                        <input
                                                            type="hidden"
                                                            name="status_akun"
                                                            value="nonaktif">

                                                        <button
                                                            type="submit"
                                                            title="Nonaktifkan akun"
                                                            class="size-9 rounded-lg
                                                                   flex items-center justify-center
                                                                   bg-red-50 text-red-600
                                                                   hover:bg-red-100
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
                                                                    d="M6 6l12 12M6 18L18 6" />

                                                            </svg>

                                                        </button>

                                                    @else

                                                        <input
                                                            type="hidden"
                                                            name="status_akun"
                                                            value="aktif">

                                                        <button
                                                            type="submit"
                                                            title="Aktifkan akun"
                                                            class="size-9 rounded-lg
                                                                   flex items-center justify-center
                                                                   bg-green-50 text-green-600
                                                                   hover:bg-green-100
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
                                                                    d="M5 12.5l4 4L19 7" />

                                                            </svg>

                                                        </button>

                                                    @endif

                                                </form>


                                            {{-- DITOLAK --}}
                                            @else

                                                <span
                                                    class="text-[12px] text-[#9aaab0]"
                                                    title="Pengguna ditolak">

                                                    Ditolak

                                                </span>

                                            @endif

                                        </div>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="px-6 py-12 text-center text-sm text-[#708993]">

                                        Belum ada data pengguna.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- FOOTER --}}
                <div class="px-4 py-3 border-t border-[#eef1f1]
                            flex items-center justify-between">

                    <p class="text-xs text-[#708993]">

                        Menampilkan

                        <span
                            id="jumlahPengguna"
                            class="font-semibold text-[#19183b]">

                            {{ $pengguna->count() }}

                        </span>

                        pengguna

                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- SEARCH & FILTER SCRIPT --}}
    <script>

        const searchInput = document.getElementById('searchPengguna');

        const rows = document.querySelectorAll('.pengguna-row');

        const filterButtons = document.querySelectorAll('.filter-btn');

        const jumlahPengguna = document.getElementById('jumlahPengguna');

        let currentFilter = 'semua';


        function filterPengguna() {

            const keyword = searchInput.value.toLowerCase().trim();

            let jumlah = 0;


            rows.forEach(row => {

                const status = row.dataset.status;

                const searchText = row.dataset.search;


                const cocokSearch =
                    searchText.includes(keyword);


                const cocokFilter =
                    currentFilter === 'semua' ||
                    status === currentFilter;


                if (cocokSearch && cocokFilter) {

                    row.style.display = '';

                    jumlah++;

                } else {

                    row.style.display = 'none';

                }

            });


            jumlahPengguna.textContent = jumlah;

        }


        searchInput.addEventListener(
            'input',
            filterPengguna
        );


        filterButtons.forEach(button => {

            button.addEventListener(
                'click',
                function () {

                    currentFilter =
                        this.dataset.filter;


                    filterButtons.forEach(btn => {

                        btn.classList.remove(
                            'bg-[#19183b]',
                            'text-white'
                        );

                    });


                    this.classList.add(
                        'bg-[#19183b]',
                        'text-white'
                    );


                    filterPengguna();

                }
            );

        });

    </script>

@endsection
