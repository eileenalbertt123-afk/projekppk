@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Tombol Kembali -->
    <a href="{{ url()->previous() }}" class="text-sm font-medium text-brand-secondary hover:text-brand-primary mb-6 inline-block">
        &larr; Kembali pilih waktu
    </a>

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-brand-primary tracking-tight">Pengajuan Reservasi</h1>
        <p class="text-sm text-brand-secondary mt-1">Lengkapi form di bawah ini untuk mengajukan peminjaman fasilitas <strong>{{ $facility->name }}</strong>.</p>
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

    <form action="{{ route('reservations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="facility_id" value="{{ $facility->id }}">
        <input type="hidden" name="date" value="{{ $date }}">
        <input type="hidden" name="start_time" value="{{ $start }}">
        <input type="hidden" name="end_time" value="{{ $end }}">

        <!-- SECTION 1: INFORMASI PEMOHON -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm mb-6">
            <div class="flex items-center gap-3 mb-5 border-b border-gray-100 pb-4">
                <div class="w-10 h-10 rounded-xl bg-brand-neutral text-brand-primary flex items-center justify-center font-bold">
                    👤
                </div>
                <div>
                    <h2 class="text-lg font-bold text-brand-primary">Informasi Pemohon</h2>
                    <p class="text-xs text-brand-secondary mt-0.5">Data identitas pengguna yang terautentikasi</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Nama Pemohon -->
                <div class="border border-gray-200 rounded-xl p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-brand-primary text-white font-bold text-sm flex items-center justify-center shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-0.5">NAMA PEMOHON</span>
                        <p class="text-sm font-bold text-brand-primary">{{ Auth::user()->name }}</p>
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

        <!-- SECTION 2: DETAIL WAKTU & PENGGUNAAN -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm mb-8">
            <div class="flex items-center gap-3 mb-5 border-b border-gray-100 pb-4">
                <div class="w-10 h-10 rounded-xl bg-brand-neutral text-brand-primary flex items-center justify-center font-bold">
                    📅
                </div>
                <div>
                    <h2 class="text-lg font-bold text-brand-primary">Detail Waktu & Penggunaan</h2>
                    <p class="text-xs text-brand-secondary mt-0.5">Jadwal yang dipilih, agenda kegiatan, dan dokumen permohonan</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <!-- Tanggal Penggunaan -->
                <div class="border border-gray-200 rounded-xl p-4">
                    <span class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-1">TANGGAL PENGGUNAAN</span>
                    <div class="flex items-center gap-2 text-brand-primary font-bold text-sm">
                        📅 {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
                    </div>
                    <p class="text-xs text-brand-secondary mt-1">{{ \Carbon\Carbon::parse($date)->translatedFormat('l') }}</p>
                </div>

                <!-- Rentang Waktu Multiselect -->
                <div class="border border-gray-200 rounded-xl p-4">
                    <span class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-1">RENTANG WAKTU</span>
                    <div class="flex items-center gap-2 text-brand-primary font-bold text-sm">
                        🕒 {{ $start }} - {{ $end }} WIB
                    </div>
                    @php
                        $durationMinutes = \Carbon\Carbon::parse($start)->diffInMinutes(\Carbon\Carbon::parse($end));
                        $slotsCount = $durationMinutes / 30;
                    @endphp
                    <p class="text-xs text-brand-secondary mt-1">Durasi {{ $durationMinutes }} menit ({{ $slotsCount }} slot)</p>
                </div>

                <!-- Upload Dokumen Surat (Opsional) -->
                <div class="border border-gray-200 rounded-xl p-4">
                    <span class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-1">DOKUMEN SURAT (OPSIONAL)</span>
                    <input type="file" name="document" class="block w-full text-xs text-brand-secondary file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-brand-neutral file:text-brand-primary cursor-pointer">
                </div>
            </div>

            <div class="border border-gray-200 rounded-xl p-4 space-y-4">
                <!-- Agenda / Tujuan Utama (purpose - Wajib) -->
                <div>
                    <label for="purpose" class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-1">TUJUAN / AGENDA UTAMA <span class="text-rose-500">*</span></label>
                    <input type="text" id="purpose" name="purpose" value="{{ old('purpose') }}" placeholder="Contoh: Rapat Koordinasi Panitia Rektor Cup" class="w-full text-sm font-bold text-brand-primary border-b border-gray-200 pb-2 focus:outline-none focus:border-brand-primary" required>
                </div>

                <!-- Deskripsi Rincian Aktivitas (activity_description - Opsional) -->
                <div>
                    <label for="activity_description" class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-1">DESKRIPSI RINCIAN AKTIVITAS (OPSIONAL)</label>
                    <textarea id="activity_description" name="activity_description" rows="2" placeholder="Jelaskan secara ringkas rincian kegiatan jika ada..." class="w-full text-sm text-brand-secondary border-b border-gray-200 pb-2 focus:outline-none focus:border-brand-primary resize-none">{{ old('activity_description') }}</textarea>
                </div>

                <!-- Estimasi Jumlah Peserta -->
                <div>
                    <label for="participant_count" class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-1">ESTIMASI JUMLAH PESERTA</label>
                    <input type="number" id="participant_count" name="participant_count" min="1" value="{{ old('participant_count', 1) }}" class="w-32 text-sm font-bold text-brand-primary border-b border-gray-200 pb-1 focus:outline-none focus:border-brand-primary">
                </div>
            </div>
        </div>

        <!-- Tombol Submit Form -->
        <div class="flex justify-end">
            <button type="submit" class="bg-brand-primary hover:opacity-90 text-white font-bold px-8 py-3.5 rounded-xl shadow-lg transition-all flex items-center gap-2 text-sm">
                <span>✓ Ajukan Reservasi</span>
            </button>
        </div>
    </form>
</div>
@endsection