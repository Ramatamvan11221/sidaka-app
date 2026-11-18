<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\DocumentVerificationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassVerifyDocumentsRequest;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Student;
use App\Services\DocumentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected DocumentService $documentService) {}

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Document::class);

        $teacher = $request->user()->teacher;

        $query = Document::with(['student.user', 'student.classInfo', 'documentType', 'verifier']);

        // 1. FILTER: Hanya ambil dokumen dari siswa yang berada di kelas guru ini
        $query->whereHas('student', function ($q) use ($teacher) {
            $q->where('class_id', $teacher?->class_id);
        });

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('student.user', fn($userQuery) => $userQuery->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('verification_status', $request->input('status'));
        }

        $documents = $query->latest()->paginate(10)->withQueryString();

        return view('teacher.documents.index', compact('documents'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Document::class);

        $teacher = $request->user()->teacher;

        // FILTER: Pilihan dropdown siswa HANYA dari kelas yang diampu guru
        $students = Student::where('class_id', $teacher?->class_id)
            ->with(['user', 'classInfo'])
            ->get();

        // RESTRIKSI: Cari tipe dokumen Raport / Rapor
        $documentTypes = DocumentType::where('name', 'like', '%raport%')
            ->orWhere('name', 'like', '%rapor%')
            ->get();

        if ($documentTypes->isEmpty()) {
            $documentTypes = DocumentType::take(1)->get();
        }

        return view('teacher.documents.create', compact('students', 'documentTypes'));
    }

    public function store(StoreDocumentRequest $request): RedirectResponse
    {
        $this->authorize('create', Document::class);

        $teacher = $request->user()->teacher;
        $student = Student::findOrFail($request->input('student_id'));

        // PROTEKSI KEAMANAN: Tolak jika mencoba mengunggah untuk siswa kelas lain
        if ($student->class_id !== $teacher?->class_id) {
            abort(403, 'Akses ditolak. Anda hanya dapat mengelola dokumen siswa di kelas Anda.');
        }

        // Ambil ID tipe dokumen Raport secara otomatis
        $raportType = DocumentType::where('name', 'like', '%raport%')
            ->orWhere('name', 'like', '%rapor%')
            ->first() ?? DocumentType::firstOrFail();

        $data = $request->validated();
        $data['document_type_id']    = $raportType->id;
        $data['category']            = 'raport';
        $data['verification_status'] = DocumentVerificationStatus::VERIFIED;
        $data['verified_by']         = $request->user()->id;
        $data['verified_at']         = now();

        $this->documentService->storeDocument(
            $data,
            $request->file('file')
        );

        return redirect()->route('teacher.documents.index')
            ->with('success', 'Dokumen Raport berhasil diunggah.');
    }

    public function edit(Document $document): View
    {
        $this->authorize('update', $document);

        $documentTypes = DocumentType::where('name', 'like', '%raport%')
            ->orWhere('name', 'like', '%rapor%')
            ->get();

        if ($documentTypes->isEmpty()) {
            $documentTypes = DocumentType::take(1)->get();
        }

        return view('teacher.documents.edit', compact('document', 'documentTypes'));
    }

    public function update(UpdateDocumentRequest $request, Document $document): RedirectResponse
    {
        $this->authorize('update', $document);

        $raportType = DocumentType::where('name', 'like', '%raport%')
            ->orWhere('name', 'like', '%rapor%')
            ->first() ?? DocumentType::firstOrFail();

        $data = $request->validated();
        $data['document_type_id'] = $raportType->id;
        $data['category']         = 'raport';

        $this->documentService->updateDocument(
            $document,
            $data,
            $request->file('file')
        );

        return redirect()->route('teacher.documents.index')
            ->with('success', 'Dokumen Raport berhasil diperbarui.');
    }

    public function verify(Request $request, Document $document): RedirectResponse
    {
        $this->authorize('verify', $document);

        $request->validate([
            'status'         => ['required', 'in:verified,rejected,pending_tu,pending_kurikulum'],
            'rejection_note' => ['required_if:status,rejected', 'nullable', 'string'],
        ]);

        $this->documentService->verifyDocument(
            $document,
            $request->user()->id,
            $request->input('status'),
            $request->input('rejection_note')
        );

        return back()->with('success', 'Status verifikasi dokumen berhasil diperbarui.');
    }

    public function massVerify(MassVerifyDocumentsRequest $request): RedirectResponse
    {
        $this->authorize('verify', Document::class);

        $status = DocumentVerificationStatus::from($request->input('status'));
        $count  = $this->documentService->massVerifyDocuments(
            $request->input('document_ids'),
            $request->user()->id,
            $status
        );

        return back()->with('success', "Sebanyak {$count} dokumen berhasil diverifikasi sekaligus.");
    }

    public function destroy(Document $document): RedirectResponse
    {
        $this->authorize('delete', $document);

        $this->documentService->deleteDocument($document);

        return redirect()->route('teacher.documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}