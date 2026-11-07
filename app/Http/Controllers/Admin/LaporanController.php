<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilSaw;
use App\Models\Kriteria;
use App\Models\Periode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periodes = Periode::orderBy('id', 'desc')->get();
        $selectedPeriodeId = $request->input('periode_id', optional(Periode::where('status_aktif', true)->first())->id);

        $selectedPeriode = null;
        $hasilSaws = collect();

        if ($selectedPeriodeId) {
            $selectedPeriode = Periode::find($selectedPeriodeId);
            if ($selectedPeriode) {
                $hasilSaws = HasilSaw::with('siswa')
                    ->where('periode_id', $selectedPeriode->id)
                    ->orderBy('peringkat', 'asc')
                    ->get();
            }
        }

        return view('pages.admin.laporan.index', compact('periodes', 'selectedPeriode', 'hasilSaws'));
    }

    public function cetakPdf(Request $request)
    {
        $periodeId = $request->input('periode_id');
        $periode = Periode::findOrFail($periodeId);

        $hasilSaws = HasilSaw::with('siswa')
            ->where('periode_id', $periode->id)
            ->orderBy('peringkat', 'asc')
            ->get();

        if ($hasilSaws->isEmpty()) {
            return back()->with('error', 'Tidak ada data hasil seleksi pada periode ini untuk dicetak.');
        }

        $kriterias = Kriteria::orderBy('kode_kriteria', 'asc')->get();

        $pdf = Pdf::loadView('pages.admin.laporan.pdf', [
            'periode' => $periode,
            'hasilSaws' => $hasilSaws,
            'kriterias' => $kriterias,
            'tanggalCetak' => date('d F Y'),
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Hasil_Seleksi_PIP_' . str_replace('/', '-', $periode->nama_periode) . '.pdf');
    }
}
