<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        return view('pages.admin.users', [
            'users' => User::all()
        ]);
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->status_akun = 'active';
        $user->save();

        return redirect()->back();
    }

    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        $user->status_akun = 'inactive';
        $user->save();

        return redirect()->back();
    }
}
