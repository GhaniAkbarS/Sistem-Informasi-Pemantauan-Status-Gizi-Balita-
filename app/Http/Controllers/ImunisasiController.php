<?php

namespace App\Http\Controllers;

use App\Models\Imunisasi;
use App\Models\Balita;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ImunisasiController extends Controller
{
    public function create()
    {
        $balitas = Balita::where('posyandu_id', session('posyandu_id'))->get();
        return view('pages.imunisasi.create', compact('balitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'balita_id'         => ['required', Rule::exists('sp_balita', 'id')->where('posyandu_id', $request->user()->posyandu_id)],
            'nama_vaksin'       => 'required',
            'tanggal_pemberian' => 'required|date',
            'keterangan'        => 'nullable|string',
        ]);

        Imunisasi::create($request->only([
            'balita_id', 'nama_vaksin', 'tanggal_pemberian', 'keterangan'
        ]));

        return redirect()->route('imunisasi.index')->with('success', 'Data imunisasi berhasil disimpan.');
    }

    public function index()
    {
        $imunisasis = Imunisasi::with('balita')
            ->whereHas('balita', function ($q) {
                $q->where('posyandu_id', session('posyandu_id'));
            })
            ->orderBy('tanggal_pemberian', 'desc')
            ->get();

        return view('pages.imunisasi.index', compact('imunisasis'));
    }

}
