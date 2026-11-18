<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Document::class);

        $student = $request->user()->student;

        if (! $student) {
            abort(403, 'Profil siswa tidak terhubung.');
        }

        $documents = Document::with(['documentType', 'verifier'])
            ->where('student_id', $student->id)
            ->latest()
            ->paginate(10);

        return view('student.documents.index', compact('documents'));
    }
}