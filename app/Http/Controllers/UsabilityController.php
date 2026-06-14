<?php

namespace App\Http\Controllers;

use App\Models\UsabilitySession;
use App\Models\UsabilityLog;
use App\Models\UsabilityTaskResult;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsabilityController extends Controller
{
    // Daftar skenario pengujian
    public static function skenarioList(): array
    {
        return [
            1 => 'Menambahkan data balita baru',
            2 => 'Melakukan input pengukuran (periksa)',
            3 => 'Melihat status gizi balita',
            4 => 'Melihat laporan / rekap data',
        ];
    }

    // ── Halaman mulai sesi ──────────────────────────────────────────────────────
    public function start()
    {
        return view('pages.usability.start', [
            'skenarios' => self::skenarioList(),
        ]);
    }

    // ── Simpan sesi baru & set session cookie ─────────────────────────────────
    public function doStart(Request $request)
    {
        $request->validate([
            'nama_penguji' => 'required|string|max:100',
            'peran'        => 'required|string|max:50',
        ]);

        $sesi = UsabilitySession::create([
            'nama_penguji' => $request->nama_penguji,
            'peran'        => $request->peran,
            'mulai_at'     => now(),
            'token'        => Str::random(32),
        ]);

        // Simpan ID sesi di Laravel session
        session(['usability_session_id' => $sesi->id]);
        session(['usability_token'      => $sesi->token]);

        return redirect('/')->with('usability_started', true);
    }

    // ── Terima log event dari JavaScript (AJAX) ───────────────────────────────
    public function logEvent(Request $request)
    {
        $sessionId = session('usability_session_id');
        if (!$sessionId) {
            return response()->json(['ok' => false, 'msg' => 'Tidak ada sesi aktif'], 400);
        }

        UsabilityLog::create([
            'usability_session_id' => $sessionId,
            'event_type'           => $request->event_type ?? 'unknown',
            'page_url'             => $request->page_url ?? '',
            'page_name'            => $request->page_name ?? null,
            'element'              => $request->element ?? null,
            'durasi_di_halaman'    => $request->durasi_di_halaman ?? null,
            'is_back_navigation'   => $request->is_back_navigation ?? false,
            'is_error'             => $request->is_error ?? false,
            'catatan'              => $request->catatan ?? null,
            'terjadi_at'           => now(),
        ]);

        return response()->json(['ok' => true]);
    }

    // ── Tandai skenario selesai ────────────────────────────────────────────────
    public function completeTask(Request $request)
    {
        $sessionId = session('usability_session_id');
        if (!$sessionId) {
            return response()->json(['ok' => false], 400);
        }

        UsabilityTaskResult::create([
            'usability_session_id' => $sessionId,
            'task_number'          => $request->task_number,
            'task_name'            => self::skenarioList()[$request->task_number] ?? 'Tidak diketahui',
            'berhasil'             => $request->berhasil ?? true,
            'durasi_detik'         => $request->durasi_detik ?? null,
            'jumlah_error'         => $request->jumlah_error ?? 0,
        ]);

        return response()->json(['ok' => true]);
    }

    // ── Akhiri sesi ───────────────────────────────────────────────────────────
    public function end()
    {
        $sessionId = session('usability_session_id');
        if (!$sessionId) {
            return redirect('/usability/start');
        }

        $sesi = UsabilitySession::find($sessionId);
        if ($sesi) {
            $sesi->update([
                'selesai_at'   => now(),
                'durasi_detik' => now()->diffInSeconds($sesi->mulai_at),
            ]);
        }

        session()->forget(['usability_session_id', 'usability_token']);

        return redirect('/usability/report/' . $sesi->token);
    }

    // ── Halaman report ────────────────────────────────────────────────────────
    public function report(string $token)
    {
        $sesi = UsabilitySession::where('token', $token)
            ->with(['logs', 'taskResults'])
            ->firstOrFail();

        $totalPages    = $sesi->logs->where('event_type', 'page_visit')->count();
        $totalClicks   = $sesi->logs->where('event_type', 'click')->count();
        $totalError    = $sesi->logs->where('is_error', true)->count();
        $totalBack     = $sesi->logs->where('is_back_navigation', true)->count();
        $taskResults   = $sesi->taskResults;
        $completedTask = $taskResults->where('berhasil', true)->count();
        $totalTask     = $taskResults->count();

        // Hitung Task Completion Rate
        $completionRate = $totalTask > 0
            ? round(($completedTask / $totalTask) * 100)
            : 0;

        // Hitung Error Rate
        $errorRate = ($totalClicks + $totalPages) > 0
            ? round(($totalError / ($totalClicks + $totalPages)) * 100, 1)
            : 0;

        // Rata-rata durasi per halaman (detik)
        $avgPageDuration = $sesi->logs
            ->where('event_type', 'page_visit')
            ->whereNotNull('durasi_di_halaman')
            ->avg('durasi_di_halaman');

        // Skor Usability sederhana (0-100)
        // Formula: (completion rate * 0.5) + ((100 - error rate) * 0.3) + (navigasi balik rendah * 0.2)
        $backNavPenalty  = min($totalBack * 5, 40); // max penalti 40 poin
        $usabilityScore  = round(
            ($completionRate * 0.5) + ((100 - $errorRate) * 0.3) + ((40 - $backNavPenalty) * 0.5)
        );
        $usabilityScore  = max(0, min(100, $usabilityScore));

        // Navigation path (urutan halaman)
        $navPath = $sesi->logs
            ->where('event_type', 'page_visit')
            ->sortBy('terjadi_at')
            ->pluck('page_name')
            ->toArray();

        return view('pages.usability.report', compact(
            'sesi', 'totalPages', 'totalClicks', 'totalError', 'totalBack',
            'completionRate', 'errorRate', 'avgPageDuration',
            'usabilityScore', 'taskResults', 'navPath'
        ));
    }

    // ── Daftar semua sesi (untuk admin) ──────────────────────────────────────
    public function index()
    {
        $sessions = UsabilitySession::withCount('logs')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('pages.usability.index', compact('sessions'));
    }
}
