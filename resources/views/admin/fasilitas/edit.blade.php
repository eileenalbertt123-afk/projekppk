<x-app-layout>

    <div class="min-h-screen bg-[#f5f7f7]">

        <div class="flex min-h-screen">

            {{-- =========================================================
                SIDEBAR
            ========================================================== --}}
            @include('layouts.admin-sidebar')


            {{-- =========================================================
                MAIN CONTENT
            ========================================================== --}}
            <main class="flex-1 min-w-0 px-8 py-8">

                {{-- HEADER --}}
                <div class="mb-6">

                    <a href="{{ route('admin.facilities.index') }}"
                       class="inline-flex items-center gap-2
                              text-sm text-[#708993]
                              hover:text-[#19183b]
                              transition mb-4">

                        <span>←</span>

                        <span>
                            Kembali ke Fasilitas
                        </span>

                    </a>


                    <h1 class="text-2xl font-bold text-[#19183b]">
                        Edit Fasilitas
                    </h1>

                    <p class="mt-1 text-sm text-[#708993]">
                        Ubah data fasilitas
                    </p>

                </div>


                {{-- =====================================================
                    FORM
                ====================================================== --}}
                <div class="bg-white rounded-xl border border-[#e2ebe9] p-6">

                    <form
                        action="{{ route('admin.facilities.update', $fasilitas->id) }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf
                        @method('PUT')


                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                            {{-- NAMA --}}
                            <div>

                                <label class="block text-sm font-semibold text-[#19183b] mb-2">
                                    Nama Fasilitas
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name', $fasilitas->name) }}"
                                    class="w-full rounded-lg border-gray-300
                                           focus:border-[#19183b]
                                           focus:ring-[#19183b]"
                                    required>

                                @error('name')
                                    <p class="mt-1 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- JENIS --}}
                            <div>

                                <label class="block text-sm font-semibold text-[#19183b] mb-2">
                                    Jenis
                                </label>

                                <select
                                    name="type"
                                    class="w-full rounded-lg border-gray-300
                                           focus:border-[#19183b]
                                           focus:ring-[#19183b]"
                                    required>

                                    <option value="ruangan"
                                        {{ old('type', $fasilitas->type) === 'ruangan' ? 'selected' : '' }}>
                                        Ruangan
                                    </option>

                                    <option value="laboratorium"
                                        {{ old('type', $fasilitas->type) === 'laboratorium' ? 'selected' : '' }}>
                                        Laboratorium
                                    </option>

                                    <option value="area_olahraga"
                                        {{ old('type', $fasilitas->type) === 'area_olahraga' ? 'selected' : '' }}>
                                        Area Olahraga
                                    </option>

                                    <option value="peralatan_presentasi"
                                        {{ old('type', $fasilitas->type) === 'peralatan_presentasi' ? 'selected' : '' }}>
                                        Peralatan Presentasi
                                    </option>

                                    <option value="audio_multimedia"
                                        {{ old('type', $fasilitas->type) === 'audio_multimedia' ? 'selected' : '' }}>
                                        Audio Multimedia
                                    </option>

                                    <option value="lainnya"
                                        {{ old('type', $fasilitas->type) === 'lainnya' ? 'selected' : '' }}>
                                        Lainnya
                                    </option>

                                </select>

                                @error('type')
                                    <p class="mt-1 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- LOKASI --}}
                            <div>

                                <label class="block text-sm font-semibold text-[#19183b] mb-2">
                                    Lokasi
                                </label>

                                <input
                                    type="text"
                                    name="location"
                                    value="{{ old('location', $fasilitas->location) }}"
                                    class="w-full rounded-lg border-gray-300
                                           focus:border-[#19183b]
                                           focus:ring-[#19183b]"
                                    required>

                                @error('location')
                                    <p class="mt-1 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- KAPASITAS --}}
                            <div>

                                <label class="block text-sm font-semibold text-[#19183b] mb-2">
                                    Kapasitas
                                </label>

                                <input
                                    type="number"
                                    name="capacity"
                                    value="{{ old('capacity', $fasilitas->capacity) }}"
                                    min="1"
                                    class="w-full rounded-lg border-gray-300
                                           focus:border-[#19183b]
                                           focus:ring-[#19183b]"
                                    required>

                                @error('capacity')
                                    <p class="mt-1 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- STATUS --}}
                            <div>

                                <label class="block text-sm font-semibold text-[#19183b] mb-2">
                                    Status
                                </label>

                                <select
                                    name="status"
                                    class="w-full rounded-lg border-gray-300
                                           focus:border-[#19183b]
                                           focus:ring-[#19183b]"
                                    required>

                                    <option value="tersedia"
                                        {{ old('status', $fasilitas->status) === 'tersedia' ? 'selected' : '' }}>
                                        Tersedia
                                    </option>

                                    <option value="dalam_perbaikan"
                                        {{ old('status', $fasilitas->status) === 'dalam_perbaikan' ? 'selected' : '' }}>
                                        Dalam Perbaikan
                                    </option>

                                    <option value="nonaktif"
                                        {{ old('status', $fasilitas->status) === 'nonaktif' ? 'selected' : '' }}>
                                        Nonaktif
                                    </option>

                                </select>

                                @error('status')
                                    <p class="mt-1 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- FOTO --}}
                            <div>

                                <label class="block text-sm font-semibold text-[#19183b] mb-2">
                                    Foto Fasilitas
                                </label>


                                {{-- FOTO LAMA --}}
                                @if($fasilitas->image)

                                    <div class="mb-3">

                                        <p class="text-xs text-[#708993] mb-2">
                                            Foto saat ini
                                        </p>

                                        <img
                                            src="{{ asset('storage/' . $fasilitas->image) }}"
                                            alt="{{ $fasilitas->name }}"
                                            class="w-32 h-24 rounded-xl object-cover
                                                   border border-[#e2ebe9]"
                                        >

                                    </div>

                                @endif


                                {{-- INPUT FOTO BARU --}}
                                <input
                                    type="file"
                                    name="image"
                                    accept=".jpg,.jpeg,.png"
                                    class="w-full rounded-lg border border-gray-300
                                           bg-white px-3 py-2 text-sm text-gray-700
                                           file:mr-4
                                           file:rounded-md
                                           file:border-0
                                           file:bg-[#eef4f3]
                                           file:px-4
                                           file:py-2
                                           file:text-sm
                                           file:font-semibold
                                           file:text-[#19183b]
                                           hover:file:bg-[#e2ebe9]">

                                <p class="mt-1 text-xs text-[#708993]">
                                    Pilih foto baru jika ingin mengganti foto lama.
                                    Format JPG, JPEG, atau PNG. Maksimal 2 MB.
                                </p>

                                @error('image')
                                    <p class="mt-1 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- DESKRIPSI --}}
                            <div class="md:col-span-2">

                                <label class="block text-sm font-semibold text-[#19183b] mb-2">
                                    Deskripsi
                                </label>

                                <textarea
                                    name="description"
                                    rows="4"
                                    class="w-full rounded-lg border-gray-300
                                           focus:border-[#19183b]
                                           focus:ring-[#19183b]"
                                    placeholder="Deskripsi fasilitas">{{ old('description', $fasilitas->description) }}</textarea>

                                @error('description')
                                    <p class="mt-1 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>


                        {{-- =================================================
                            BUTTON
                        ================================================== --}}
                        <div class="flex justify-end gap-3 mt-6">

                            <a href="{{ route('admin.facilities.index') }}"
                               class="px-4 py-2.5 rounded-lg
                                      border border-gray-300
                                      text-sm font-medium text-gray-700
                                      hover:bg-gray-50">

                                Batal

                            </a>


                            <button
                                type="submit"
                                class="px-4 py-2.5 rounded-lg
                                       bg-[#19183b]
                                       text-white
                                       text-sm font-semibold
                                       hover:opacity-90
                                       transition">

                                Simpan Perubahan

                            </button>

                        </div>

                    </form>

                </div>

            </main>

        </div>

    </div>

</x-app-layout>