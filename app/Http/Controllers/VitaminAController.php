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
            'balita_id'         => 'required|exists:sp_balita,id',
            'jenis_kapsul'      => 'required',
            'bulan_pemberian'   => 'required',
            'tahun_pemberian'   => 'required|digits:4',
            'tanggal_pemberian' => 'required|date',
        ], [
            'balita_id.required'         => 'Nama anak tidak boleh kosong.',
            'jenis_kapsul.required'      => 'Jenis kapsul tidak boleh kosong.',
            'bulan_pemberian.required'   => 'Bulan pemberian tidak boleh kosong.',
            'tahun_pemberian.required'   => 'Tahun pemberian tidak boleh kosong.',
            'tahun_pemberian.digits'     => 'Tahun pemberian harus 4 digit (contoh: 2025).',
            'tanggal_pemberian.required' => 'Tanggal pemberian tidak boleh kosong.',
            'tanggal_pemberian.date'     => 'Format tanggal pemberian tidak valid.',
        ]);

        VitaminA::create($request->only([
            'balita_id', 'jenis_kapsul', 'bulan_pemberian', 'tahun_pemberian', 'tanggal_pemberian'
        ]));

        return redirect()->route('vitamina.index')->with('success', 'Data Vitamin A berhasil disimpan.');
    }

    public function index()
    {
        $vitamins = VitaminA::with('balita')
            ->whereHas('balita', function ($q) {
                $q->where('posyandu_id', session('posyandu_id'));
            })
            ->orderBy('tanggal_pemberian', 'desc')
            ->get();

        return view('pages.vitamin_a.index', compact('vitamins'));
    }

}
