<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register()
    {
        return view('pages.auth.register');
    }

    public function login()
    {
        return view('pages.auth.login');
    }

    public function daftar(Request $request)
    {
        $request->validate([
            'nama_depan' => 'required',
            'nama_belakang' => 'required',
            'username' => 'required',
            'password' => 'required|confirmed',
            'jenis_akun' => 'required|in:admin,toko,konsumen',
        ]);

        try {
            $user = User::create([
                'name' => $request->nama_depan . " " . $request->nama_belakang,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->jenis_akun,
                'status_akun' => 'inactive'
            ]);

            Cart::create([
                'user_id' => $user->id,
                'total' => 0
            ]);

            return redirect()->route('login')->with('success', 'Berhasil daftar akun');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
        }
    }

    public function masuk(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required'
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status_akun !== 'active') {
                Auth::logout();
                return redirect()->back()->with('error', 'Akun anda tidak aktif silahkan hubungi admin');
            }

            if ($user->role === 'admin') {
                return redirect()->route('dashboard');
            } elseif ($user->role === 'toko' || $user->role === 'konsumen') {
                return redirect()->route('home');
            } else {
                Auth::logout();
                return redirect()->back()->with('error', 'Role tidak dikenali');
            }
        }

        return redirect()->back()->with('error', 'Username atau kata sandi salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
