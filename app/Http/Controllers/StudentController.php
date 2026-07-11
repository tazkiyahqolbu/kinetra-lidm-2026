<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'classRoom'])->inClassesOwnedBy(Auth::id())->get();
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
        $temporaryPassword = Str::random(10);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $temporaryPassword,
            'role' => 'student',
        ]);

        // 2. Buat Student Profile
        Student::create([
            'user_id' => $user->id,
            'class_id' => $validated['class_id'],
            'nis' => $validated['nis'],
            'temporary_password' => $temporaryPassword,
        ]);

        return back()->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $student = Student::inClassesOwnedBy(Auth::id())->findOrFail($id);
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
        $student = Student::inClassesOwnedBy(Auth::id())->findOrFail($id);

        // Hapus user terkait, tabel students otomatis terhapus karena 'onDelete cascade'
        User::destroy($student->user_id);

        return back()->with('success', 'Siswa berhasil dihapus!');
    }
}
