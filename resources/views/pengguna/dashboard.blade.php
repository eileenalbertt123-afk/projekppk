<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Pengguna</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">

<div class="min-h-screen">

    {{-- NAVBAR --}}
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <div>
                <h1 class="text-xl font-bold text-green-700">
                    Reservasi Fasilitas
                </h1>
            </div>

            <div class="flex items-center gap-4">
                <span class="text-sm">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="text-sm text-red-600 hover:text-red-800">
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </nav>


    {{-- CONTENT --}}
    <main class="max-w-7xl mx-auto px-6 py-8">

        {{-- HEADER --}}
        <div class="mb-8">
            <h2 class="text-3xl font-bold">
                Beranda
            </h2>

            <p class="mt-2 text-gray-600">
                Selamat datang, {{ auth()->user()->name }} 👋
            </p>

            <p class="text-sm text-gray-500">
                Cari fasilitas, buat reservasi, dan lihat aktivitas Anda di sini.
            </p>
        </div>


        {{-- TOP CARDS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


            {{-- CARI FASILITAS --}}
            <div class="bg-white rounded-xl border border-green-200 shadow-sm overflow-hidden">

                <div class="bg-green-50 p-5">
                    <h3 class="text-lg font-bold text-green-800">
                        Cari & Lihat Fasilitas
                    </h3>

                    <p class="text-sm text-green-700 mt-1">
                        Filter berdasarkan tipe, lokasi, dan kapasitas
                    </p>
                </div>

                <div class="p-5 space-y-4">

                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Tipe Fasilitas
                        </label>

                        <select class="w-full border-gray-300 rounded-lg">
                            <option>Semua</option>
                            <option>Ruang Rapat</option>
                            <option>Aula</option>
                            <option>Laboratorium</option>
                            <option>Lapangan</option>
                        </select>
                    </div>


                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Lokasi
                        </label>

                        <select class="w-full border-gray-300 rounded-lg">
                            <option>Semua</option>
                            <option>Gedung A</option>
                            <option>Gedung B</option>
                            <option>Gedung C</option>
                        </select>
                    </div>


                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Kapasitas
                        </label>

                        <select class="w-full border-gray-300 rounded-lg">
                            <option>Semua</option>
                            <option>1 - 10 orang</option>
                            <option>11 - 30 orang</option>
                            <option>31 - 50 orang</option>
                            <option>50+ orang</option>
                        </select>
                    </div>


                    <button
                        class="w-full bg-green-600 text-white py-2.5 rounded-lg hover:bg-green-700">
                        Cari Fasilitas
                    </button>

                </div>
            </div>


            {{-- AKTIVITAS SAYA --}}
            <div class="bg-white rounded-xl border border-yellow-200 shadow-sm overflow-hidden">

                <div class="bg-yellow-50 p-5">
                    <h3 class="text-lg font-bold text-yellow-800">
                        Aktivitas Saya
                    </h3>

                    <p class="text-sm text-yellow-700 mt-1">
                        Reservasi & laporan saya
                    </p>
                </div>

                <div class="p-5 space-y-4">

                    <a href="#riwayat-reservasi"
                       class="block border rounded-lg p-4 hover:bg-gray-50">

                        <div class="font-semibold">
                            📅 Riwayat Reservasi
                        </div>

                        <p class="text-sm text-gray-500 mt-1">
                            Lihat status, detail, dan batalkan reservasi
                        </p>

                    </a>


                    <a href="#lapor-kerusakan"
                       class="block border rounded-lg p-4 hover:bg-gray-50">

                        <div class="font-semibold">
                            🔧 Lapor Kerusakan
                        </div>

                        <p class="text-sm text-gray-500 mt-1">
                            Buat laporan kerusakan fasilitas
                        </p>

                    </a>

                </div>
            </div>


            {{-- RIWAYAT LAPORAN --}}
            <div class="bg-white rounded-xl border border-purple-200 shadow-sm overflow-hidden">

                <div class="bg-purple-50 p-5">
                    <h3 class="text-lg font-bold text-purple-800">
                        Riwayat Laporan
                    </h3>

                    <p class="text-sm text-purple-700 mt-1">
                        Lihat status laporan kerusakan Anda
                    </p>
                </div>

                <div class="p-5 space-y-3">

                    <div class="flex justify-between border-b pb-3">
                        <span>Semua Laporan</span>
                        <span class="font-bold">0</span>
                    </div>

                    <div class="flex justify-between border-b pb-3">
                        <span>Menunggu</span>
                        <span class="font-bold">0</span>
                    </div>

                    <div class="flex justify-between border-b pb-3">
                        <span>Diproses</span>
                        <span class="font-bold">0</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Selesai</span>
                        <span class="font-bold">0</span>
                    </div>

                </div>
            </div>

        </div>


        {{-- FASILITAS --}}
        <section class="mt-10">

            <div class="flex justify-between items-center mb-4">

                <h2 class="text-xl font-bold">
                    Fasilitas Tersedia
                </h2>

                <a href="#" class="text-green-600 text-sm font-semibold">
                    Lihat semua →
                </a>

            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                @foreach([
                    ['Ruang Rapat A', 'Ruang Rapat', 'Gedung A Lt.2', '20 orang'],
                    ['Ruang Rapat B', 'Ruang Rapat', 'Gedung A Lt.2', '16 orang'],
                    ['Aula Utama', 'Aula', 'Gedung B Lt.1', '100 orang'],
                    ['Lab Komputer', 'Laboratorium', 'Gedung C Lt.3', '30 orang'],
                ] as $fasilitas)

                    <div class="bg-white border rounded-xl p-5 shadow-sm">

                        <div class="h-28 bg-gray-100 rounded-lg mb-4 flex items-center justify-center text-gray-400">
                            Foto Fasilitas
                        </div>

                        <h3 class="font-bold">
                            {{ $fasilitas[0] }}
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            {{ $fasilitas[1] }}
                        </p>

                        <p class="text-sm mt-2">
                            📍 {{ $fasilitas[2] }}
                        </p>

                        <p class="text-sm mt-1">
                            👥 Kapasitas: {{ $fasilitas[3] }}
                        </p>

                        <button
                            class="w-full mt-4 border border-green-600 text-green-700 py-2 rounded-lg hover:bg-green-50">
                            Detail
                        </button>

                    </div>

                @endforeach

            </div>

        </section>


        {{-- FORM RESERVASI --}}
        <section id="form-reservasi" class="mt-10">

            <div class="bg-white rounded-xl border shadow-sm">

                <div class="bg-purple-50 px-6 py-4 border-b">
                    <h2 class="text-xl font-bold text-purple-800">
                        Form Reservasi
                    </h2>

                    <p class="text-sm text-gray-600">
                        Isi data reservasi fasilitas
                    </p>
                </div>


                <form class="p-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Fasilitas
                            </label>

                            <select class="w-full rounded-lg border-gray-300">
                                <option>Ruang Rapat A</option>
                                <option>Ruang Rapat B</option>
                                <option>Aula Utama</option>
                            </select>
                        </div>


                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Lokasi
                            </label>

                            <input
                                type="text"
                                value="Gedung A Lt.2"
                                readonly
                                class="w-full rounded-lg border-gray-300 bg-gray-100">
                        </div>


                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Tanggal Mulai
                            </label>

                            <input
                                type="date"
                                class="w-full rounded-lg border-gray-300">
                        </div>


                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Waktu Mulai
                            </label>

                            <input
                                type="time"
                                class="w-full rounded-lg border-gray-300">
                        </div>


                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Tanggal Selesai
                            </label>

                            <input
                                type="date"
                                class="w-full rounded-lg border-gray-300">
                        </div>


                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Waktu Selesai
                            </label>

                            <input
                                type="time"
                                class="w-full rounded-lg border-gray-300">
                        </div>

                    </div>


                    <div class="mt-5">

                        <label class="block text-sm font-medium mb-1">
                            Tujuan / Keterangan
                        </label>

                        <textarea
                            rows="4"
                            placeholder="Contoh: Rapat koordinasi divisi marketing"
                            class="w-full rounded-lg border-gray-300"></textarea>

                    </div>


                    <div class="mt-5">

                        <label class="block text-sm font-medium mb-1">
                            Lampiran (Opsional)
                        </label>

                        <input
                            type="file"
                            class="w-full rounded-lg border-gray-300">

                    </div>


                    <div class="flex justify-end gap-3 mt-6">

                        <button
                            type="reset"
                            class="px-5 py-2 border rounded-lg">
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="px-5 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            Kirim Reservasi
                        </button>

                    </div>

                </form>

            </div>

        </section>


        {{-- LAPOR KERUSAKAN --}}
        <section id="lapor-kerusakan" class="mt-10">

            <div class="bg-white rounded-xl border shadow-sm">

                <div class="bg-orange-50 px-6 py-4 border-b">
                    <h2 class="text-xl font-bold text-orange-800">
                        Lapor Kerusakan
                    </h2>

                    <p class="text-sm text-gray-600">
                        Laporkan kerusakan fasilitas yang Anda temukan
                    </p>
                </div>


                <form class="p-6">

                    <div class="grid md:grid-cols-2 gap-5">

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Fasilitas
                            </label>

                            <select class="w-full rounded-lg border-gray-300">
                                <option>Ruang Rapat A</option>
                                <option>Aula Utama</option>
                                <option>Lab Komputer</option>
                            </select>
                        </div>


                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Kategori Kerusakan
                            </label>

                            <select class="w-full rounded-lg border-gray-300">
                                <option>Fasilitas</option>
                                <option>Listrik</option>
                                <option>Peralatan</option>
                                <option>AC</option>
                                <option>Lainnya</option>
                            </select>
                        </div>

                    </div>


                    <div class="mt-5">

                        <label class="block text-sm font-medium mb-1">
                            Deskripsi
                        </label>

                        <textarea
                            rows="4"
                            placeholder="Jelaskan kerusakan yang terjadi..."
                            class="w-full rounded-lg border-gray-300"></textarea>

                    </div>


                    <div class="mt-5">

                        <label class="block text-sm font-medium mb-1">
                            Foto Kerusakan
                        </label>

                        <input
                            type="file"
                            accept="image/*"
                            class="w-full rounded-lg border-gray-300">

                    </div>


                    <div class="flex justify-end mt-6">

                        <button
                            type="submit"
                            class="px-5 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                            Kirim Laporan
                        </button>

                    </div>

                </form>

            </div>

        </section>


        {{-- RIWAYAT RESERVASI --}}
        <section id="riwayat-reservasi" class="mt-10">

            <div class="bg-white rounded-xl border shadow-sm overflow-hidden">

                <div class="bg-yellow-50 px-6 py-4 border-b">

                    <h2 class="text-xl font-bold text-yellow-800">
                        Riwayat Reservasi
                    </h2>

                    <p class="text-sm text-gray-600">
                        Status dan riwayat reservasi Anda
                    </p>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-6 py-4">No</th>
                                <th class="text-left px-6 py-4">Tanggal</th>
                                <th class="text-left px-6 py-4">Fasilitas</th>
                                <th class="text-left px-6 py-4">Waktu</th>
                                <th class="text-left px-6 py-4">Status</th>
                                <th class="text-left px-6 py-4">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr class="border-t">

                                <td class="px-6 py-4">1</td>

                                <td class="px-6 py-4">
                                    24/05/2025
                                </td>

                                <td class="px-6 py-4">
                                    Ruang Rapat A
                                </td>

                                <td class="px-6 py-4">
                                    09:00 - 11:00
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full">
                                        Menunggu
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <button class="text-blue-600">
                                        Detail
                                    </button>
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </section>


        {{-- RIWAYAT LAPORAN --}}
        <section id="riwayat-laporan" class="mt-10">

            <div class="bg-white rounded-xl border shadow-sm overflow-hidden">

                <div class="bg-purple-50 px-6 py-4 border-b">

                    <h2 class="text-xl font-bold text-purple-800">
                        Riwayat Laporan
                    </h2>

                    <p class="text-sm text-gray-600">
                        Lihat status laporan kerusakan Anda
                    </p>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead class="bg-gray-50">

                            <tr>
                                <th class="text-left px-6 py-4">No</th>
                                <th class="text-left px-6 py-4">Tanggal</th>
                                <th class="text-left px-6 py-4">Fasilitas</th>
                                <th class="text-left px-6 py-4">Kategori</th>
                                <th class="text-left px-6 py-4">Deskripsi</th>
                                <th class="text-left px-6 py-4">Status</th>
                                <th class="text-left px-6 py-4">Aksi</th>
                            </tr>

                        </thead>


                        <tbody>

                            <tr class="border-t">

                                <td class="px-6 py-4">1</td>

                                <td class="px-6 py-4">
                                    23/05/2025
                                </td>

                                <td class="px-6 py-4">
                                    Ruang Rapat A
                                </td>

                                <td class="px-6 py-4">
                                    AC
                                </td>

                                <td class="px-6 py-4">
                                    AC tidak dingin saat digunakan.
                                </td>

                                <td class="px-6 py-4">

                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full">
                                        Menunggu
                                    </span>

                                </td>

                                <td class="px-6 py-4">

                                    <button class="text-blue-600">
                                        Detail
                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </section>

    </main>

</div>

</body>
</html>