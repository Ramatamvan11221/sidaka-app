<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $loginType = $request->input('login_type', 'user');

        // -------------------------------------------------------------
        // 1. PORTAL LOGIN ADMIN (Email + Password)
        // -------------------------------------------------------------
        if ($loginType === 'admin') {
            $request->validate([
                'identity' => ['required', 'string'],
                'password' => ['required', 'string'],
            ]);

            $identity = trim($request->input('identity'));
            $password = $request->input('password');

            if (Auth::attempt(['email' => $identity, 'password' => $password], $request->boolean('remember'))) {
                $request->session()->regenerate();
                $user = Auth::user();

                if (! $user->is_active) {
                    Auth::logout();
                    return back()->withErrors(['identity' => 'Akun Admin Anda sedang dinonaktifkan.'])->withInput();
                }

                if (! $user->isAdmin()) {
                    Auth::logout();
                    return back()->withErrors(['identity' => 'Akses ditolak. Port ini khusus untuk Admin / Petugas.'])->withInput();
                }

                return redirect()->intended(route('admin.dashboard'));
            }

            return back()->withErrors([
                'identity' => 'Email atau kata sandi Admin salah.',
            ])->withInput();
        }

        // -------------------------------------------------------------
        // 2. PORTAL LOGIN SISWA & GURU (NIP / NISN / NIS / Email + Password)
        // -------------------------------------------------------------
        $request->validate([
            'identity' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $rawIdentity   = trim($request->input('identity'));
        $cleanIdentity = preg_replace('/[^0-9A-Za-z]/', '', $rawIdentity); // Bersihkan spasi & strip
        $password      = $request->input('password');

        $user = null;

        // A. Pencarian Lapis 1: Cari dari Tabel Teacher (by NIP)
        $teacher = Teacher::where(function ($q) use ($rawIdentity, $cleanIdentity) {
            $q->where('nip', $rawIdentity)
              ->orWhere('nip', $cleanIdentity)
              ->orWhereRaw("REPLACE(REPLACE(nip, ' ', ''), '-', '') = ?", [$cleanIdentity]);
        })->first();

        if ($teacher) {
            $user = $teacher->user;
        }

        // B. Pencarian Lapis 2: Cari dari Tabel Student (by NISN / NIS)
        if (! $user) {
            $student = Student::where(function ($q) use ($rawIdentity, $cleanIdentity) {
                $q->where('nisn', $rawIdentity)
                  ->orWhere('nisn', $cleanIdentity)
                  ->orWhere('nis', $rawIdentity)
                  ->orWhere('nis', $cleanIdentity)
                  ->orWhereRaw("REPLACE(REPLACE(nisn, ' ', ''), '-', '') = ?", [$cleanIdentity])
                  ->orWhereRaw("REPLACE(REPLACE(nis, ' ', ''), '-', '') = ?", [$cleanIdentity]);
            })->first();

            if ($student) {
                $user = $student->user;
            }
        }

        // C. Pencarian Lapis 3: Cari by Email jika user memasukkan email
        if (! $user) {
            $user = User::where('email', $rawIdentity)->first();
        }

        // D. Verifikasi Akun & Password
        if ($user && Hash::check($password, $user->password)) {
            if (! $user->is_active) {
                return back()->withErrors(['identity' => 'Akun Anda sedang dinonaktifkan oleh Admin.'])->withInput();
            }

            // Mencegah Admin login lewat portal Siswa/Guru
            if ($user->isAdmin()) {
                return back()->withErrors(['identity' => 'Akun Admin wajib masuk melalui portal Admin.'])->withInput();
            }

            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            $role = is_object($user->role) ? $user->role->value : $user->role;

            return match ($role) {
                'teacher' => redirect()->intended(route('teacher.dashboard')),
                'student' => redirect()->intended(route('student.dashboard')),
                default   => redirect('/'),
            };
        }

        return back()->withErrors([
            'identity' => 'NIP / NISN / Email atau kata sandi yang Anda masukkan salah.',
        ])->withInput();
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}