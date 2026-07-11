@extends('layouts.dashboard')

@section('title', 'Teman Sekelas - KINETRA')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Teman Sekelas</h1>
    <p class="text-gray-600 mt-2">
        {{ $student?->classRoom?->class_name ?? 'Anda belum tergabung di kelas manapun' }}
    </p>
</div>

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
            <tr>
                <th class="text-left py-4 px-6 font-semibold">Nama</th>
                <th class="text-left py-4 px-6 font-semibold">NIS</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($classmates as $classmate)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-6 font-medium">{{ $classmate->user->name ?? '-' }}</td>
                <td class="py-4 px-6 text-sm text-gray-600">{{ $classmate->nis }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="py-6 px-6 text-center text-gray-500">Belum ada teman sekelas lain.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
