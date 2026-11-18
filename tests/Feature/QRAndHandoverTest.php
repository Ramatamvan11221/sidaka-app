<?php

namespace Tests\Feature;

use App\Enums\DocumentVerificationStatus;
use App\Enums\RequestStatus;
use App\Enums\UserRole;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Major;
use App\Models\SchoolClass;
use App\Models\ServiceRequest;
use App\Models\ServiceType;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class QRAndHandoverTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_validate_qr_and_process_handover(): void
    {
        $class = SchoolClass::create(['name' => 'XII RPL C']);
        $major = Major::create(['code' => 'RPL', 'name' => 'Rekayasa Perangkat Lunak']);
        $docType = DocumentType::create(['code' => 'IJZ', 'name' => 'Ijazah']);
        $serviceType = ServiceType::create(['code' => 'SRV-IJZ', 'name' => 'Pengambilan Ijazah', 'requires_return' => false]);

        $admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => UserRole::ADMIN,
            'is_active' => true,
        ]);

        $studentUser = User::create([
            'name' => 'Siswa Test',
            'email' => 'siswa@example.com',
            'password' => bcrypt('password'),
            'role' => UserRole::STUDENT,
            'is_active' => true,
        ]);

        $student = Student::create([
            'user_id' => $studentUser->id,
            'nis' => '1102',
            'nisn' => '2202',
            'class_id' => $class->id,
            'major_id' => $major->id,
        ]);

        $token = Str::uuid()->toString();

        $serviceRequest = ServiceRequest::create([
            'request_number' => 'REQ-20260902-0001',
            'student_id' => $student->id,
            'service_type_id' => $serviceType->id,
            'qr_token' => $token,
            'status' => RequestStatus::READY,
            'purpose' => 'Ambil Ijazah',
        ]);

        // Validasi QR via API Scanner
        $scanResponse = $this->actingAs($admin)->postJson(route('admin.qr-scanner.validate'), [
            'token' => $token,
        ]);

        $scanResponse->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.request_number', 'REQ-20260902-0001');

        // Eksekusi Penyerahan (Handover)
        $handoverResponse = $this->actingAs($admin)
            ->post(route('admin.handovers.store', $serviceRequest), [
                'notes' => 'Telah diserahkan ke siswa.',
            ]);

        $handoverResponse->assertSessionHas('success');
        $this->assertDatabaseHas('service_requests', [
            'id' => $serviceRequest->id,
            'status' => RequestStatus::COMPLETED->value,
        ]);
        $this->assertDatabaseHas('handovers', [
            'service_request_id' => $serviceRequest->id,
            'processed_by' => $admin->id,
        ]);
    }
}