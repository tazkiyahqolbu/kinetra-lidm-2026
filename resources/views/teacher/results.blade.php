@extends('layouts.dashboard', ['role' => 'Guru'])

@section('title', 'Hasil Analisis - KINETRA')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Hasil Analisis</h1>
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
            @for($i = 1; $i <= 8; $i++)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-6 font-medium">Siswa {{ $i }}</td>
                <td class="py-4 px-6 text-sm text-gray-600">{{ date('d M Y', strtotime("-$i days")) }}</td>
                <td class="py-4 px-6 text-center font-semibold">{{ 15 + ($i * 2) }}</td>
                <td class="py-4 px-6 text-center font-semibold">{{ 85 + rand(0, 15) }}°</td>
                <td class="py-4 px-6">
                    <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-semibold">{{ 75 + rand(0, 25) }}</span>
                </td>
                <td class="py-4 px-6">
                    <a href="/teacher/detail/{{ $i }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">Lihat Detail</a>
                </td>
            </tr>
            @endfor
        </tbody>
    </table>
</div>

@endsection
