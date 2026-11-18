<?php

namespace App\Http\Requests;

use App\Enums\DocumentVerificationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class MassVerifyDocumentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isTeacher() || $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'document_ids' => ['required', 'array', 'min:1'],
            'document_ids.*' => ['required', 'exists:documents,id'],
            'status' => ['required', new Enum(DocumentVerificationStatus::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'document_ids.required' => 'Pilih minimal satu dokumen untuk diproses.',
            'document_ids.min' => 'Pilih minimal satu dokumen untuk diproses.',
            'status.required' => 'Status verifikasi massal harus ditentukan.',
        ];
    }
}