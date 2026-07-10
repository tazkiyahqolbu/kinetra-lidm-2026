@extends('layouts.dashboard')

@section('title', 'Kelas Saya - KINETRA')

@section('content')
<!-- Header -->
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Kelas Saya</h1>
        <p class="text-gray-600 mt-2">Kelola semua kelas Anda. Bagikan "Kode Kelas" ke siswa agar mereka bisa bergabung saat mendaftar.</p>
    </div>
    <button type="button" onclick="document.getElementById('modal-add-class').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
        + Tambah Kelas
    </button>
</div>

@if(session('success'))
    <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg p-3">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3">
        {{ $errors->first() }}
    </div>
@endif

<!-- Table -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
            <tr>
                <th class="text-left py-4 px-6 font-semibold">Nama Kelas</th>
                <th class="text-left py-4 px-6 font-semibold">Kode Kelas</th>
                <th class="text-left py-4 px-6 font-semibold">Jumlah Siswa</th>
                <th class="text-left py-4 px-6 font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($classes as $class)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-6 font-medium">{{ $class->class_name }}</td>
                <td class="py-4 px-6">
                    <span class="font-mono font-bold tracking-wider bg-blue-50 text-blue-700 px-3 py-1 rounded-lg">{{ $class->class_code }}</span>
                </td>
                <td class="py-4 px-6">{{ $class->students_count }} Siswa</td>
                <td class="py-4 px-6 flex space-x-3">
                    <button type="button" onclick="document.getElementById('modal-edit-class-{{ $class->id }}').classList.remove('hidden')" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">Edit</button>
                    <form method="POST" action="/classes/{{ $class->id }}" onsubmit="return confirm('Hapus kelas {{ $class->class_name }}? Semua data siswa di kelas ini juga akan terhapus.')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-700 font-semibold text-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="py-6 px-6 text-center text-gray-500">Belum ada kelas. Klik "+ Tambah Kelas" untuk membuat kelas pertama.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div id="modal-add-class" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Tambah Kelas</h2>
        <form method="POST" action="/classes">
            @csrf
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kelas</label>
            <input type="text" name="class_name" required placeholder="Contoh: 10.A" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg mb-4">
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold">Simpan</button>
                <button type="button" onclick="document.getElementById('modal-add-class').classList.add('hidden')" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-lg font-semibold">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modals (one per class) -->
@foreach($classes as $class)
<div id="modal-edit-class-{{ $class->id }}" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Edit Kelas</h2>
        <form method="POST" action="/classes/{{ $class->id }}">
            @csrf
            @method('PUT')
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kelas</label>
            <input type="text" name="class_name" value="{{ $class->class_name }}" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg mb-4">
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold">Simpan</button>
                <button type="button" onclick="document.getElementById('modal-edit-class-{{ $class->id }}').classList.add('hidden')" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-lg font-semibold">Batal</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection
