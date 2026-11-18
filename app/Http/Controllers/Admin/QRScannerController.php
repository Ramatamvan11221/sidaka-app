<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\QRService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QRScannerController extends Controller
{
    public function __construct(protected QRService $qrService) {}

    public function index(): View
    {
        return view('admin.qr_scanner.index');
    }

    public function validateToken(Request $request): JsonResponse
    {
        $request->validate([
            'token' => ['required', 'string'],
        ]);
    
        $input = trim($request->input('token'));
    
        // Cari berdasarkan qr_token (UUID) ATAU berdasarkan request_number (REQ-xxxx)
        $serviceRequest = ServiceRequest::with([
            'student.user',
            'student.classInfo',
            'student.major',
            'serviceType',
            'items.document.documentType',
        ])
        ->where('qr_token', $input)
        ->orWhere('request_number', $input)
        ->first();
    
        if (! $serviceRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengajuan tidak ditemukan.',
            ], 404);
        }
    
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $serviceRequest->id,
                'request_number' => $serviceRequest->request_number,
                'student_name' => $serviceRequest->student->user->name,
                'nis' => $serviceRequest->student->nis,
                'class' => $serviceRequest->student->classInfo->name,
                'service_type' => $serviceRequest->serviceType->name,
                'requires_return' => $serviceRequest->serviceType->requires_return,
                'status' => $serviceRequest->status->value,
                'status_label' => $serviceRequest->status->label(),
                'purpose' => $serviceRequest->purpose,
                'documents' => $serviceRequest->items->map(fn($item) => [
                    'title' => $item->document->title,
                    'type' => $item->document->documentType->name,
                ]),
            ],
        ]);
    }
}