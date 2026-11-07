<?php

namespace App\Services;

use App\Models\HasilSaw;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Periode;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

/**
 * Class SawService
 * 
 * Bertanggung jawab menangani seluruh kalkulasi Sistem Pendukung Keputusan (SPK)
 * menggunakan metode Simple Additive Weighting (SAW).
 * Mengedepankan Clean Code, Single Responsibility, dan mudah ditelusuri (traceable).
 */
class SawService
{
    /**
     * Hitung proses SAW lengkap untuk suatu periode
     * 
     * @param int $periodeId
     * @param int|null $kuota
     * @return array
     */
    public function calculate(int $periodeId, ?int $kuota = null): array
    {
        $periode = Periode::findOrFail($periodeId);
        $kriterias = Kriteria::with('subKriterias')->orderBy('kode_kriteria', 'asc')->get();
        $siswas = Siswa::orderBy('nama', 'asc')->get();

        // 1. Validasi Awal Prasyarat SAW
        if ($kriterias->isEmpty()) {
            return [
                'status' => false,
                'message' => 'Belum ada data kriteria yang ditentukan.',
            ];
        }

        if ($siswas->isEmpty()) {
            return [
                'status' => false,
                'message' => 'Belum ada data siswa (alternatif) yang terdaftar.',
            ];
        }

        $totalBobot = $kriterias->sum('bobot');
        if (abs($totalBobot - 100) > 0.01) {
            return [
                'status' => false,
                'message' => "Total bobot kriteria saat ini {$totalBobot}%. Syarat perhitungan SAW total bobot harus tepat 100%.",
            ];
        }

        // Ambil seluruh penilaian pada periode ini
        $allPenilaians = Penilaian::with('subKriteria')
            ->where('periode_id', $periodeId)
            ->get();

        // 2. Pembentukan Matriks Keputusan (X)
        $matriksX = [];
        $siswaDinilaiIds = [];

        foreach ($siswas as $siswa) {
            $nilaiSiswaPerKriteria = [];
            $lengkap = true;

            foreach ($kriterias as $kriteria) {
                $penilaian = $allPenilaians->first(function ($item) use ($siswa, $kriteria) {
                    return $item->siswa_id === $siswa->id && $item->kriteria_id === $kriteria->id;
                });

                if ($penilaian && $penilaian->subKriteria) {
                    $nilaiSiswaPerKriteria[$kriteria->id] = (float) $penilaian->subKriteria->nilai;
                } else {
                    $nilaiSiswaPerKriteria[$kriteria->id] = null;
                    $lengkap = false;
                }
            }

            // Hanya siswa yang sudah lengkap dinilai pada seluruh kriteria yang masuk matriks keputusan
            if ($lengkap) {
                $matriksX[$siswa->id] = [
                    'siswa' => $siswa,
                    'nilai' => $nilaiSiswaPerKriteria,
                ];
                $siswaDinilaiIds[] = $siswa->id;
            }
        }

        if (empty($matriksX)) {
            return [
                'status' => false,
                'message' => 'Belum ada siswa yang memiliki penilaian lengkap pada semua kriteria di periode ini.',
            ];
        }

        // 3. Tentukan Nilai Ekstrem (Max untuk Benefit, Min untuk Cost)
        $ekstremKriteria = [];
        foreach ($kriterias as $kriteria) {
            $kolomNilai = [];
            foreach ($matriksX as $row) {
                $kolomNilai[] = $row['nilai'][$kriteria->id];
            }

            $ekstremKriteria[$kriteria->id] = [
                'max' => !empty($kolomNilai) ? max($kolomNilai) : 1,
                'min' => !empty($kolomNilai) ? min($kolomNilai) : 1,
            ];
        }

        // 4. Normalisasi Matriks (R)
        // Benefit: R_ij = X_ij / Max_j
        // Cost:    R_ij = Min_j / X_ij
        $matriksR = [];
        foreach ($matriksX as $siswaId => $data) {
            $normalisasiRow = [];
            foreach ($kriterias as $kriteria) {
                $xVal = $data['nilai'][$kriteria->id];
                $maxVal = $ekstremKriteria[$kriteria->id]['max'];
                $minVal = $ekstremKriteria[$kriteria->id]['min'];

                if ($kriteria->tipe === 'benefit') {
                    $rVal = $maxVal > 0 ? ($xVal / $maxVal) : 0;
                } else {
                    // Cost
                    $rVal = $xVal > 0 ? ($minVal / $xVal) : 0;
                }

                $normalisasiRow[$kriteria->id] = round($rVal, 4);
            }

            $matriksR[$siswaId] = [
                'siswa' => $data['siswa'],
                'normalisasi' => $normalisasiRow,
            ];
        }

        // 5. Perhitungan Nilai Preferensi (V)
        // V_i = sum(W_j * R_ij)
        // W_j dinormalisasi dari persentase (e.g. 25% = 0.25)
        $hasilAkhir = [];
        foreach ($matriksR as $siswaId => $data) {
            $totalV = 0;
            $rincianV = [];

            foreach ($kriterias as $kriteria) {
                $w = $kriteria->bobot / 100; // Skala 0 s/d 1
                $r = $data['normalisasi'][$kriteria->id];
                $bobotXR = $w * $r;

                $rincianV[$kriteria->id] = round($bobotXR, 4);
                $totalV += $bobotXR;
            }

            $hasilAkhir[] = [
                'siswa' => $data['siswa'],
                'siswa_id' => $siswaId,
                'rincian_v' => $rincianV,
                'nilai_akhir' => round($totalV, 4),
            ];
        }

        // 6. Urutkan Ranking (Nilai Preferensi Tertinggi ke Terendah)
        usort($hasilAkhir, function ($a, $b) {
            if ($a['nilai_akhir'] == $b['nilai_akhir']) {
                return 0;
            }
            return ($a['nilai_akhir'] > $b['nilai_akhir']) ? -1 : 1;
        });

        // 7. Berikan Peringkat & Tentukan Status Berdasarkan Kuota
        $peringkat = 1;
        $rankings = [];

        foreach ($hasilAkhir as $item) {
            $status = 'Pending';
            if ($kuota !== null && $kuota > 0) {
                if ($peringkat <= $kuota) {
                    $status = 'Lolos';
                } else {
                    $status = 'Tidak Lolos';
                }
            } else {
                $status = 'Lolos';
            }

            $item['peringkat'] = $peringkat;
            $item['status_penerimaan'] = $status;
            $rankings[] = $item;
            $peringkat++;
        }

        return [
            'status' => true,
            'periode' => $periode,
            'kriterias' => $kriterias,
            'ekstremKriteria' => $ekstremKriteria,
            'matriksX' => $matriksX,
            'matriksR' => $matriksR,
            'rankings' => $rankings,
            'total_alternatif' => count($siswas),
            'total_dinilai' => count($siswaDinilaiIds),
        ];
    }

    /**
     * Hitung dan Simpan / Perbarui Hasil ke Tabel hasil_saws
     * 
     * @param int $periodeId
     * @param int|null $kuota
     * @return array
     */
    public function calculateAndPersist(int $periodeId, ?int $kuota = null): array
    {
        $result = $this->calculate($periodeId, $kuota);

        if (!$result['status']) {
            return $result;
        }

        DB::transaction(function () use ($periodeId, $result) {
            foreach ($result['rankings'] as $rank) {
                HasilSaw::updateOrCreate(
                    [
                        'periode_id' => $periodeId,
                        'siswa_id' => $rank['siswa_id'],
                    ],
                    [
                        'nilai_akhir' => $rank['nilai_akhir'],
                        'peringkat' => $rank['peringkat'],
                        'status_penerimaan' => $rank['status_penerimaan'],
                    ]
                );
            }
        });

        return $result;
    }
}
