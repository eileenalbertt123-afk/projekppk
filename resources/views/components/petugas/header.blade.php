<header class="w-full bg-white border-b border-[#e2ebe9] flex items-center justify-between px-3 sm:px-6 lg:px-8 h-16 sm:h-[80px] gap-2 sm:gap-4 sticky top-0 z-40">

    {{-- Tombol Menu --}}
    <div class="flex items-center gap-3">
        <button id="sidebarToggle"
            class="flex items-center gap-2 px-2.5 py-2 sm:px-3 border border-[#e2ebe9] rounded-lg text-sm text-[#19183b]">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <span class="hidden sm:inline">Menu</span>
        </button>
    </div>

    {{-- Segmented Tabs --}}
    <div class="bg-[#eef4f3] border border-[rgba(186,205,201,0.5)] rounded-xl p-1 sm:p-[5px] flex items-center gap-1 sm:gap-2 min-w-0">
        @php
        $tabs = [
        [
        'label' => 'Reservasi',
        'route' => 'petugas.reservasi.dashboard',
        'active' => request()->routeIs('petugas.reservasi.*'),
        ],
        [
        'label' => 'Laporan',
        'route' => 'petugas.laporan.dashboard',
        'active' => request()->routeIs('petugas.laporan.*', 'petugas.fasilitas.*'),
        ],
        ];
        @endphp
        @foreach ($tabs as $tab)
        <a href="{{ Route::has($tab['route']) ? route($tab['route']) : '#' }}"
            class="rounded-lg px-3 py-1.5 sm:px-5 sm:py-2 text-xs sm:text-sm leading-5 text-center whitespace-nowrap transition
                    {{ $tab['active']
                        ? 'bg-[#19183b] text-white font-semibold shadow-sm'
                        : 'font-medium text-[#708993] hover:bg-white/70'
                    }}">
            {{ $tab['label'] }}
        </a>
        @endforeach
    </div>

    {{-- User Profile --}}
    <div class="flex items-center gap-3 shrink-0">
        <p class="hidden md:block text-sm font-medium text-[#708993]">
            Halo,
            <span class="font-bold text-[#19183b]">{{ ucfirst(auth()->user()->name) }}</span>
        </p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="md:ml-3 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full border border-[#f4b6c2] text-[#e85b6f] text-xs sm:text-sm font-semibold hover:bg-[#e85b6f] hover:text-white transition">
                Keluar
            </button>
        </form>
    </div>

</header>