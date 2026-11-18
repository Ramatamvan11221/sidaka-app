<?php

namespace App\Services;

use App\Enums\DocumentVerificationStatus;
use App\Models\Document;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    public function storeDocument(array $data, UploadedFile $file): Document
    {
        return DB::transaction(function () use ($data, $file) {
            $path = $file->store('private/documents');

            // Jika status tidak ditentukan dari data, default-kan ke VERIFIED (Raport Guru) atau PENDING_TU (Siswa)
            $status = isset($data['verification_status']) 
                ? $data['verification_status'] 
                : DocumentVerificationStatus::VERIFIED;

            $doc = Document::create([
                'student_id'          => $data['student_id'],
                'document_type_id'    => $data['document_type_id'],
                'title'               => $data['title'] ?? ('Dokumen Raport - ' . now()->format('Y')),
                'file_path'           => $path,
                'original_name'       => $file->getClientOriginalName(),
                'mime_type'           => $file->getClientMimeType(),
                'file_size'           => $file->getSize(),
                'verification_status' => $status,
                'uploaded_by'         => auth()->id(),
            ]);

            ActivityLogger::log('UPLOAD_DOCUMENT', "Mengunggah dokumen '{$doc->title}' untuk siswa ID {$doc->student_id}.");

            return $doc;
        });
    }

    public function updateDocument(Document $document, array $data, ?UploadedFile $file = null): Document
    {
        return DB::transaction(function () use ($document, $data, $file) {
            if ($file) {
                if (Storage::exists($document->file_path)) {
                    Storage::delete($document->file_path);
                }

                $document->file_path     = $file->store('private/documents');
                $document->original_name = $file->getClientOriginalName();
                $document->mime_type     = $file->getClientMimeType();
                $document->file_size     = $file->getSize();
            }

            $document->update([
                'document_type_id' => $data['document_type_id'],
                'title'            => $data['title'] ?? $document->title,
            ]);

            ActivityLogger::log('UPDATE_DOCUMENT', "Perbarui dokumen '{$document->title}' (ID: {$document->id}).");

            return $document;
        });
    }

    public function verifyDocument(Document $document, int $verifierUserId, string|DocumentVerificationStatus $status, ?string $rejectionNote = null): bool
    {
        return DB::transaction(function () use ($document, $verifierUserId, $status, $rejectionNote) {
            $statusValue = $status instanceof DocumentVerificationStatus ? $status->value : $status;
            $isRejected  = $statusValue === DocumentVerificationStatus::REJECTED->value;

            $updated = $document->update([
                'verification_status' => $statusValue,
                'verified_by'         => $verifierUserId,
                'verified_at'         => now(),
                'rejection_note'      => $isRejected ? $rejectionNote : null,
            ]);

            ActivityLogger::log('VERIFY_DOCUMENT', "Mengubah status verifikasi dokumen '{$document->title}' menjadi " . strtoupper($statusValue), $verifierUserId);

            return $updated;
        });
    }

    public function massVerifyDocuments(array $documentIds, int $verifierUserId, string|DocumentVerificationStatus $status): int
    {
        return DB::transaction(function () use ($documentIds, $verifierUserId, $status) {
            $statusValue = $status instanceof DocumentVerificationStatus ? $status->value : $status;

            $updatedCount = Document::whereIn('id', $documentIds)->update([
                'verification_status' => $statusValue,
                'verified_by'         => $verifierUserId,
                'verified_at'         => now(),
            ]);

            ActivityLogger::log('MASS_VERIFY_DOCUMENTS', "Melakukan verifikasi massal untuk {$updatedCount} dokumen menjadi " . strtoupper($statusValue), $verifierUserId);

            return $updatedCount;
        });
    }

    public function deleteDocument(Document $document): bool
    {
        return DB::transaction(function () use ($document) {
            if (Storage::exists($document->file_path)) {
                Storage::delete($document->file_path);
            }

            ActivityLogger::log('DELETE_DOCUMENT', "Menghapus dokumen '{$document->title}' (ID: {$document->id}).");

            return $document->delete();
        });
    }
}