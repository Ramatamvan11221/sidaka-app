<?php

namespace App\Http\Requests;

use App\Enums\RequestStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateServiceRequestStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'status' => ['required', new Enum(RequestStatus::class)],
            'admin_notes' => ['nullable', 'string', 'max:1000', 'required_if:status,rejected'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status pengajuan wajib dipilih.',
            'admin_notes.required_if' => 'Catatan penolakan wajib diisi jika pengajuan ditolak.',
        ];
    }
}