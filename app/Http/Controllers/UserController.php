<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login()
    {
        return view('pages.login.index');
    }

    public function doLogin(Request $request)
    {
        // Dummy data login
        $username = $request->input('username');
        $password = $request->input('password');

        // Simple validation
        if (empty($username) || empty($password)) {
            return back()->with('error', 'Username dan Password is required');
        }

        // Dummy check
        if (($username === 'admin' && $password === 'admin') || ($username === 'user' && $password === 'user')) {
             $request->session()->put('user', $username);
             return redirect('/');
        }
        
        return back()->with('error', 'Username atau Password salah');
    }

    public function register()
    {
        return view('pages.login.register');
    }

    public function doRegister(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        // Karena dummy, kita anggap registrasi selalu berhasil
        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect('/login');
    }
}
