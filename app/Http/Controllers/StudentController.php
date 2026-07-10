<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'classRoom'])->get();
        return response()->json($students);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nis' => 'required|string|unique:students,nis',
            'class_id' => 'required|exists:class_rooms,id',
        ]);

        // 1. Buat User Account untuk Siswa
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make('password123'), // Default password siswa
            'role' => 'student',
        ]);

        // 2. Buat Student Profile
        Student::create([
            'user_id' => $user->id,
            'class_id' => $validated['class_id'],
            'nis' => $validated['nis'],
        ]);

        return response()->json(['message' => 'Siswa berhasil ditambahkan!']);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $user = $student->user;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nis' => 'required|string|unique:students,nis,' . $student->id,
            'class_id' => 'required|exists:class_rooms,id',
        ]);

        $user->update(['name' => $validated['name'], 'email' => $validated['email']]);
        $student->update(['class_id' => $validated['class_id'], 'nis' => $validated['nis']]);

        return response()->json(['message' => 'Data siswa berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        // Hapus user terkait, tabel students otomatis terhapus karena 'onDelete cascade'
        User::destroy($student->user_id);

        return response()->json(['message' => 'Siswa berhasil dihapus!']);
    }
}
