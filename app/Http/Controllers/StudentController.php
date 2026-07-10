<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $classIds = ClassRoom::where('teacher_id', Auth::id())->pluck('id');
        $students = Student::with(['user', 'classRoom'])->whereIn('class_id', $classIds)->get();
        return response()->json($students);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nis' => 'required|string|unique:students,nis',
            'class_id' => [
                'required',
                Rule::exists('class_rooms', 'id')->where('teacher_id', Auth::id()),
            ],
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

        return back()->with('success', 'Siswa berhasil ditambahkan! Password default: password123');
    }

    public function update(Request $request, $id)
    {
        $classIds = ClassRoom::where('teacher_id', Auth::id())->pluck('id');
        $student = Student::whereIn('class_id', $classIds)->findOrFail($id);
        $user = $student->user;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nis' => 'required|string|unique:students,nis,' . $student->id,
            'class_id' => [
                'required',
                Rule::exists('class_rooms', 'id')->where('teacher_id', Auth::id()),
            ],
        ]);

        $user->update(['name' => $validated['name'], 'email' => $validated['email']]);
        $student->update(['class_id' => $validated['class_id'], 'nis' => $validated['nis']]);

        return back()->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $classIds = ClassRoom::where('teacher_id', Auth::id())->pluck('id');
        $student = Student::whereIn('class_id', $classIds)->findOrFail($id);

        // Hapus user terkait, tabel students otomatis terhapus karena 'onDelete cascade'
        User::destroy($student->user_id);

        return back()->with('success', 'Siswa berhasil dihapus!');
    }
}
