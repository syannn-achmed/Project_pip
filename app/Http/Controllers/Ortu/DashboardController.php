<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use App\Models\HasilSaw;
use App\Models\Periode;
use App\Models\Siswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $periodeAktif = Periode::where('status_aktif', true)->first();

        // 1. Ambil anak yang tertaut dengan akun orang tua ini
        $anakTertaut = Siswa::where('user_id_ortu', $user->id)->get();

        // Jika orang tua mencoba mencari data anak via NIS
        $searchSiswa = null;
        if ($request->filled('nis')) {
            $searchSiswa = Siswa::where('nis', $request->nis)->first();
        }

        // 2. Ambil hasil seleksi untuk anak tertaut atau anak yang dicari
        $hasilAnak = collect();
        if ($periodeAktif) {
            $targetSiswaIds = $anakTertaut->pluck('id')->toArray();
            if ($searchSiswa && !in_array($searchSiswa->id, $targetSiswaIds)) {
                $targetSiswaIds[] = $searchSiswa->id;
            }

            if (!empty($targetSiswaIds)) {
                $hasilAnak = HasilSaw::with('siswa')
                    ->where('periode_id', $periodeAktif->id)
                    ->whereIn('siswa_id', $targetSiswaIds)
                    ->get();
            }
        }

        // 3. Ambil daftar pengumuman umum dengan data masking (sensor nama & NIS demi privasi)
        $pengumumanUmum = collect();
        if ($periodeAktif) {
            $pengumumanUmum = HasilSaw::with('siswa')
                ->where('periode_id', $periodeAktif->id)
                ->orderBy('peringkat', 'asc')
                ->get()
                ->map(function ($item) {
                    $nama = $item->siswa->nama ?? 'Siswa';
                    $nis = $item->siswa->nis ?? '0000';

                    // Masking Nama: Ambil huruf awal tiap kata, sisanya sensor bintang
                    $maskedNama = preg_replace_callback('/\b(\w)(\w+)/u', function ($matches) {
                        return $matches[1] . str_repeat('*', min(4, strlen($matches[2])));
                    }, $nama);

                    // Masking NIS: Sisakan 2 digit awal dan 2 digit akhir
                    $maskedNis = strlen($nis) > 4
                        ? substr($nis, 0, 2) . str_repeat('*', strlen($nis) - 4) . substr($nis, -2)
                        : str_repeat('*', strlen($nis));

                    return [
                        'peringkat' => $item->peringkat,
                        'masked_nama' => $maskedNama,
                        'masked_nis' => $maskedNis,
                        'kelas' => $item->siswa->kelas ?? '-',
                        'nilai_akhir' => $item->nilai_akhir,
                        'status_penerimaan' => $item->status_penerimaan,
                    ];
                });
        }

        return view('pages.ortu.dashboard', compact(
            'user',
            'periodeAktif',
            'anakTertaut',
            'searchSiswa',
            'hasilAnak',
            'pengumumanUmum'
        ));
    }
}
