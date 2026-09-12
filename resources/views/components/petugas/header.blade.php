        <header class="bg-white border-b border-[#e2ebe9] flex items-center justify-between px-8 h-[80px]">
            {{-- Segmented view tabs --}}
            <div class="bg-[#eef4f3] border border-[rgba(186,205,201,0.5)] rounded-xl p-[5px] flex items-center gap-2">
                @php
                    $tabs = [
                        ['label' => 'All', 'active' => false],
                        ['label' => 'Reservasi', 'active' => true],
                        ['label' => 'Laporan', 'active' => false],
                    ];
                @endphp
                @foreach ($tabs as $tab)
                    <button type="button"
                        class="rounded-lg px-5 py-2 text-sm leading-5 text-center whitespace-nowrap
                               {{ $tab['active']
                                    ? 'bg-white border border-[#bacdc9] font-semibold text-[#19183b] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)]'
                                    : 'font-medium text-[#708993]' }}">
                        {{ $tab['label'] }}
                    </button>
                @endforeach
            </div>

            {{-- User profile --}}
            <div class="flex items-center gap-4">
                <span class="bg-[#e2ebe9] h-8 w-px"></span>
                <div class="flex items-center gap-3">
                    <div class="relative bg-[#19183b] border border-[#19183b] rounded-xl size-10 flex items-center justify-center shadow-[0px_0px_0px_2px_rgba(161,194,189,0.4)]">
                        <span class="text-base font-bold text-white leading-6 text-center">
                            {{ $petugas->initials ?? 'KP' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-[#19183b] leading-[17.5px]">
                            {{ $petugas->name ?? 'Kirana Puspa' }}
                        </p>
                        <p class="text-xs font-medium text-[#708993] leading-4">
                            {{ $petugas->role ?? 'Petugas 1' }}
                        </p>
                    </div>
                    <button type="button" class="pl-1">
                        <svg class="size-4 text-[#708993]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </div>
            </div>
        </header>