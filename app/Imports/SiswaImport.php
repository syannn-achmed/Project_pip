<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Mendukung heading standar baik bahasa Indonesia maupun lowercase
        $nis = $row['nis'] ?? null;
        $nama = $row['nama_lengkap'] ?? $row['nama'] ?? null;

        if (!$nis || !$nama) {
            return null;
        }

        $jk = strtoupper(trim($row['jenis_kelamin_lp'] ?? $row['jk'] ?? 'L'));
        if (!in_array($jk, ['L', 'P'])) {
            $jk = 'L';
        }

        return Siswa::updateOrCreate(
            ['nis' => (string) $nis],
            [
                'nama' => $nama,
                'kelas' => $row['kelas'] ?? '-',
                'jk' => $jk,
                'nama_ortu' => $row['nama_orang_tua_wali'] ?? $row['nama_ortu'] ?? '-',
                'pekerjaan_ortu' => $row['pekerjaan_orang_tua'] ?? $row['pekerjaan_ortu'] ?? null,
                'no_telp' => $row['no_telepon_wa'] ?? $row['no_telp'] ?? null,
                'alamat' => $row['alamat'] ?? null,
            ]
        );
    }
}
