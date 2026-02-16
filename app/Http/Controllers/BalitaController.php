<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balita;

class BalitaController extends Controller
{
    public function create()
    {
        return view('pages.balita.create');
    }

    public function index(){
        $balitas = Balita::all();
        return view('pages.balita.index', compact('balitas'));
    }

    public function store(Request $request)
    {
        // Simple validation
        $request->validate([
            'nama' => 'required',
            'tgl_lahir' => 'required|date',
            'umur' => 'required|numeric',
            'nama_ortu' => 'required',
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
        ]);

        // Create data balita
        Balita::create($request->all());
        
        return redirect()->route('balita.index')->with('success', 'Data Balita berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $balita = Balita::findOrFail($id);
        return view('pages.balita.edit', compact('balita'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'tgl_lahir' => 'required|date',
            'umur' => 'required|numeric',
            'nama_ortu' => 'required',
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
        ]);

        $balita = Balita::findOrFail($id);
        $balita->update($request->all());

        return redirect()->route('balita.index')->with('success', 'Data Balita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $balita = Balita::findOrFail($id);
        $balita->delete();

        return redirect()->route('balita.index')->with('success', 'Data Balita berhasil dihapus!');
    }
}
