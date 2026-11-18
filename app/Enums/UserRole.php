<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case TEACHER = 'teacher';
    case STUDENT = 'student';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Admin / Petugas',
            self::TEACHER => 'Guru',
            self::STUDENT => 'Siswa',
        };
    }
}