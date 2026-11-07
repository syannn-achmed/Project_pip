<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilSaw;
use App\Models\Periode;
use App\Services\SawService;
use Illuminate\Http\Request;

class HasilSawController extends Controller
{
    public function index(Request $request, SawService $sawService)
    {
        $periodeAktif = Periode::where('status_aktif', true)->first();

        if (!$periodeAktif) {
            return view('pages.admin.saw.index', [
                'periodeAktif' => null,
                'calculation' => [
                    'status' => false,
                    'message' => 'Tidak ada periode seleksi yang sedang aktif.',
                ],
                'kuota' => 10,
                'isPersisted' => false,
            ]);
        }

        $kuota = $request->input('kuota', 10);
        $kuota = max(1, (int) $kuota);

        $calculation = $sawService->calculate($periodeAktif->id, $kuota);
        $isPersisted = HasilSaw::where('periode_id', $periodeAktif->id)->exists();

        return view('pages.admin.saw.index', compact('periodeAktif', 'calculation', 'kuota', 'isPersisted'));
    }

    public function proses(Request $request, SawService $sawService)
    {
        $periodeAktif = Periode::where('status_aktif', true)->first();

        if (!$periodeAktif) {
            return back()->with('error', 'Gagal memproses. Tidak ada periode yang sedang aktif.');
        }

        $kuota = $request->input('kuota', 10);
        $kuota = max(1, (int) $kuota);

        $result = $sawService->calculateAndPersist($periodeAktif->id, $kuota);

        if (!$result['status']) {
            return back()->with('error', $result['message']);
        }

        return redirect()->route('admin.saw.index', ['kuota' => $kuota])
            ->with('success', 'Perhitungan SAW dan pembaruan perangkingan berhasil disimpan ke basis data.');
    }
}
