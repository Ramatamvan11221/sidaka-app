<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassInfo;
use App\Models\Major;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BatchImportController extends Controller
{
    public function index(): View
    {
        return view('admin.imports.index');
    }

    public function importStudents(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        
        // Skip header CSV
        fgetcsv($handle);

        $importedCount = 0;

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (count($row) < 6) continue;

                $nis = trim($row[0]);
                $nisn = trim($row[1]);
                $name = trim($row[2]);
                $email = trim($row[3]);
                $className = trim($row[4]);
                $majorName = trim($row[5]);

                if (empty($email) || empty($nis)) continue;

                // 1. Buat / Update User (Cukup passing string biasa jika User model punya cast 'password' => 'hashed')
                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $name,
                        'password' => 'password123',
                        'role' => 'student',
                        'is_active' => true,
                    ]
                );

                // 2. Resolver Jurusan & Kelas
                $major = Major::firstOrCreate(
                    ['code' => Str::slug($majorName)],
                    ['name' => $majorName]
                );

                $classInfo = ClassInfo::firstOrCreate(
                    ['name' => $className],
                    ['major_id' => $major->id]
                );

                Student::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nis' => $nis,
                        'nisn' => $nisn,
                        'class_id' => $classInfo->id, 
                        'major_id' => $major->id,
                    ]
                );

                $importedCount++;
            }

            fclose($handle);
            DB::commit();

            return redirect()->back()->with('success', "Berhasil mengimpor {$importedCount} data akun siswa!");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    public function importTeachers(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ]);
    
        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        fgetcsv($handle);

        $importedCount = 0;
    
        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (count($row) < 5) continue;
    
                $nip = trim($row[0]);
                $name = trim($row[1]);
                $email = trim($row[2]);
                $className = trim($row[3]);
                $majorName = trim($row[4]);
    
                if (empty($email) || empty($nip)) continue;
    
                // 1. Buat / Update User Account Guru
                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $name,
                        'password' => 'password123',
                        'role' => 'teacher',
                        'is_active' => true,
                    ]
                );
    
                // 2. Resolve / Create Jurusan & Kelas
                $major = Major::firstOrCreate(
                    ['code' => Str::slug($majorName)],
                    ['name' => $majorName]
                );
    
                $classInfo = ClassInfo::firstOrCreate(
                    ['name' => $className],
                    ['major_id' => $major->id]
                );
    
                // 3. Buat / Update Profile Teacher
                Teacher::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nip' => $nip,
                        'class_id' => $classInfo->id,
                        'major_id' => $major->id,
                    ]
                );
    
                $importedCount++;
            }
    
            fclose($handle);
            DB::commit();
    
            return redirect()->back()->with('success', "Berhasil mengimpor {$importedCount} data akun guru / wali kelas!");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengimpor data guru: ' . $e->getMessage());
        }
    }
}