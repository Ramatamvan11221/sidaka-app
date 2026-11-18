<?php

namespace App\Http\Requests;

use App\Enums\DocumentVerificationStatus;
use App\Models\Document;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isStudent();
    }

    public function rules(): array
    {
        return [
            'service_type_id' => ['required', 'exists:service_types,id'],
            'document_ids' => ['required', 'array', 'min:1'],
            'document_ids.*' => ['required', 'exists:documents,id'],
            'purpose' => ['required', 'string', 'max:1000'],
            'pickup_schedule' => ['nullable', 'date', 'after:now'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $student = $this->user()->student;
            if (! $student) {
                $validator->errors()->add('student', 'Profil siswa tidak ditemukan.');
                return;
            }

            $documentIds = $this->input('document_ids', []);
            $validDocumentsCount = Document::where('student_id', $student->id)
                ->where('verification_status', DocumentVerificationStatus::VERIFIED->value)
                ->whereIn('id', $documentIds)
                ->count();

            if (count($documentIds) !== $validDocumentsCount) {
                $validator->errors()->add('document_ids', 'Beberapa dokumen yang dipilih tidak valid atau belum terverifikasi oleh guru.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'service_type_id.required' => 'Jenis layanan wajib dipilih.',
            'service_type_id.exists' => 'Jenis layanan tidak valid.',
            'document_ids.required' => 'Pilih minimal satu dokumen.',
            'document_ids.min' => 'Pilih minimal satu dokumen.',
            'purpose.required' => 'Keperluan pengajuan wajib diisi.',
            'pickup_schedule.after' => 'Jadwal pengambilan harus berupa tanggal di masa depan.',
        ];
    }
}