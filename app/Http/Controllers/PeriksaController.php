<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Periksa;
use App\Models\Balita;

class PeriksaController extends Controller
{
    public function index()
    {
        $periksas = Periksa::all();
        return view('pages.periksa.index', compact('periksas'));
    }

    public function create()
    {
        // Tambahkan pengambilan data Balita
        $balitas = Balita::all(); 
        return view('pages.periksa.create', compact('balitas'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'balita_id' => 'required|exists:sp_balita,id',
            'tgl_periksa' => 'required|date',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
            'lingkar_kepala' => 'nullable|numeric',
            'catatan' => 'nullable|string',
        ]);

        // Ambil data balita
        $balita = Balita::findOrFail($request->balita_id);

        // Hitung umur bulan
        $tgl_lahir = \Carbon\Carbon::parse($balita->tgl_lahir);
        $tgl_periksa = \Carbon\Carbon::parse($request->tgl_periksa);
        $umur_bulan = $tgl_lahir->diffInMonths($tgl_periksa);

        // Simpan data dengan mapping kolom yang benar
        Periksa::create([
            'balita_id' => $request->balita_id,
            'tgl_lahir' => $balita->tgl_lahir,
            'umur_bulan' => $umur_bulan,
            'nama_ortu' => $balita->nama_ortu,
            'tanggal_periksa' => $request->tgl_periksa, // Mapping tgl_periksa (form) -> tanggal_periksa (db)
            'berat_badan' => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
            'jenis_pengukuran' => 'TB', // Set default sementara
            'status_gizi' => 'Gizi Normal', // Set default sementara
        ]);

        return redirect()->route('periksa.index')
            ->with('success', 'Data pemeriksaan berhasil ditambahkan.');
    }
}
