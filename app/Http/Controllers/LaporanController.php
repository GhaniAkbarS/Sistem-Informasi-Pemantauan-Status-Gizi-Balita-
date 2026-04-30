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

        // Tambahkan filter whereHas untuk posyandu
        $periksas = Periksa::with('balita')
            ->whereHas('balita', function ($q) {
                $q->where('posyandu_id', session('posyandu_id'));
            })
            ->whereMonth('tanggal_periksa', $bulan)
            ->whereYear('tanggal_periksa', $tahun)
            ->get();

        // Tahun list juga difilter agar hanya muncul tahun dari data posyandu ini
        $tahunList = Periksa::whereHas('balita', function ($q) {
                $q->where('posyandu_id', session('posyandu_id'));
            })
            ->selectRaw('YEAR(tanggal_periksa) as tahun')
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
            ->whereHas('balita', function ($q) {
                $q->where('posyandu_id', session('posyandu_id'));
            })
            ->whereMonth('tanggal_periksa', $bulan)
            ->whereYear('tanggal_periksa', $tahun)
            ->get();

        return view('pages.laporan.cetak', compact('periksas', 'bulan', 'tahun'));
    }
}
