<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
        $user = User::where('posyandu_id', Auth::user()->posyandu_id)->findOrFail($id);
        abort_if($user->id === Auth::id(), 403);
        if (\App\Models\Balita::where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Akun yang masih terhubung ke data balita tidak dapat dihapus.');
        }
        $user->delete();
        
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
    
    public function login()
    {
        return view('pages.login.index');
    }

    public function doLogin(Request $request)
    {
        $request->merge(['username' => strtolower((string) $request->username)]);
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            if ($role == 'orang_tua'){
                return redirect()->route('ortu.dashboard');
            }
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
        $request->merge(['username' => strtolower((string) $request->username)]);
        $request->validate([
            'name'        => 'required|string|max:255',
            'username'    => 'required|string|regex:/^\S+$/|unique:sp_users,username',
            'password'    => 'required|string|min:12',
            'role'        => ['required', Rule::in(['admin', 'kader'])],
            'posyandu_id' => 'required|exists:sp_posyandu,id', // ← validasi posyandu
        ], [
            'name.required'        => 'Nama Lengkap tidak boleh kosong.',
            'username.required'    => 'Username tidak boleh kosong.',
            'username.regex'       => 'Username ini sudah digunakan, silakan pilih yang lain.',
            'password.required'    => 'Password tidak boleh kosong.',
            'password.min'         => 'Password minimal 12 karakter.',
            'role.required'        => 'Role tidak boleh kosong.',
            'role.in'              => 'Role yang dipilih tidak valid.',
            'posyandu_id.required' => 'Posyandu tidak boleh kosong.',
            'posyandu_id.exists'   => 'Posyandu yang dipilih tidak valid.',
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

    public function editPassword()
    {
        return view('pages.users.password');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
        ]);
        $request->user()->update(['password' => $validated['password']]);
        $request->session()->regenerate();

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function createOrangTua()
    {
        return view('pages.ortu.create');
    }

    public function storeOrangTua(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        ]);
        // Auto-generate username: huruf kecil, tanpa spasi
        $baseUsername = strtolower(str_replace(' ', '', $request->name));
        $username = $baseUsername;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }
        User::create([
            'name'        => $request->name,
            'username'    => $username,
            'password'    => Hash::make('posyandu123'),
            'role'        => 'orang_tua',
            'posyandu_id' => session('posyandu_id'),
        ]);
        return redirect()->route('ortu.create')
            ->with('success_ortu', [
                'name'     => $request->name,
                'username' => $username,
                'password' => 'posyandu123',
            ]);
    }
}
