<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RequestStatus;
use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\ServiceType;
use App\Services\ServiceRequestService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
    public function __construct(protected ServiceRequestService $serviceRequestService) {}

    public function index(Request $request): View
    {
        $query = ServiceRequest::with(['student.user', 'student.classInfo', 'serviceType']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('request_number', 'like', "%{$search}%")
                  ->orWhereHas('student.user', fn($userQuery) => $userQuery->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('student', fn($studentQuery) => $studentQuery->where('nis', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('service_type_id')) {
            $query->where('service_type_id', $request->input('service_type_id'));
        }

        $serviceRequests = $query->latest()->paginate(15)->withQueryString();
        $serviceTypes    = ServiceType::all();

        return view('admin.service_requests.index', compact('serviceRequests', 'serviceTypes'));
    }

    public function show(ServiceRequest $serviceRequest): View
    {
        $serviceRequest->load([
            'student.user',
            'student.classInfo',
            'serviceType',
            'items.document.documentType',
            'statusHistories.creator',
            'tuApprovedBy',
            'kurikulumApprovedBy',
            'handover',
            'returnTransaction',
        ]);

        return view('admin.service_requests.show', compact('serviceRequest'));
    }

    /**
     * Tahap 1: Verifikasi Kelengkapan Berkas Fisik ku Tata Usaha (TU)
     */
    public function verifyTu(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        $request->validate([
            'action'         => ['required', 'in:approve,reject'],
            'rejection_note' => ['required_if:action,reject', 'nullable', 'string'],
        ]);

        if ($request->input('action') === 'approve') {
            $serviceRequest->update([
                'tu_approved_by' => $request->user()->id,
                'tu_approved_at' => now(),
            ]);

            // Cek apakah jenis layanan adalah Legalisir
            $serviceType = $serviceRequest->serviceType;
            $isLegalisir = ($serviceType?->code === 'SRV-LGL') 
                || str_contains(strtolower($serviceType?->name ?? ''), 'legalisir');

            if ($isLegalisir) {
                // Legalisir: Langsung TERVERIFIKASI oleh TU (Bypass Kurikulum)
                $this->serviceRequestService->updateStatus(
                    $serviceRequest,
                    RequestStatus::VERIFIED,
                    $request->user()->id,
                    'Pengajuan Legalisir telah diverifikasi & disahkan langsung oleh Tata Usaha (TU).'
                );

                return back()->with('success', 'Pengajuan Legalisir berhasil disahkan oleh TU.');
            }

            // Pengajuan Lain: Teruskan ke Tim Kurikulum
            $this->serviceRequestService->updateStatus(
                $serviceRequest,
                RequestStatus::PENDING_KURIKULUM,
                $request->user()->id,
                'Berkas fisik dinyatakan lengkap oleh Tata Usaha (TU) dan diteruskan ke Kurikulum.'
            );

            return back()->with('success', 'Pengajuan berhasil diverifikasi TU & diteruskan ke Kurikulum.');
        }

        $this->serviceRequestService->updateStatus(
            $serviceRequest,
            RequestStatus::REJECTED,
            $request->user()->id,
            $request->input('rejection_note')
        );

        return back()->with('success', 'Pengajuan telah ditolak di tahap verifikasi TU.');
    }

    /**
     * Tahap 2: Validasi Keabsahan Akademik ku Kurikulum
     */
    public function verifyKurikulum(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        $request->validate([
            'action'         => ['required', 'in:approve,reject'],
            'rejection_note' => ['required_if:action,reject', 'nullable', 'string'],
        ]);

        if ($request->input('action') === 'approve') {
            $serviceRequest->update([
                'kurikulum_approved_by' => $request->user()->id,
                'kurikulum_approved_at' => now(),
            ]);

            $this->serviceRequestService->updateStatus(
                $serviceRequest,
                RequestStatus::VERIFIED,
                $request->user()->id,
                'Pengajuan telah divalidasi dan disahkan oleh Tim Kurikulum.'
            );

            return back()->with('success', 'Pengajuan telah divalidasi & disahkan oleh Kurikulum.');
        }

        $this->serviceRequestService->updateStatus(
            $serviceRequest,
            RequestStatus::REJECTED,
            $request->user()->id,
            $request->input('rejection_note')
        );

        return back()->with('success', 'Pengajuan telah ditolak di tahap validasi Kurikulum.');
    }

    public function updateStatus(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'string'],
            'notes'  => ['nullable', 'string'],
        ]);

        $statusEnum = RequestStatus::from($request->input('status'));

        $this->serviceRequestService->updateStatus(
            $serviceRequest,
            $statusEnum,
            $request->user()->id,
            $request->input('notes')
        );

        return back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function massUpdateStatus(Request $request): RedirectResponse
    {
        $request->validate([
            'request_ids'   => ['required', 'array'],
            'request_ids.*' => ['exists:service_requests,id'],
            'status'        => ['required', 'string'],
        ]);

        $statusEnum = RequestStatus::from($request->input('status'));

        $count = $this->serviceRequestService->massUpdateStatus(
            $request->input('request_ids'),
            $statusEnum,
            $request->user()->id
        );

        return back()->with('success', "Sebanyak {$count} pengajuan berhasil diperbarui.");
    }

    public function massVerify(Request $request): RedirectResponse
    {
        $request->validate([
            'request_ids'   => ['required', 'array'],
            'request_ids.*' => ['exists:service_requests,id'],
            'action'        => ['required', 'in:tu,kurikulum'],
        ]);
    
        $action = $request->input('action');
        $count = 0;
    
        foreach ($request->input('request_ids') as $id) {
            $serviceRequest = ServiceRequest::find($id);
            if (! $serviceRequest) {
                continue;
            }
    
            if ($action === 'tu' && in_array($serviceRequest->status->value ?? $serviceRequest->status, ['pending', 'pending_tu'], true)) {
                $serviceRequest->update([
                    'tu_approved_by' => $request->user()->id,
                    'tu_approved_at' => now(),
                ]);
    
                $serviceType = $serviceRequest->serviceType;
                $isLegalisir = ($serviceType?->code === 'SRV-LGL') || str_contains(strtolower($serviceType?->name ?? ''), 'legalisir');
    
                $targetStatus = $isLegalisir ? RequestStatus::VERIFIED : RequestStatus::PENDING_KURIKULUM;
                $note         = $isLegalisir ? 'Mass approval legalisir disahkan langsung oleh TU.' : 'Mass approval verifikasi berkas oleh TU.';
    
                $this->serviceRequestService->updateStatus(
                    $serviceRequest,
                    $targetStatus,
                    $request->user()->id,
                    $note
                );
                $count++;
            } elseif ($action === 'kurikulum' && ($serviceRequest->status->value ?? $serviceRequest->status) === 'pending_kurikulum') {
                $serviceRequest->update([
                    'kurikulum_approved_by' => $request->user()->id,
                    'kurikulum_approved_at' => now(),
                ]);
                $this->serviceRequestService->updateStatus(
                    $serviceRequest,
                    RequestStatus::VERIFIED,
                    $request->user()->id,
                    'Mass approval validasi akademik oleh Kurikulum.'
                );
                $count++;
            }
        }
    
        return back()->with('success', "Sebanyak {$count} pengajuan berhasil diverifikasi massal.");
    }
}