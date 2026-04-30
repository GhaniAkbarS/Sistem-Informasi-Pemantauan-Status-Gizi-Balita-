<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balita;

class BalitaController extends Controller
{
    public function index()
    {
        // Hanya tampilkan balita milik posyandu yang sedang login
        $balitas = Balita::where('posyandu_id', session('posyandu_id'))->get();
        return view('pages.balita.index', compact('balitas'));
    }

    public function create()
    {
        return view('pages.balita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required',
            'tgl_lahir'   => 'required|date',
            'umur'        => 'required|numeric',
            'nama_ortu'   => 'required',
            'tinggi_badan'=> 'required|numeric',
            'berat_badan' => 'required|numeric',
        ]);

        Balita::create([
            'nama'         => $request->nama,
            'tgl_lahir'    => $request->tgl_lahir,
            'umur'         => $request->umur,
            'nama_ortu'    => $request->nama_ortu,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan'  => $request->berat_badan,
            'posyandu_id'  => session('posyandu_id'), // ← otomatis dari session
        ]);

        return redirect()->route('balita.index')->with('success', 'Data Balita berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $balita = Balita::where('posyandu_id', session('posyandu_id'))->findOrFail($id);
        return view('pages.balita.edit', compact('balita'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'        => 'required',
            'tgl_lahir'   => 'required|date',
            'umur'        => 'required|numeric',
            'nama_ortu'   => 'required',
            'tinggi_badan'=> 'required|numeric',
            'berat_badan' => 'required|numeric',
        ]);

        $balita = Balita::where('posyandu_id', session('posyandu_id'))->findOrFail($id);
        $balita->update($request->except('posyandu_id')); // posyandu_id tidak boleh diubah

        return redirect()->route('balita.index')->with('success', 'Data Balita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $balita = Balita::where('posyandu_id', session('posyandu_id'))->findOrFail($id);
        $balita->delete();

        return redirect()->route('balita.index')->with('success', 'Data Balita berhasil dihapus!');
    }
}
