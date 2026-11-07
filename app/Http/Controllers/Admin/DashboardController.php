<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilSaw;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Periode;
use App\Models\Siswa;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $periodeAktif = Periode::where('status_aktif', true)->first();

        $totalSiswa = Siswa::count();
        $totalKriteria = Kriteria::count();
        $totalSubKriteria = SubKriteria::count();
        $totalPeriode = Periode::count();

        $siswaDinilaiCount = 0;
        $persenDinilai = 0;
        $topSaw = collect();

        if ($periodeAktif) {
            $siswaDinilaiCount = Penilaian::where('periode_id', $periodeAktif->id)
                ->distinct('siswa_id')
                ->count('siswa_id');

            if ($totalSiswa > 0) {
                $persenDinilai = round(($siswaDinilaiCount / $totalSiswa) * 100);
            }

            $topSaw = HasilSaw::with('siswa')
                ->where('periode_id', $periodeAktif->id)
                ->orderBy('peringkat', 'asc')
                ->take(5)
                ->get();
        }

        return view('pages.admin.dashboard', compact(
            'periodeAktif',
            'totalSiswa',
            'totalKriteria',
            'totalSubKriteria',
            'totalPeriode',
            'siswaDinilaiCount',
            'persenDinilai',
            'topSaw'
        ));
    }
}
