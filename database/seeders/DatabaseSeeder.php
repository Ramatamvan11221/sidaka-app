<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\DocumentType;
use App\Models\Major;
use App\Models\SchoolClass;
use App\Models\ServiceType;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Master Jurusan
        $majorRpl = Major::firstOrCreate(['code' => 'RPL'], ['name' => 'Rekayasa Perangkat Lunak']);
        Major::firstOrCreate(['code' => 'TKJ'], ['name' => 'Teknik Komputer & Jaringan']);

        // 2. Master Kelas
        $classRpl = SchoolClass::firstOrCreate(
            ['name' => 'XII RPL C'],
            ['major_id' => $majorRpl->id]
        );
        SchoolClass::firstOrCreate(['name' => 'XII RPL A'], ['major_id' => $majorRpl->id]);
        SchoolClass::firstOrCreate(['name' => 'XII RPL B'], ['major_id' => $majorRpl->id]);

        // 3. Master Tipe Dokumen
        DocumentType::firstOrCreate(['code' => 'IJZ'], ['name' => 'Ijazah']);
        DocumentType::firstOrCreate(['code' => 'SKL'], ['name' => 'Surat Keterangan Lulus (SKL)']);
        DocumentType::firstOrCreate(['code' => 'RPR'], ['name' => 'Rapor Semester 1-6']);
        DocumentType::firstOrCreate(['code' => 'SRT'], ['name' => 'Sertifikat']);

        // 4. Master Tipe Layanan
        ServiceType::firstOrCreate(['code' => 'SRV-IJZ'], ['name' => 'Pengambilan Ijazah', 'requires_return' => false]);
        ServiceType::firstOrCreate(['code' => 'SRV-SRT'], ['name' => 'Pengambilan Sertifikat', 'requires_return' => false]);
        ServiceType::firstOrCreate(['code' => 'SRV-RPR'], ['name' => 'Peminjaman Rapor', 'requires_return' => true]);
        ServiceType::firstOrCreate(['code' => 'SRV-LGL'], ['name' => 'Legalisir Dokumen', 'requires_return' => false]);

        // 5. 1 Data Admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'      => 'Admin Petugas SIDAKA',
                'password'  => Hash::make('password'),
                'role'      => UserRole::ADMIN,
                'is_active' => true,
            ]
        );

        // 6. 1 Data Guru (Wali Kelas XII RPL C)
        $teacherUser = User::firstOrCreate(
            ['email' => 'guru@example.com'],
            [
                'name'      => 'Budi Santoso, S.Kom',
                'password'  => Hash::make('password'),
                'role'      => UserRole::TEACHER,
                'is_active' => true,
            ]
        );

        Teacher::firstOrCreate(
            ['user_id' => $teacherUser->id],
            [
                'nip'      => '198507122010011005',
                'phone'    => '081234567890',
                'class_id' => $classRpl->id,
            ]
        );

        // 7. 1 Data Siswa (Kelas XII RPL C)
        $studentUser = User::firstOrCreate(
            ['email' => 'siswa@example.com'],
            [
                'name'      => 'Ramaditya Surya Putra',
                'password'  => Hash::make('password'),
                'role'      => UserRole::STUDENT,
                'is_active' => true,
            ]
        );

        Student::firstOrCreate(
            ['user_id' => $studentUser->id],
            [
                'nis'      => '2210028',
                'nisn'     => '0054819203',
                'class_id' => $classRpl->id,
                'major_id' => $majorRpl->id,
                'phone'    => '089876543210',
            ]
        );
    }
}