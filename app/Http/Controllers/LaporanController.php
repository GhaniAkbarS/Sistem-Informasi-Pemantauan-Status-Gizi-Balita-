<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Periksa;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = (int)($request->bulan ?? now()->month);
        $tahun = (int)($request->tahun ?? now()->year);
        $posyanduId = session('posyandu_id');

        // ── Data Pemeriksaan ──
        $periksas = \App\Models\Periksa::with('balita')
            ->whereHas('balita', fn($q) => $q->where('posyandu_id', $posyanduId))
            ->whereMonth('tanggal_periksa', $bulan)
            ->whereYear('tanggal_periksa', $tahun)
            ->get();

        // ── Data Balita & Ortu ──
        $balitas = \App\Models\Balita::where('posyandu_id', $posyanduId)
            ->orderBy('nama')
            ->get();

        // ── Data Imunisasi ──
        $imunisasis = \App\Models\Imunisasi::with('balita')
            ->whereHas('balita', fn($q) => $q->where('posyandu_id', $posyanduId))
            ->whereYear('tanggal_pemberian', $tahun)
            ->orderBy('tanggal_pemberian', 'desc')
            ->get();

        // ── Data Vitamin A ──
        $vitamins = \App\Models\VitaminA::with('balita')
            ->whereHas('balita', fn($q) => $q->where('posyandu_id', $posyanduId))
            ->where('tahun_pemberian', $tahun)
            ->orderBy('tanggal_pemberian', 'desc')
            ->get();

        // ── Daftar Tahun untuk filter ──
        $tahunList = \App\Models\Periksa::whereHas('balita', fn($q) => $q->where('posyandu_id', $posyanduId))
            ->selectRaw('YEAR(tanggal_periksa) as tahun')
            ->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('pages.laporan.index', compact(
            'periksas', 'balitas', 'imunisasis', 'vitamins',
            'bulan', 'tahun', 'tahunList'
        ));
    }


    public function cetak(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $periksas = Periksa::with('balita')
            ->whereHas('balita', function ($q) {
                $q->where('posyandu_id', session('posyandu_id'));
            })
            ->whereMonth('tanggal_periksa', $bulan)
            ->whereYear('tanggal_periksa', $tahun)
            ->get();
        $namaBulan = \Carbon\Carbon::create()->month((int)$bulan)->locale('id')->translatedFormat('F');

        return view('pages.laporan.cetak', compact('periksas', 'bulan', 'tahun', 'namaBulan'));
    }

    public function cetakBalita()
    {
        $balitas = \App\Models\Balita::where('posyandu_id', session('posyandu_id'))
            ->orderBy('nama')
            ->get();

        return view('pages.laporan.cetak_balita', compact('balitas'));
    }

    public function cetakImunisasi(Request $request)
    {
        $tahun = (int)($request->tahun ?? now()->year);

        $imunisasis = \App\Models\Imunisasi::with('balita')
            ->whereHas('balita', function ($q) {
                $q->where('posyandu_id', session('posyandu_id'));
            })
            ->whereYear('tanggal_pemberian', $tahun)
            ->orderBy('tanggal_pemberian', 'desc')
            ->get();

        $tahunList = \App\Models\Imunisasi::whereHas('balita', function ($q) {
                $q->where('posyandu_id', session('posyandu_id'));
            })
            ->selectRaw('YEAR(tanggal_pemberian) as tahun')
            ->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('pages.laporan.cetak_imunisasi', compact('imunisasis', 'tahun', 'tahunList'));
    }

    public function cetakVitaminA(Request $request)
    {
        $tahun = (int)($request->tahun ?? now()->year);

        $vitamins = \App\Models\VitaminA::with('balita')
            ->whereHas('balita', function ($q) {
                $q->where('posyandu_id', session('posyandu_id'));
            })
            ->where('tahun_pemberian', $tahun)
            ->orderBy('tanggal_pemberian', 'desc')
            ->get();

        $tahunList = \App\Models\VitaminA::whereHas('balita', function ($q) {
                $q->where('posyandu_id', session('posyandu_id'));
            })
            ->selectRaw('tahun_pemberian as tahun')
            ->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('pages.laporan.cetak_vitamina', compact('vitamins', 'tahun', 'tahunList'));
    }

}
