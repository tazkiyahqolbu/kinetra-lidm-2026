<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $request->merge(['class_code' => strtoupper((string) $request->input('class_code'))]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:guru,siswa',
            'class_code' => 'required_if:role,siswa|nullable|exists:class_rooms,class_code',
            'nis' => 'required_if:role,siswa|nullable|string|unique:students,nis',
        ], [
            'class_code.exists' => 'Kode kelas tidak ditemukan. Pastikan kode sudah benar.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] === 'guru' ? 'teacher' : 'student',
        ]);

        if ($validated['role'] === 'siswa') {
            $class = ClassRoom::where('class_code', $validated['class_code'])->firstOrFail();

            Student::create([
                'user_id' => $user->id,
                'class_id' => $class->id,
                'nis' => $validated['nis'],
            ]);
        }

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
