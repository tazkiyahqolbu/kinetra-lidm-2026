@extends('layouts.dashboard')

@section('title', 'Detail Latihan - KINETRA')

@section('content')
<!-- Header -->
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Detail Latihan</h1>
        <p class="text-gray-600 mt-2">{{ \Carbon\Carbon::parse($history->date)->format('d M Y') }} - Squat</p>
    </div>
    <a href="/student/history" class="text-blue-600 hover:text-blue-700 font-semibold">← Kembali</a>
</div>

<!-- Main Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column - Snapshot, Chart & Feedback -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Snapshots -->
        @include('components.snapshot-panel', ['history' => $history])

        <!-- Chart -->
        @include('components.angle-chart', ['angles' => $history->angles, 'id' => 'chart-student-' . $history->id])

        <!-- Feedback -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Feedback & Catatan</h2>
            <div class="bg-blue-50 border-l-4 border-blue-600 p-6 rounded">
                <h3 class="font-bold text-gray-900 mb-3">Analisis Gerakan Squat</h3>
                @if(count($feedback) > 0)
                    <ul class="space-y-3 text-gray-700">
                        @foreach($feedback as $item)
                        <li class="flex items-start space-x-3">
                            <span class="{{ $item['level'] === 'success' ? 'text-green-600' : 'text-orange-600' }} font-bold mt-1">
                                {{ $item['level'] === 'success' ? '✓' : '⚠' }}
                            </span>
                            <span>{{ $item['message'] }}</span>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-600">Tidak ada catatan feedback untuk sesi ini.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column - Stats -->
    <div class="space-y-6">
        <!-- Nilai Overall -->
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-xl shadow-lg p-8">
            <p class="text-white opacity-90 font-semibold mb-2">Nilai Keseluruhan</p>
            <div class="text-6xl font-bold mb-4">{{ $history->score }}</div>
        </div>

        <!-- Repetition -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <p class="text-gray-600 text-sm font-semibold mb-2">Total Repetition</p>
            <p class="text-4xl font-bold text-gray-900">{{ $history->repetition }}</p>
        </div>

        <!-- ROM (Range of Motion) -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <p class="text-gray-600 text-sm font-semibold mb-2">ROM (Range of Motion)</p>
            <p class="text-4xl font-bold text-gray-900">{{ $history->rom }}°</p>
        </div>
    </div>
</div>

@endsection
