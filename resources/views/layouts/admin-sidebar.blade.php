<aside class="w-[290px] shrink-0 bg-white border-r border-[#e2ebe9] flex flex-col justify-between">

    <div>

        <!-- BRAND -->
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


        <!-- NAVIGATION -->
        <nav class="px-4 pt-4">

            <p class="px-3 mb-3 text-[11px] font-bold uppercase tracking-wide text-[#708993]">
                Menu Utama
            </p>


            <!-- DASHBOARD -->
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


            <!-- FASILITAS -->
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


            <!-- PENGGUNA -->
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


            <!-- LAPORAN -->
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


    <!-- SYSTEM STATUS -->
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