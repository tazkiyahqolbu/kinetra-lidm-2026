@extends('layouts.dashboard')

@section('title', 'Laporan Latihan - KINETRA')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Laporan Latihan</h1>
    <p class="text-gray-600 mt-2">Hasil analisis gerakan seluruh siswa</p>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
            <tr>
                <th class="text-left py-4 px-6 font-semibold">Nama</th>
                <th class="text-left py-4 px-6 font-semibold">Tanggal</th>
                <th class="text-left py-4 px-6 font-semibold">Repetition</th>
                <th class="text-left py-4 px-6 font-semibold">ROM</th>
                <th class="text-left py-4 px-6 font-semibold">Nilai</th>
                <th class="text-left py-4 px-6 font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($results as $result)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-6 font-medium">{{ $result->student->user->name ?? '-' }}</td>
                <td class="py-4 px-6 text-sm text-gray-600">{{ \Carbon\Carbon::parse($result->date)->format('d M Y') }}</td>
                <td class="py-4 px-6 text-center font-semibold">{{ $result->repetition }}</td>
                <td class="py-4 px-6 text-center font-semibold">{{ $result->rom }}°</td>
                <td class="py-4 px-6">
                    <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-semibold">{{ $result->score }}</span>
                </td>
                <td class="py-4 px-6">
                    <a href="/teacher/detail/{{ $result->id }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">Lihat Detail</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-6 px-6 text-center text-gray-500">Belum ada hasil analisis.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $results->links() }}
</div>

@endsection
