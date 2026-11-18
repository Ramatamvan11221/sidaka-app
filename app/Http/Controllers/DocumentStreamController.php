<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Services\ActivityLogger;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentStreamController extends Controller
{
    use AuthorizesRequests;

    public function show(Request $request, Document $document): StreamedResponse
    {
        $this->authorize('view', $document);

        if (! Storage::exists($document->file_path)) {
            abort(404, 'File dokumen tidak ditemukan di server.');
        }

        ActivityLogger::log('PREVIEW_DOCUMENT', "Membuka pratinjau dokumen '{$document->title}' (ID: {$document->id}).");

        return Storage::response($document->file_path, $document->original_name, [
            'Content-Type' => $document->mime_type,
            'Content-Disposition' => 'inline; filename="' . $document->original_name . '"',
            'X-SIDAKA-Watermark' => $document->verification_status->value === 'verified' ? 'VERIFIED-SIDAKA-SMKN5' : 'UNVERIFIED-PREVIEW',
        ]);
    }

    public function download(Request $request, Document $document): StreamedResponse
    {
        $this->authorize('download', $document);

        if (! Storage::exists($document->file_path)) {
            abort(404, 'File dokumen tidak ditemukan di server.');
        }

        ActivityLogger::log('DOWNLOAD_DOCUMENT', "Mengunduh file dokumen '{$document->title}' (ID: {$document->id}).");

        return Storage::download($document->file_path, $document->original_name);
    }
}