<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class PublicTrackController extends Controller
{
    public function index(Request $request)
    {
        $searchResult = null;
        $notFound = false;

        $rawQuery = trim($request->input('request_number') ?? $request->input('query') ?? '');

        if ($rawQuery !== '') {
            $cleanQuery = preg_replace('/\s+/', '', $rawQuery);

            $searchResult = ServiceRequest::with([
                'student.user',
                'student.classInfo',
                'serviceType',
                'items.document.documentType',
                'statusHistories',
            ])
            ->where(function ($q) use ($rawQuery, $cleanQuery) {
                $q->where('request_number', $rawQuery)
                  ->orWhere('request_number', $cleanQuery)
                  ->orWhere('qr_token', $rawQuery)
                  ->orWhere('qr_token', $cleanQuery);
            })
            ->first();

            if (! $searchResult) {
                $notFound = true;
                session()->flash('error', 'Kode pengajuan / Resi "' . $rawQuery . '" tidak ditemukan.');
            }
        }

        return view('landing', [
            'searchResult'   => $searchResult,
            'trackedRequest' => $searchResult,
            'serviceRequest' => $searchResult,
            'notFound'       => $notFound,
        ]);
    }
}