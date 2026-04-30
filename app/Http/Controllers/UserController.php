<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function userIndex()
    {
        // Admin hanya bisa melihat user yang posyandunya sama dengan dia
        $users = User::where('posyandu_id', session('posyandu_id'))
                    ->where('id', '!=', Auth::id()) // Agar tidak menghapus diri sendiri
                    ->get();
                    
        return view('pages.users.index', compact('users'));
    }

    public function userDestroy($id)
    {
        $user = User::where('posyandu_id', session('posyandu_id'))->findOrFail($id);
        $user->delete();
        
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
    
    public function login()
    {
        return view('pages.login.index');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('error', 'Username atau Password salah');
    }

    public function register()
    {
        // Kirim daftar posyandu ke form register
        $posyandus = Posyandu::orderBy('nama_posyandu')->get();
        return view('pages.login.register', compact('posyandus'));
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'username'    => 'required|string|unique:sp_users,username',
            'password'    => 'required|string|min:4',
            'role'        => 'required',
            'posyandu_id' => 'required|exists:sp_posyandu,id', // ← validasi posyandu
        ]);

        User::create([
            'name'        => $request->name,
            'username'    => $request->username,
            'password'    => Hash::make($request->password),
            'role'        => $request->role,
            'posyandu_id' => $request->posyandu_id, // ← simpan posyandu
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
