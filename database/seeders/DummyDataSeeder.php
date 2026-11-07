<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Periode;
use App\Models\Siswa;
use App\Models\SubKriteria;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Periode Aktif
        $periode = Periode::firstOrCreate(
            ['nama_periode' => 'Seleksi Tahap 1 2026/2027'],
            [
                'tahun_ajaran' => '2026/2027',
                'status_aktif' => true,
            ]
        );

        // 2. Setup Kriteria PIP (Total Bobot = 100%)
        $kriteriasData = [
            [
                'kode' => 'C1',
                'nama' => 'Penghasilan Orang Tua',
                'tipe' => 'cost',
                'bobot' => 25,
                'ket' => 'Semakin kecil penghasilan, semakin tinggi prioritas penerima bantuan (Cost).',
                'subs' => [
                    ['nama' => '< Rp 1.000.000 / bulan', 'nilai' => 5],
                    ['nama' => 'Rp 1.000.000 - Rp 2.000.000 / bulan', 'nilai' => 4],
                    ['nama' => 'Rp 2.000.000 - Rp 3.500.000 / bulan', 'nilai' => 3],
                    ['nama' => 'Rp 3.500.000 - Rp 5.000.000 / bulan', 'nilai' => 2],
                    ['nama' => '> Rp 5.000.000 / bulan', 'nilai' => 1],
                ]
            ],
            [
                'kode' => 'C2',
                'nama' => 'Kepemilikan Kartu Bantuan (KIP/KKS/PKH)',
                'tipe' => 'benefit',
                'bobot' => 25,
                'ket' => 'Kepemilikan kartu jaminan sosial pemerintah menjadi indikator utama kemiskinan (Benefit).',
                'subs' => [
                    ['nama' => 'Memiliki KIP dan PKH/KKS', 'nilai' => 5],
                    ['nama' => 'Memiliki KIP Saja', 'nilai' => 4],
                    ['nama' => 'Memiliki KKS/PKH Saja', 'nilai' => 3],
                    ['nama' => 'Surat Keterangan Tidak Mampu (SKTM)', 'nilai' => 2],
                    ['nama' => 'Tidak Memiliki Kartu Bantuan', 'nilai' => 1],
                ]
            ],
            [
                'kode' => 'C3',
                'nama' => 'Status Orang Tua',
                'tipe' => 'benefit',
                'bobot' => 20,
                'ket' => 'Kondisi yatim piatu diprioritaskan untuk menjamin kelangsungan sekolah (Benefit).',
                'subs' => [
                    ['nama' => 'Yatim Piatu', 'nilai' => 5],
                    ['nama' => 'Yatim (Ayah Meninggal)', 'nilai' => 4],
                    ['nama' => 'Piatu (Ibu Meninggal)', 'nilai' => 3],
                    ['nama' => 'Orang Tua Lengkap', 'nilai' => 1],
                ]
            ],
            [
                'kode' => 'C4',
                'nama' => 'Jumlah Tanggungan Keluarga',
                'tipe' => 'benefit',
                'bobot' => 15,
                'ket' => 'Banyaknya anggota keluarga dalam satu kartu keluarga yang dibiayai (Benefit).',
                'subs' => [
                    ['nama' => 'Lebih dari 5 Anak/Tanggungan', 'nilai' => 5],
                    ['nama' => '4 - 5 Tanggungan', 'nilai' => 4],
                    ['nama' => '3 Tanggungan', 'nilai' => 3],
                    ['nama' => '2 Tanggungan', 'nilai' => 2],
                    ['nama' => '1 Tanggungan', 'nilai' => 1],
                ]
            ],
            [
                'kode' => 'C5',
                'nama' => 'Jarak Domisili ke Sekolah',
                'tipe' => 'benefit',
                'bobot' => 15,
                'ket' => 'Beban ongkos transportasi siswa dari rumah menuju sekolah (Benefit).',
                'subs' => [
                    ['nama' => '> 10 Kilometer', 'nilai' => 5],
                    ['nama' => '6 - 10 Kilometer', 'nilai' => 4],
                    ['nama' => '3 - 5 Kilometer', 'nilai' => 3],
                    ['nama' => '< 3 Kilometer', 'nilai' => 1],
                ]
            ],
        ];

        $subMap = []; // [kode_kriteria => [skor => sub_id]]
        foreach ($kriteriasData as $kData) {
            $kriteria = Kriteria::firstOrCreate(
                ['kode_kriteria' => $kData['kode']],
                [
                    'nama_kriteria' => $kData['nama'],
                    'tipe' => $kData['tipe'],
                    'bobot' => $kData['bobot'],
                    'keterangan' => $kData['ket'],
                ]
            );

            foreach ($kData['subs'] as $sData) {
                $sub = SubKriteria::firstOrCreate(
                    [
                        'kriteria_id' => $kriteria->id,
                        'nama_subkriteria' => $sData['nama'],
                    ],
                    [
                        'nilai' => $sData['nilai'],
                    ]
                );
                $subMap[$kData['kode']][$sData['nilai']] = $sub->id;
            }
        }

        // 3. Ambil User Ortu Dummy
        $ortuUser = User::where('email', 'ortu@sekolah.com')->first();

        // 4. Buat Contoh Data Siswa
        $siswaSamples = [
            [
                'nis' => '202601001',
                'nama' => 'Ahmad Fauzi',
                'kelas' => 'X RPL 1',
                'jk' => 'L',
                'nama_ortu' => 'Budi Santoso',
                'pekerjaan_ortu' => 'Buruh Harian Lepas',
                'no_telp' => '081234567891',
                'alamat' => 'Jl. Merdeka No. 12',
                'user_id_ortu' => $ortuUser ? $ortuUser->id : null,
                'eval' => ['C1' => 5, 'C2' => 5, 'C3' => 4, 'C4' => 4, 'C5' => 4],
            ],
            [
                'nis' => '202601002',
                'nama' => 'Siti Nurhaliza',
                'kelas' => 'X RPL 1',
                'jk' => 'P',
                'nama_ortu' => 'Hasanudin',
                'pekerjaan_ortu' => 'Petani',
                'no_telp' => '081234567892',
                'alamat' => 'Desa Sukamaju RT 02/01',
                'user_id_ortu' => null,
                'eval' => ['C1' => 4, 'C2' => 4, 'C3' => 5, 'C4' => 5, 'C5' => 5],
            ],
            [
                'nis' => '202601003',
                'nama' => 'Dimas Aditya Pratama',
                'kelas' => 'XI TKJ 2',
                'jk' => 'L',
                'nama_ortu' => 'Slamet Riyadi',
                'pekerjaan_ortu' => 'Tukang Ojek',
                'no_telp' => '081234567893',
                'alamat' => 'Kampung Baru RT 04/02',
                'user_id_ortu' => null,
                'eval' => ['C1' => 5, 'C2' => 3, 'C3' => 1, 'C4' => 4, 'C5' => 3],
            ],
            [
                'nis' => '202601004',
                'nama' => 'Anisa Rahmawati',
                'kelas' => 'XI RPL 2',
                'jk' => 'P',
                'nama_ortu' => 'Surono',
                'pekerjaan_ortu' => 'Pedagang Kaki Lima',
                'no_telp' => '081234567894',
                'alamat' => 'Jl. Pahlawan Gg. 3',
                'user_id_ortu' => null,
                'eval' => ['C1' => 3, 'C2' => 2, 'C3' => 3, 'C4' => 3, 'C5' => 4],
            ],
            [
                'nis' => '202601005',
                'nama' => 'Bambang Triyono',
                'kelas' => 'XII TKJ 1',
                'jk' => 'L',
                'nama_ortu' => 'Wahyudi',
                'pekerjaan_ortu' => 'Karyawan Swasta',
                'no_telp' => '081234567895',
                'alamat' => 'Perumahan Asri Blok C4',
                'user_id_ortu' => null,
                'eval' => ['C1' => 1, 'C2' => 1, 'C3' => 1, 'C4' => 2, 'C5' => 1],
            ],
        ];

        foreach ($siswaSamples as $s) {
            $siswa = Siswa::firstOrCreate(
                ['nis' => $s['nis']],
                [
                    'nama' => $s['nama'],
                    'kelas' => $s['kelas'],
                    'jk' => $s['jk'],
                    'nama_ortu' => $s['nama_ortu'],
                    'pekerjaan_ortu' => $s['pekerjaan_ortu'],
                    'no_telp' => $s['no_telp'],
                    'alamat' => $s['alamat'],
                    'user_id_ortu' => $s['user_id_ortu'],
                ]
            );

            // 5. Simpan Nilai Penilaian Dummy
            foreach ($s['eval'] as $kode => $skor) {
                $kriteriaObj = Kriteria::where('kode_kriteria', $kode)->first();
                $subId = $subMap[$kode][$skor] ?? null;

                if ($kriteriaObj && $subId) {
                    Penilaian::updateOrCreate(
                        [
                            'periode_id' => $periode->id,
                            'siswa_id' => $siswa->id,
                            'kriteria_id' => $kriteriaObj->id,
                        ],
                        [
                            'sub_kriteria_id' => $subId,
                        ]
                    );
                }
            }
        }
    }
}
