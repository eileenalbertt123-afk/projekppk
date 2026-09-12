    <aside class="bg-white border-r border-[#e2ebe9] w-[288px] flex flex-col justify-between shrink-0">
        <div>
            {{-- Brand Logo Header --}}
            <div class="flex items-center gap-3 h-[80px] px-6 border-b border-[#e2ebe9]">
                <div class="bg-[#19183b] rounded-xl size-10 flex items-center justify-center shadow-[0px_4px_6px_-1px_rgba(25,24,59,0.2),0px_2px_4px_-2px_rgba(25,24,59,0.2)]">
                    <svg class="size-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 14.25l2.25 2.25 5.25-5.25" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <p class="font-extrabold text-[20px] tracking-[-0.5px] text-[#19183b] leading-[28px]">
                            Book<span class="text-[#708993]">&amp;</span>Fix
                        </p>
                        <span class="bg-[#eef4f3] border border-[#bacdc9] rounded px-[7px] py-[3px] text-[10px] font-bold uppercase tracking-[0.5px] text-[#19183b] leading-[15px]">
                            petugas
                        </span>
                    </div>
                    <p class="text-[11px] font-medium text-[#708993] leading-4">Campus Facility Management</p>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex flex-col gap-1.5 px-4 pt-[15px] pb-4">
                <p class="px-3 pb-2 text-[11px] font-bold uppercase tracking-[0.55px] text-[#708993]">Menu Utama</p>

                @php
                    $navItems = [
                        [
                            'label' => 'Dashboard',
                            'route' => 'petugas.dashboard',
                            'active' => true,
                            'badge' => null,
                            'icon' => 'grid',
                        ],
                        [
                            'label' => 'Daftar Reservasi',
                            'route' => 'petugas.reservasi.index',
                            'active' => false,
                            'badge' => $reservasiBaruCount ?? 3,
                            'icon' => 'clipboard',
                        ],
                        [
                            'label' => 'Jadwal',
                            'route' => 'petugas.jadwal.index',
                            'active' => false,
                            'badge' => null,
                            'icon' => 'calendar',
                        ],
                    ];
                @endphp

                @foreach ($navItems as $item)
                    <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                       class="flex items-center justify-between gap-3.5 rounded-xl px-3.5 py-3 w-full
                              {{ $item['active'] ? 'bg-[#19183b] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)]' : '' }}">
                        <span class="flex items-center gap-3.5">
                            <svg class="size-5 shrink-0 {{ $item['active'] ? 'text-white' : 'text-[#708993]' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                @if ($item['icon'] === 'grid')
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                @elseif ($item['icon'] === 'clipboard')
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 13.5l2.25 2.25 4.5-4.5" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                @endif
                            </svg>
                            <span class="text-sm leading-5 whitespace-nowrap {{ $item['active'] ? 'font-semibold text-white' : 'font-medium text-[#708993]' }}">
                                {{ $item['label'] }}
                            </span>
                        </span>

                        @if ($item['badge'])
                            <span class="bg-[#fef3c7] rounded-full px-2 py-0.5 text-xs font-semibold text-[#92400e] leading-4 whitespace-nowrap">
                                {{ $item['badge'] }} Baru
                            </span>
                        @endif
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- Sidebar bottom status --}}
        <div class="p-4">
            <div class="bg-[#eef4f3] border border-[#e2ebe9] rounded-2xl p-[17px] flex items-center gap-3">
                <span class="relative flex size-3 shrink-0">
                    <span class="absolute inline-flex h-full w-full rounded-full bg-[#34d399] opacity-75"></span>
                    <span class="relative inline-flex rounded-full size-3 bg-[#10b981]"></span>
                </span>
                <div>
                    <p class="text-xs font-semibold text-[#19183b] leading-4">
                        {{ $systemStatusTitle ?? 'Sistem Booking Aktif' }}
                    </p>
                    <p class="text-[11px] font-normal text-[#708993] leading-4">
                        {{ $systemStatusSubtitle ?? 'Server Kampus Normal' }}
                    </p>
                </div>
            </div>
        </div>
    </aside>