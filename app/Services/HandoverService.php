<?php

namespace App\Services;

use App\Enums\RequestStatus;
use App\Models\DocumentReturn;
use App\Models\Handover;
use App\Models\RequestStatusHistory;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class HandoverService
{
    public function processHandover(ServiceRequest $serviceRequest, int $adminUserId, ?string $notes = null): Handover
    {
        if ($serviceRequest->status !== RequestStatus::READY) {
            throw new InvalidArgumentException('Penyerahan hanya dapat dilakukan untuk pengajuan berstatus SIAP (READY).');
        }

        return DB::transaction(function () use ($serviceRequest, $adminUserId, $notes) {
            $nextStatus = $serviceRequest->serviceType->requires_return
                ? RequestStatus::BORROWED
                : RequestStatus::COMPLETED;

            $serviceRequest->update([
                'status' => $nextStatus,
            ]);

            $handover = Handover::create([
                'service_request_id' => $serviceRequest->id,
                'processed_by' => $adminUserId,
                'handover_at' => now(),
                'notes' => $notes,
            ]);

            RequestStatusHistory::create([
                'service_request_id' => $serviceRequest->id,
                'status' => $nextStatus,
                'notes' => $notes ?? "Dokumen telah diserahkan. Status transaksi menjadi {$nextStatus->label()}.",
                'created_by' => $adminUserId,
            ]);

            return $handover;
        });
    }

    public function processReturn(ServiceRequest $serviceRequest, int $adminUserId, ?string $conditionNotes = null): DocumentReturn
    {
        if ($serviceRequest->status !== RequestStatus::BORROWED) {
            throw new InvalidArgumentException('Pengembalian hanya dapat dilakukan untuk pengajuan berstatus DIPINJAM (BORROWED).');
        }

        return DB::transaction(function () use ($serviceRequest, $adminUserId, $conditionNotes) {
            $serviceRequest->update([
                'status' => RequestStatus::RETURNED,
            ]);

            $documentReturn = DocumentReturn::create([
                'service_request_id' => $serviceRequest->id,
                'processed_by' => $adminUserId,
                'returned_at' => now(),
                'condition_notes' => $conditionNotes,
            ]);

            RequestStatusHistory::create([
                'service_request_id' => $serviceRequest->id,
                'status' => RequestStatus::RETURNED,
                'notes' => $conditionNotes ?? 'Dokumen telah dikembalikan dalam kondisi lengkap.',
                'created_by' => $adminUserId,
            ]);

            return $documentReturn;
        });
    }
}