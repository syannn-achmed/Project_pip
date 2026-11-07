<x-admin-layout>
    <div class="space-y-6 pb-12">

        <!-- 1. Header Halaman -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="p-2.5 rounded-2xl bg-primary/10 text-primary mt-1 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-xs font-bold uppercase tracking-wider text-primary">Sistem Keputusan</span>
                        <span class="text-xs text-base-content/30">•</span>
                        <span class="text-xs text-base-content/50">Simple Additive Weighting</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-base-content">Hasil Perhitungan SAW</h1>
                    <p class="text-xs sm:text-sm text-base-content/65 mt-0.5">Audit transparan tahapan normalisasi, nilai preferensi (V), dan perangkingan penerima PIP.</p>
                </div>
            </div>

            @if ($periodeAktif)
                <div class="flex items-center gap-2 px-4 py-2 bg-primary/10 border border-primary/20 rounded-2xl">
                    <span class="badge badge-primary badge-xs"></span>
                    <span class="text-xs font-bold text-primary">Periode: {{ $periodeAktif->nama_periode }}</span>
                </div>
            @endif
        </div>

        <!-- 2. Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success bg-success/15 border border-success/30 text-success shadow-sm rounded-2xl flex items-center gap-3 py-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error bg-error/15 border border-error/30 text-error shadow-sm rounded-2xl flex items-center gap-3 py-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        <!-- 3. Form Kuota & Eksekusi Simpan -->
        <div class="card bg-white shadow-sm border border-slate-200 rounded-2xl p-5">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <form method="GET" action="{{ route('admin.saw.index') }}" class="flex items-center gap-3 flex-wrap">
                    <label class="text-xs font-bold uppercase tracking-wider text-slate-700">Batas Kuota Penerima:</label>
                    <input type="number" name="kuota" value="{{ $kuota }}" min="1" max="1000"
                        class="input input-bordered input-sm w-28 rounded-xl font-black text-slate-900 bg-white border-slate-300 focus:border-emerald-600 focus:outline-none" />
                    <button type="submit" class="btn btn-neutral btn-sm rounded-xl font-bold">Terapkan Kuota</button>
                </form>

                @if ($calculation['status'])
                    <form method="POST" action="{{ route('admin.saw.proses') }}">
                        @csrf
                        <input type="hidden" name="kuota" value="{{ $kuota }}">
                        <button type="submit" class="btn btn-primary btn-sm rounded-xl gap-2 shadow-sm shadow-primary/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            {{ $isPersisted ? 'Perbarui Hasil di Database' : 'Simpan Hasil ke Database' }}
                        </button>
                    </form>
                @endif
            </div>
        </div>

        @if (!$calculation['status'])
            <!-- Pesan Error / Panduan Perbaikan -->
            <div class="alert alert-warning shadow-sm rounded-2xl p-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <h3 class="font-bold text-sm">Perhitungan SAW Belum Dapat Dijalankan</h3>
                    <div class="text-xs mt-1">{{ $calculation['message'] }}</div>
                </div>
            </div>
        @else
            <!-- TABEL 1: HASIL AKHIR & PERANGKINGAN -->
            <div class="card bg-base-100 shadow-sm border border-base-200/90 rounded-2xl overflow-hidden">
                <div class="p-4 sm:p-5 border-b border-base-200 bg-base-100/50 flex items-center justify-between">
                    <div>
                        <h2 class="font-extrabold text-base text-base-content">Hasil Akhir & Rekomendasi Peringkat Penerima</h2>
                        <p class="text-xs text-base-content/60">Diurutkan berdasarkan nilai preferensi tertinggi (V) dengan batas kuota {{ $kuota }} siswa.</p>
                    </div>
                    <span class="badge badge-primary badge-sm font-semibold">{{ count($calculation['rankings']) }} Siswa Dinilai</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-md w-full">
                        <thead class="bg-base-200/50 text-base-content/70 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="w-16">Rank</th>
                                <th>Siswa (Alternatif)</th>
                                <th>Kelas</th>
                                <th class="font-mono">Nilai Akhir (V)</th>
                                <th>Status Penerimaan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-base-200 text-sm">
                            @foreach ($calculation['rankings'] as $item)
                                <tr class="hover:bg-base-200/30 transition-colors {{ $item['peringkat'] <= $kuota ? 'bg-success/5' : '' }}">
                                    <td>
                                        <div class="badge {{ $item['peringkat'] <= $kuota ? 'badge-primary' : 'badge-ghost' }} font-bold">
                                            #{{ $item['peringkat'] }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-bold text-base-content">{{ $item['siswa']->nama }}</div>
                                        <span class="text-xs font-mono text-base-content/50">NIS: {{ $item['siswa']->nis }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-neutral badge-sm">{{ $item['siswa']->kelas }}</span>
                                    </td>
                                    <td class="font-mono font-bold text-primary text-base">
                                        {{ number_format($item['nilai_akhir'], 4) }}
                                    </td>
                                    <td>
                                        @if ($item['status_penerimaan'] === 'Lolos')
                                            <span class="badge badge-success badge-sm text-white font-bold gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Lolos PIP
                                            </span>
                                        @else
                                            <span class="badge badge-ghost badge-sm text-base-content/50 font-semibold">
                                                Tidak Lolos
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TABEL 2: MATRIKS KEPUTUSAN (X) -->
            <div class="card bg-base-100 shadow-sm border border-base-200/90 rounded-2xl overflow-hidden">
                <div class="p-4 sm:p-5 border-b border-base-200 bg-base-100/50">
                    <h2 class="font-extrabold text-base text-base-content">1. Matriks Keputusan (X)</h2>
                    <p class="text-xs text-base-content/60">Nilai mentah berdasarkan sub-kriteria yang dipilih untuk tiap alternatif.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-sm w-full font-mono text-xs">
                        <thead class="bg-base-200/50 uppercase">
                            <tr>
                                <th>Alternatif</th>
                                @foreach ($calculation['kriterias'] as $kriteria)
                                    <th class="text-center">
                                        {{ $kriteria->kode_kriteria }}
                                        <span class="block text-[10px] text-base-content/50 lowercase">({{ $kriteria->tipe }})</span>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($calculation['matriksX'] as $row)
                                <tr class="hover:bg-base-200/30">
                                    <td class="font-sans font-semibold">{{ $row['siswa']->nama }}</td>
                                    @foreach ($calculation['kriterias'] as $kriteria)
                                        <td class="text-center font-bold">{{ $row['nilai'][$kriteria->id] }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            <!-- Baris Nilai Ekstrem (Max / Min) -->
                            <tr class="bg-base-200/80 font-bold">
                                <td class="font-sans uppercase text-primary">Nilai Ekstrem</td>
                                @foreach ($calculation['kriterias'] as $kriteria)
                                    <td class="text-center text-primary">
                                        @if ($kriteria->tipe === 'benefit')
                                            Max: {{ $calculation['ekstremKriteria'][$kriteria->id]['max'] }}
                                        @else
                                            Min: {{ $calculation['ekstremKriteria'][$kriteria->id]['min'] }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TABEL 3: MATRIKS TERNORMALISASI (R) -->
            <div class="card bg-base-100 shadow-sm border border-base-200/90 rounded-2xl overflow-hidden">
                <div class="p-4 sm:p-5 border-b border-base-200 bg-base-100/50">
                    <h2 class="font-extrabold text-base text-base-content">2. Matriks Ternormalisasi (R)</h2>
                    <p class="text-xs text-base-content/60">Hasil normalisasi: Benefit (X / Max) atau Cost (Min / X).</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-sm w-full font-mono text-xs">
                        <thead class="bg-base-200/50 uppercase">
                            <tr>
                                <th>Alternatif</th>
                                @foreach ($calculation['kriterias'] as $kriteria)
                                    <th class="text-center">{{ $kriteria->kode_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($calculation['matriksR'] as $row)
                                <tr class="hover:bg-base-200/30">
                                    <td class="font-sans font-semibold">{{ $row['siswa']->nama }}</td>
                                    @foreach ($calculation['kriterias'] as $kriteria)
                                        <td class="text-center">{{ number_format($row['normalisasi'][$kriteria->id], 4) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</x-admin-layout>
