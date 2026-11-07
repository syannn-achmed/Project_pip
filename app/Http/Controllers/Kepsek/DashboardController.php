<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\HasilSaw;
use App\Models\Periode;
use App\Models\Siswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $periodeAktif = Periode::where('status_aktif', true)->first();

        $totalSiswa = Siswa::count();
        $hasilSaws = collect();
        $totalLolos = 0;

        if ($periodeAktif) {
            $hasilSaws = HasilSaw::with('siswa')
                ->where('periode_id', $periodeAktif->id)
                ->orderBy('peringkat', 'asc')
                ->get();

            $totalLolos = $hasilSaws->where('status_penerimaan', 'Lolos')->count();
        }

        return view('pages.kepsek.dashboard', compact('periodeAktif', 'totalSiswa', 'hasilSaws', 'totalLolos'));
    }
}
