use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

public function authenticate(Request $request)
{
    $request->validate([
        'login'    => ['required', 'string'], // Bisa diisi Email / NISN / NIP
        'password' => ['required', 'string'],
    ]);

    $loginInput = $request->input('login');
    $password   = $request->input('password');

    // Cari User berdasarkan Email, NISN (Siswa), atau NIP (Guru)
    $user = User::where('email', $loginInput)
        ->orWhereHas('student', function ($query) use ($loginInput) {
            $query->where('nisn', $loginInput)->orWhere('nis', $loginInput);
        })
        ->orWhereHas('teacher', function ($query) use ($loginInput) {
            $query->where('nip', $loginInput);
        })
        ->first();

    // Cek password
    if ($user && Hash::check($password, $user->password)) {
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'login' => 'NIP / NISN / Email atau password yang dimasukkan salah.',
    ])->onlyInput('login');
}