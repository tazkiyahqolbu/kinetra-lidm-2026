@extends('layouts.dashboard', ['role' => 'Guru'])

@section('title', 'Data Siswa - KINETRA')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Data Siswa</h1>
    <p class="text-gray-600 mt-2">Daftar lengkap seluruh siswa Anda</p>
</div>

<!-- Search & Filter -->
<div class="mb-6 flex flex-col md:flex-row gap-4">
    <input 
        type="text" 
        placeholder="Cari nama siswa..."
        class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600"
    >
    <select class="px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 md:w-48">
        <option>Semua Kelas</option>
        <option>Kelas 10.A</option>
        <option>Kelas 10.B</option>
    </select>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
            <tr>
                <th class="text-left py-4 px-6 font-semibold">Nama</th>
                <th class="text-left py-4 px-6 font-semibold">Email</th>
                <th class="text-left py-4 px-6 font-semibold">Kelas</th>
                <th class="text-left py-4 px-6 font-semibold">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @php $students = ['Aldi Pratama', 'Siti Nurhaliza', 'Budi Santoso', 'Rini Wijaya', 'Doni Kurniawan']; @endphp
            @foreach($students as $student)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-6 font-medium">{{ $student }}</td>
                <td class="py-4 px-6 text-sm text-gray-600">{{ strtolower(str_replace(' ', '.', $student)) }}@school.id</td>
                <td class="py-4 px-6">10.A</td>
                <td class="py-4 px-6">
                    <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-sm font-semibold">Aktif</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6 flex justify-center gap-2">
    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">← Sebelumnya</button>
    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">1</button>
    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">2</button>
    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">3</button>
    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Selanjutnya →</button>
</div>

@endsection
