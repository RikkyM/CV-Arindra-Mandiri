<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        return view('pages.admin.users.index', [
            'users' => User::all()
        ]);
    }

    public function changeStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->status_akun == 'inactive') {
            $user->status_akun = 'active';
        } else {
            $user->status_akun = 'inactive';
        }
        $user->save();

        return redirect()->back();
    }

    public function create()
    {
        return view('pages.admin.users.add-user');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'no_hp' => 'required|min:11|max:12',
            'password' => 'required',
            'status_akun' => 'required'
        ]);

        // $user = new User();
        // $user->name = $request->nama_lengkap;
        // $user->username = $request->no_hp;
        // $user->password = Hash::make($request->password);
        // $user->role = $request->role;
        // $user->status_akun = $request->status_akun;
        // $user->save();

        $user = User::create([
            'name' => strtolower($request->nama_lengkap),
            'username' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status_akun' => $request->status_akun
        ]);

        Cart::create([
            'user_id' => $user->id,
            'total' => 0
        ]);

        return redirect()->route('users')->with('success', 'Berhasil menambahkan user');
    }

    public function edit($id)
    {
        return view('pages.admin.users.edit-user', [
            'user' => User::findOrFail($id)
        ]);
    }

    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'nama_lengkap' => 'nullable|string',
            'no_hp' => 'nullable|unique:users,username,' . $user->id,
            'role' => 'nullable|in:toko,konsumen',
            'password' => 'nullable|confirmed'
        ]);

        $user->name = strtolower($validatedData['nama_lengkap']);
        $user->username = $validatedData['no_hp'];
        $user->role = $validatedData['role'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->route('users');
    }
}
