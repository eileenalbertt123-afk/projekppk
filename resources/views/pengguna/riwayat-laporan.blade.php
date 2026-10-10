@extends('layouts.app')

@section('content')
<div class="mb-5 sm:mb-8">
    <h2 class="text-brand-primary text-2xl sm:text-3xl font-extrabold tracking-tight">
        Riwayat Laporan
    </h2>
    <p class="text-sm text-brand-secondary mt-1">
        Pantau laporan kerusakan fasilitas yang telah Anda buat.
    </p>
</div>

<div class="grid grid-cols-2 xl:grid-cols-4 gap-3 sm:gap-4 mb-5 sm:mb-8">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-panel p-4 sm:p-5">
        <p class="text-sm font-semibold text-brand-secondary">Laporan Baru</p>
        <p class="text-2xl sm:text-3xl font-extrabold text-amber-600 mt-2">
            {{ $laporanBaru }}
        </p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-panel p-4 sm:p-5">
        <p class="text-sm font-semibold text-brand-secondary">Diproses</p>
        <p class="text-2xl sm:text-3xl font-extrabold text-indigo-600 mt-2">
            {{ $laporanDiproses }}
        </p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-panel p-4 sm:p-5">
        <p class="text-sm font-semibold text-brand-secondary">Ditolak</p>
        <p class="text-2xl sm:text-3xl font-extrabold text-rose-600 mt-2">
            {{ $laporanDitolak }}
        </p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-panel p-4 sm:p-5">
        <p class="text-sm font-semibold text-brand-secondary">Selesai</p>
        <p class="text-2xl sm:text-3xl font-extrabold text-emerald-600 mt-2">
            {{ $laporanSelesai }}
        </p>
    </div>
</div>

<div class="bg-white rounded-3xl border border-gray-200 shadow-panel p-4 sm:p-8">
    @php
    $statusAktif = request('status', 'semua');

    $filterStatus = [
    'semua' => ['label' => 'Semua', 'jumlah' => $laporanBaru + $laporanDiproses + $laporanDitolak + $laporanSelesai],
    'baru' => ['label' => 'Baru', 'jumlah' => $laporanBaru],
    'diproses' => ['label' => 'Diproses', 'jumlah' => $laporanDiproses],
    'ditolak' => ['label' => 'Ditolak', 'jumlah' => $laporanDitolak],
    'selesai' => ['label' => 'Selesai', 'jumlah' => $laporanSelesai],
    ];
    @endphp

    <div class="flex flex-col gap-5 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h3 class="font-bold text-lg text-brand-primary">
                Daftar Laporan
            </h3>

            <div>
                <label for="urutan-laporan"
                    class="text-sm font-semibold text-brand-primary mr-2">
                    Urutkan:
                </label>

                <select
                    id="urutan-laporan"
                    class="border border-gray-300 rounded-xl px-3 py-2 text-sm bg-white">
                    <option value="terbaru"
                        {{ request('urutan', 'terbaru') === 'terbaru' ? 'selected' : '' }}>
                        Terbaru
                    </option>
                    <option value="terlama"
                        {{ request('urutan') === 'terlama' ? 'selected' : '' }}>
                        Terlama
                    </option>
                </select>
            </div>
        </div>

        <div class="flex flex-wrap gap-2">
            @foreach($filterStatus as $nilai => $item)
            <a
                href="{{ route('riwayat.laporan', [
                        'status' => $nilai,
                        'urutan' => request('urutan', 'terbaru')
                    ]) }}"
                data-status="{{ $nilai }}"
                class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 rounded-full border text-xs sm:text-sm font-semibold transition
                    {{ $statusAktif === $nilai
                        ? 'bg-brand-primary text-white border-brand-primary'
                        : 'bg-white text-brand-secondary border-gray-200 hover:bg-gray-100' }}">
                {{ $item['label'] }}

                <span class="ml-1 font-bold">
                    {{ $item['jumlah'] }}
                </span>


            </a>
            @endforeach
        </div>
    </div>

    @if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-semibold">
        {{ session('success') }}
    </div>
    @endif

    <div
        id="daftar-laporan"
        data-status-awal="{{ request('status', 'semua') }}">
        @include('pengguna.partials.daftar-laporan', ['reports' => $reports])
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const daftar = document.getElementById('daftar-laporan');
        const urutan = document.getElementById('urutan-laporan');
        const tombolFilter = document.querySelectorAll('[data-status]');

        let statusAktif = daftar.dataset.statusAwal;

        async function muatLaporan(status, pilihanUrutan) {
            const params = new URLSearchParams({
                status: status,
                urutan: pilihanUrutan
            });

            try {
                const response = await fetch(
                    `{{ route('riwayat.laporan') }}?${params.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    }
                );

                if (!response.ok) {
                    throw new Error('Gagal mengambil daftar laporan.');
                }

                const html = await response.text();
                daftar.innerHTML = html;

                statusAktif = status;

                tombolFilter.forEach(function(tombol) {
                    const aktif = tombol.dataset.status === status;

                    tombol.classList.toggle('bg-brand-primary', aktif);
                    tombol.classList.toggle('text-white', aktif);
                    tombol.classList.toggle('border-brand-primary', aktif);

                    tombol.classList.toggle('bg-white', !aktif);
                    tombol.classList.toggle('text-brand-secondary', !aktif);
                    tombol.classList.toggle('border-gray-200', !aktif);
                });

                history.replaceState({},
                    '',
                    `{{ route('riwayat.laporan') }}?${params.toString()}`
                );
            } catch (error) {
                console.error(error);
                alert('Gagal memuat laporan. Silakan coba lagi.');
            }
        }

        tombolFilter.forEach(function(tombol) {
            tombol.addEventListener('click', function(event) {
                event.preventDefault();
                muatLaporan(tombol.dataset.status, urutan.value);
            });
        });

        urutan.addEventListener('change', function() {
            muatLaporan(statusAktif, urutan.value);
        });
    });
</script>

@endsection