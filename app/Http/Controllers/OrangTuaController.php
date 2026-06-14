<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Balita;
use Auth;

class OrangTuaController extends Controller
{
    public function index(){
        $anakDaftar = Balita::where('user_id', Auth::id())->get();
        return view('pages.ortu.dashboard', compact('anakDaftar'));
    }

    public function show($id)
    {
        $anak = Balita::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Ascending untuk grafik (lama → baru)
        $riwayat = $anak->periksa()->orderBy('tanggal_periksa', 'asc')->get();

        // Hitung umur otomatis (standar Buku KIA): selisih tgl_lahir vs tanggal_periksa
        $chartLabels = $riwayat->map(
            fn($p) => \Carbon\Carbon::parse($anak->tgl_lahir)->diffInMonths($p->tanggal_periksa)
        );
        $chartUmur = $chartLabels;
        $chartBB   = $riwayat->pluck('berat_badan');
        $chartTB   = $riwayat->pluck('tinggi_badan');

        return view('pages.ortu.detail', compact('anak', 'riwayat', 'chartLabels', 'chartUmur', 'chartBB', 'chartTB'));
    }


    
}
