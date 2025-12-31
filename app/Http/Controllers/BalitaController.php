<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balita;

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

        // Create data balita
        Balita::create($request->all());
        
        return redirect()->route('balita.create')->with('success', 'Data Balita berhasil ditambahkan!');
    }
}
