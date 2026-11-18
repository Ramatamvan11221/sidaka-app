<?php

namespace App\Http\Requests;

use App\Enums\RequestStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class MassUpdateServiceRequestsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'request_ids' => ['required', 'array', 'min:1'],
            'request_ids.*' => ['required', 'exists:service_requests,id'],
            'status' => ['required', new Enum(RequestStatus::class)],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'request_ids.required' => 'Pilih minimal satu pengajuan untuk diproses.',
            'request_ids.min' => 'Pilih minimal satu pengajuan untuk diproses.',
            'status.required' => 'Status target massal harus dipilih.',
        ];
    }
}