<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
        dd($request->all());
    }
}
