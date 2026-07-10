@extends('layouts.dashboard')

@section('title', 'Jejak Latihan - KINETRA')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Jejak Latihan</h1>
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
                <th class="text-left py-4 px-6 font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($histories as $item)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-6 text-sm text-gray-600">{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</td>
                <td class="py-4 px-6 font-medium">Squat</td>
                <td class="py-4 px-6 text-center font-semibold">{{ $item->repetition }}</td>
                <td class="py-4 px-6 text-center font-semibold">{{ $item->rom }}°</td>
                <td class="py-4 px-6">
                    <span class="
                        @if($item->score >= 85) bg-emerald-100 text-emerald-800
                        @elseif($item->score >= 75) bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif
                        px-3 py-1 rounded-full text-sm font-semibold">
                        {{ $item->score }}
                    </span>
                </td>
                <td class="py-4 px-6">
                    <a href="/student/history/{{ $item->id }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">Lihat Detail</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-6 px-6 text-center text-gray-500">Belum ada riwayat latihan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $histories->links() }}
</div>

@endsection
