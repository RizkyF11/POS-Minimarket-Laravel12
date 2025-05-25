<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
       $data['result'] = User::all();
        return view('users.index', $data);
    }

    public function create()
    {
        return view('users.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_user' => 'required|unique:users,nama_user',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,kasir',
        ]);

        User::create([
            'nama_user' => $request->nama_user,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect('users')->with('success', 'user berhasil ditambahkan');
    }

    public function edit($id)
    {
        $result = User::findOrFail($id);
        return view('users.form', compact('result'));
    }

    public function update(Request $request, $id )
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_user' => 'required|unique:users,nama_user,' . $user->id_user . ',id_user',
            'role' => 'required|in:admin,kasir',
            'password' => 'nullable|min:6',
        ]);

        $user->nama_user = $request->nama_user;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('users')->with('success', 'user berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'user berhasil dihapus');
    }
}
