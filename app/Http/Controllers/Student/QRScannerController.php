<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Services\HandoverService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QRScannerController extends Controller
{
    public function __construct(protected HandoverService $handoverService) {}

    public function index(): View
    {
        return view('student.qr.scan');
    }

    public function claimViaQr(Request $request): JsonResponse
    {
        $request->validate([
            'qr_token' => ['required', 'string'],
        ]);

        $serviceRequest = ServiceRequest::with(['student.user', 'serviceType'])
            ->where('qr_token', $request->input('qr_token'))
            ->first();

        if (! $serviceRequest) {
            return response()->json(['success' => false, 'message' => 'QR Code tidak ditemukan atau tidak valid.'], 404);
        }

        $student = $request->user()->student;
        if (! $student || $serviceRequest->student_id !== $student->id) {
            return response()->json(['success' => false, 'message' => 'QR Code ini bukan milik pengajuan Anda!'], 403);
        }

        if ($serviceRequest->status->value !== 'ready') {
            return response()->json(['success' => false, 'message' => 'Pengajuan belum berstatus SIAP (READY).'], 400);
        }

        $this->handoverService->processHandover(
            $serviceRequest,
            $serviceRequest->student->user_id,
            'Konfirmasi penyerahan mandiri via Scan QR Monitor Admin oleh Siswa.'
        );

        return response()->json([
            'success' => true,
            'message' => 'Penyerahan dokumen berhasil dikonfirmasi!',
        ]);
    }
}