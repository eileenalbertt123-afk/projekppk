<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fasilitas - {{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen">
    <nav class="border-b border-gray-800 px-6 py-4 flex justify-between items-center">
        <h1 class="text-lg font-bold">Sistem Reservasi Fasilitas</h1>
        <div class="flex gap-3">
            @guest
                <a href="{{ route('login') }}" class="text-sm text-indigo-400 hover:underline self-center">Log in</a>
                <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm">Register</a>
            @else
                <a href="{{ route('dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm">Dashboard</a>
            @endguest
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-6 py-10">
        <h2 class="text-2xl font-bold mb-6">Daftar Fasilitas</h2>

        <form method="GET" class="flex flex-wrap gap-2 mb-8">
            <select name="type" class="bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm">
                <option value="">Semua Tipe</option>
                @foreach ($types as $type)
                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
            <select name="location" class="bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm">
                <option value="">Semua Lokasi</option>
                @foreach ($locations as $location)
                    <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>{{ $location }}</option>
                @endforeach
            </select>
            <input type="number" name="capacity" placeholder="Kapasitas min" value="{{ request('capacity') }}" class="bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm">
            <select name="status" class="bg-gray-800 border border-gray-700 rounded-md px-3 py-2 text-sm">
                <option value="">Semua Status</option>
                <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="tidak tersedia" {{ request('status') == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
            </select>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm">Cari</button>
        </form>

        <div class="grid gap-4 md:grid-cols-2">
            @forelse ($facilities as $facility)
                <a href="{{ route('facilities.availability', $facility) }}" class="block border border-gray-800 bg-gray-800/50 rounded-lg overflow-hidden hover:bg-gray-800 transition">
                    @if ($facility->image)
                        <img src="{{ asset('storage/' . $facility->image) }}" alt="{{ $facility->name }}" class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-gray-700 flex items-center justify-center text-gray-500 text-sm">Tidak ada gambar</div>
                    @endif
                    <div class="p-5">
                        <div class="flex items-center justify-between gap-2">
                            <h3 class="font-semibold text-lg">{{ $facility->name }}</h3>
                            <span class="text-xs px-2 py-1 rounded-full {{ $facility->status === 'tersedia' ? 'bg-green-600/20 text-green-400' : 'bg-red-600/20 text-red-400' }}">
                                {{ ucfirst($facility->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-400 mt-1">{{ $facility->type }} &middot; {{ $facility->location }} &middot; Kapasitas {{ $facility->capacity }}</p>
                    </div>
                </a>
            @empty
                <p class="text-gray-500 col-span-2">Belum ada fasilitas.</p>
            @endforelse
        </div>
    </div>
</body>
</html>