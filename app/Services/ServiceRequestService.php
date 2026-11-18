<?php

namespace App\Services;

use App\Enums\RequestStatus;
use App\Models\RequestStatusHistory;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestItem;
use App\Notifications\ServiceRequestStatusUpdated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use InvalidArgumentException;

class ServiceRequestService
{
    public function createRequest(int $studentId, array $data, int $userId): ServiceRequest
    {
        return DB::transaction(function () use ($studentId, $data, $userId) {
            $requestNumber = $this->generateRequestNumber();
            $qrToken = Str::uuid()->toString();
            $initialStatus = RequestStatus::PENDING_TU;

            $serviceRequest = ServiceRequest::create([
                'request_number'  => $requestNumber,
                'student_id'      => $studentId,
                'service_type_id' => $data['service_type_id'],
                'qr_token'        => $qrToken,
                'status'          => $initialStatus,
                'purpose'         => $data['purpose'],
                'pickup_schedule' => $data['pickup_schedule'] ?? null,
            ]);

            foreach ($data['document_ids'] as $documentId) {
                ServiceRequestItem::create([
                    'service_request_id' => $serviceRequest->id,
                    'document_id'         => $documentId,
                ]);
            }

            RequestStatusHistory::create([
                'service_request_id' => $serviceRequest->id,
                'status'             => $initialStatus,
                'notes'              => 'Pengajuan berhasil dibuat oleh siswa dan masuk antrean Tata Usaha (TU).',
                'created_by'         => $userId,
            ]);

            return $serviceRequest;
        });
    }

    public function updateStatus(ServiceRequest $serviceRequest, RequestStatus $newStatus, int $adminUserId, ?string $adminNotes = null): ServiceRequest
    {
        $currentStatus = $serviceRequest->status;
        if (is_string($currentStatus)) {
            $currentStatus = RequestStatus::tryFrom($currentStatus) ?? RequestStatus::PENDING_TU;
        }

        $this->validateStateTransition($currentStatus, $newStatus);

        return DB::transaction(function () use ($serviceRequest, $newStatus, $adminUserId, $adminNotes) {
            $serviceRequest->update([
                'status'      => $newStatus,
                'admin_notes' => $adminNotes ?? $serviceRequest->admin_notes,
            ]);

            RequestStatusHistory::create([
                'service_request_id' => $serviceRequest->id,
                'status'             => $newStatus,
                'notes'              => $adminNotes ?? "Status pengajuan diperbarui menjadi {$newStatus->label()}.",
                'created_by'         => $adminUserId,
            ]);

            $studentUser = $serviceRequest->student?->user;
            if ($studentUser) {
                $studentUser->notify(new ServiceRequestStatusUpdated($serviceRequest));
            }

            return $serviceRequest;
        }
        );
    }

    public function massUpdateStatus(array $requestIds, RequestStatus $newStatus, int $adminUserId, ?string $adminNotes = null): int
    {
        $count = 0;
        $requests = ServiceRequest::whereIn('id', $requestIds)->get();

        foreach ($requests as $req) {
            try {
                $this->updateStatus($req, $newStatus, $adminUserId, $adminNotes ?? "Mass approval oleh Admin.");
                $count++;
            } catch (InvalidArgumentException $e) {
                continue;
            }
        }

        return $count;
    }

    protected function validateStateTransition(RequestStatus $currentStatus, RequestStatus $newStatus): void
    {
        $allowedTransitions = [
            RequestStatus::PENDING->value            => [RequestStatus::PENDING_TU->value, RequestStatus::PENDING_KURIKULUM->value, RequestStatus::APPROVED->value, RequestStatus::REJECTED->value],
            
            // PENDING_TU sekarang bisa langsung ke VERIFIED (khusus Legalisir) atau PENDING_KURIKULUM (selain Legalisir)
            RequestStatus::PENDING_TU->value         => [RequestStatus::PENDING_KURIKULUM->value, RequestStatus::VERIFIED->value, RequestStatus::REJECTED->value],
            
            RequestStatus::PENDING_KURIKULUM->value  => [RequestStatus::VERIFIED->value, RequestStatus::APPROVED->value, RequestStatus::REJECTED->value],
            RequestStatus::VERIFIED->value          => [RequestStatus::PREPARING->value, RequestStatus::READY->value],
            RequestStatus::APPROVED->value          => [RequestStatus::PREPARING->value],
            RequestStatus::PREPARING->value         => [RequestStatus::READY->value],
            RequestStatus::READY->value             => [RequestStatus::COMPLETED->value, RequestStatus::BORROWED->value],
            RequestStatus::BORROWED->value          => [RequestStatus::RETURNED->value],
        ];
    
        $currentValue = $currentStatus->value;
        $newValue     = $newStatus->value;
    
        if (! isset($allowedTransitions[$currentValue]) || ! in_array($newValue, $allowedTransitions[$currentValue], true)) {
            throw new InvalidArgumentException("Perubahan status dari '{$currentStatus->label()}' ke '{$newStatus->label()}' tidak sah.");
        }
    }

    protected function generateRequestNumber(): string
    {
        $datePrefix = date('Ymd');
        $countToday = ServiceRequest::whereDate('created_at', now()->today())->count() + 1;

        return 'REQ-' . $datePrefix . '-' . str_pad((string) $countToday, 4, '0', STR_PAD_LEFT);
    }
}