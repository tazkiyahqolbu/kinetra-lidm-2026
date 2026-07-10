@extends('layouts.dashboard')

@section('title', 'Progress Saya - KINETRA')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Halo, {{ explode(' ', auth()->user()->name)[0] }}</h1>
    <p class="text-gray-600 mt-2">
        @if($totalLatihan > 0)
            Ini progress latihan squat kamu sejauh ini.
        @else
            Belum ada latihan tercatat — yuk mulai sesi pertamamu.
        @endif
    </p>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Latihan Terakhir -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-600">
        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">Latihan Terakhir</p>
        <p class="text-3xl font-bold text-gray-900 mt-3">{{ $latihanTerakhir ? $latihanTerakhir->score : '-' }}</p>
        <p class="text-sm text-gray-500 mt-1">{{ $latihanTerakhir ? $latihanTerakhir->created_at->diffForHumans() : 'Belum ada latihan' }}</p>
        @if($latihanTerakhir && $sebelumnya)
            @php $selisih = $latihanTerakhir->score - $sebelumnya->score; @endphp
            <p class="text-xs font-semibold mt-3 {{ $selisih >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                {{ $selisih >= 0 ? '▲' : '▼' }} {{ abs($selisih) }} poin dari sesi sebelumnya
            </p>
        @endif
    </div>

    <!-- Nilai Terbaik -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-emerald-500">
        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">Nilai Terbaik</p>
        <p class="text-3xl font-bold text-gray-900 mt-3">{{ $nilaiTerbaik ?? 0 }}</p>
        <p class="text-sm text-gray-500 mt-1">Squat</p>
    </div>

    <!-- Rata-rata Nilai -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">Rata-rata Nilai</p>
        <p class="text-3xl font-bold text-gray-900 mt-3">{{ $rataRata ?? '-' }}</p>
        <p class="text-sm text-gray-500 mt-1">Dari {{ $totalLatihan }} sesi</p>
    </div>

    <!-- Sesi Minggu Ini -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
        <p class="text-gray-500 text-xs font-semibold uppercase tracking-wide">Sesi Minggu Ini</p>
        <p class="text-3xl font-bold text-gray-900 mt-3">{{ $sesiMingguIni }}</p>
        <p class="text-sm text-gray-500 mt-1">Kali latihan</p>
    </div>
</div>

<!-- Quick Action -->
<div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-xl shadow-lg p-8 mb-8 text-center">
    <h2 class="text-2xl font-bold mb-4">
        {{ $totalLatihan > 0 ? 'Lanjutkan Latihanmu' : 'Siap untuk Latihan Pertama?' }}
    </h2>
    <a href="/student/analysis" class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition">
        Mulai Analisis Sekarang
    </a>
</div>

<!-- Recent History -->
<div class="bg-white rounded-xl shadow-lg p-8">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Riwayat Terakhir</h2>

    <div class="space-y-4">
        @forelse($riwayatTerbaru as $item)
        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
            <div class="flex-1">
                <p class="font-semibold text-gray-900">Latihan Squat</p>
                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }} - {{ $item->repetition }} Repetition</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-blue-600">{{ $item->score }}</p>
                @php
                    $label = $item->score >= 80 ? 'Sangat Baik' : ($item->score >= 60 ? 'Baik' : 'Perlu Latihan');
                    $badge = $item->score >= 80 ? 'bg-emerald-100 text-emerald-700' : ($item->score >= 60 ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700');
                @endphp
                <span class="inline-block mt-1 text-xs font-semibold px-2 py-0.5 rounded-full {{ $badge }}">{{ $label }}</span>
            </div>
        </div>
        @empty
        <p class="text-gray-500 text-center py-6">Belum ada riwayat latihan.</p>
        @endforelse
    </div>

    <a href="/student/history" class="inline-block mt-6 text-blue-600 hover:text-blue-700 font-semibold">
        Lihat Semua Riwayat →
    </a>
</div>

@endsection
