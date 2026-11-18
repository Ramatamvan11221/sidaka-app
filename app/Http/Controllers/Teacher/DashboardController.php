<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\DocumentVerificationStatus;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $teacher = $request->user()->teacher;
        $classId = $teacher?->class_id;

        if (!$classId) {
            $stats = [
                'total_students'       => 0,
                'total_documents'      => 0,
                'students_without_doc' => 0,
                'verified_documents'   => 0,
            ];

            $students  = collect([]);
            $className = 'Belum Ditentukan';

            return view('teacher.dashboard', compact('stats', 'students', 'className'))
                ->with('warning', 'Anda belum ditugaskan sebagai Wali Kelas.');
        }

        // 1. Ambil daftar siswa di kelas binaan beserta dokumen raport mereka
        $students = Student::where('class_id', $classId)
            ->with(['user', 'classInfo', 'documents' => function ($q) {
                $q->where('category', 'raport')->latest();
            }])
            ->get();

        $totalStudents   = $students->count();
        $studentsWithDoc = $students->filter(fn($s) => $s->documents->isNotEmpty())->count();
        $studentsNoDoc   = $totalStudents - $studentsWithDoc;

        // 2. Hitung statistik HANYA untuk siswa & dokumen di kelas guru ini
        $stats = [
            'total_students'       => $totalStudents,
            'total_documents'      => Document::whereHas('student', fn($q) => $q->where('class_id', $classId))->count(),
            'students_without_doc' => $studentsNoDoc,
            'verified_documents'   => Document::whereHas('student', fn($q) => $q->where('class_id', $classId))
                ->where('verification_status', DocumentVerificationStatus::VERIFIED)
                ->count(),
        ];

        $className = $teacher?->classInfo?->name ?? 'Belum Ditentukan';

        return view('teacher.dashboard', compact('stats', 'students', 'className'));
    }
}