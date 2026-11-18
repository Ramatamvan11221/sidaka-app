<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function exportStudents(): StreamedResponse
    {
        $fileName = 'data_siswa_sidaka_' . date('Ymd_His') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            
            // UTF-8 BOM agar rapi saat dibuka di Microsoft Excel
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header Kolom
            fputcsv($handle, ['NIS', 'NISN', 'Nama Siswa', 'Kelas', 'Jurusan', 'Email', 'Status Akun']);

            Student::with(['user', 'classInfo', 'major'])->chunk(200, function ($students) use ($handle) {
                foreach ($students as $student) {
                    fputcsv($handle, [
                        $student->nis,
                        $student->nisn,
                        $student->user->name ?? '-',
                        $student->classInfo->name ?? '-',
                        $student->major->name ?? '-',
                        $student->user->email ?? '-',
                        ($student->user && $student->user->is_active) ? 'Aktif' : 'Non-Aktif',
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportTeachers(): StreamedResponse
    {
        $fileName = 'data_guru_sidaka_' . date('Ymd_His') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, ['NIP', 'Nama Guru', 'Email', 'Status Akun']);

            Teacher::with('user')->chunk(200, function ($teachers) use ($handle) {
                foreach ($teachers as $teacher) {
                    fputcsv($handle, [
                        $teacher->nip ?? '-',
                        $teacher->user->name ?? '-',
                        $teacher->user->email ?? '-',
                        ($teacher->user && $teacher->user->is_active) ? 'Aktif' : 'Non-Aktif',
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}