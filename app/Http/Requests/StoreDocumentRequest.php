<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isTeacher() || $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'exists:students,id'],
            'document_type_id' => ['required', 'exists:document_types,id'],
            'title' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // Max 5MB
            'category' => ['required', 'in:ijazah,raport,sertifikat'],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'Siswa harus dipilih.',
            'student_id.exists' => 'Data siswa tidak ditemukan.',
            'document_type_id.required' => 'Jenis dokumen harus dipilih.',
            'document_type_id.exists' => 'Jenis dokumen tidak valid.',
            'title.required' => 'Judul dokumen wajib diisi.',
            'file.required' => 'File dokumen wajib diunggah.',
            'file.mimes' => 'Format file harus berupa PDF, JPG, JPEG, atau PNG.',
            'file.max' => 'Ukuran file tidak boleh lebih dari 5 MB.',
        ];
    }
}