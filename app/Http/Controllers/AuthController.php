<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ], [
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        // Ambil data email dan password
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'karyawan') {
                return redirect()->route('karyawan.dashboard');
            } else {
                Auth::logout();
                return redirect()->route('auth.login')->withErrors([
                    'email' => 'Role tidak dikenali'
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'email atau password salah'
        ]);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function prosesRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'karyawan' // otomatis jadi customer
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silahkan login');
    }
}
