<?php

namespace App\Http\Controllers;

use App\Models\VitaminA;
use App\Models\Balita;
use Illuminate\Http\Request;

class VitaminAController extends Controller
{
    public function create()
    {
        $balitas = Balita::where('posyandu_id', session('posyandu_id'))->get();
        return view('pages.vitamin_a.create', compact('balitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'balita_id'          => 'required|exists:sp_balita,id',
            'jenis_kapsul'       => 'required',
            'bulan_pemberian'    => 'required',
            'tahun_pemberian'    => 'required|digits:4',
            'tanggal_pemberian'  => 'required|date',
        ]);

        VitaminA::create($request->only([
            'balita_id', 'jenis_kapsul', 'bulan_pemberian', 'tahun_pemberian', 'tanggal_pemberian'
        ]));

        return redirect()->route('vitamina.create')->with('success', 'Data Vitamin A berhasil disimpan.');
    }
}
