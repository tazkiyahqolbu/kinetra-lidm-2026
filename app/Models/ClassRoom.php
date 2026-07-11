<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    protected $fillable = ['teacher_id', 'class_name', 'class_code'];

    protected static function booted(): void
    {
        static::creating(function (ClassRoom $class) {
            if (! $class->class_code) {
                $class->class_code = static::generateUniqueCode();
            }
        });
    }

    /**
     * Generates a short code students use to self-join this class.
     * Excludes visually ambiguous characters (0/O, 1/I).
     */
    public static function generateUniqueCode(): string
    {
        $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

        do {
            $code = collect(range(1, 6))
                ->map(fn () => $alphabet[random_int(0, strlen($alphabet) - 1)])
                ->implode('');
        } while (static::where('class_code', $code)->exists());

        return $code;
    }

    public function scopeOwnedBy($query, $teacherId) {
        return $query->where('teacher_id', $teacherId);
    }

    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students() {
        return $this->hasMany(Student::class, 'class_id');
    }
}
