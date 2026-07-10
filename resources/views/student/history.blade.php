@extends('layouts.dashboard', ['role' => 'Siswa'])

@section('title', 'Riwayat Latihan - KINETRA')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Riwayat Latihan</h1>
    <p class="text-gray-600 mt-2">Lihat semua riwayat analisis gerak Anda</p>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
            <tr>
                <th class="text-left py-4 px-6 font-semibold">Tanggal</th>
                <th class="text-left py-4 px-6 font-semibold">Gerakan</th>
                <th class="text-left py-4 px-6 font-semibold">Repetition</th>
                <th class="text-left py-4 px-6 font-semibold">ROM</th>
                <th class="text-left py-4 px-6 font-semibold">Nilai</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @for($i = 1; $i <= 12; $i++)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-6 text-sm text-gray-600">{{ date('d M Y', strtotime("-$i days")) }}</td>
                <td class="py-4 px-6 font-medium">
                    @switch($i % 5)
                        @case(0) Squat @break
                        @case(1) Push-up @break
                        @case(2) Lunge @break
                        @case(3) Plank @break
                        @default Sit-up
                    @endswitch
                </td>
                <td class="py-4 px-6 text-center font-semibold">{{ 15 + ($i % 10) }}</td>
                <td class="py-4 px-6 text-center font-semibold">{{ 85 + rand(0, 20) }}°</td>
                <td class="py-4 px-6">
                    @php $score = 75 + rand(0, 25); @endphp
                    <span class="
                        @if($score >= 85) bg-emerald-100 text-emerald-800
                        @elseif($score >= 75) bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif
                        px-3 py-1 rounded-full text-sm font-semibold">
                        {{ $score }}
                    </span>
                </td>
            </tr>
            @endfor
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6 flex justify-center gap-2">
    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">← Sebelumnya</button>
    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">1</button>
    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">2</button>
    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Selanjutnya →</button>
</div>

@endsection
