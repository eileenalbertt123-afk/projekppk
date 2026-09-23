<x-app-layout>

    <div class="min-h-screen bg-[#F4F8F7]">

        <div class="flex min-h-screen">

            <!-- SIDEBAR -->
            <aside class="w-64 min-h-screen bg-white shadow-md flex-shrink-0">

                <!-- Brand -->
                <div class="px-6 py-6">
                    <h1 class="text-xl font-bold text-[#19183B]">
                        Book & Fix
                    </h1>

                    <p class="text-xs text-[#708993] mt-1">
                        Admin Panel
                    </p>
                </div>

                <!-- Navigation -->
                <nav class="px-4">

                    <!-- Dashboard -->
                    <a href="{{ route('admin') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl
                               text-[#708993] hover:bg-[#F4F8F7]
                               hover:text-[#19183B] transition">

                        <span class="text-lg">🏠</span>
                        <span class="text-sm">Dashboard</span>

                    </a>

                    <!-- Fasilitas -->
                    <a href="{{ route('admin.facilities.index') }}"
                        class="flex items-center gap-3 px-4 py-3 mt-2 rounded-xl
                               bg-[#19183B] text-white font-semibold">

                        <span class="text-lg">🏢</span>
                        <span class="text-sm">Fasilitas</span>

                    </a>

                    <!-- Pengguna -->
                    <a href="#pengguna"
                        class="flex items-center gap-3 px-4 py-3 mt-2 rounded-xl
                               text-[#708993] hover:bg-[#F4F8F7]
                               hover:text-[#19183B] transition">

                        <span class="text-lg">👥</span>
                        <span class="text-sm">Pengguna</span>

                    </a>

                    <!-- Laporan -->
                    <a href="{{ route('admin.rekap') }}"
                        class="flex items-center gap-3 px-4 py-3 mt-2 rounded-xl
                               text-[#708993] hover:bg-[#F4F8F7]
                               hover:text-[#19183B] transition">

                        <span class="text-lg">📊</span>
                        <span class="text-sm">Laporan</span>

                    </a>

                </nav>

            </aside>


            <!-- CONTENT -->
            <main class="flex-1 p-8">

                <!-- Header -->
                <div class="mb-6">

                    <!-- Back -->
                    <a href="{{ route('admin.facilities.index') }}"
                        class="inline-flex items-center gap-2 text-sm text-[#708993]
                               hover:text-[#19183B] transition mb-4">

                        <span>←</span>
                        <span>Kembali ke Fasilitas</span>

                    </a>

                    <h1 class="text-2xl font-bold text-[#19183B]">
                        Tambah Fasilitas
                    </h1>

                    <p class="mt-1 text-sm text-[#708993]">
                        Tambahkan data fasilitas baru
                    </p>

                </div>


                <!-- Form -->
                <div class="bg-white rounded-xl border border-gray-200 p-6">

                    <form action="{{ route('admin.facilities.store') }}" method="POST">
                        @csrf

                        <!-- Input utama -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            <!-- Nama -->
                            <div>
                                <label class="block text-sm font-semibold text-[#19183B] mb-2">
                                    Nama Fasilitas
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    class="w-full rounded-lg border-gray-300 focus:border-[#19183B] focus:ring-[#19183B]"
                                    placeholder="Contoh: Lab Komputer"
                                    required>
                            </div>

                            <!-- Jenis -->
                            <div>
                                <label class="block text-sm font-semibold text-[#19183B] mb-2">
                                    Jenis
                                </label>

                                <select
                                    name="type"
                                    class="w-full rounded-lg border-gray-300 focus:border-[#19183B] focus:ring-[#19183B]"
                                    required>

                                    <option value="">Pilih jenis fasilitas</option>
                                    <option value="ruangan">Ruangan</option>
                                    <option value="laboratorium">Laboratorium</option>
                                    <option value="area_olahraga">Area Olahraga</option>
                                    <option value="peralatan_presentasi">Peralatan Presentasi</option>
                                    <option value="audio_multimedia">Audio Multimedia</option>
                                    <option value="lainnya">Lainnya</option>

                                </select>
                            </div>

                            <!-- Lokasi -->
                            <div>
                                <label class="block text-sm font-semibold text-[#19183B] mb-2">
                                    Lokasi
                                </label>

                                <input
                                    type="text"
                                    name="location"
                                    class="w-full rounded-lg border-gray-300 focus:border-[#19183B] focus:ring-[#19183B]"
                                    placeholder="Contoh: Gedung A"
                                    required>
                            </div>

                            <!-- Kapasitas -->
                            <div>
                                <label class="block text-sm font-semibold text-[#19183B] mb-2">
                                    Kapasitas
                                </label>

                                <input
                                    type="number"
                                    name="capacity"
                                    class="w-full rounded-lg border-gray-300 focus:border-[#19183B] focus:ring-[#19183B]"
                                    placeholder="Contoh: 30"
                                    required>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-semibold text-[#19183B] mb-2">
                                    Status
                                </label>

                                <select
                                    name="status"
                                    class="w-full rounded-lg border-gray-300 focus:border-[#19183B] focus:ring-[#19183B]"
                                    required>

                                    <option value="tersedia">Tersedia</option>
                                    <option value="dalam_perbaikan">Dalam Perbaikan</option>
                                    <option value="nonaktif">Nonaktif</option>

                                </select>
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label class="block text-sm font-semibold text-[#19183B] mb-2">
                                    Deskripsi
                                </label>

                                <textarea
                                    name="description"
                                    rows="4"
                                    class="w-full rounded-lg border-gray-300 focus:border-[#19183B] focus:ring-[#19183B]"
                                    placeholder="Deskripsi fasilitas"></textarea>
                            </div>

                        </div>

                        <!-- Tombol -->
                        <div class="flex justify-end gap-3 mt-6">

                            <a href="{{ route('admin.facilities.index') }}"
                                class="px-4 py-2.5 rounded-lg border border-gray-300
                                       text-sm font-medium text-gray-700
                                       hover:bg-gray-50">
                                Batal
                            </a>

                            <button type="submit"
                                class="px-4 py-2.5 rounded-lg bg-[#19183B]
                                       text-white text-sm font-semibold
                                       hover:opacity-90 transition">
                                Simpan Fasilitas
                            </button>

                        </div>

                    </form>

                </div>

            </main>

        </div>

    </div>

</x-app-layout>