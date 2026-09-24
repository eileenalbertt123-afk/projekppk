<x-admin-layout>
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


            {{-- MAIN --}}
            <main class="flex-1 min-w-0 px-8 py-8">


                {{-- HEADER --}}
                <div class="flex items-center justify-between mb-10">

                    <div>

                        <h1 class="font-extrabold text-[30px] tracking-[-0.75px] text-[#19183b]">
                            Dashboard Admin
                        </h1>

                        <p class="text-sm text-[#708993] mt-1">
                            Kelola pengguna, fasilitas, dan laporan sistem.
                        </p>

                    </div>

                    <div class="bg-[#d1fae5] border border-[#a7f3d0] rounded-lg px-3.5 py-2 flex items-center gap-2">

                        <span class="size-2 rounded-full bg-[#059669]"></span>

                        <span class="text-xs font-semibold text-[#065f46]">
                            Sistem Aktif
                        </span>

                    </div>

                </div>


                {{-- STATISTIK --}}
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">


                    {{-- TOTAL FASILITAS --}}
                    <a href="{{ route('admin.facilities.index') }}"
                       class="bg-white border border-[#e2ebe9] rounded-2xl p-5 shadow-sm hover:shadow-md transition">

                        <div class="flex items-center justify-between">

                            <p class="text-sm text-[#708993] font-semibold">
                                Total Fasilitas
                            </p>

                            <div class="size-10 rounded-xl bg-[#eef4f3] flex items-center justify-center">

                                <svg class="size-5 text-[#19183b]"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M2.25 21h19.5M4.5 21V4.5A1.5 1.5 0 016 3h4.5a1.5 1.5 0 011.5 1.5V21m0-12h6a1.5 1.5 0 011.5 1.5V21" />
                                </svg>

                            </div>

                        </div>

                        <p class="mt-5 text-[30px] font-extrabold text-[#19183b]">
                            {{ $totalFasilitas }}
                        </p>

                        <p class="text-xs text-[#708993] mt-1">
                            Kelola fasilitas →
                        </p>

                    </a>


                    {{-- FASILITAS TERSEDIA --}}
                    <a href="{{ route('admin.facilities.index') }}"
                       class="bg-white border border-[#e2ebe9] rounded-2xl p-5 shadow-sm hover:shadow-md transition">

                        <div class="flex items-center justify-between">

                            <p class="text-sm text-[#708993] font-semibold">
                                Fasilitas Tersedia
                            </p>

                            <div class="size-10 rounded-xl bg-[#d1fae5] flex items-center justify-center">

                                <svg class="size-5 text-[#059669]"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M5 13l4 4L19 7" />
                                </svg>

                            </div>

                        </div>

                        <p class="mt-5 text-[30px] font-extrabold text-[#059669]">
                            {{ $fasilitasAktif }}
                        </p>

                        <p class="text-xs text-[#059669] mt-1">
                            Fasilitas dapat digunakan
                        </p>

                    </a>


                    {{-- MENUNGGU VERIFIKASI --}}
                    <a href="{{ route('admin.pengguna.index') }}"
                       class="bg-white border border-[#e2ebe9] rounded-2xl p-5 shadow-sm hover:shadow-md transition">

                        <div class="flex items-center justify-between">

                            <p class="text-sm text-[#708993] font-semibold">
                                Menunggu Verifikasi
                            </p>

                            <div class="size-10 rounded-xl bg-[#fef3c7] flex items-center justify-center">

                                <svg class="size-5 text-[#b45309]"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>

                            </div>

                        </div>

                        <p class="mt-5 text-[30px] font-extrabold text-[#b45309]">
                            {{ $menungguVerifikasi }}
                        </p>

                        <p class="text-xs text-[#b45309] mt-1">
                            Perlu ditinjau →
                        </p>

                    </a>


                    {{-- PERBAIKAN --}}
                    <a href="{{ route('admin.facilities.index') }}"
                       class="bg-white border border-[#e2ebe9] rounded-2xl p-5 shadow-sm hover:shadow-md transition">

                        <div class="flex items-center justify-between">

                            <p class="text-sm text-[#708993] font-semibold">
                                Dalam Perbaikan
                            </p>

                            <div class="size-10 rounded-xl bg-[#fee2e2] flex items-center justify-center">

                                <svg class="size-5 text-[#dc2626]"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a6 6 0 01-7.8 7.8L7 20.5a2.12 2.12 0 01-3-3l6.7-6.2a6 6 0 017.8-7.8l3.8-3.8z" />
                                </svg>

                            </div>

                        </div>

                        <p class="mt-5 text-[30px] font-extrabold text-[#dc2626]">
                            {{ $fasilitasPerbaikan }}
                        </p>

                        <p class="text-xs text-[#dc2626] mt-1">
                            Lihat fasilitas →
                        </p>

                    </a>

                </div>


                {{-- AKSI CEPAT --}}
                <div class="mb-8">

                    <h2 class="font-bold text-lg text-[#19183b]">
                        Aksi Cepat
                    </h2>

                    <p class="text-sm text-[#708993] mt-1 mb-5">
                        Akses menu administrasi yang sering digunakan.
                    </p>


                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">


                        {{-- FASILITAS --}}
                        <a href="{{ route('admin.facilities.index') }}"
                           class="bg-white border border-[#e2ebe9] rounded-2xl p-6 shadow-sm hover:-translate-y-0.5 hover:shadow-md transition">

                            <div class="flex justify-between items-center mb-6">

                                <div class="size-11 rounded-xl bg-[#eef4f3] flex items-center justify-center">

                                    <svg class="size-5 text-[#19183b]"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>

                                </div>

                                <span class="text-xl text-[#708993]">
                                    →
                                </span>

                            </div>

                            <h3 class="font-bold text-base text-[#19183b]">
                                Kelola Fasilitas
                            </h3>

                            <p class="text-sm text-[#708993] mt-1">
                                Tambah, edit, dan nonaktifkan fasilitas kampus.
                            </p>

                        </a>


                        {{-- PENGGUNA --}}
                        <a href="{{ route('admin.pengguna.index') }}"
                           class="bg-white border border-[#e2ebe9] rounded-2xl p-6 shadow-sm hover:-translate-y-0.5 hover:shadow-md transition">

                            <div class="flex justify-between items-center mb-6">

                                <div class="size-11 rounded-xl bg-[#fef3c7] flex items-center justify-center">

                                    <svg class="size-5 text-[#b45309]"
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

                                </div>

                                <span class="text-xl text-[#708993]">
                                    →
                                </span>

                            </div>

                            <h3 class="font-bold text-base text-[#19183b]">
                                Kelola Pengguna
                            </h3>

                            <p class="text-sm text-[#708993] mt-1">
                                Lihat dan kelola status akun pengguna.
                            </p>

                        </a>


                        {{-- REKAP --}}
                        <a href="{{ route('admin.rekap') }}"
                           class="bg-white border border-[#e2ebe9] rounded-2xl p-6 shadow-sm hover:-translate-y-0.5 hover:shadow-md transition">

                            <div class="flex justify-between items-center mb-6">

                                <div class="size-11 rounded-xl bg-[#e0f2fe] flex items-center justify-center">

                                    <svg class="size-5 text-[#0369a1]"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M3 3v18h18M7 16v-5m5 5V7m5 9v-8" />
                                    </svg>

                                </div>

                                <span class="text-xl text-[#708993]">
                                    →
                                </span>

                            </div>

                            <h3 class="font-bold text-base text-[#19183b]">
                                Rekap Penggunaan
                            </h3>

                            <p class="text-sm text-[#708993] mt-1">
                                Lihat penggunaan fasilitas berdasarkan periode.
                            </p>

                        </a>

                    </div>

                </div>


                {{-- RINGKASAN --}}
                <div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-sm p-6 mb-8">

                    <div class="flex items-center gap-3 mb-5">

                        <div class="size-9 rounded-lg bg-[#eef4f3] flex items-center justify-center">

                            <svg class="size-4 text-[#19183b]"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z" />
                            </svg>

                        </div>

                        <div>

                            <h2 class="font-bold text-base text-[#19183b]">
                                Ringkasan Admin
                            </h2>

                            <p class="text-xs text-[#708993]">
                                Pengelolaan sistem fasilitas kampus
                            </p>

                        </div>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div class="bg-[#f8faf9] border border-[#e2ebe9] rounded-xl p-4">

                            <p class="text-xs text-[#708993]">
                                Fasilitas Terdaftar
                            </p>

                            <p class="font-bold text-[#19183b] mt-1">
                                {{ $totalFasilitas }} fasilitas
                            </p>

                        </div>


                        <div class="bg-[#f8faf9] border border-[#e2ebe9] rounded-xl p-4">

                            <p class="text-xs text-[#708993]">
                                Fasilitas Siap Digunakan
                            </p>

                            <p class="font-bold text-[#059669] mt-1">
                                {{ $fasilitasAktif }} fasilitas
                            </p>

                        </div>


                        <div class="bg-[#f8faf9] border border-[#e2ebe9] rounded-xl p-4">

                            <p class="text-xs text-[#708993]">
                                Total Pengguna
                            </p>

                            <p class="font-bold text-[#19183b] mt-1">
                                {{ $totalPengguna }} pengguna
                            </p>

                        </div>

                    </div>

                </div>


                {{-- REKAP DETAIL --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">


                    {{-- REKAP PENGGUNAAN --}}
                    <div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-sm p-6">

                        <div class="flex items-center justify-between mb-6">

                            <div>

                                <h2 class="font-bold text-base text-[#19183b]">
                                    Rekap Penggunaan
                                </h2>

                                <p class="text-xs text-[#708993] mt-1">
                                    Penggunaan fasilitas berdasarkan reservasi.
                                </p>

                            </div>

                            <div class="size-9 rounded-lg bg-[#e0f2fe] flex items-center justify-center">

                                <svg class="size-4 text-[#0369a1]"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M3 3v18h18M7 16v-5m5 5V7m5 9v-8" />
                                </svg>

                            </div>

                        </div>

                        <div class="flex items-center justify-between py-3 border-b border-[#eef1f1]">

                            <span class="text-sm text-[#19183b]">
                                Total fasilitas
                            </span>

                            <span class="text-sm font-semibold text-[#708993]">
                                {{ $totalFasilitas }} fasilitas
                            </span>

                        </div>

                        <div class="flex items-center justify-between py-3">

                            <span class="text-sm text-[#19183b]">
                                Fasilitas tersedia
                            </span>

                            <span class="text-sm font-semibold text-[#059669]">
                                {{ $fasilitasAktif }} fasilitas
                            </span>

                        </div>

                        <a href="{{ route('admin.rekap') }}"
                           class="block mt-4 text-sm font-semibold text-[#19183b] hover:underline">
                            Lihat rekap lengkap →
                        </a>

                    </div>


                    {{-- REKAP KERUSAKAN --}}
                    <div class="bg-white border border-[#e2ebe9] rounded-2xl shadow-sm p-6">

                        <div class="flex items-center justify-between mb-6">

                            <div>

                                <h2 class="font-bold text-base text-[#19183b]">
                                    Rekap Kerusakan
                                </h2>

                                <p class="text-xs text-[#708993] mt-1">
                                    Fasilitas yang sedang dalam perbaikan.
                                </p>

                            </div>

                            <div class="size-9 rounded-lg bg-[#fee2e2] flex items-center justify-center">

                                <svg class="size-4 text-[#dc2626]"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a6 6 0 01-7.8 7.8L7 20.5a2.12 2.12 0 01-3-3l6.7-6.2a6 6 0 017.8-7.8l3.8-3.8z" />
                                </svg>

                            </div>

                        </div>

                        <div class="flex items-center justify-between py-3">

                            <span class="text-sm text-[#19183b]">
                                Dalam perbaikan
                            </span>

                            <span class="text-sm font-semibold text-[#dc2626]">
                                {{ $fasilitasPerbaikan }} fasilitas
                            </span>

                        </div>

                        <a href="{{ route('admin.facilities.index') }}"
                           class="block mt-4 text-sm font-semibold text-[#19183b] hover:underline">
                            Lihat fasilitas →
                        </a>

                    </div>

                </div>

            </main>

        </div>

    </div>

</x-admin-layout>