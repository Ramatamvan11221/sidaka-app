<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DocumentVerificationStatus;
use App\Http\Controllers\Controller;
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

        $query = Document::with(['student.user', 'student.classInfo', 'documentType', 'verifier']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('student.user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('document_type_id')) {
            $query->where('document_type_id', $request->input('document_type_id'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $documents     = $query->latest()->paginate(15)->withQueryString();
        $documentTypes = DocumentType::all();

        return view('admin.documents.index', compact('documents', 'documentTypes'));
    }

    public function create(): View
    {
        $this->authorize('create', Document::class);

        // Admin bisa memilih SEMUA siswa & SEMUA jenis dokumen (Ijazah, Sertifikat, Raport, dll.)
        $students      = Student::with(['user', 'classInfo'])->get();
        $documentTypes = DocumentType::all();

        return view('admin.documents.create', compact('students', 'documentTypes'));
    }

    public function store(StoreDocumentRequest $request): RedirectResponse
    {
        $this->authorize('create', Document::class);

        $data = $request->validated();

        // Tentukan kategori otomatis jika tidak dikirim secara eksplisit dari form
        $data['category'] = $this->resolveCategory(
            $request->input('category'),
            $data['document_type_id'] ?? null
        );

        // Dokumen yang diunggah Admin langsung terverifikasi otomatis
        $data['verification_status'] = DocumentVerificationStatus::VERIFIED;
        $data['verified_by']         = $request->user()->id;
        $data['verified_at']         = now();

        $this->documentService->storeDocument(
            $data,
            $request->file('file')
        );

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil diunggah dan diverifikasi.');
    }

    public function edit(Document $document): View
    {
        $this->authorize('update', $document);

        $students      = Student::with(['user', 'classInfo'])->get();
        $documentTypes = DocumentType::all();

        return view('admin.documents.edit', compact('document', 'students', 'documentTypes'));
    }

    public function update(UpdateDocumentRequest $request, Document $document): RedirectResponse
    {
        $this->authorize('update', $document);

        $data = $request->validated();

        // Sinkronkan ulang kategori jika jenis dokumen atau kategori diubah
        $data['category'] = $this->resolveCategory(
            $request->input('category'),
            $data['document_type_id'] ?? $document->document_type_id
        );

        $this->documentService->updateDocument(
            $document,
            $data,
            $request->file('file')
        );

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document): RedirectResponse
    {
        $this->authorize('delete', $document);

        $this->documentService->deleteDocument($document);

        return redirect()->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * Menentukan kategori berkas ('ijazah', 'raport', atau 'sertifikat')
     * berdasarkan input form atau nama DocumentType.
     */
    protected function resolveCategory(?string $inputCategory, ?int $documentTypeId): string
    {
        if (in_array($inputCategory, ['ijazah', 'raport', 'sertifikat'], true)) {
            return $inputCategory;
        }

        $docType  = DocumentType::find($documentTypeId);
        $typeName = strtolower($docType->name ?? '');

        if (str_contains($typeName, 'ijazah') || str_contains($typeName, 'skl')) {
            return 'ijazah';
        }

        if (str_contains($typeName, 'rapor')) {
            return 'raport';
        }

        return 'sertifikat';
    }
}