<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('users.index', compact('user'));
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nama_user' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/categories')->with('success', 'Login berhasil sebagai admin');
            } elseif ($user->role === 'kasir') {
                return redirect()->intended('kasir')->with('success', 'Login berhasil sebagai kasir');
            }
        }

        return back()->withErrors([
            'nama_user' => 'Login gagal, Silahkan cek kembali username dan password anda'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
