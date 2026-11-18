<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isTeacher() || $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'document_type_id' => ['required', 'exists:document_types,id'],
            'title' => ['required', 'string', 'max:255'],
            'file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'document_type_id.required' => 'Jenis dokumen harus dipilih.',
            'title.required' => 'Judul dokumen wajib diisi.',
            'file.mimes' => 'Format file harus berupa PDF, JPG, JPEG, atau PNG.',
            'file.max' => 'Ukuran file tidak boleh lebih dari 5 MB.',
        ];
    }
}