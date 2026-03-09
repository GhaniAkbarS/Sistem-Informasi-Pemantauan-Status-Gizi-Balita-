<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Periksa;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $periksas = Periksa::with('balita')
            ->whereMonth('tanggal_periksa', $bulan)
            ->whereYear('tanggal_periksa', $tahun)
            ->get();

        $tahunList = Periksa::selectRaw('YEAR(tanggal_periksa) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('pages.laporan.index', compact('periksas', 'bulan', 'tahun', 'tahunList'));
    }

    public function cetak(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $periksas = Periksa::with('balita')
            ->whereMonth('tanggal_periksa', $bulan)
            ->whereYear('tanggal_periksa', $tahun)
            ->get();

        $namaBulan = \Carbon\Carbon::create()->month($bulan)->locale('id')->translatedFormat('F');

        return view('pages.laporan.cetak', compact('periksas', 'bulan', 'tahun', 'namaBulan'));
    }
}
