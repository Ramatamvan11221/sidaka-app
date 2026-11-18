<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RequestStatus;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Document;
use App\Models\ServiceRequest;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'total_students' => Student::count(),
            'total_teachers' => Teacher::count(),
            'total_documents' => Document::count(),
            'pending_requests' => ServiceRequest::where('status', RequestStatus::PENDING)->count(),
            'preparing_requests' => ServiceRequest::where('status', RequestStatus::PREPARING)->count(),
            'ready_requests' => ServiceRequest::where('status', RequestStatus::READY)->count(),
            'active_borrowed' => ServiceRequest::where('status', RequestStatus::BORROWED)->count(),
            'completed_requests' => ServiceRequest::where('status', RequestStatus::COMPLETED)->count(),
        ];

        // Status Breakdown for Donut Chart
        $statusCounts = ServiceRequest::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statusChartData = [
            'labels' => ['Pending', 'Disetujui', 'Diproses', 'Siap', 'Selesai', 'Dipinjam', 'Dikembalikan', 'Ditolak'],
            'series' => [
                $statusCounts[RequestStatus::PENDING->value] ?? 0,
                $statusCounts[RequestStatus::APPROVED->value] ?? 0,
                $statusCounts[RequestStatus::PREPARING->value] ?? 0,
                $statusCounts[RequestStatus::READY->value] ?? 0,
                $statusCounts[RequestStatus::COMPLETED->value] ?? 0,
                $statusCounts[RequestStatus::BORROWED->value] ?? 0,
                $statusCounts[RequestStatus::RETURNED->value] ?? 0,
                $statusCounts[RequestStatus::REJECTED->value] ?? 0,
            ],
        ];

        // 7-Day Request Trend for Area Chart
        $trendData = [];
        $trendLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $trendLabels[] = $date->format('d M');
            $trendData[] = ServiceRequest::whereDate('created_at', $date->toDateString())->count();
        }

        $recentRequests = ServiceRequest::with(['student.user', 'serviceType'])
            ->latest()
            ->take(5)
            ->get();

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'statusChartData', 'trendData', 'trendLabels', 'recentRequests', 'recentActivities'));
    }
}