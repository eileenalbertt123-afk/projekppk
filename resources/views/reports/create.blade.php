@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <a href="{{ route('reports.index') }}" class="text-sm font-medium text-brand-secondary hover:text-brand-primary mb-6 inline-block">&larr; Kembali ke daftar laporan</a>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-brand-primary">Form Pelaporan Kerusakan</h1>
        <p class="text-sm text-brand-secondary mt-1">Sampaikan kendala fasilitas kampus agar dapat segera ditindaklanjuti oleh petugas.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-sm font-semibold">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-5">
        @csrf

        <!-- Pilih Fasilitas -->
        <div>
            <label for="facility_id" class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-1">
                PILIH FASILITAS / RUANGAN <span class="text-rose-500">*</span>
            </label>
            <select id="facility_id" name="facility_id" class="w-full text-sm font-semibold text-brand-primary border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-brand-primary" required>
                <option value="" disabled selected>-- Pilih Fasilitas --</option>
                @foreach($facilities as $facility)
                    <option value="{{ $facility->id }}">{{ $facility->name }} ({{ $facility->location }})</option>
                @endforeach
            </select>
        </div>

        <!-- Kategori Kerusakan -->
        <div>
            <label for="category" class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-1">
                KATEGORI KENDALA / KERUSAKAN <span class="text-rose-500">*</span>
            </label>
            <select id="category" name="category" class="w-full text-sm font-semibold text-brand-primary border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-brand-primary" required>
                <option value="" disabled selected>-- Pilih Kategori --</option>
                <option value="elektronik_av">Elektronik / AC / Proyektor</option>
                <option value="furnitur">Meubeler / Kursi / Meja</option>
                <option value="kebersihan">Kebersihan</option>
                <option value="mekanikal_utilitas">Kelistrikan / Lampu</option>
                <option value="struktur_bangunan">Struktur Bangunan</option>
                <option value="jaringan_it">Jaringan / IT</option>
                <option value="lainnya">Lainnya</option>
            </select>
        </div>

        <!-- Deskripsi Kerusakan -->
        <div>
            <label for="description" class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-1">
                DESKRIPSI KERUSAKAN <span class="text-rose-500">*</span>
            </label>
            <textarea id="description" name="description" rows="4" placeholder="Jelaskan detail kendala atau kerusakan yang ditemukan..." class="w-full text-sm text-brand-primary border border-gray-200 rounded-xl p-3 focus:outline-none focus:border-brand-primary resize-none" required></textarea>
        </div>

        <!-- Upload Foto Bukti -->
        <div>
            <label for="image" class="text-[10px] font-bold text-brand-secondary uppercase tracking-wider block mb-1">
                FOTO BUKTI KERUSAKAN <span class="text-gray-400 font-normal">(Opsional)</span>
            </label>
            <input type="file" id="image" name="image" accept="image/*" class="block w-full text-xs text-brand-secondary file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-brand-neutral file:text-brand-primary hover:file:bg-gray-200 cursor-pointer">
        </div>

        <div class="pt-3 flex justify-end">
            <button type="submit" class="bg-brand-primary hover:opacity-90 text-white font-bold px-8 py-3 rounded-xl shadow-md transition text-sm">
                Kirim Laporan Kerusakan
            </button>
        </div>
    </form>
</div>
@endsection