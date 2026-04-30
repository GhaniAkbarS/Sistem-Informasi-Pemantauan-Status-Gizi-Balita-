<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Cek apakah role user ada dalam daftar role yang diperbolehkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, lempar ke dashboard dengan pesan error
        return redirect('/')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
    }
}
