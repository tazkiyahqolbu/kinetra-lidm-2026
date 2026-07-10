@extends('layouts.dashboard', ['role' => 'Guru'])

@section('title', 'Dashboard - KINETRA')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-900">Dashboard Guru</h1>
    <p class="text-gray-600 mt-2">Selamat datang kembali, Ibu/Bapak Guru</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Kelas -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Total Kelas</p>
                <p class="text-4xl font-bold text-gray-900 mt-2">5</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 8.557 2 11.142c0 2.586 4.5 4.89 10 4.89m0-13c5.5 0 10 2.304 10 4.89c0 2.586-4.5 4.89-10 4.89m0 0c5.5 0 10 2.305 10 4.89 0 2.586-4.5 4.891-10 4.891-5.5 0-10-2.305-10-4.891C2 17.142 6.5 14.838 12 14.838z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Siswa -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-emerald-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Total Siswa</p>
                <p class="text-4xl font-bold text-gray-900 mt-2">142</p>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20a7 7 0 1114 0"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Analisis Hari Ini -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Analisis Hari Ini</p>
                <p class="text-4xl font-bold text-gray-900 mt-2">28</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Analisis -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Total Analisis</p>
                <p class="text-4xl font-bold text-gray-900 mt-2">1,234</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Grafik Analisis Per Minggu -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Analisis Per Minggu</h2>
        <div class="h-64 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg flex items-center justify-center">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-200 rounded-lg mx-auto flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                </div>
                <p class="text-gray-600 font-semibold">Chart.js</p>
                <p class="text-sm text-gray-500 mt-1">Data akan ditampilkan di sini</p>
            </div>
        </div>
    </div>

    <!-- Distribusi Kelas -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Distribusi Siswa Per Kelas</h2>
        <div class="h-64 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-lg flex items-center justify-center">
            <div class="text-center">
                <div class="w-16 h-16 bg-emerald-200 rounded-lg mx-auto flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <p class="text-gray-600 font-semibold">Chart.js</p>
                <p class="text-sm text-gray-500 mt-1">Data akan ditampilkan di sini</p>
            </div>
        </div>
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
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-4 font-medium">Aldi Pratama</td>
                <td class="py-4 px-4">Squat</td>
                <td class="py-4 px-4 text-sm text-gray-600">10:30 AM</td>
                <td class="py-4 px-4">
                    <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-semibold">Selesai</span>
                </td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-4 font-medium">Siti Nurhaliza</td>
                <td class="py-4 px-4">Push-up</td>
                <td class="py-4 px-4 text-sm text-gray-600">09:15 AM</td>
                <td class="py-4 px-4">
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">Berlangsung</span>
                </td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-4 font-medium">Budi Santoso</td>
                <td class="py-4 px-4">Lunge</td>
                <td class="py-4 px-4 text-sm text-gray-600">08:45 AM</td>
                <td class="py-4 px-4">
                    <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-semibold">Selesai</span>
                </td>
            </tr>
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-4 font-medium">Rini Wijaya</td>
                <td class="py-4 px-4">Plank</td>
                <td class="py-4 px-4 text-sm text-gray-600">Kemarin</td>
                <td class="py-4 px-4">
                    <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-semibold">Selesai</span>
                </td>
            </tr>
        </tbody>
    </table>

    <a href="/teacher/results" class="inline-block mt-6 text-blue-600 hover:text-blue-700 font-semibold">
        Lihat Semua →
    </a>
</div>

@endsection
