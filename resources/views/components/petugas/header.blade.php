        <header class="w-full bg-white border-b border-[#e2ebe9] flex items-center justify-between px-4 sm:px-6 lg:px-8 h-[80px] gap-4">
            {{-- Segmented view tabs --}}
            <div class="bg-[#eef4f3] border border-[rgba(186,205,201,0.5)] rounded-xl p-[5px] flex items-center gap-2 shrink-0">
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
                            'active' => request()->routeIs('petugas.laporan.*', 'petugas.fasilitas.*' ),
                        ],
                    ];
                @endphp
                @foreach ($tabs as $tab)
                    <a
                        href="{{ Route::has($tab['route']) ? route($tab['route']) : '#' }}"
                        class="rounded-lg px-5 py-2 text-sm leading-5 text-center whitespace-nowrap transition
                            {{ $tab['active']
                                ? 'bg-[#19183b] text-white font-semibold shadow-sm'
                                : 'font-medium text-[#708993] hover:bg-white/70'
                            }}"
                    >
                        {{ $tab['label'] }}
                    </a>
                @endforeach
            </div>

            {{-- User profile --}}
        @php
            $user = auth()->user();

            $initials = $user
                ? \Illuminate\Support\Str::of($user->name)
                    ->explode(' ')
                    ->filter()
                    ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                    ->take(2)
                    ->implode('')
                : '?';
        @endphp

        <div class="flex items-center gap-4 shrink-0">

            <span class="bg-[#e2ebe9] h-8 w-px"></span>

            <div class="flex items-center gap-3">

                {{-- Initial --}}
                <div class="relative bg-[#19183b] border border-[#19183b]
                            rounded-xl size-10 flex items-center justify-center
                            shadow-[0px_0px_0px_2px_rgba(161,194,189,0.4)]">

                    <span class="text-base font-bold text-white leading-6 text-center">
                        {{ $initials }}
                    </span>

                </div>

                {{-- User --}}
                <div>

                    <p class="text-sm font-bold text-[#19183b] leading-[17.5px]">
                        {{ $user?->name ? \Illuminate\Support\Str::title($user->name) : '-' }}
                    </p>

                    <p class="text-xs font-medium text-[#708993] leading-4 capitalize">
                        {{ $user?->role ?? '-' }}
                    </p>

                </div>

                <button type="button" class="pl-1">
                    <svg class="size-4 text-[#708993]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

            </div>

        </div>
</header>