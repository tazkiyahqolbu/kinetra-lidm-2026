@extends('layouts.dashboard', ['role' => 'Guru'])

@section('title', 'Data Kelas - KINETRA')

@section('content')
<!-- Header -->
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Data Kelas</h1>
        <p class="text-gray-600 mt-2">Kelola semua kelas Anda</p>
    </div>
    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
        + Tambah Kelas
    </button>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
            <tr>
                <th class="text-left py-4 px-6 font-semibold">Nama Kelas</th>
                <th class="text-left py-4 px-6 font-semibold">Jumlah Siswa</th>
                <th class="text-left py-4 px-6 font-semibold">Semester</th>
                <th class="text-left py-4 px-6 font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @for($i = 1; $i <= 5; $i++)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-6 font-medium">Kelas {{ 10 + $i }}.{{ chr(64 + $i) }}</td>
                <td class="py-4 px-6">{{ 28 + ($i * 2) }} Siswa</td>
                <td class="py-4 px-6 text-sm">Genap</td>
                <td class="py-4 px-6 flex space-x-3">
                    <a href="#" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">Edit</a>
                    <a href="#" class="text-red-600 hover:text-red-700 font-semibold text-sm">Hapus</a>
                </td>
            </tr>
            @endfor
        </tbody>
    </table>
</div>

@endsection
