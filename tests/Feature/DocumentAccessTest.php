<?php

namespace Tests\Feature;

use App\Enums\DocumentVerificationStatus;
use App\Enums\UserRole;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Major;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentAccessTest extends TestCase
{
    use RefreshDatabase;

    protected User $studentAUser;
    protected Student $studentA;
    protected User $studentBUser;
    protected Student $studentB;
    protected Document $documentA;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');

        $class = SchoolClass::create(['name' => 'XII RPL A']);
        $major = Major::create(['code' => 'RPL', 'name' => 'Rekayasa Perangkat Lunak']);
        $docType = DocumentType::create(['code' => 'IJZ', 'name' => 'Ijazah']);

        // Siswa A
        $this->studentAUser = User::create([
            'name' => 'Siswa A',
            'email' => 'siswaa@example.com',
            'password' => bcrypt('password'),
            'role' => UserRole::STUDENT,
            'is_active' => true,
        ]);
        $this->studentA = Student::create([
            'user_id' => $this->studentAUser->id,
            'nis' => '1001',
            'nisn' => '2001',
            'class_id' => $class->id,
            'major_id' => $major->id,
        ]);

        // Siswa B
        $this->studentBUser = User::create([
            'name' => 'Siswa B',
            'email' => 'siswab@example.com',
            'password' => bcrypt('password'),
            'role' => UserRole::STUDENT,
            'is_active' => true,
        ]);
        $this->studentB = Student::create([
            'user_id' => $this->studentBUser->id,
            'nis' => '1002',
            'nisn' => '2002',
            'class_id' => $class->id,
            'major_id' => $major->id,
        ]);

        // Buat file dummy di storage fake
        $filePath = 'private/documents/sample_ijazah_a.pdf';
        Storage::disk('local')->put($filePath, 'sample content stream');

        // Dokumen milik Siswa A
        $this->documentA = Document::create([
            'student_id' => $this->studentA->id,
            'document_type_id' => $docType->id,
            'title' => 'Ijazah Siswa A',
            'file_path' => $filePath,
            'original_name' => 'ijazah.pdf',
            'mime_type' => 'application/pdf',
            'file_size' => 1024,
            'verification_status' => DocumentVerificationStatus::VERIFIED,
        ]);
    }

    public function test_student_can_download_own_document(): void
    {
        $response = $this->actingAs($this->studentAUser)
            ->get(route('documents.download', $this->documentA));

        $response->assertStatus(200);
    }

    public function test_student_cannot_download_other_students_document(): void
    {
        $response = $this->actingAs($this->studentBUser)
            ->get(route('documents.download', $this->documentA));

        $response->assertStatus(403);
    }
}