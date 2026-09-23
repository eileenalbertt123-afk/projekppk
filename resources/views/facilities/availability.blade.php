@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto" x-data="{ 
    currentDate: '{{ $date }}',
    formattedDate: '{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}',
    slots: {{ json_encode($slots) }},
    loading: false,
    selectedSlots: [],

    // Fungsi Fetch API untuk muat slot tanpa full reload
    async fetchSlots(newDate) {
        if (this.currentDate === newDate && !this.loading) return;
        this.loading = true;
        this.selectedSlots = []; // Reset pilihan slot saat pindah tanggal

        try {
            let response = await fetch(`{{ route('api.facilities.slots', $facility->id) }}?date=${newDate}`);
            let data = await response.json();
            this.slots = data.slots;
            this.currentDate = data.date;
            this.formattedDate = data.formatted_date;
        } catch (e) {
            console.error('Gagal memuat slot:', e);
        } finally {
            this.loading = false;
        }
    },

    toggleSlot(slotKey, isSelectable) {
        if (!isSelectable) return; // Mencegah klik jika slot tidak tersedia / lewat
        
        if (this.selectedSlots.includes(slotKey)) {
            this.selectedSlots = this.selectedSlots.filter(s => s !== slotKey);
        } else {
            this.selectedSlots.push(slotKey);
            this.selectedSlots.sort(); // Mengurutkan slot berurutan
        }
    },
    get startTime() {
        if (this.selectedSlots.length === 0) return '';
        return this.selectedSlots[0].split(' - ')[0];
    },
    get endTime() {
        if (this.selectedSlots.length === 0) return '';
        return this.selectedSlots[this.selectedSlots.length - 1].split(' - ')[1];
    },
    get totalDuration() {
        return (this.selectedSlots.length * 30) + ' Menit (' + this.selectedSlots.length + ' Slot)';
    }
}">
    <!-- Tombol Kembali -->
    <a href="{{ route('home') }}" class="text-brand-primary text-sm font-medium hover:underline mb-4 inline-block">&larr; Kembali ke Daftar Fasilitas</a>

    <!-- Foto Fasilitas -->
    <div class="h-72 rounded-2xl overflow-hidden bg-gradient-to-br from-brand-secondary/25 to-brand-tertiary/25 mb-6">
        @if ($facility->image)
            <img src="{{ asset('storage/' . $facility->image) }}" alt="{{ $facility->name }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex flex-col items-center justify-center gap-1 text-brand-secondary">
                <svg class="w-10 h-10 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-sm font-medium">Tidak ada gambar</span>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_380px] gap-6">

        <!-- KIRI: INFO RUANGAN -->
        <div>
            <div class="flex items-center justify-between gap-4 mb-4">
                <h1 class="text-2xl font-extrabold text-brand-primary">{{ $facility->name }}</h1>
                <span class="px-3 py-1 rounded-full text-xs font-semibold border shadow-sm shrink-0 {{ $facility->status === 'tersedia' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-600 border-rose-200' }}">
                    {{ [
                        'tersedia' => 'Tersedia',
                        'dalam_perbaikan' => 'Dalam Perbaikan',
                        'nonaktif' => 'Nonaktif',
                    ][$facility->status] ?? ucfirst($facility->status) }}
                </span>
            </div>

            <!-- Badge Info -->
            <div class="grid grid-cols-3 gap-3 mb-6">
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-3">
                    <span class="text-[10px] font-semibold text-blue-600 uppercase tracking-wider block mb-0.5">Tipe</span>
                    <span class="text-sm font-bold text-brand-primary">{{ ucfirst($facility->type) }}</span>
                </div>
                <div class="bg-amber-50 border border-amber-100 rounded-xl p-3">
                    <span class="text-[10px] font-semibold text-amber-600 uppercase tracking-wider block mb-0.5">Lokasi</span>
                    <span class="text-sm font-bold text-brand-primary">{{ $facility->location }}</span>
                </div>
                <div class="bg-purple-50 border border-purple-100 rounded-xl p-3">
                    <span class="text-[10px] font-semibold text-purple-600 uppercase tracking-wider block mb-0.5">Kapasitas</span>
                    <span class="text-sm font-bold text-brand-primary">{{ $facility->capacity }} Orang</span>
                </div>
            </div>

            @if ($facility->description)
            <div class="mb-6">
                <h3 class="font-bold text-brand-primary mb-2">Tentang Ruangan</h3>
                <p class="text-sm text-brand-secondary leading-relaxed">{{ $facility->description }}</p>
            </div>
            @endif

            @if ($facility->equipment && count($facility->equipment))
            <div>
                <h3 class="font-bold text-brand-primary mb-3">Fasilitas & Peralatan</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach ($facility->equipment as $item)
                        <span class="inline-flex items-center gap-1.5 bg-white border border-gray-200 text-brand-primary text-xs font-medium px-3 py-1.5 rounded-lg shadow-2xs">
                            <span class="text-emerald-600">✓</span> {{ $item }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- KANAN: PILIH TANGGAL & JAM (DENGAN FLOATING ACTION BAR) -->
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm relative flex flex-col h-[560px]">
            
            <!-- Header Judul (Tetap diam di atas) -->
            <div class="shrink-0 mb-4">
                <h3 class="text-lg font-bold text-brand-primary mb-0.5">Pilih Tanggal & Jam</h3>
                <p class="text-xs text-brand-secondary">Anda dapat memilih beberapa slot sekaligus untuk menentukan rentang sewa.</p>
            </div>

            <!-- Tab Kalender 7 Hari + Tombol More (Tetap diam di atas) -->
            <div class="shrink-0 flex items-center gap-1.5 mb-4">
                <button class="w-6 h-8 flex items-center justify-center text-brand-secondary hover:text-brand-primary shrink-0">◀</button>

                <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-hide flex-1 items-center">
                    @foreach ($days as $d)
                        <button 
                            type="button"
                            @click="fetchSlots('{{ $d['key'] }}')"
                            :class="currentDate === '{{ $d['key'] }}' 
                                ? 'bg-brand-primary border-brand-primary text-white shadow-sm' 
                                : 'bg-white border-gray-200 text-brand-secondary hover:border-brand-primary hover:text-brand-primary'"
                            class="flex flex-col items-center justify-center w-12 h-14 rounded-xl border shrink-0 transition-all cursor-pointer">
                            <span class="text-[10px] font-medium">{{ $d['day'] }}</span>
                            <span class="text-sm font-bold">{{ $d['date'] }}</span>
                        </button>
                    @endforeach

                    <!-- Tombol More -->
                    <div class="relative flex flex-col items-center justify-center w-12 h-14 rounded-xl border border-dashed border-gray-300 bg-brand-neutral text-brand-secondary hover:border-brand-primary hover:text-brand-primary transition shrink-0 cursor-pointer overflow-hidden">
                        <svg class="w-4 h-4 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-[9px] font-bold">More</span>
                        <input type="date" class="absolute inset-0 opacity-0 cursor-pointer" @change="fetchSlots($event.target.value)">
                    </div>
                </div>

                <button class="w-6 h-8 flex items-center justify-center text-brand-secondary hover:text-brand-primary shrink-0">▶</button>
            </div>

            <p class="shrink-0 text-xs text-brand-secondary mb-3">Slots for: <strong class="text-brand-primary" x-text="formattedDate"></strong></p>

            <!-- Loading Indicator Sederhana -->
            <div x-show="loading" class="py-12 text-center text-xs font-semibold text-brand-secondary">
                Memuat slot jam...
            </div>

            <!-- AREA GRID SLOT JAM (Hanya bagian ini yang bisa di-scroll) -->
            <div x-show="!loading" class="flex-1 overflow-y-auto pr-1">
                <div class="grid grid-cols-2 gap-2.5">
                    <template x-for="slot in slots" :key="slot.start">
                        @php 
                            $isFacilityAvailable = ($facility->status === 'tersedia');
                        @endphp
                        <div>
                            <!-- KOTAK JAM TERSEDIA (BISA DIPILIH / MULTISELECT) -->
                            <template x-if="{{ $isFacilityAvailable ? 'true' : 'false' }} && slot.status === 'tersedia' && !slot.is_past">
                                <button 
                                    type="button"
                                    @click="toggleSlot(slot.start + ' - ' + slot.end, true)"
                                    :class="selectedSlots.includes(slot.start + ' - ' + slot.end) 
                                        ? 'bg-brand-primary border-brand-primary text-white shadow-md' 
                                        : 'bg-white border-gray-200 text-brand-primary hover:border-brand-primary/50'"
                                    class="relative flex flex-col items-center justify-center py-3.5 rounded-xl border-2 transition-all cursor-pointer w-full">
                                    
                                    <div x-show="selectedSlots.includes(slot.start + ' - ' + slot.end)" class="absolute top-1.5 right-1.5 bg-white text-brand-primary rounded-full w-4 h-4 flex items-center justify-center text-[10px] font-bold shadow-xs">
                                        ✓
                                    </div>

                                    <span class="text-[10px] opacity-70 mb-0.5">30 Menit</span>
                                    <span class="text-sm font-extrabold" x-text="slot.start + ' - ' + slot.end"></span>
                                </button>
                            </template>

                            <!-- KOTAK JAM TIDAK BISA DIPILIH (DISABLED) -->
                            <template x-if="!({{ $isFacilityAvailable ? 'true' : 'false' }} && slot.status === 'tersedia' && !slot.is_past)">
                                <button 
                                    type="button" 
                                    disabled 
                                    @click.prevent
                                    class="flex flex-col items-center justify-center py-3.5 rounded-xl border border-gray-200 bg-gray-100/80 text-gray-400 cursor-not-allowed opacity-60 w-full select-none">
                                    <span class="text-[10px] mb-0.5 opacity-60">30 Menit</span>
                                    <span class="text-sm font-bold line-through" x-text="slot.start + ' - ' + slot.end"></span>
                                    
                                    @if (in_array($facility->status, ['perbaikan', 'dalam_perbaikan', 'dalam perbaikan']))
                                        <span class="text-[10px] font-semibold text-amber-600 mt-0.5">Dalam Perbaikan</span>
                                    @elseif (in_array($facility->status, ['nonaktif', 'tidak_tersedia', 'tidak tersedia']))
                                        <span class="text-[10px] font-semibold text-gray-500 mt-0.5">Nonaktif</span>
                                    @else
                                        <span x-show="slot.is_past" class="text-[10px] font-semibold text-gray-500 mt-0.5">Selesai / Lewat</span>
                                        <span x-show="!slot.is_past" class="text-[10px] font-semibold text-rose-500 mt-0.5">Terisi</span>
                                    @endif
                                </button>
                            </template>
                        </div>
                    </template>
                </div>
            </div>

            <!-- FLOATING / STICKY ACTION BAR (Ter kunci di paling bawah saat jam di-scroll) -->
            <div x-show="selectedSlots.length > 0" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-3"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="sticky bottom-0 bg-white/95 backdrop-blur-xs pt-3 pb-1 border-t border-gray-100 mt-auto z-10 shrink-0">
                
                <div class="bg-brand-neutral p-3 rounded-xl border border-gray-200 mb-3 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-0.5">Selected Rentang Slot</span>
                        <span class="text-sm font-extrabold text-brand-primary" x-text="startTime + ' - ' + endTime + ' WIB'"></span>
                    </div>
                    <span class="text-xs text-brand-secondary font-bold" x-text="totalDuration"></span>
                </div>

                @auth
                    <a :href="'{{ route('reservations.create') }}?facility_id={{ $facility->id }}&date=' + currentDate + '&start=' + startTime + '&end=' + endTime"
                       class="w-full bg-brand-primary hover:opacity-90 text-white font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2 text-sm shadow-md">
                        <span>✓ Lanjut Pemesanan</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full bg-brand-primary hover:opacity-90 text-white font-bold py-3 rounded-xl transition-all block text-center text-sm shadow-md">
                        Login untuk Memesan
                    </a>
                @endauth
            </div>

        </div>

    </div>
</div>

@endsection