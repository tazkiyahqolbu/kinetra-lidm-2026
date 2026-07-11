@extends('layouts.dashboard')

@section('title', 'Siswa Saya - KINETRA')

@section('content')
<!-- Header -->
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Siswa Saya</h1>
        <p class="text-gray-600 mt-2">Daftar lengkap seluruh siswa Anda</p>
    </div>
    <button type="button" onclick="document.getElementById('modal-add-student').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
        + Tambah Siswa
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

<!-- Search & Filter -->
<form method="GET" action="/teacher/students" class="mb-6 flex flex-col md:flex-row gap-4">
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Cari nama siswa..."
        class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600"
    >
    <select name="class_id" onchange="this.form.submit()" class="px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-600 md:w-48">
        <option value="">Semua Kelas</option>
        @foreach($classes as $class)
            <option value="{{ $class->id }}" @selected(request('class_id') == $class->id)>{{ $class->class_name }}</option>
        @endforeach
    </select>
    <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold">Cari</button>
</form>

<!-- Table -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
            <tr>
                <th class="text-left py-4 px-6 font-semibold">Nama</th>
                <th class="text-left py-4 px-6 font-semibold">Email</th>
                <th class="text-left py-4 px-6 font-semibold">NIS</th>
                <th class="text-left py-4 px-6 font-semibold">Kelas</th>
                <th class="text-left py-4 px-6 font-semibold">Password Sementara</th>
                <th class="text-left py-4 px-6 font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($students as $student)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-6 font-medium">{{ $student->user->name ?? '-' }}</td>
                <td class="py-4 px-6 text-sm text-gray-600">{{ $student->user->email ?? '-' }}</td>
                <td class="py-4 px-6 text-sm text-gray-600">{{ $student->nis }}</td>
                <td class="py-4 px-6">{{ $student->classRoom->class_name ?? '-' }}</td>
                <td class="py-4 px-6 text-sm">
                    @if($student->temporary_password)
                        <span class="font-mono bg-yellow-50 text-yellow-800 px-2 py-1 rounded">{{ $student->temporary_password }}</span>
                    @else
                        <span class="text-gray-400">Sudah diganti siswa</span>
                    @endif
                </td>
                <td class="py-4 px-6 flex space-x-3">
                    <button type="button" onclick="document.getElementById('modal-edit-student-{{ $student->id }}').classList.remove('hidden')" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">Edit</button>
                    <form method="POST" action="/students/{{ $student->id }}" onsubmit="return confirm('Hapus siswa {{ $student->user->name ?? '' }}? Akun login siswa ini juga akan terhapus.')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-700 font-semibold text-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-6 px-6 text-center text-gray-500">Belum ada siswa yang cocok.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $students->links() }}
</div>

<!-- Add Modal -->
<div id="modal-add-student" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Tambah Siswa</h2>
        <form method="POST" action="/students">
            @csrf
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
            <input type="text" name="name" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg mb-4">

            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
            <input type="email" name="email" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg mb-4">

            <label class="block text-sm font-semibold text-gray-700 mb-2">NIS</label>
            <input type="text" name="nis" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg mb-4">

            <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas</label>
            <select name="class_id" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg mb-4">
                <option value="">-- Pilih Kelas --</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                @endforeach
            </select>

            <p class="text-xs text-gray-500 mb-4">Password sementara acak akan dibuatkan otomatis dan tampil di kolom "Password Sementara" pada tabel siswa.</p>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold">Simpan</button>
                <button type="button" onclick="document.getElementById('modal-add-student').classList.add('hidden')" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-lg font-semibold">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modals (one per student) -->
@foreach($students as $student)
<div id="modal-edit-student-{{ $student->id }}" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Edit Siswa</h2>
        <form method="POST" action="/students/{{ $student->id }}">
            @csrf
            @method('PUT')
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
            <input type="text" name="name" value="{{ $student->user->name }}" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg mb-4">

            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
            <input type="email" name="email" value="{{ $student->user->email }}" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg mb-4">

            <label class="block text-sm font-semibold text-gray-700 mb-2">NIS</label>
            <input type="text" name="nis" value="{{ $student->nis }}" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg mb-4">

            <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas</label>
            <select name="class_id" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg mb-4">
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" @selected($student->class_id == $class->id)>{{ $class->class_name }}</option>
                @endforeach
            </select>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold">Simpan</button>
                <button type="button" onclick="document.getElementById('modal-edit-student-{{ $student->id }}').classList.add('hidden')" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-lg font-semibold">Batal</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection
