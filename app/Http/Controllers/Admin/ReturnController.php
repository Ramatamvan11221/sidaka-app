<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessReturnRequest;
use App\Models\ServiceRequest;
use App\Services\HandoverService;
use Illuminate\Http\RedirectResponse;
use InvalidArgumentException;

class ReturnController extends Controller
{
    public function __construct(protected HandoverService $handoverService) {}

    public function store(ProcessReturnRequest $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        try {
            $this->handoverService->processReturn(
                $serviceRequest,
                $request->user()->id,
                $request->input('condition_notes')
            );

            return back()->with('success', 'Pengembalian dokumen berhasil dicatat.');
        } catch (InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}