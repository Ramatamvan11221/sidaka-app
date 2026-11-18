<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Services\QRService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class QRDisplayController extends Controller
{
    public function __construct(protected QRService $qrService) {}

    public function show(ServiceRequest $serviceRequest): View
    {
        $qrSvg = $this->qrService->generateQrSvg($serviceRequest->qr_token);

        return view('admin.service_requests.qr_display', compact('serviceRequest', 'qrSvg'));
    }

    public function checkStatus(ServiceRequest $serviceRequest): JsonResponse
    {
        return response()->json([
            'status' => $serviceRequest->status->value,
            'is_completed' => in_array($serviceRequest->status->value, ['completed', 'borrowed']),
        ]);
    }
}