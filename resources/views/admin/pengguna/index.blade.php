<x-app-layout>

    <div class="min-h-screen bg-[#f5f7f7]">

        <div class="flex min-h-screen">

            {{-- SIDEBAR --}}
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

                                <path
                                    stroke-linecap="round"
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

                                <path
                                    stroke-linecap="round"
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
                            Kelola Pengguna
                        </h1>

                        <p class="text-sm text-[#708993] mt-1">
                            Kelola akun pengguna dalam sistem.
                        </p>

                    </div>

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

            </main>

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

</x-app-layout>