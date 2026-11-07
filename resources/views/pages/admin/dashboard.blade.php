<x-admin-layout>
    <div class="space-y-6">

        <!-- 1. HERO SECTION: Welcome Banner -->
        <div class="card bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-800 text-white shadow-lg overflow-hidden relative border border-emerald-600/30">
            <div class="card-body p-6 lg:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6 z-10">
                <div class="flex items-start gap-4">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo MIS AL KAUTSAR" class="w-16 h-16 sm:w-20 sm:h-20 object-contain p-1.5 bg-white/95 rounded-2xl shadow-md shrink-0 border border-white/20 hidden sm:block" onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                    <div class="space-y-2 max-w-2xl">
                        <div class="flex items-center gap-2">
                            <span class="badge badge-warning badge-sm font-bold tracking-wide uppercase text-gray-900">MIS AL KAUTSAR</span>
                            <span class="text-xs text-white/80 font-medium">
                                {{ $periodeAktif ? $periodeAktif->nama_periode . ' (' . $periodeAktif->tahun_ajaran . ')' : 'Belum Ada Periode Aktif' }}
                            </span>
                        </div>
                        <h1 class="text-2xl lg:text-3xl font-black tracking-tight text-white">
                            Selamat Datang di SPK PIP MIS AL KAUTSAR
                        </h1>
                        <p class="text-sm lg:text-base text-white/90 leading-relaxed">
                            Panel kendali seleksi penerima Program Indonesia Pintar (PIP) secara transparan, obyektif, dan akuntabel menggunakan metode <em>Simple Additive Weighting</em> (SAW).
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('admin.periode.create') }}" class="btn btn-warning text-gray-900 font-bold shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Periode
                    </a>
                    <a href="{{ route('admin.saw.index') }}" class="btn btn-ghost bg-white/10 hover:bg-white/20 text-white border-0 font-bold">
                        Hitung SAW
                    </a>
                </div>
            </div>

            <!-- Background subtle pattern -->
            <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none">
                <svg width="240" height="240" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
            </div>
        </div>

        <!-- 2. GRID STATISTIK DATA (Siswa, Kriteria, Periode, Kuota PIP) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- Data Siswa -->
            <div class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-shadow">
                <div class="card-body p-5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase tracking-wider text-base-content/60">Data Siswa</span>
                        <div class="p-2.5 rounded-xl bg-primary/10 text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="text-3xl font-bold text-base-content">{{ $totalSiswa }}</div>
                        <p class="text-xs text-success flex items-center gap-1 mt-1 font-medium">
                            <span class="badge badge-success badge-xs"></span>
                            {{ $siswaDinilaiCount }} Siswa dinilai ({{ $persenDinilai }}%)
                        </p>
                    </div>
                </div>
            </div>

            <!-- Data Kriteria -->
            <div class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-shadow">
                <div class="card-body p-5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase tracking-wider text-base-content/60">Data Kriteria</span>
                        <div class="p-2.5 rounded-xl bg-info/10 text-info">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="text-3xl font-bold text-base-content">{{ $totalKriteria }} <span class="text-sm font-normal text-base-content/60">Kriteria</span></div>
                        <p class="text-xs text-base-content/70 mt-1 font-medium">
                            Total {{ $totalSubKriteria }} Sub Kriteria aktif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Data Periode -->
            <div class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-shadow">
                <div class="card-body p-5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase tracking-wider text-base-content/60">Data Periode</span>
                        <div class="p-2.5 rounded-xl bg-secondary/10 text-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="text-3xl font-bold text-base-content">{{ $totalPeriode }} <span class="text-sm font-normal text-base-content/60">Batch</span></div>
                        <p class="text-xs text-base-content/70 mt-1 font-medium">
                            Periode aktif: {{ $periodeAktif ? $periodeAktif->nama_periode : 'Tidak ada' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Menu Cepat Laporan -->
            <div class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-shadow">
                <div class="card-body p-5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase tracking-wider text-base-content/60">Rekap Laporan</span>
                        <div class="p-2.5 rounded-xl bg-warning/10 text-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.laporan.index') }}" class="btn btn-warning btn-sm rounded-xl text-xs w-full mt-2">
                            Buka Rekapitulasi
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- 3. SECTION GRAFIK HASIL & RINGKASAN REKOMENDASI -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Area Grafik Hasil (2 Kolom) -->
            <div class="card bg-base-100 shadow-sm border border-base-200 lg:col-span-2">
                <div class="card-body p-5 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-base-200">
                        <div>
                            <h2 class="card-title text-base font-bold text-base-content">Grafik Distribusi Nilai SAW</h2>
                            <p class="text-xs text-base-content/60">Persebaran skor preferensi (V) hasil kalkulasi calon penerima</p>
                        </div>
                        <div class="badge badge-outline text-xs">Update Otomatis</div>
                    </div>

                    <!-- Placeholder Visualisasi Grafik -->
                    <div class="w-full h-64 mt-4 bg-base-200/50 rounded-xl border border-dashed border-base-300 flex flex-col items-center justify-center text-center p-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-base-content/40 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <p class="text-sm font-semibold text-base-content/70">Area Canvas Chart (Chart.js / ApexCharts)</p>
                        <p class="text-xs text-base-content/50 mt-1 max-w-sm">Siap diintegrasikan dengan data distribusi nilai preferensi tertinggi hingga terendah</p>
                    </div>

                    <!-- Quick Legend / Metric Bar -->
                    <div class="grid grid-cols-3 gap-2 pt-4 text-center">
                        <div class="p-2 rounded-lg bg-base-200/40">
                            <span class="text-xs text-base-content/60 block">Skor Tertinggi</span>
                            <span class="font-bold text-sm text-success">0.985</span>
                        </div>
                        <div class="p-2 rounded-lg bg-base-200/40">
                            <span class="text-xs text-base-content/60 block">Rata-rata Skor</span>
                            <span class="font-bold text-sm text-info">0.742</span>
                        </div>
                        <div class="p-2 rounded-lg bg-base-200/40">
                            <span class="text-xs text-base-content/60 block">Skor Terendah</span>
                            <span class="font-bold text-sm text-error">0.410</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Kelayakan & Informasi Alur (1 Kolom) -->
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body p-5 sm:p-6 space-y-4">
                    <h2 class="card-title text-base font-bold text-base-content">Progres Kuota & Status</h2>

                    <!-- Progres Pengisian Kuota -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs font-semibold">
                            <span>Kapasitas Kuota Terpenuhi</span>
                            <span class="text-primary font-bold">100% (40/40 Siswa)</span>
                        </div>
                        <progress class="progress progress-primary w-full" value="40" max="40"></progress>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between text-xs font-semibold">
                            <span>Siswa Masuk Daftar Cadangan</span>
                            <span class="text-warning font-bold">45 Siswa</span>
                        </div>
                        <progress class="progress progress-warning w-full" value="45" max="85"></progress>
                    </div>

                    <div class="divider my-1"></div>

                    <!-- Tahapan SPK PIP -->
                    <h3 class="text-xs font-bold uppercase tracking-wider text-base-content/60">Tahapan Sistem SAW</h3>
                    <ul class="steps steps-vertical text-xs w-full">
                        <li class="step step-primary">Pengumpulan Berkas Siswa</li>
                        <li class="step step-primary">Input Nilai Alternatif</li>
                        <li class="step step-primary">Normalisasi & Perangkingan</li>
                        <li class="step">Penerbitan SK & Cetak Laporan</li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- 4. TABEL AKTIVITAS TERBARU & TOP RANKING SAW -->
        <div class="card bg-base-100 shadow-sm border border-base-200">
            <div class="card-body p-5 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                    <div>
                        <h2 class="card-title text-base font-bold text-base-content">Pratinjau Ranking Penerima Teratas (Top SAW)</h2>
                        <p class="text-xs text-base-content/60">Hasil perhitungan otomatis berdasarkan bobot kriteria</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.saw.index') }}" class="btn btn-sm btn-outline btn-primary rounded-lg">
                            Lihat Semua Hasil
                        </a>
                    </div>
                </div>

                <!-- Tabel Data -->
                <div class="overflow-x-auto">
                    <table class="table table-sm md:table-md w-full">
                        <thead class="bg-base-200/60 text-base-content/80 text-xs uppercase">
                            <tr>
                                <th class="w-16">Rank</th>
                                <th>NIS & Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Nilai Preferensi (V)</th>
                                <th>Status Rekomendasi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse ($topSaw as $item)
                                <tr class="hover:bg-base-200/30">
                                    <td>
                                        <div class="badge {{ $item->status_penerimaan === 'Lolos' ? 'badge-primary' : 'badge-ghost' }} font-bold">
                                            #{{ $item->peringkat }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-bold text-base-content">{{ $item->siswa->nama }}</div>
                                        <span class="text-xs font-mono text-base-content/60">NIS: {{ $item->siswa->nis }}</span>
                                    </td>
                                    <td>{{ $item->siswa->kelas }}</td>
                                    <td class="font-mono font-bold text-primary">{{ number_format($item->nilai_akhir, 4) }}</td>
                                    <td>
                                        @if ($item->status_penerimaan === 'Lolos')
                                            <span class="badge badge-success badge-sm text-white">Lolos Penerima PIP</span>
                                        @else
                                            <span class="badge badge-warning badge-sm text-white">{{ $item->status_penerimaan }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-base-content/50">
                                        <div class="flex flex-col items-center justify-center gap-1">
                                            <span>Belum ada hasil kalkulasi SAW yang disimpan untuk periode aktif ini.</span>
                                            <a href="{{ route('admin.saw.index') }}" class="btn btn-link btn-xs text-primary">Buka Perhitungan SAW</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
