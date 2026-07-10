@extends('layouts.dashboard', ['role' => 'Siswa'])

@section('title', 'Mulai Analisis - KINETRA')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Mulai Analisis Gerak</h1>
    <p class="text-gray-600 mt-2">Analisis gerakan olahraga Anda secara real-time</p>
</div>

<!-- Main Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left: Video -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Video Placeholder -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 h-96 md:h-[500px] flex items-center justify-center relative">
                <div class="text-center space-y-4 z-10">
                    <div class="w-20 h-20 bg-gray-700 rounded-lg mx-auto flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-white text-xl">Video Placeholder</p>
                    <p class="text-sm text-gray-400">Kamera akan ditampilkan di sini</p>
                </div>
                <!-- Overlay -->
                <div class="absolute inset-0 bg-black opacity-30"></div>
            </div>

            <!-- Controls -->
            <div class="p-8 bg-white space-y-6">
                <!-- Gerakan Selection -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Pilih Jenis Gerakan</label>
                    <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                        <option>-- Pilih Gerakan --</option>
                        <option selected>Squat</option>
                        <option>Push-up</option>
                        <option>Lunge</option>
                        <option>Plank</option>
                        <option>Sit-up</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-lg transition shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                        <span>Mulai Rekam</span>
                    </button>
                    <button class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-lg transition shadow-lg hover:shadow-xl flex items-center justify-center space-x-2 opacity-50 cursor-not-allowed">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 4h12v12H6z"/>
                        </svg>
                        <span>Hentikan</span>
                    </button>
                </div>

                <!-- Info -->
                <div class="bg-blue-50 border-l-4 border-blue-600 p-4 rounded">
                    <p class="text-sm text-gray-700">
                        <strong>Tips:</strong> Pastikan seluruh tubuh Anda terlihat dalam frame kamera untuk hasil analisis yang akurat.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Real-time Data -->
    <div class="space-y-6">
        <!-- Timer -->
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            <p class="text-gray-600 text-sm font-semibold mb-2">Durasi Rekaman</p>
            <p class="text-5xl font-bold text-blue-600">0:00</p>
        </div>

        <!-- Repetition -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Repetition</p>
                    <p class="text-4xl font-bold text-gray-900 mt-2">0</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Knee Angle -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Sudut Lutut</p>
                    <p class="text-4xl font-bold text-gray-900 mt-2">--°</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <p class="text-gray-600 text-sm font-semibold mb-3">Status Gerakan</p>
            <div class="space-y-2">
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 bg-gray-400 rounded-full"></span>
                    <span class="text-gray-600">Menunggu rekaman dimulai...</span>
                </div>
            </div>
        </div>

        <!-- Feedback Box -->
        <div class="bg-blue-50 rounded-xl shadow-lg p-6 border-l-4 border-blue-600">
            <h3 class="font-bold text-gray-900 mb-3">Feedback Real-time</h3>
            <p class="text-sm text-gray-700">
                Feedback akan muncul di sini saat Anda melakukan gerakan.
            </p>
        </div>
    </div>
</div>

@endsection
