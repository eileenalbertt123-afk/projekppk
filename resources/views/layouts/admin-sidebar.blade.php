<aside class="w-64 min-h-screen bg-white border-r border-gray-200 flex-shrink-0">

    {{-- LOGO --}}
    <div class="px-5 py-5 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#19183B] flex items-center justify-center text-white text-lg">
                📅
            </div>

            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-lg font-bold text-[#19183B]">
                        Book & Fix
                    </h1>

                    <span class="px-2 py-0.5 text-[10px] font-semibold rounded-md bg-gray-100 text-gray-600">
                        ADMIN
                    </span>
                </div>

                <p class="text-xs text-[#708993] mt-0.5">
                    Campus Facility Management
                </p>
            </div>
        </div>
    </div>

    {{-- MENU --}}
    <nav class="px-4 py-5">

        <p class="px-3 mb-4 text-[11px] font-medium tracking-wide text-[#708993] uppercase">
            Menu Utama
        </p>

        {{-- DASHBOARD --}}
        <a href="{{ route('admin') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl
                   text-[#708993] hover:bg-[#F4F8F7]
                   hover:text-[#19183B] transition">

            <span class="text-lg">🏠</span>
            <span class="text-sm">Dashboard</span>
        </a>

        {{-- FASILITAS --}}
        <a href="{{ route('admin.facilities.index') }}"
            class="flex items-center gap-3 px-4 py-3 mt-2 rounded-xl
                   bg-[#19183B] text-white font-semibold">

            <span class="text-lg">🏢</span>
            <span class="text-sm">Fasilitas</span>
        </a>

        {{-- PENGGUNA --}}
        <a href="{{ route('admin.pengguna.index') }}"
            class="flex items-center gap-3 px-4 py-3 mt-2 rounded-xl
                   text-[#708993] hover:bg-[#F4F8F7]
                   hover:text-[#19183B] transition">

            <span class="text-lg">👤</span>
            <span class="text-sm">Pengguna</span>
        </a>

        {{-- LAPORAN --}}
        <a href="{{ route('admin.rekap') }}"
            class="flex items-center gap-3 px-4 py-3 mt-2 rounded-xl
                   text-[#708993] hover:bg-[#F4F8F7]
                   hover:text-[#19183B] transition">

            <span class="text-lg">📊</span>
            <span class="text-sm">Laporan</span>
        </a>

    </nav>

</aside>