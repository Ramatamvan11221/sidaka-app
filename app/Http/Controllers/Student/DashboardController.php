<?php

namespace App\Http\Controllers\Student;

use App\Enums\DocumentVerificationStatus;
use App\Enums\RequestStatus;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $student = $request->user()->student;

        if (! $student) {
            abort(403, 'Profil siswa tidak terhubung.');
        }

        $stats = [
            'total_my_documents' => Document::where('student_id', $student->id)->count(),
            'verified_my_documents' => Document::where('student_id', $student->id)
                ->where('verification_status', DocumentVerificationStatus::VERIFIED)
                ->count(),
            'active_requests' => ServiceRequest::where('student_id', $student->id)
                ->whereIn('status', [RequestStatus::PENDING, RequestStatus::APPROVED, RequestStatus::PREPARING])
                ->count(),
            'ready_requests' => ServiceRequest::where('student_id', $student->id)
                ->where('status', RequestStatus::READY)
                ->count(),
        ];

        $recentMyRequests = ServiceRequest::with('serviceType')
            ->where('student_id', $student->id)
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard', compact('stats', 'recentMyRequests'));
    }
}