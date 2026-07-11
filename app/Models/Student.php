<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['user_id', 'class_id', 'nis', 'temporary_password'];

    // Dikecualikan dari serialisasi array/JSON (mis. StudentController::index)
    // supaya nggak ikut ke response API; tetap bisa diakses langsung di Blade.
    protected $hidden = ['temporary_password'];

    public function scopeInClassesOwnedBy($query, $teacherId) {
        return $query->whereHas('classRoom', fn ($q) => $q->where('teacher_id', $teacherId));
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function classRoom() {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function analysisHistories() {
        return $this->hasMany(AnalysisHistory::class, 'student_id');
    }
}
