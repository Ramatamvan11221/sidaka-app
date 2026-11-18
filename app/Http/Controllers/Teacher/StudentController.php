<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $teacher = $request->user()->teacher;

        // Validasi jika guru belum ditugaskan sebagai wali kelas
        if (! $teacher || ! $teacher->class_id) {
            return view('teacher.students.index', [
                'students' => collect([]),
                'message'  => 'Anda belum ditugaskan sebagai Wali Kelas.',
            ]);
        }

        $query = Student::where('class_id', $teacher->class_id)
            ->with(['user', 'classInfo', 'major']);

        // Fitur pencarian nama, NIS, atau NISN siswa di kelas
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $students = $query->latest()->paginate(15)->withQueryString();

        return view('teacher.students.index', compact('students'));
    }

    public function show(Request $request, Student $student): View
    {
        $teacher = $request->user()->teacher;

        // Proteksi Keamanan: Blokir jika guru coba intip ID siswa kelas lain lewat URL
        if (! $teacher || $student->class_id !== $teacher->class_id) {
            abort(403, 'Akses ditolak. Siswa ini bukan bagian dari kelas yang Anda ampu.');
        }

        $student->load(['user', 'classInfo', 'major', 'documents.documentType']);

        return view('teacher.students.show', compact('student'));
    }
}