<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Services\QRService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class QRController extends Controller
{
    use AuthorizesRequests;

    public function __construct(protected QRService $qrService) {}

    public function show(ServiceRequest $serviceRequest): View
    {
        $this->authorize('view', $serviceRequest);

        $qrSvg = $this->qrService->generateQrSvg($serviceRequest->qr_token);

        return view('student.qr.show', compact('serviceRequest', 'qrSvg'));
    }
}