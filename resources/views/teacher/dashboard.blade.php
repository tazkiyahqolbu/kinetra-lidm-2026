@extends('layouts.dashboard')

@section('title', 'Ringkasan - KINETRA')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-900">Ringkasan</h1>
    <p class="text-gray-600 mt-2">Selamat datang kembali, Ibu/Bapak Guru</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Kelas -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-600">
        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">Total Kelas</p>
        <p class="text-4xl font-bold text-gray-900 mt-3">{{ $totalKelas }}</p>
    </div>

    <!-- Total Siswa -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-emerald-500">
        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">Total Siswa</p>
        <p class="text-4xl font-bold text-gray-900 mt-3">{{ $totalSiswa }}</p>
    </div>

    <!-- Analisis Hari Ini -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">Analisis Hari Ini</p>
        <p class="text-4xl font-bold text-gray-900 mt-3">{{ $analisisHariIni }}</p>
    </div>

    <!-- Total Analisis -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">Total Analisis</p>
        <p class="text-4xl font-bold text-gray-900 mt-3">{{ $totalAnalisis }}</p>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-xl shadow-lg p-8">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Aktivitas Terbaru</h2>
    
    <table class="w-full">
        <thead class="border-b-2 border-gray-200">
            <tr>
                <th class="text-left py-3 px-4 font-semibold text-gray-700">Nama Siswa</th>
                <th class="text-left py-3 px-4 font-semibold text-gray-700">Gerakan</th>
                <th class="text-left py-3 px-4 font-semibold text-gray-700">Waktu</th>
                <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($aktivitasTerbaru as $activity)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-4 font-medium">{{ $activity->student->user->name ?? '-' }}</td>
                <td class="py-4 px-4">Squat</td>
                <td class="py-4 px-4 text-sm text-gray-600">{{ $activity->created_at->format('d M Y, H:i') }}</td>
                <td class="py-4 px-4">
                    <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-semibold">Selesai</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="py-6 px-4 text-center text-gray-500">Belum ada aktivitas analisis.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <a href="/teacher/results" class="inline-block mt-6 text-blue-600 hover:text-blue-700 font-semibold">
        Lihat Semua →
    </a>
</div>

@endsection
