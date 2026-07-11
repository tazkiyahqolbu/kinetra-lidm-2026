@extends('layouts.dashboard')

@section('title', 'Profil Saya - KINETRA')

@section('content')
@php
    $user = auth()->user();
    $isTeacher = $user->role === 'teacher';
    $student = $isTeacher ? null : $user->studentProfile;
@endphp

<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Profil Saya</h1>
    <p class="text-gray-600 mt-2">Lihat informasi profile Anda</p>
</div>

<div class="max-w-2xl">
    <!-- Profile Card -->
    <div class="bg-white rounded-xl shadow-lg p-12">
        <!-- Avatar -->
        <div class="flex justify-center mb-8">
            <div class="w-32 h-32 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-5xl">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            </div>
        </div>

        <!-- Info -->
        <div class="space-y-6">
            <!-- Name -->
            <div class="border-b border-gray-200 pb-6">
                <p class="text-gray-600 text-sm font-semibold mb-1">Nama Lengkap</p>
                <p class="text-2xl font-bold text-gray-900">{{ $user->name }}</p>
            </div>

            <!-- Email -->
            <div class="border-b border-gray-200 pb-6">
                <p class="text-gray-600 text-sm font-semibold mb-1">Email</p>
                <p class="text-lg text-gray-900">{{ $user->email }}</p>
            </div>

            <!-- Role -->
            <div class="{{ $student ? 'border-b border-gray-200 pb-6' : '' }}">
                <p class="text-gray-600 text-sm font-semibold mb-1">Peran</p>
                <div class="flex items-center space-x-2">
                    @if($isTeacher)
                        <span class="bg-emerald-100 text-emerald-800 px-4 py-2 rounded-full text-sm font-semibold">Guru</span>
                    @else
                        <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-semibold">Siswa</span>
                    @endif
                </div>
            </div>

            @if($student)
                <!-- Kelas -->
                <div class="border-b border-gray-200 pb-6">
                    <p class="text-gray-600 text-sm font-semibold mb-1">Kelas</p>
                    <p class="text-lg text-gray-900">{{ $student->classRoom->class_name ?? '-' }}</p>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 gap-6 mt-8 pt-6 border-t border-gray-200">
                    <div class="text-center">
                        <p class="text-3xl font-bold text-blue-600">{{ $student->analysisHistories->count() }}</p>
                        <p class="text-gray-600 text-sm mt-1">Total Latihan</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-emerald-500">{{ $student->analysisHistories->max('score') ?? 0 }}</p>
                        <p class="text-gray-600 text-sm mt-1">Nilai Terbaik</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Ganti Password -->
    <div class="bg-white rounded-xl shadow-lg p-12 mt-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Ganti Password</h2>

        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg p-3 mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3 mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
            @csrf

            <div>
                <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition">
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                <input type="password" id="password" name="password"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 transition">
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition">
                Simpan Password Baru
            </button>
        </form>
    </div>
</div>

@endsection
