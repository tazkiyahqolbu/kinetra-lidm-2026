<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\AnalysisHistory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Guru (Teacher)
        $teacherUser = User::create([
            'name' => 'Guru PJOK',
            'email' => 'guru@kinetra.com',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
        ]);

        // 2. Buat Kelas (ClassRooms)
        $class1 = ClassRoom::create([
            'teacher_id' => $teacherUser->id,
            'class_name' => 'XI IPA 1',
        ]);

        $class2 = ClassRoom::create([
            'teacher_id' => $teacherUser->id,
            'class_name' => 'XI IPA 2',
        ]);

        // 3. Buat Data Siswa Dummy (Users & Student Profiles)
        $studentsData = [
            ['name' => 'Andi', 'email' => 'andi@kinetra.com', 'nis' => '10001', 'class_id' => $class1->id],
            ['name' => 'Budi', 'email' => 'budi@kinetra.com', 'nis' => '10002', 'class_id' => $class1->id],
            ['name' => 'Citra', 'email' => 'citra@kinetra.com', 'nis' => '10003', 'class_id' => $class2->id],
            ['name' => 'Dewi', 'email' => 'dewi@kinetra.com', 'nis' => '10004', 'class_id' => $class2->id],
        ];

        foreach ($studentsData as $data) {
            // Buat akun user siswa
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password123'),
                'role' => 'student',
            ]);

            // Hubungkan ke profil student dan kelasnya
            $student = Student::create([
                'user_id' => $user->id,
                'class_id' => $data['class_id'],
                'nis' => $data['nis'],
            ]);

            // 4. Buat Data Dummy Riwayat Analisis (AnalysisHistories) untuk tiap siswa
            AnalysisHistory::create([
                'student_id' => $student->id,
                'date' => Carbon::now()->subDays(1)->format('Y-m-d'),
                'repetition' => 12,
                'rom' => 135.5,
                'score' => 85,
                'feedback' => 'Gerakan squat sudah konsisten, pertahankan sudut lutut.',
                'video_path' => 'videos/squat_sample_' . $data['name'] . '.mp4',
            ]);
        }
    }
}
