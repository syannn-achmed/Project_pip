<?php

namespace App\Imports;

use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Siswa;
use App\Models\SubKriteria;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PenilaianImport implements ToCollection, WithHeadingRow
{
    protected int $periodeId;
    protected array $importStats = [
        'total_rows' => 0,
        'siswa_processed' => 0,
        'penilaian_saved' => 0,
        'skipped_rows' => 0,
        'errors' => []
    ];

    public function __construct(int $periodeId)
    {
        $this->periodeId = $periodeId;
    }

    public function collection(Collection $rows)
    {
        $kriterias = Kriteria::with('subKriterias')->orderBy('kode_kriteria', 'asc')->get();

        if ($kriterias->isEmpty()) {
            throw new \Exception('Data kriteria belum tersedia. Harap isi data kriteria dan sub kriteria terlebih dahulu.');
        }

        // Petakan kriteria untuk pencocokan header fleksibel (c1, c2, c_1, kriteria_c1, dsb)
        $kriteriaMap = [];
        foreach ($kriterias as $k) {
            $kodeClean = strtolower(trim($k->kode_kriteria));
            $kriteriaMap[$kodeClean] = $k;
        }

        DB::transaction(function () use ($rows, $kriterias, $kriteriaMap) {
            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; // +2 untuk memperhitungkan baris header Excel
                $this->importStats['total_rows']++;

                // 1. Ekstraksi NIS dan Nama Siswa
                $nis = null;
                foreach (['nis', 'nisn', 'nomor_induk', 'no_induk'] as $key) {
                    if (isset($row[$key]) && trim((string)$row[$key]) !== '') {
                        $nis = trim((string)$row[$key]);
                        break;
                    }
                }

                $nama = null;
                foreach (['nama_siswa', 'nama_lengkap', 'nama', 'alternatif'] as $key) {
                    if (isset($row[$key]) && trim((string)$row[$key]) !== '') {
                        $nama = trim((string)$row[$key]);
                        break;
                    }
                }

                if (!$nis && !$nama) {
                    $this->importStats['skipped_rows']++;
                    continue;
                }

                // 2. Temukan siswa di database berdasarkan NIS, atau fallback via Nama Siswa
                $siswa = null;
                if ($nis) {
                    $siswa = Siswa::where('nis', $nis)->first();
                }

                if (!$siswa && $nama) {
                    $siswa = Siswa::where('nama', 'like', $nama)->first();
                }

                if (!$siswa) {
                    $this->importStats['errors'][] = "Baris #{$rowNumber}: Siswa dengan NIS '{$nis}' / Nama '{$nama}' tidak ditemukan di database data siswa.";
                    $this->importStats['skipped_rows']++;
                    continue;
                }

                $this->importStats['siswa_processed']++;

                // 3. Ekstraksi nilai kriteria untuk tiap C1, C2, C3, dst
                foreach ($kriterias as $kriteria) {
                    $kodeClean = strtolower(trim($kriteria->kode_kriteria));

                    // Cari nilai dari berbagai kemungkinan format header:
                    // 'c1', 'C1', 'c_1', 'kriteria_c1', nama kriteria yang di-slug
                    $val = null;
                    foreach ($row as $headerKey => $headerVal) {
                        $cleanedHeader = strtolower(str_replace(['_', ' ', '-'], '', (string)$headerKey));
                        $cleanedTarget = strtolower(str_replace(['_', ' ', '-'], '', $kodeClean));

                        if ($cleanedHeader === $cleanedTarget || $cleanedHeader === 'kriteria' . $cleanedTarget) {
                            if ($headerVal !== null && trim((string)$headerVal) !== '') {
                                $val = $headerVal;
                                break;
                            }
                        }
                    }

                    if ($val === null) {
                        continue;
                    }

                    // Tentukan sub_kriteria_id yang sesuai
                    $subKriteriaId = $this->resolveSubKriteriaId($kriteria, $val);

                    if ($subKriteriaId) {
                        Penilaian::updateOrCreate(
                            [
                                'periode_id' => $this->periodeId,
                                'siswa_id' => $siswa->id,
                                'kriteria_id' => $kriteria->id,
                            ],
                            [
                                'sub_kriteria_id' => $subKriteriaId,
                            ]
                        );
                        $this->importStats['penilaian_saved']++;
                    }
                }
            }
        });
    }

    /**
     * Resolusi sub_kriteria_id dari input Excel.
     * Mendukung:
     * - Nilai numerik skala (misal 1, 2, 3, 4, 5) -> mencari sub kriteria dengan nilai yang sama/paling mendekati
     * - Teks nama sub kriteria (misal "Sangat Kurang", "< 1.000.000") -> pencocokan teks string
     */
    protected function resolveSubKriteriaId(Kriteria $kriteria, $inputVal): ?int
    {
        $inputStr = trim((string)$inputVal);
        $subs = $kriteria->subKriterias;

        if ($subs->isEmpty()) {
            return null;
        }

        // Cek jika input adalah numerik skala (1 - 5 atau float)
        if (is_numeric($inputStr)) {
            $numericVal = (float)$inputStr;

            // Cari yang nilainya persis sama
            $exact = $subs->first(function ($s) use ($numericVal) {
                return (float)$s->nilai == $numericVal;
            });

            if ($exact) {
                return $exact->id;
            }

            // Jika tidak ada yang persis sama, pilih sub kriteria dengan selisih terkecil (nearest)
            $closest = $subs->sortBy(function ($s) use ($numericVal) {
                return abs((float)$s->nilai - $numericVal);
            })->first();

            return $closest ? $closest->id : null;
        }

        // Jika input berupa teks deskripsi sub kriteria
        $textMatch = $subs->first(function ($s) use ($inputStr) {
            return strcasecmp(trim($s->nama_subkriteria), $inputStr) === 0;
        });

        if ($textMatch) {
            return $textMatch->id;
        }

        // Pencarian parsial LIKE string
        $partialMatch = $subs->first(function ($s) use ($inputStr) {
            return stripos($s->nama_subkriteria, $inputStr) !== false;
        });

        if ($partialMatch) {
            return $partialMatch->id;
        }

        return null;
    }

    public function getStats(): array
    {
        return $this->importStats;
    }
}
