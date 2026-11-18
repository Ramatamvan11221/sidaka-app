<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessHandoverRequest;
use App\Models\ServiceRequest;
use App\Services\HandoverService;
use Illuminate\Http\RedirectResponse;
use InvalidArgumentException;

class HandoverController extends Controller
{
    public function __construct(protected HandoverService $handoverService) {}

    public function store(ProcessHandoverRequest $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        try {
            $this->handoverService->processHandover(
                $serviceRequest,
                $request->user()->id,
                $request->input('notes')
            );

            return back()->with('success', 'Penyerahan dokumen berhasil dicatat.');
        } catch (InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}