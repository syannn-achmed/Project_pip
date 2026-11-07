<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Seleksi PIP - {{ $periode->nama_periode }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            color: #333333;
            line-height: 1.4;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333333;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }
        .header h2 {
            font-size: 12pt;
            font-weight: normal;
            margin: 4px 0 0 0;
        }
        .header p {
            font-size: 9pt;
            margin: 4px 0 0 0;
            color: #666666;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 10pt;
        }
        .meta-table td {
            padding: 3px 0;
        }
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 9.5pt;
        }
        .table-data th, .table-data td {
            border: 1px solid #999999;
            padding: 6px 8px;
        }
        .table-data th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            font-size: 8.5pt;
        }
        .text-center {
            text-align: center;
        }
        .font-mono {
            font-family: "Courier New", Courier, monospace;
        }
        .font-bold {
            font-weight: bold;
        }
        .badge-lolos {
            color: #15803d;
            font-weight: bold;
        }
        .badge-tidak {
            color: #6b7280;
        }
        .signature-table {
            width: 100%;
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 10pt;
        }
    </style>
</head>
<body>
    @php
        $logoPath = public_path('logo.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }
    @endphp

    <!-- Header Dokumen Resmi Ber-KOP MIS AL KAUTSAR -->
    <table style="width: 100%; border-bottom: 3px double #111827; padding-bottom: 10px; margin-bottom: 20px;">
        <tr>
            <td style="width: 15%; text-align: center; vertical-align: middle;">
                @if ($logoBase64)
                    <img src="{{ $logoBase64 }}" style="width: 75px; height: auto;" alt="Logo MIS AL KAUTSAR">
                @endif
            </td>
            <td style="width: 85%; text-align: center; vertical-align: middle;">
                <h3 style="margin: 0; font-size: 10pt; font-weight: normal; text-transform: uppercase; letter-spacing: 0.5px;">KEMENTERIAN AGAMA REPUBLIK INDONESIA</h3>
                <h1 style="margin: 3px 0; font-size: 14pt; font-weight: bold; text-transform: uppercase; color: #065f46;">MADRASAH IBTIDAIYAH SWASTA (MIS) AL KAUTSAR</h1>
                <p style="margin: 2px 0; font-size: 9pt; color: #374151;">Sistem Pendukung Keputusan Penentuan Penerima Bantuan Program Indonesia Pintar (PIP)</p>
                <p style="margin: 0; font-size: 8pt; color: #6b7280; font-style: italic;">Alamat: Jl. Pendidikan No. 12, Kelurahan / Desa Makmur &bull; Email: misalkautsar@kemenag.go.id</p>
            </td>
        </tr>
    </table>

    <div style="text-align: center; margin-bottom: 15px;">
        <h2 style="font-size: 12pt; font-weight: bold; margin: 0; text-transform: uppercase; text-decoration: underline;">SURAT KEPUTUSAN HASIL SELEKSI BEASISWA PIP</h2>
        <p style="font-size: 9pt; color: #4b5563; margin-top: 3px;">Metode Penjumlahan Terbobot (Simple Additive Weighting - SAW)</p>
    </div>

    <!-- Informasi Periode -->
    <table class="meta-table">
        <tr>
            <td style="width: 18%;"><strong>Periode Seleksi</strong></td>
            <td style="width: 2%;">:</td>
            <td style="width: 40%;">{{ $periode->nama_periode }}</td>
            <td style="width: 18%;"><strong>Tanggal Cetak</strong></td>
            <td style="width: 2%;">:</td>
            <td>{{ $tanggalCetak }}</td>
        </tr>
        <tr>
            <td><strong>Tahun Ajaran</strong></td>
            <td>:</td>
            <td>{{ $periode->tahun_ajaran }}</td>
            <td><strong>Total Pendaftar</strong></td>
            <td>:</td>
            <td>{{ $hasilSaws->count() }} Siswa</td>
        </tr>
    </table>

    <!-- Tabel Data Rekapitulasi -->
    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 6%;">Rank</th>
                <th style="width: 14%;">NIS</th>
                <th style="width: 26%;">Nama Lengkap Siswa</th>
                <th style="width: 10%;">Kelas</th>
                <th style="width: 22%;">Nama Orang Tua / Wali</th>
                <th style="width: 11%;">Skor SAW (V)</th>
                <th style="width: 11%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hasilSaws as $item)
                <tr>
                    <td class="text-center font-bold">#{{ $item->peringkat }}</td>
                    <td class="text-center font-mono">{{ $item->siswa->nis }}</td>
                    <td class="font-bold">{{ $item->siswa->nama }}</td>
                    <td class="text-center">{{ $item->siswa->kelas }}</td>
                    <td>{{ $item->siswa->nama_ortu }}</td>
                    <td class="text-center font-mono font-bold">{{ number_format($item->nilai_akhir, 4) }}</td>
                    <td class="text-center">
                        @if ($item->status_penerimaan === 'Lolos')
                            <span class="badge-lolos">Lolos PIP</span>
                        @else
                            <span class="badge-tidak">Tidak Lolos</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data hasil seleksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan Pengesahan -->
    <table class="signature-table">
        <tr>
            <td>
                Mengetahui,<br>
                <strong>Panitia Pelaksana PIP</strong>
                <br><br><br><br><br>
                <u>(.......................................................)</u><br>
                NIP. ...............................................
            </td>
            <td>
                Disahkan oleh,<br>
                <strong>Kepala Madrasah MIS AL KAUTSAR</strong>
                <br><br><br><br><br>
                <u>(.......................................................)</u><br>
                NIP. ...............................................
            </td>
        </tr>
    </table>

</body>
</html>
