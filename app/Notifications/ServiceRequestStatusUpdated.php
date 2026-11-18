<?php

namespace App\Notifications;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ServiceRequestStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(public ServiceRequest $serviceRequest) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'service_request_id' => $this->serviceRequest->id,
            'request_number' => $this->serviceRequest->request_number,
            'status' => $this->serviceRequest->status->value,
            'status_label' => $this->serviceRequest->status->label(),
            'message' => "Status pengajuan #{$this->serviceRequest->request_number} diperbarui menjadi {$this->serviceRequest->status->label()}.",
            'url' => route('student.service-requests.show', $this->serviceRequest),
        ];
    }
}