<x-admin-layout>
    <div class="space-y-6 pb-12">

        <!-- 1. Header Halaman -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="p-2.5 rounded-2xl bg-primary/10 text-primary mt-1 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-xs font-bold uppercase tracking-wider text-primary">Laporan & Arsip</span>
                        <span class="text-xs text-base-content/30">•</span>
                        <span class="text-xs text-base-content/50">Dokumentasi Keputusan</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-base-content">Laporan Hasil Seleksi</h1>
                    <p class="text-xs sm:text-sm text-base-content/65 mt-0.5">Rekapitulasi dan cetak laporan resmi keputusan penerima PIP per periode.</p>
                </div>
            </div>

            @if ($selectedPeriode && $hasilSaws->isNotEmpty())
                <a href="{{ route('admin.laporan.pdf', ['periode_id' => $selectedPeriode->id]) }}" target="_blank"
                    class="btn btn-primary rounded-xl gap-2 shadow-sm shadow-primary/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Dokumen PDF
                </a>
            @endif
        </div>

        <!-- 2. Filter Periode -->
        <div class="card bg-white shadow-sm border border-slate-200 rounded-2xl p-5">
            <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-col sm:flex-row items-center gap-3">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Pilih Periode Seleksi:</label>
                <select name="periode_id" class="select select-bordered select-sm rounded-xl flex-1 max-w-md font-semibold text-slate-900 bg-white border-slate-300 focus:border-emerald-600 focus:outline-none" onchange="this.form.submit()">
                    @forelse ($periodes as $p)
                        <option value="{{ $p->id }}" {{ $selectedPeriode && $selectedPeriode->id == $p->id ? 'selected' : '' }} class="text-slate-900 font-medium">
                            {{ $p->nama_periode }} ({{ $p->tahun_ajaran }}) {{ $p->status_aktif ? '★ Periode Aktif' : '' }}
                        </option>
                    @empty
                        <option value="" class="text-slate-500">Belum ada data periode</option>
                    @endforelse
                </select>
                <button type="submit" class="btn btn-primary btn-sm rounded-xl font-bold">Tampilkan Rekap</button>
            </form>
        </div>

        <!-- 3. Tabel Rekapitulasi -->
        <div class="card bg-base-100 shadow-sm border border-base-200/90 rounded-2xl overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-base-200 bg-base-100/50 flex items-center justify-between">
                <div>
                    <h2 class="font-extrabold text-base text-base-content">
                        Daftar Peringkat Penerima PIP: {{ $selectedPeriode ? $selectedPeriode->nama_periode : '-' }}
                    </h2>
                    <p class="text-xs text-base-content/60">Tahun Ajaran: {{ $selectedPeriode ? $selectedPeriode->tahun_ajaran : '-' }}</p>
                </div>
                <span class="badge badge-primary badge-sm font-semibold">{{ $hasilSaws->count() }} Data Tercatat</span>
            </div>

            <div class="overflow-x-auto">
                <table class="table table-md w-full">
                    <thead class="bg-base-200/50 text-base-content/70 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="w-16">Rank</th>
                            <th>NIS</th>
                            <th>Nama Lengkap</th>
                            <th>Kelas</th>
                            <th>Orang Tua / Wali</th>
                            <th class="font-mono">Nilai SAW (V)</th>
                            <th>Status Penerimaan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-base-200 text-sm">
                        @forelse ($hasilSaws as $item)
                            <tr class="hover:bg-base-200/30 transition-colors">
                                <td>
                                    <div class="badge {{ $item->status_penerimaan === 'Lolos' ? 'badge-primary' : 'badge-ghost' }} font-bold">
                                        #{{ $item->peringkat }}
                                    </div>
                                </td>
                                <td class="font-mono text-xs">{{ $item->siswa->nis }}</td>
                                <td class="font-bold text-base-content">{{ $item->siswa->nama }}</td>
                                <td><span class="badge badge-neutral badge-sm">{{ $item->siswa->kelas }}</span></td>
                                <td class="text-xs text-base-content/70">{{ $item->siswa->nama_ortu }}</td>
                                <td class="font-mono font-bold text-primary">{{ number_format($item->nilai_akhir, 4) }}</td>
                                <td>
                                    @if ($item->status_penerimaan === 'Lolos')
                                        <span class="badge badge-success badge-sm text-white font-bold">Lolos PIP</span>
                                    @else
                                        <span class="badge badge-ghost badge-sm text-base-content/50">Tidak Lolos</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-10 text-base-content/50">
                                    Belum ada hasil perhitungan yang disimpan untuk periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-admin-layout>
