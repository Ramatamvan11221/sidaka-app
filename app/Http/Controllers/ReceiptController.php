<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Services\QRService;
use Illuminate\View\View;

class ReceiptController extends Controller
{
    public function print(ServiceRequest $serviceRequest, QRService $qrService): View
    {
        // Pastikan hanya transaksi completed/borrowed yang punya resi resmi
        if (! in_array($serviceRequest->status->value ?? $serviceRequest->status, ['completed', 'borrowed'])) {
            abort(403, 'Resi bukti penyerahan hanya tersedia untuk pengajuan yang telah selesai.');
        }

        $qrSvg = $qrService->generateQrSvg($serviceRequest->qr_token);

        return view('receipts.service_request', compact('serviceRequest', 'qrSvg'));
    }
}