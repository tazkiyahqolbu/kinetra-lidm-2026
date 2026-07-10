@extends('layouts.dashboard', ['role' => 'Siswa'])

@section('title', 'Dashboard - KINETRA')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard Siswa</h1>
    <p class="text-gray-600 mt-2">Pantau progress latihan Anda</p>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Latihan Terakhir -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Latihan Terakhir</p>
                <p class="text-2xl font-bold text-gray-900 mt-2">Squat</p>
                <p class="text-sm text-gray-500 mt-1">2 hari yang lalu</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Nilai Terbaik -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-emerald-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Nilai Terbaik</p>
                <p class="text-2xl font-bold text-gray-900 mt-2">92</p>
                <p class="text-sm text-gray-500 mt-1">Push-up</p>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Latihan -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Total Latihan</p>
                <p class="text-2xl font-bold text-gray-900 mt-2">18</p>
                <p class="text-sm text-gray-500 mt-1">Kali</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Quick Action -->
<div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-xl shadow-lg p-8 mb-8 text-center">
    <h2 class="text-2xl font-bold mb-4">Siap untuk Latihan?</h2>
    <a href="/student/analysis" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition">
        Mulai Analisis Sekarang
    </a>
</div>

<!-- Recent History -->
<div class="bg-white rounded-xl shadow-lg p-8">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Riwayat Terakhir</h2>
    
    <div class="space-y-4">
        @for($i = 1; $i <= 5; $i++)
        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
            <div class="flex-1">
                <p class="font-semibold text-gray-900">Latihan Gerakan {{ chr(64 + $i) }}</p>
                <p class="text-sm text-gray-600">{{ date('d M Y', strtotime("-$i days")) }} - 15 Repetition</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-blue-600">{{ 85 + rand(0, 15) }}</p>
                <p class="text-xs text-gray-500">Nilai</p>
            </div>
        </div>
        @endfor
    </div>

    <a href="/student/history" class="inline-block mt-6 text-blue-600 hover:text-blue-700 font-semibold">
        Lihat Semua Riwayat →
    </a>
</div>

@endsection
