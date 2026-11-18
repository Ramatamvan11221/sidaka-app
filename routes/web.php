<?php

use App\Http\Controllers\Admin\ActivityLogController as AdminActivityLogController;
use App\Http\Controllers\Admin\BatchImportController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\HandoverController;
use App\Http\Controllers\Admin\QRDisplayController as AdminQRDisplayController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\ServiceRequestController as AdminServiceRequestController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DocumentStreamController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PublicTrackController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\DocumentController as StudentDocumentController;
use App\Http\Controllers\Student\QRScannerController as StudentQRScannerController;
use App\Http\Controllers\Student\ServiceRequestController as StudentServiceRequestController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\DocumentController as TeacherDocumentController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use Illuminate\Support\Facades\Route;

// Public Landing Page & Track Status
Route::get('/', [PublicTrackController::class, 'index'])->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Printable Receipt
    Route::get('/service-requests/{serviceRequest}/receipt', [ReceiptController::class, 'print'])->name('service-requests.receipt');

    // Notifications
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    // Secure Document Stream & Download
    Route::get('/documents/{document}/stream', [DocumentStreamController::class, 'show'])->name('documents.stream');
    Route::get('/documents/{document}/download', [DocumentStreamController::class, 'download'])->name('documents.download');

    // Admin Group (TU & Kurikulum)
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::resource('documents', AdminDocumentController::class);
        
        // Service Requests
        Route::resource('service-requests', AdminServiceRequestController::class)->only(['index', 'show']);
        
        // Verifikasi Berjenjang TU & Kurikulum
        Route::post('service-requests/{serviceRequest}/verify-tu', [AdminServiceRequestController::class, 'verifyTu'])->name('service-requests.verify-tu');
        Route::post('service-requests/{serviceRequest}/verify-kurikulum', [AdminServiceRequestController::class, 'verifyKurikulum'])->name('service-requests.verify-kurikulum');
        Route::post('service-requests/mass-verify', [AdminServiceRequestController::class, 'massVerify'])->name('service-requests.mass-verify');
        
        Route::patch('service-requests/{serviceRequest}/status', [AdminServiceRequestController::class, 'updateStatus'])->name('service-requests.update-status');
        Route::post('service-requests/mass-update-status', [AdminServiceRequestController::class, 'massUpdateStatus'])->name('service-requests.mass-update-status');

        // Export Data
        Route::get('/export/students', [ExportController::class, 'exportStudents'])->name('export.students');
        Route::get('/export/teachers', [ExportController::class, 'exportTeachers'])->name('export.teachers');

        // Batch Import Routes
        Route::get('/imports', [BatchImportController::class, 'index'])->name('imports.index');
        Route::post('/imports/students', [BatchImportController::class, 'importStudents'])->name('imports.students');
        Route::post('/imports/teachers', [BatchImportController::class, 'importTeachers'])->name('imports.teachers');

        // Admin Display QR & Transaction Confirmation
        Route::get('/service-requests/{serviceRequest}/qr-display', [AdminQRDisplayController::class, 'show'])->name('service-requests.qr-display');
        Route::get('/service-requests/{serviceRequest}/check-status', [AdminQRDisplayController::class, 'checkStatus'])->name('service-requests.check-status');
        Route::post('/service-requests/{serviceRequest}/handover', [HandoverController::class, 'store'])->name('handovers.store');
        Route::post('/service-requests/{serviceRequest}/return', [ReturnController::class, 'store'])->name('returns.store');
        Route::get('/qr-scanner', function () {
            return redirect()->route('admin.service-requests.index', ['status' => 'ready']);
        })->name('qr-scanner');
        
        // Reports & Audit Logs
        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/print', [AdminReportController::class, 'print'])->name('reports.print');
        Route::get('/activity-logs', AdminActivityLogController::class)->name('activity-logs');
    });

    // Teacher Group
    Route::middleware('role:teacher')->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', TeacherDashboardController::class)->name('dashboard');
        Route::resource('documents', TeacherDocumentController::class)->except(['show']);
        Route::patch('documents/{document}/verify', [TeacherDocumentController::class, 'verify'])->name('documents.verify');
        Route::post('documents/mass-verify', [TeacherDocumentController::class, 'massVerify'])->name('documents.mass-verify');
    });

    // Student Group
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', StudentDashboardController::class)->name('dashboard');
        Route::get('/documents', [StudentDocumentController::class, 'index'])->name('documents.index');
        Route::resource('service-requests', StudentServiceRequestController::class)->only(['index', 'create', 'store', 'show']);

        // Student Scan QR Admin Routes
        Route::get('/scan-qr', [StudentQRScannerController::class, 'index'])->name('qr-scan');
        Route::post('/claim-via-qr', [StudentQRScannerController::class, 'claimViaQr'])->name('claim-via-qr');
    });
});