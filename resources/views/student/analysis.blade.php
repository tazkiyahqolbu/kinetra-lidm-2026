@extends('layouts.dashboard')

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
            <!-- Camera preview -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 h-96 md:h-[500px] relative">
                <video id="squat-video" autoplay playsinline muted class="absolute inset-0 w-full h-full object-cover"></video>
                <canvas id="squat-canvas" class="hidden"></canvas>
                <canvas id="squat-overlay" class="absolute inset-0 w-full h-full object-cover"></canvas>
            </div>

            <!-- Controls -->
            <div class="p-8 bg-white space-y-6">
                <!-- Gerakan Selection -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Pilih Jenis Gerakan</label>
                    <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600">
                        <option selected>Squat</option>
                        <option disabled>Push-up (segera hadir)</option>
                        <option disabled>Lunge (segera hadir)</option>
                        <option disabled>Plank (segera hadir)</option>
                        <option disabled>Sit-up (segera hadir)</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-2">Saat ini hanya analisis Squat yang tersedia.</p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button id="btn-start" type="button" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-lg transition shadow-lg hover:shadow-xl flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                        <span>Mulai Rekam</span>
                    </button>
                    <button id="btn-stop" type="button" disabled class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-lg transition shadow-lg hover:shadow-xl flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed">
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
            <p id="stat-duration" class="text-5xl font-bold text-blue-600">0:00</p>
        </div>

        <!-- Repetition -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <p class="text-gray-600 text-sm font-semibold">Repetition</p>
            <p id="stat-repetition" class="text-4xl font-bold text-gray-900 mt-2">0</p>
        </div>

        <!-- Knee Angle -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <p class="text-gray-600 text-sm font-semibold">Sudut Lutut</p>
            <p id="stat-angle" class="text-4xl font-bold text-gray-900 mt-2">--°</p>
        </div>

        <!-- Status -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <p class="text-gray-600 text-sm font-semibold mb-3">Status Gerakan</p>
            <div class="space-y-2">
                <div class="flex items-center space-x-2">
                    <span id="stat-status-dot" class="w-3 h-3 bg-gray-400 rounded-full"></span>
                    <span id="stat-status-text" class="text-gray-600">Menunggu rekaman dimulai...</span>
                </div>
            </div>
        </div>

        <!-- Feedback Box -->
        <div class="bg-blue-50 rounded-xl shadow-lg p-6 border-l-4 border-blue-600">
            <h3 class="font-bold text-gray-900 mb-3">Feedback Real-time</h3>
            <div id="feedback-list">
                <p class="text-sm text-gray-700">
                    Feedback akan muncul di sini saat Anda melakukan gerakan.
                </p>
            </div>
        </div>
    </div>
</div>

@vite(['resources/js/analysis.js'])
@endsection
