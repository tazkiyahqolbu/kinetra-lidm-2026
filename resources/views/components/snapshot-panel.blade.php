@php
    $panels = [
        ['label' => 'Awal (Berdiri)', 'path' => $history->snapshot_start_path],
        ['label' => 'Titik Terdalam', 'path' => $history->snapshot_bottom_path],
        ['label' => 'Akhir (Berdiri)', 'path' => $history->snapshot_end_path],
    ];
@endphp

<div class="bg-white rounded-xl shadow-lg p-8">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Cuplikan Gerakan</h2>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach($panels as $panel)
            <div>
                <div class="rounded-lg overflow-hidden bg-gray-900 aspect-square flex items-center justify-center">
                    @if($panel['path'])
                        <img src="{{ asset('storage/' . $panel['path']) }}" alt="{{ $panel['label'] }}" class="w-full h-full object-contain">
                    @else
                        <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18M10.5 10.5a2 2 0 002.83 2.83M9.88 4.24A9.06 9.06 0 0112 4c5.5 0 9 5 9 8a9.77 9.77 0 01-1.68 2.68M6.1 6.1C4.14 7.55 3 9.6 3 12c0 3 3.5 8 9 8a8.9 8.9 0 004.02-.94"></path>
                        </svg>
                    @endif
                </div>
                <p class="text-center text-sm font-semibold text-gray-700 mt-2">{{ $panel['label'] }}</p>
            </div>
        @endforeach
    </div>
    @if(!$history->snapshot_start_path && !$history->snapshot_bottom_path && !$history->snapshot_end_path)
        <p class="text-gray-500 text-center text-sm mt-4">Sesi ini disimpan sebelum fitur cuplikan foto tersedia.</p>
    @endif
</div>
