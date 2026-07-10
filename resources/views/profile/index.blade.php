@extends('layouts.dashboard')

@section('title', 'Profile - KINETRA')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Profile</h1>
    <p class="text-gray-600 mt-2">Lihat dan kelola informasi profile Anda</p>
</div>

<div class="max-w-2xl">
    <!-- Profile Card -->
    <div class="bg-white rounded-xl shadow-lg p-12">
        <!-- Avatar -->
        <div class="flex justify-center mb-8">
            <div class="w-32 h-32 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-5xl">A</span>
            </div>
        </div>

        <!-- Info -->
        <div class="space-y-6">
            <!-- Name -->
            <div class="border-b border-gray-200 pb-6">
                <p class="text-gray-600 text-sm font-semibold mb-1">Nama Lengkap</p>
                <p class="text-2xl font-bold text-gray-900">Aldi Pratama</p>
            </div>

            <!-- Email -->
            <div class="border-b border-gray-200 pb-6">
                <p class="text-gray-600 text-sm font-semibold mb-1">Email</p>
                <p class="text-lg text-gray-900">aldi.pratama@school.id</p>
            </div>

            <!-- Role -->
            <div class="border-b border-gray-200 pb-6">
                <p class="text-gray-600 text-sm font-semibold mb-1">Peran</p>
                <div class="flex items-center space-x-2">
                    <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-semibold">👦 Siswa</span>
                </div>
            </div>

            <!-- Kelas -->
            <div class="border-b border-gray-200 pb-6">
                <p class="text-gray-600 text-sm font-semibold mb-1">Kelas</p>
                <p class="text-lg text-gray-900">10.A</p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 gap-6 mt-8 pt-6 border-t border-gray-200">
                <div class="text-center">
                    <p class="text-3xl font-bold text-blue-600">18</p>
                    <p class="text-gray-600 text-sm mt-1">Total Latihan</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-emerald-500">92</p>
                    <p class="text-gray-600 text-sm mt-1">Nilai Terbaik</p>
                </div>
            </div>
        </div>

        <!-- Edit Button -->
        <div class="mt-8">
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition shadow-lg hover:shadow-xl">
                Edit Profile
            </button>
        </div>

        <!-- Logout -->
        <div class="mt-4">
            <button class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg transition shadow-lg hover:shadow-xl">
                Logout
            </button>
        </div>
    </div>
</div>

@endsection
