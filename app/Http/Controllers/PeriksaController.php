<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Periksa;
use App\Models\Balita;
use App\Services\GiziKalkulator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PeriksaController extends Controller
{
    public function index()
    {
        // Hanya tampilkan periksa dari balita yang posyanduNya sama
        $periksas = Periksa::whereHas('balita', function ($q) {
            $q->where('posyandu_id', session('posyandu_id'));
        })->get();

        return view('pages.periksa.index', compact('periksas'));
    }

    public function create()
    {

        // Hanya tampilkan balita dari posyandu yang sedang login
        $balitas = Balita::where('posyandu_id', session('posyandu_id'))->get();
        return view('pages.periksa.create', compact('balitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'balita_id'      => ['required', Rule::exists('sp_balita', 'id')->where('posyandu_id', $request->user()->posyandu_id)],
            'tgl_periksa'    => 'required|date|before_or_equal:today',
            'berat_badan'    => 'required|numeric|gt:0',
            'tinggi_badan'   => 'required|numeric|between:45,110',
            'lingkar_kepala' => 'nullable|numeric',
            'catatan'        => 'nullable|string',
        ]);

        $balita = Balita::findOrFail($request->balita_id);

        $tgl_lahir   = \Carbon\Carbon::parse($balita->tgl_lahir);
        $tgl_periksa = \Carbon\Carbon::parse($request->tgl_periksa);
        if ($tgl_periksa->lt($tgl_lahir) || $tgl_periksa->gte($tgl_lahir->copy()->addMonths(61))) {
            throw ValidationException::withMessages(['tgl_periksa' => 'Tanggal pemeriksaan harus saat usia 0–60 bulan.']);
        }
        $umur_bulan  = (int) $tgl_lahir->diffInMonths($tgl_periksa);
        $gizi = \App\Services\GiziKalkulator::hitung(
        (float) $request->berat_badan,
        (float) $request->tinggi_badan,
        (int)   $umur_bulan,
        $balita->jk
    );

        Periksa::create([
            'balita_id'       => $request->balita_id,
            'tgl_lahir'       => $balita->tgl_lahir,
            'umur_bulan'      => $umur_bulan,
            'nama_ortu'       => $balita->nama_ortu,
            'tanggal_periksa' => $request->tgl_periksa,
            'berat_badan'     => $request->berat_badan,
            'tinggi_badan'    => $request->tinggi_badan,
            'jenis_pengukuran'=> 'TB',
            'status_gizi'     => $gizi['status_gizi'],
            'z_bbu'          => $gizi['z_bbu'],
            'z_tbu'          => $gizi['z_tbu'],
            'z_bbpb'         => $gizi['z_bbpb'],
        ]);

        return redirect()->route('periksa.index')->with('success', 'Data pemeriksaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $periksa = Periksa::whereHas('balita', fn ($q) => $q->where('posyandu_id', auth()->user()->posyandu_id))->findOrFail($id);
        $balitas = Balita::where('posyandu_id', session('posyandu_id'))->get();
        return view('pages.periksa.edit', compact('periksa', 'balitas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'balita_id'      => ['required', Rule::exists('sp_balita', 'id')->where('posyandu_id', $request->user()->posyandu_id)],
            'tgl_periksa'    => 'required|date|before_or_equal:today',
            'berat_badan'    => 'required|numeric|gt:0',
            'tinggi_badan'   => 'required|numeric|between:45,110',
            'lingkar_kepala' => 'nullable|numeric',
            'catatan'        => 'nullable|string',
        ]);

        $periksa = Periksa::whereHas('balita', fn ($q) => $q->where('posyandu_id', $request->user()->posyandu_id))->findOrFail($id);
        $balita  = Balita::findOrFail($request->balita_id);

        $tgl_lahir   = \Carbon\Carbon::parse($balita->tgl_lahir);
        $tgl_periksa = \Carbon\Carbon::parse($request->tgl_periksa);
        if ($tgl_periksa->lt($tgl_lahir) || $tgl_periksa->gte($tgl_lahir->copy()->addMonths(61))) {
            throw ValidationException::withMessages(['tgl_periksa' => 'Tanggal pemeriksaan harus saat usia 0–60 bulan.']);
        }
        $umur_bulan  = (int) $tgl_lahir->diffInMonths($tgl_periksa);

        $gizi = \App\Services\GiziKalkulator::hitung(
            (float) $request->berat_badan,
            (float) $request->tinggi_badan,
            (int)   $umur_bulan,
            $balita->jk
        );

        $periksa->update([
            'balita_id'       => $request->balita_id,
            'tgl_lahir'       => $balita->tgl_lahir,
            'umur_bulan'      => $umur_bulan,
            'nama_ortu'       => $balita->nama_ortu,
            'tanggal_periksa' => $request->tgl_periksa,
            'berat_badan'     => $request->berat_badan,
            'tinggi_badan'    => $request->tinggi_badan,
            'jenis_pengukuran'=> 'TB',
            'status_gizi'     => $gizi['status_gizi'],
            'z_bbu'          => $gizi['z_bbu'],
            'z_tbu'          => $gizi['z_tbu'],
            'z_bbpb'         => $gizi['z_bbpb'],
        ]);

        return redirect()->route('periksa.index')->with('success', 'Data pemeriksaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $periksa = Periksa::whereHas('balita', fn ($q) => $q->where('posyandu_id', auth()->user()->posyandu_id))->findOrFail($id);
        $periksa->delete();

        return redirect()->route('periksa.index')->with('success', 'Data pemeriksaan berhasil dihapus.');
    }

    public function riwayatAnak($balita_id)
    {
        $balita = Balita::with([
            'periksa'   => fn($q) => $q->orderBy('tanggal_periksa', 'desc'),
            'imunisasi' => fn($q) => $q->orderBy('tanggal_pemberian', 'desc'),
            'vitaminA'  => fn($q) => $q->orderBy('tanggal_pemberian', 'desc'),
        ])->where('posyandu_id', session('posyandu_id'))->findOrFail($balita_id);

        return response()->json([
            'jk'        => $balita->jk,
            'tgl_lahir' => $balita->tgl_lahir,
            'periksa'   => $balita->periksa->map(fn($p) => [
                'tanggal'      => $p->tanggal_periksa,
                'umur_bulan'   => $p->umur_bulan,
                'berat_badan'  => $p->berat_badan,
                'tinggi_badan' => $p->tinggi_badan,
                'status_gizi'  => $p->status_gizi,
                'z_bbu'       => $p->z_bbu,
                'z_tbu'       => $p->z_tbu,
                'z_bbpb'      => $p->z_bbpb,
            ]),
            'imunisasi' => $balita->imunisasi->map(fn($i) => [
                'tanggal'    => $i->tanggal_pemberian,
                'nama_vaksin'=> $i->nama_vaksin,
                'keterangan' => $i->keterangan,
            ]),
            'vitamin_a' => $balita->vitaminA->map(fn($v) => [
                'tanggal'     => $v->tanggal_pemberian,
                'jenis_kapsul'=> $v->jenis_kapsul,
            ]),
        ]);
    }


}
