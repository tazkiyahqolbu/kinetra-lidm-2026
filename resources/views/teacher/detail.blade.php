@extends('layouts.dashboard', ['role' => 'Guru'])

@section('title', 'Detail Hasil Analisis - KINETRA')

@section('content')
<!-- Header -->
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Detail Hasil Analisis</h1>
        <p class="text-gray-600 mt-2">Analisis detail gerakan siswa</p>
    </div>
    <a href="/teacher/results" class="text-blue-600 hover:text-blue-700 font-semibold">← Kembali</a>
</div>

<!-- Main Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column - Video & Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Video Placeholder -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 h-96 flex items-center justify-center">
                <div class="text-center space-y-4">
                    <div class="w-20 h-20 bg-gray-700 rounded-lg mx-auto flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-white text-xl">Video Placeholder</p>
                    <p class="text-sm text-gray-400">Video analisis akan ditampilkan di sini</p>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Siswa</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Nama</p>
                    <p class="font-bold text-gray-900">Aldi Pratama</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Kelas</p>
                    <p class="font-bold text-gray-900">10.A</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Tanggal</p>
                    <p class="font-bold text-gray-900">10 Jul 2026</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Durasi</p>
                    <p class="font-bold text-gray-900">2 menit 15 detik</p>
                </div>
            </div>
        </div>

        <!-- Feedback -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Feedback & Catatan</h2>
            <div class="bg-blue-50 border-l-4 border-blue-600 p-6 rounded">
                <h3 class="font-bold text-gray-900 mb-3">Analisis Gerakan Squat</h3>
                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-start space-x-3">
                        <span class="text-green-600 font-bold mt-1">✓</span>
                        <span>Posisi punggung sangat baik, tulang belakang tetap lurus</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="text-green-600 font-bold mt-1">✓</span>
                        <span>Keseimbangan berat badan terdistribusi dengan sempurna</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="text-orange-600 font-bold mt-1">⚠</span>
                        <span>Lutut sedikit ke depan, coba lebih ke belakang</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="text-orange-600 font-bold mt-1">⚠</span>
                        <span>Kedalaman squat dapat ditingkatkan sedikit lagi</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Right Column - Stats -->
    <div class="space-y-6">
        <!-- Nilai Overall -->
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-xl shadow-lg p-8">
            <p class="text-white opacity-90 font-semibold mb-2">Nilai Keseluruhan</p>
            <div class="text-6xl font-bold mb-4">85</div>
            <div class="space-y-2 text-sm">
                <p>✓ Teknik Baik</p>
                <p>✓ Konsistensi Tinggi</p>
            </div>
        </div>

        <!-- Repetition -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <p class="text-gray-600 text-sm font-semibold mb-2">Total Repetition</p>
            <p class="text-4xl font-bold text-gray-900">20</p>
            <p class="text-gray-500 text-sm mt-2">Repetition standar: 15-25</p>
        </div>

        <!-- ROM (Range of Motion) -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <p class="text-gray-600 text-sm font-semibold mb-2">ROM (Range of Motion)</p>
            <p class="text-4xl font-bold text-gray-900">92°</p>
            <p class="text-gray-500 text-sm mt-2">Target: 90-110°</p>
        </div>

        <!-- Knee Angle -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <p class="text-gray-600 text-sm font-semibold mb-2">Sudut Lutut</p>
            <p class="text-4xl font-bold text-gray-900">95°</p>
            <p class="text-gray-500 text-sm mt-2">Ideal range: 80-100°</p>
        </div>

        <!-- Consistency Graph -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h3 class="font-bold text-gray-900 mb-4">Konsistensi Gerakan</h3>
            <div class="space-y-2">
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-700">Rep 1</span>
                    <span class="text-gray-700">92%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-emerald-500 h-2 rounded-full" style="width: 92%"></div>
                </div>
                
                <div class="flex justify-between text-sm mb-1 mt-3">
                    <span class="text-gray-700">Rep 2</span>
                    <span class="text-gray-700">88%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-emerald-500 h-2 rounded-full" style="width: 88%"></div>
                </div>

                <div class="flex justify-between text-sm mb-1 mt-3">
                    <span class="text-gray-700">Rep 3</span>
                    <span class="text-gray-700">85%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 85%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
