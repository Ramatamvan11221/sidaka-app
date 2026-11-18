<?php

namespace Tests\Feature;

use App\Enums\DocumentVerificationStatus;
use App\Enums\RequestStatus;
use App\Enums\UserRole;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Major;
use App\Models\SchoolClass;
use App\Models\ServiceType;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceRequestWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_create_service_request_with_verified_documents(): void
    {
        $class = SchoolClass::create(['name' => 'XII RPL C']);
        $major = Major::create(['code' => 'RPL', 'name' => 'Rekayasa Perangkat Lunak']);
        $docType = DocumentType::create(['code' => 'IJZ', 'name' => 'Ijazah']);
        $serviceType = ServiceType::create(['code' => 'SRV-IJZ', 'name' => 'Pengambilan Ijazah', 'requires_return' => false]);

        $studentUser = User::create([
            'name' => 'Siswa Test',
            'email' => 'siswa@example.com',
            'password' => bcrypt('password'),
            'role' => UserRole::STUDENT,
            'is_active' => true,
        ]);

        $student = Student::create([
            'user_id' => $studentUser->id,
            'nis' => '1101',
            'nisn' => '2201',
            'class_id' => $class->id,
            'major_id' => $major->id,
        ]);

        $document = Document::create([
            'student_id' => $student->id,
            'document_type_id' => $docType->id,
            'title' => 'Ijazah Asli',
            'file_path' => 'private/documents/sample.pdf',
            'original_name' => 'sample.pdf',
            'mime_type' => 'application/pdf',
            'file_size' => 1024,
            'verification_status' => DocumentVerificationStatus::VERIFIED,
        ]);

        $response = $this->actingAs($studentUser)->post(route('student.service-requests.store'), [
            'service_type_id' => $serviceType->id,
            'document_ids' => [$document->id],
            'purpose' => 'Daftar kerja',
        ]);

        $response->assertRedirect(route('student.service-requests.index'));
        $this->assertDatabaseHas('service_requests', [
            'student_id' => $student->id,
            'service_type_id' => $serviceType->id,
            'status' => RequestStatus::PENDING->value,
        ]);
    }
}