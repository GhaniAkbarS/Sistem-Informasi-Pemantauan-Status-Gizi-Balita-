<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Posyandu;
use Auth;

class CheckPosyandu
{
public function handle(Request $request, Closure $next)
    {
        // Pastikan sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }
        $user = Auth::user();
        // Cek apakah user sudah punya posyandu
        if (is_null($user->posyandu_id)) {
            Auth::logout();
            return redirect('/login')
                ->with('error', 'Akun Anda belum ditetapkan ke posyandu. Hubungi admin.');
        }
        // Simpan posyandu ke session agar mudah diakses di seluruh app
        session([
            'posyandu_id'   => $user->posyandu_id,
            'posyandu_nama' => $user->posyandu->nama_posyandu ?? '-',
        ]);
        return $next($request);
    }
}
