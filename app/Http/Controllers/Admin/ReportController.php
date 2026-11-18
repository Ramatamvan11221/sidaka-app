<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $query = ServiceRequest::with([
            'student.user',
            'student.classInfo',
            'serviceType',
            'handover.processor',
            'returnTransaction.processor',
        ]);

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('service_type_id')) {
            $query->where('service_type_id', $request->input('service_type_id'));
        }

        $reports = $query->latest()->paginate(15)->withQueryString();
        $serviceTypes = ServiceType::all();

        return view('admin.reports.index', compact('reports', 'serviceTypes'));
    }

    public function print(Request $request): View
    {
        $query = ServiceRequest::with([
            'student.user',
            'student.classInfo',
            'serviceType',
            'items.document.documentType',
            'handover.processor',
            'returnTransaction.processor',
        ]);

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('service_type_id')) {
            $query->where('service_type_id', $request->input('service_type_id'));
        }

        $reports = $query->latest()->get();
        $filters = $request->only(['start_date', 'end_date', 'status', 'service_type_id']);

        return view('admin.reports.print', compact('reports', 'filters'));
    }
}