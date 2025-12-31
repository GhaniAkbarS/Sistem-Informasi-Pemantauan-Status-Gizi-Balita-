<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BalitaController extends Controller
{
    public function create()
    {
        return view('pages.input.balita.create');
    }

    public function index(): View{
        
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

        // Karena dummy, kita tidak simpan ke database.
        // Langsung redirect back dengan success message.
        
        return redirect()->route('balita.create')->with('success', 'Data Balita berhasil ditambahkan (Dummy)!');
    }
}
