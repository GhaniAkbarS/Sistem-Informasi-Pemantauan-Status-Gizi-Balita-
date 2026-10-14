<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Balita;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class BalitaController extends Controller
{
    public function index()
    {
        // Hanya tampilkan balita milik posyandu yang sedang login
        $balitas = Balita::where('posyandu_id', session('posyandu_id'))->get();
        // <-- MENGEMBALIKAN (return) objek View berisi halaman HTML
        return view('pages.balita.index', compact('balitas'));
    }

    public function create()
    {
        $orangTuas = \App\Models\User::where('role', 'orang_tua')->where('posyandu_id',session('posyandu_id'))->get();
        return view('pages.balita.create', compact('orangTuas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'jk'          => 'required|in:L,P',
            'tgl_lahir'   => 'required|date|before_or_equal:today',
            'umur'        => 'nullable|integer|between:0,60',
            'tinggi_badan'=> 'required|numeric|gt:0',
            'berat_badan' => 'required|numeric|gt:0',
            'user_id'     => ['required', Rule::exists('sp_users', 'id')->where('posyandu_id', $request->user()->posyandu_id)->where('role', 'orang_tua')],
        ]);

        /* =========================================================
           SLIDE 7: IMPLEMENTASI DEBUGGING
           (Bisa Anda uncomment dd() di bawah ini untuk screenshot, 
           lalu comment/hapus lagi agar aplikasi berjalan normal)
           ========================================================= */
        // \Illuminate\Support\Facades\Log::info('Mencoba input data balita', $request->all());
        // dd('Berhenti di sini untuk cek input data:', $request->all());

        $orangTua = User::findOrFail($request->user_id);
        $umurBulan = $this->umurBulan($request->tgl_lahir);

        $namaBalita = $request->nama;

        /* =========================================================
           SLIDE 4: IMPLEMENTASI PEMROGRAMAN TERSTRUKTUR (POINTER)
           Memanggil fungsi reference/pointer untuk mengubah nama
           ========================================================= */
        $this->formatNamaBalita($namaBalita);

        Balita::create([
            'nama'         => $namaBalita,
            'jk'           => $request->jk,
            'tgl_lahir'    => $request->tgl_lahir,
            'umur'         => $umurBulan,
            'nama_ortu'    => $orangTua->name,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan'  => $request->berat_badan,
            'user_id'      => $request->user_id,
            'posyandu_id'  => session('posyandu_id'),
        ]);

        return redirect()->route('balita.index')->with('success', 'Data Balita berhasil ditambahkan!');
    }

    /**
     * SLIDE 4: POINTER/REFERENCE
     * Fungsi Helper dengan POINTER (Reference &)
     * Mengubah nama menjadi huruf kapital langsung pada memori variabel aslinya.
     */
    private function formatNamaBalita(&$nama)
    {
        $nama = strtoupper($nama);
    }

    public function edit($id)
    {
        $balita = Balita::where('posyandu_id', session('posyandu_id'))->findOrFail($id);
        
        // Ambil akun orang tua dari posyandu yang sama
        $orangTuas = \App\Models\User::where('posyandu_id', session('posyandu_id'))
                        ->where('role', 'orang_tua')
                        ->get();

        return view('pages.balita.edit', compact('balita', 'orangTuas'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'user_id'      => ['nullable', Rule::exists('sp_users', 'id')->where('posyandu_id', $request->user()->posyandu_id)->where('role', 'orang_tua')],
            'jk'           => 'required|in:L,P',
            'tgl_lahir'    => 'required|date|before_or_equal:today',
            'umur'         => 'nullable|integer|between:0,60',
            'tinggi_badan' => 'required|numeric|gt:0',
            'berat_badan'  => 'required|numeric|gt:0',
        ]);

        $balita = Balita::where('posyandu_id', session('posyandu_id'))->findOrFail($id);
        $umurBulan = $this->umurBulan($request->tgl_lahir);

        // Ambil nama_ortu dari user yang dipilih
        $namaOrtu = $balita->nama_ortu; // default tetap yang lama
        if ($request->user_id) {
            $orangTua = \App\Models\User::find($request->user_id);
            if ($orangTua) $namaOrtu = $orangTua->name;
        }

        $namaBalita = $request->nama;
        // Gunakan pointer untuk mengubah menjadi uppercase
        $this->formatNamaBalita($namaBalita);

        $balita->update([
            'nama'         => $namaBalita,
            'jk'           => $request->jk,
            'tgl_lahir'    => $request->tgl_lahir,
            'umur'         => $umurBulan,
            'nama_ortu'    => $namaOrtu,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan'  => $request->berat_badan,
            'user_id'      => $request->user_id,
        ]);

        return redirect()->route('balita.index')->with('success', 'Data Balita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $balita = Balita::where('posyandu_id', session('posyandu_id'))->findOrFail($id);
        if ($balita->periksa()->exists() || $balita->imunisasi()->exists() || $balita->vitaminA()->exists()) {
            return back()->with('error', 'Data balita dengan riwayat pemeriksaan atau layanan tidak dapat dihapus.');
        }
        $balita->delete();

        return redirect()->route('balita.index')->with('success', 'Data Balita berhasil dihapus!');
    }

    private function umurBulan(string $tanggalLahir): int
    {
        $lahir = Carbon::parse($tanggalLahir);
        $umur = (int) $lahir->diffInMonths(today());
        if ($umur > 60) {
            throw ValidationException::withMessages(['tgl_lahir' => 'Usia balita harus 0–60 bulan.']);
        }
        return $umur;
    }
}
