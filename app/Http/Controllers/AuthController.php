<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan formulir login.
     */
    public function showLoginForm()
    {
        Cookie::queue(Cookie::forget('remembered_username'));

        return view('auth.login');
    }

    /**
     * Proses autentikasi login.
     */
    public function login(Request $request)
    {
        if (Auth::user()?->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $inputUsername = trim($request->input('username') ?? $request->input('email') ?? '');
        $request->merge(['username' => $inputUsername]);

        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $loginInput = $validated['username'];
        $passwordInput = $validated['password'];

        // Cari akun murni berdasarkan username/nama secara case-sensitive (huruf besar/kecil berpengaruh)
        $user = DB::connection()->getDriverName() === 'mysql'
            ? User::whereRaw('BINARY name = ?', [$loginInput])->first()
            : User::where('name', $loginInput)->first();

        // 1. Validasi: User tidak ditemukan atau huruf besar/kecil tidak cocok
        if (!$user || $user->name !== $loginInput) {
            return back()->withInput($request->only('username', 'email'))
                ->with('error', 'Username tidak terdaftar dalam sistem.')
                ->withErrors([
                    'username' => 'Username tidak terdaftar.',
                ]);
        }

        // 2. Validasi: Bukan administrator yang ditentukan
        if (!$user->isAdmin()) {
            return back()->withInput($request->only('username', 'email'))
                ->with('error', 'Tidak bisa melakukan login karena anda bukan admin.')
                ->withErrors([
                    'username' => 'Tidak bisa melakukan login karena anda bukan admin.',
                ]);
        }

        // 3. Validasi: Kata sandi tidak sesuai
        if (!Hash::check($passwordInput, $user->password)) {
            return back()->withInput($request->only('username', 'email'))
                ->with('error', 'Kata sandi salah! Silakan ulangi memasukkan kata sandi Anda.')
                ->withErrors([
                    'password' => 'Kata sandi salah. Silakan masukkan ulang kata sandi Anda.',
                ]);
        }

        // 4. Berhasil masuk
        Auth::login($user);
        $request->session()->regenerate();

        Cookie::queue(Cookie::forget('remembered_username'));

        return redirect()->route('admin.dashboard')
            ->with('show_preloader', true)
            ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
    }

    /**
     * Tampilkan formulir registrasi untuk user baru.
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin() 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('user.home');
        }

        return view('auth.register');
    }

    /**
     * Proses registrasi akun user baru.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user', // Default selalu role user
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('user.home')
            ->with('success', 'Akun berhasil dibuat! Selamat datang di SIPESAN.');
    }

    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
