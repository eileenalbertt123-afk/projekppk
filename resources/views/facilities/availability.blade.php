<x-guest-layout>
    <div class="max-w-2xl mx-auto mt-8 px-4">
        <a href="{{ route('facilities.index') }}" class="text-indigo-600 text-sm">&larr; Kembali</a>
        <h1 class="text-2xl font-bold mt-2 mb-1">{{ $facility->name }}</h1>
        <p class="text-gray-600 mb-4">{{ $facility->type }} - {{ $facility->location }} - Kapasitas {{ $facility->capacity }}</p>

        <form method="GET" class="mb-6">
            <label class="block text-sm font-medium mb-1">Pilih Tanggal</label>
            <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()" class="border rounded-md px-3 py-2">
        </form>

        <div class="grid grid-cols-3 gap-2">
            @foreach ($slots as $slot)
                <div class="text-center text-sm rounded-md py-2 {{ $slot['status'] === 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $slot['start'] }} - {{ $slot['end'] }}
                </div>
            @endforeach
        </div>
    </div>
</x-guest-layout>