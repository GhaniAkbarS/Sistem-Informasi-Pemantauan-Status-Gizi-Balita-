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
        // Hanya tampilkan periksa dari balita yang posyanduNya sama
        $periksas = Periksa::whereHas('balita', function ($q) {
            $q->where('posyandu_id', session('posyandu_id'));
        })->get();

        return view('pages.periksa.index', compact('periksas'));
    }

    public function create()
    {
        // Hanya tampilkan balita dari posyandu yang sedang login
        $balitas = Balita::where('posyandu_id', session('posyandu_id'))->get();
        return view('pages.periksa.create', compact('balitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'balita_id'      => 'required|exists:sp_balita,id',
            'tgl_periksa'    => 'required|date',
            'berat_badan'    => 'required|numeric',
            'tinggi_badan'   => 'required|numeric',
            'lingkar_kepala' => 'nullable|numeric',
            'catatan'        => 'nullable|string',
        ]);

        $balita = Balita::findOrFail($request->balita_id);

        $tgl_lahir   = \Carbon\Carbon::parse($balita->tgl_lahir);
        $tgl_periksa = \Carbon\Carbon::parse($request->tgl_periksa);
        $umur_bulan  = $tgl_lahir->diffInMonths($tgl_periksa);

        Periksa::create([
            'balita_id'       => $request->balita_id,
            'tgl_lahir'       => $balita->tgl_lahir,
            'umur_bulan'      => $umur_bulan,
            'nama_ortu'       => $balita->nama_ortu,
            'tanggal_periksa' => $request->tgl_periksa,
            'berat_badan'     => $request->berat_badan,
            'tinggi_badan'    => $request->tinggi_badan,
            'jenis_pengukuran'=> 'TB',
            'status_gizi'     => 'Gizi Normal',
        ]);

        return redirect()->route('periksa.index')->with('success', 'Data pemeriksaan berhasil ditambahkan.');
    }
}
