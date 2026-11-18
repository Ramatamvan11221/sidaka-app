<?php

namespace App\Http\Controllers\Student;

use App\Enums\DocumentVerificationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Models\Document;
use App\Models\ServiceRequest;
use App\Models\ServiceType;
use App\Services\ServiceRequestService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected ServiceRequestService $serviceRequestService) {}

    public function index(Request $request): View
    {
        $this->authorize('viewAny', ServiceRequest::class);

        $student = $request->user()->student;

        if (! $student) {
            abort(403, 'Profil siswa tidak terhubung.');
        }

        $serviceRequests = ServiceRequest::with(['serviceType', 'items'])
            ->where('student_id', $student->id)
            ->latest()
            ->paginate(10);

        return view('student.service_requests.index', compact('serviceRequests'));
    }

    public function create(Request $request): View
    {
        $this->authorize('create', ServiceRequest::class);

        $student = $request->user()->student;

        if (! $student) {
            abort(403, 'Profil siswa tidak terhubung.');
        }

        // Tampilkan hanya dokumen siswa yang sudah terverifikasi
        $verifiedDocuments = Document::with('documentType')
            ->where('student_id', $student->id)
            ->where('verification_status', DocumentVerificationStatus::VERIFIED)
            ->get();

        $serviceTypes = ServiceType::all();

        return view('student.service_requests.create', compact('verifiedDocuments', 'serviceTypes'));
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $this->authorize('create', ServiceRequest::class);

        $student = $request->user()->student;

        $this->serviceRequestService->createRequest(
            $student->id,
            $request->validated(),
            $request->user()->id
        );

        return redirect()->route('student.service-requests.index')
            ->with('success', 'Pengajuan layanan berhasil dibuat dan masuk antrean verifikasi Tata Usaha (TU).');
    }

    public function show(ServiceRequest $serviceRequest): View
    {
        $this->authorize('view', $serviceRequest);

        $serviceRequest->load([
            'serviceType',
            'items.document.documentType',
            'statusHistories.creator',
            'handover',
            'returnTransaction',
        ]);

        return view('student.service_requests.show', compact('serviceRequest'));
    }

    public function claimViaQr(Request $request): JsonResponse
    {
        $request->validate([
            'qr_token' => ['required', 'string'],
        ]);

        $serviceRequest = ServiceRequest::where('qr_token', $request->input('qr_token'))->first();

        if (! $serviceRequest) {
            return response()->json(['success' => false, 'message' => 'QR Code tidak valid.'], 404);
        }

        // Otorisasi: Pastikan siswa yang scan adalah pemilik pengajuan ini
        if ($serviceRequest->student_id !== $request->user()->student?->id) {
            return response()->json(['success' => false, 'message' => 'QR Code ini bukan milik pengajuan Anda!'], 403);
        }

        $statusVal = is_object($serviceRequest->status) ? $serviceRequest->status->value : $serviceRequest->status;

        if ($statusVal !== 'ready') {
            return response()->json(['success' => false, 'message' => 'Pengajuan belum berstatus SIAP (READY).'], 400);
        }

        // Eksekusi perubahan status
        $nextStatus = $serviceRequest->serviceType->requires_return ? 'borrowed' : 'completed';
        $serviceRequest->update(['status' => $nextStatus]);

        return response()->json([
            'success' => true,
            'message' => 'Penyerahan dokumen berhasil dikonfirmasi!',
        ]);
    }
}