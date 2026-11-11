<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SiswaExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Siswa::orderBy('nama', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama Lengkap',
            'Kelas',
            'Jenis Kelamin (L/P)',
            'Nama Orang Tua / Wali',
            'No Telepon / WA',
            'Alamat',
        ];
    }

    public function map($siswa): array
    {
        return [
            $siswa->nis,
            $siswa->nama,
            $siswa->kelas,
            $siswa->jk,
            $siswa->nama_ortu,
            $siswa->no_telp ?? '-',
            $siswa->alamat ?? '-',
        ];
    }
}
