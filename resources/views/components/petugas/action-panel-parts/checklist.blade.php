@props([
    'items' => []
])

<div class="flex flex-col gap-2">

    <p class="text-xs font-bold text-[#1e293b]">
        CHECKLIST VERIFIKASI
    </p>

    @foreach ($items as $item)

        <label class="flex items-start gap-3 bg-[#f8fafc] border border-[#e2e8f0] rounded-lg p-3">

            <input 
                type="checkbox"
                class="mt-1 size-4 rounded border-gray-300"
            >

            <span class="text-xs text-[#475569] leading-5">
                {{ $item }}
            </span>

        </label>

    @endforeach
</div>