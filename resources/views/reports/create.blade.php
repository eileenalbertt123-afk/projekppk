@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto"> 
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-brand-primary tracking-tight">Form Pelaporan Kerusakan</h1>
        <p class="text-sm text-brand-secondary mt-1">Sampaikan kendala fasilitas kampus agar dapat segera ditindaklanjuti oleh petugas.</p>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-sm font-semibold">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- SECTION 1: INFORMASI PELAPOR -->
        <div style="animation-delay: 0ms" class="animate-fade-up bg-white rounded-2xl border border-gray-200 p-6 shadow-panel mb-6">
            <div class="flex items-center gap-3 mb-5 border-b border-gray-100 pb-4">
                <div class="w-10 h-10 rounded-xl bg-brand-neutral text-brand-primary flex items-center justify-center font-bold shrink-0">
                    <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-brand-primary">Informasi Pelapor</h2>
                    <p class="text-xs text-brand-secondary mt-0.5">Data identitas pengguna yang terautentikasi</p>
                </div>
            </div>

            <div class="border border-gray-200 rounded-2xl p-4 shadow-card">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Nama Pelapor -->
                    <div class="border border-gray-200 rounded-xl p-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-brand-primary text-white font-bold text-sm flex items-center justify-center shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="truncate">
                            <span class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-0.5">NAMA PELAPOR</span>
                            <p class="text-sm font-bold text-brand-primary truncate">{{ Auth::user()->name }}</p>
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="border border-gray-200 rounded-xl p-4">
                        <span class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-0.5">ROLE / PERAN</span>
                        <p class="text-sm font-bold text-brand-primary capitalize">{{ Auth::user()->role_type ?? 'Mahasiswa' }}</p>
                        <p class="text-xs text-brand-secondary mt-0.5">Civitas Akademika</p>
                    </div>

                    <!-- Email -->
                    <div class="border border-gray-200 rounded-xl p-4">
                        <span class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-0.5">EMAIL KHUSUS</span>
                        <p class="text-sm font-bold text-brand-primary truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: DETAIL FASILITAS & KERUSAKAN -->
        <div style="animation-delay: 120ms" class="animate-fade-up bg-white rounded-2xl border border-gray-200 p-6 shadow-panel mb-8">
            <div class="flex items-center gap-3 mb-5 border-b border-gray-100 pb-4">
                <div class="w-10 h-10 rounded-xl bg-brand-neutral text-brand-primary flex items-center justify-center font-bold shrink-0">
                    <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-brand-primary">Detail Fasilitas &amp; Kerusakan</h2>
                    <p class="text-xs text-brand-secondary mt-0.5">Lokasi, jenis kendala, penjelasan, dan foto bukti kerusakan</p>
                </div>
            </div>

            <div class="space-y-5">
                <!-- Fasilitas & Kategori -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Fasilitas -->
                    <div>
                        <label for="facility_id" class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-1">
                            PILIH FASILITAS / RUANGAN <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-brand-secondary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </span>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-brand-secondary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                            <select id="facility_id" name="facility_id" class="w-full appearance-none text-sm font-semibold text-brand-primary border border-gray-200 rounded-xl py-3 pl-10 pr-10 focus:outline-none focus:border-brand-primary cursor-pointer" required>
                                <option value="" disabled {{ old('facility_id') ? '' : 'selected' }}>-- Pilih Fasilitas --</option>
                                @foreach($facilities as $facility)
                                <option value="{{ $facility->id }}" {{ old('facility_id') == $facility->id ? 'selected' : '' }}>
                                    {{ $facility->name }} ({{ $facility->location }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category" class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-1">
                            KATEGORI KENDALA / KERUSAKAN <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-brand-secondary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </span>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-brand-secondary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                            <select id="category" name="category" class="w-full appearance-none text-sm font-semibold text-brand-primary border border-gray-200 rounded-xl py-3 pl-10 pr-10 focus:outline-none focus:border-brand-primary cursor-pointer" required>
                                <option value="" disabled {{ old('category') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                                <option value="elektronik_av" {{ old('category') == 'elektronik_av' ? 'selected' : '' }}>Elektronik / AC / Proyektor</option>
                                <option value="furnitur" {{ old('category') == 'furnitur' ? 'selected' : '' }}>Meubeler / Kursi / Meja</option>
                                <option value="kebersihan" {{ old('category') == 'kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                                <option value="mekanikal_utilitas" {{ old('category') == 'mekanikal_utilitas' ? 'selected' : '' }}>Kelistrikan / Lampu</option>
                                <option value="struktur_bangunan" {{ old('category') == 'struktur_bangunan' ? 'selected' : '' }}>Struktur Bangunan</option>
                                <option value="jaringan_it" {{ old('category') == 'jaringan_it' ? 'selected' : '' }}>Jaringan / IT</option>
                                <option value="lainnya" {{ old('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Kerusakan -->
                <div>
                    <label for="description" class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-1">
                        DESKRIPSI KERUSAKAN <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-0 top-0 pl-3.5 pt-3.5 pointer-events-none text-brand-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h10" />
                            </svg>
                        </span>
                        <textarea id="description" name="description" rows="4" placeholder="Jelaskan detail kendala atau kerusakan yang ditemukan..." class="w-full text-sm text-brand-primary border border-gray-200 rounded-xl py-3 pl-10 pr-3 focus:outline-none focus:border-brand-primary resize-none" required>{{ old('description') }}</textarea>
                    </div>
                </div>

                <!-- Upload Foto Bukti -->
                <div>
                    <label for="image"
                        class="block text-xs font-semibold text-slate-500 mb-2">
                        FOTO BUKTI KERUSAKAN
                        <span class="font-normal">(Opsional)</span>
                    </label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                        class="block w-full text-sm text-slate-600
               file:mr-3 file:rounded-lg file:border-0
               file:bg-slate-100 file:px-3 file:py-2
               file:text-sm file:font-medium
               file:text-slate-700
               hover:file:bg-slate-200">

                    <p class="mt-2 text-xs text-slate-500">
                        Format JPG, JPEG, atau PNG. Maksimal 2 MB.
                    </p>
                </div>
            </div>
        </div>

        <!-- Tombol Submit Form -->
        <div style="animation-delay: 240ms" class="animate-fade-up flex justify-end">
            <button type="submit" class="bg-brand-primary hover:opacity-90 text-white font-bold px-8 py-3.5 rounded-xl shadow-md transition-all flex items-center gap-2 text-sm cursor-pointer">
                <svg class="w-4 h-4 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                <span>Kirim Laporan Kerusakan</span>
            </button>
        </div>
    </form>
</div>
@endsection