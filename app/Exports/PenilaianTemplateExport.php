<?php

namespace App\Exports;

use App\Models\Kriteria;
use App\Models\Periode;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenilaianTemplateExport implements FromArray, WithHeadings, WithStyles
{
    protected ?Periode $periode;
    protected $kriterias;

    public function __construct(?Periode $periode = null)
    {
        $this->periode = $periode;
        $this->kriterias = Kriteria::with('subKriterias')->orderBy('kode_kriteria', 'asc')->get();
    }

    public function headings(): array
    {
        $headers = ['nis', 'nama_siswa'];
        foreach ($this->kriterias as $k) {
            $headers[] = strtoupper($k->kode_kriteria);
        }
        return $headers;
    }

    public function array(): array
    {
        // Ambil data siswa yang ada di database untuk memudahkan pengguna
        $siswas = Siswa::orderBy('kelas', 'asc')->orderBy('nama', 'asc')->get();
        $rows = [];

        foreach ($siswas as $siswa) {
            $row = [
                'nis' => (string) $siswa->nis,
                'nama_siswa' => $siswa->nama,
            ];

            // Isi nilai default atau kosong untuk tiap kolom kriteria
            foreach ($this->kriterias as $k) {
                // Beri contoh nilai sub kriteria pertama jika ada
                $defaultNilai = $k->subKriterias->first() ? $k->subKriterias->first()->nilai : 1;
                $row[strtoupper($k->kode_kriteria)] = $defaultNilai;
            }

            $rows[] = $row;
        }

        // Jika belum ada siswa, berikan 2 baris contoh
        if (empty($rows)) {
            $rowContoh1 = ['nis' => '1001', 'nama_siswa' => 'Ahmad Fauzi'];
            $rowContoh2 = ['nis' => '1002', 'nama_siswa' => 'Siti Aisyah'];
            foreach ($this->kriterias as $k) {
                $rowContoh1[strtoupper($k->kode_kriteria)] = 3;
                $rowContoh2[strtoupper($k->kode_kriteria)] = 4;
            }
            $rows = [$rowContoh1, $rowContoh2];
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '047857'], // emerald-700
                ],
            ],
        ];
    }
}
