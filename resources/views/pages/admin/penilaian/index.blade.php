<x-admin-layout>
    <div class="space-y-6 pb-10">

        <!-- 1. Header Halaman -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="p-2.5 rounded-2xl bg-primary/10 text-primary mt-1 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-xs font-bold uppercase tracking-wider text-primary">Sistem Keputusan</span>
                        <span class="text-xs text-base-content/30">•</span>
                        <span class="text-xs text-base-content/50">Matriks Keputusan (X)</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-base-content">Penilaian Siswa</h1>
                    <p class="text-xs sm:text-sm text-base-content/65 mt-0.5">Input dan perbarui data evaluasi kriteria calon penerima PIP pada periode aktif.</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                @if ($periodeAktif)
                    <div class="hidden sm:flex items-center gap-2 px-3.5 py-1.5 bg-primary/10 border border-primary/20 rounded-2xl">
                        <span class="badge badge-primary badge-xs"></span>
                        <span class="text-xs font-bold text-primary">Periode: {{ $periodeAktif->nama_periode }}</span>
                    </div>

                    <a href="{{ route('admin.penilaian.template') }}" class="btn btn-outline btn-success btn-sm rounded-xl gap-2 font-bold shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download Format Excel
                    </a>

                    <button onclick="document.getElementById('modal-import-penilaian').showModal()" class="btn btn-primary btn-sm rounded-xl gap-2 shadow-sm shadow-primary/20 font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l4-4m0 0l4 4m-4-4v12" />
                        </svg>
                        Import Nilai Excel
                    </button>
                @endif
            </div>
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

        @if (!$periodeAktif)
            <div class="alert alert-warning shadow-sm rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <h3 class="font-bold text-sm">Tidak Ada Periode Aktif!</h3>
                    <div class="text-xs">Silakan aktifkan salah satu periode seleksi di menu Data Periode agar proses penilaian dapat dilakukan.</div>
                </div>
                <a href="{{ route('admin.periode.index') }}" class="btn btn-sm btn-ghost bg-base-100 rounded-xl">Buka Periode</a>
            </div>
        @endif

        <!-- 3. Toolbar Filter & Search -->
        <div class="card bg-white shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-200 bg-slate-50/70">
                <form method="GET" action="{{ route('admin.penilaian.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="relative w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari siswa atau NIS..."
                            class="input input-bordered input-sm w-full pl-9 rounded-xl font-semibold text-slate-900 bg-white border-slate-300 placeholder:text-slate-400 focus:border-emerald-600 focus:outline-none" />
                    </div>

                    <div>
                        <select name="kelas" class="select select-bordered select-sm w-full rounded-xl font-semibold text-slate-900 bg-white border-slate-300 focus:border-emerald-600 focus:outline-none" onchange="this.form.submit()">
                            <option value="" class="text-slate-900 font-bold">-- Semua Kelas --</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }} class="text-slate-900 font-medium">
                                    Kelas {{ $kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="btn btn-primary btn-sm rounded-xl font-bold flex-1">Filter</button>
                        @if (request()->hasAny(['search', 'kelas']))
                            <a href="{{ route('admin.penilaian.index') }}" class="btn btn-ghost btn-sm rounded-xl text-slate-600">Reset</a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- 4. Tabel Siswa & Status Penilaian -->
            <div class="overflow-x-auto">
                <table class="table table-md w-full">
                    <thead class="bg-base-200/50 text-base-content/70 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="w-16">Foto</th>
                            <th>NIS & Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Kelengkapan Nilai</th>
                            <th class="text-right">Aksi Penilaian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-base-200 text-sm">
                        @forelse ($siswas as $siswa)
                            @php
                                $dinilaiCount = $penilaianSummary[$siswa->id] ?? 0;
                                $isLengkap = ($totalKriteria > 0 && $dinilaiCount >= $totalKriteria);
                                $isSebagian = ($dinilaiCount > 0 && $dinilaiCount < $totalKriteria);
                            @endphp
                            <tr class="hover:bg-base-200/30 transition-colors">
                                <td>
                                    <div class="avatar placeholder">
                                        <div class="w-10 h-10 rounded-xl bg-base-300 text-base-content/60 overflow-hidden ring-1 ring-base-300">
                                            @if ($siswa->foto && Storage::disk('public')->exists($siswa->foto))
                                                <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama }}" class="object-cover w-full h-full" />
                                            @else
                                                <span class="text-xs font-bold">{{ strtoupper(substr($siswa->nama, 0, 2)) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="font-bold text-base-content">{{ $siswa->nama }}</div>
                                    <span class="text-xs font-mono text-base-content/50">NIS: {{ $siswa->nis }}</span>
                                </td>

                                <td>
                                    <span class="badge badge-neutral badge-sm">{{ $siswa->kelas }}</span>
                                </td>

                                <td>
                                    @if ($isLengkap)
                                        <span class="badge badge-success badge-sm text-white gap-1 font-semibold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Lengkap ({{ $dinilaiCount }}/{{ $totalKriteria }})
                                        </span>
                                    @elseif ($isSebagian)
                                        <span class="badge badge-warning badge-sm text-white font-semibold">
                                            Sebagian ({{ $dinilaiCount }}/{{ $totalKriteria }})
                                        </span>
                                    @else
                                        <span class="badge badge-ghost badge-sm text-base-content/50 font-semibold">
                                            Belum Dinilai (0/{{ $totalKriteria }})
                                        </span>
                                    @endif
                                </td>

                                <td class="text-right">
                                    @if ($periodeAktif)
                                        <a href="{{ route('admin.penilaian.edit', $siswa->id) }}"
                                            class="btn btn-sm rounded-xl gap-1.5 {{ $isLengkap ? 'btn-outline btn-neutral' : 'btn-primary shadow-sm shadow-primary/20' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            {{ $isLengkap ? 'Ubah Nilai' : 'Input Nilai' }}
                                        </a>
                                    @else
                                        <button disabled class="btn btn-sm btn-disabled rounded-xl">Periode Nonaktif</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-base-content/50">
                                    Belum ada data siswa untuk dinilai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($siswas->hasPages())
                <div class="p-4 border-t border-base-200">
                    {{ $siswas->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- Modal Import Excel Nilai Kriteria -->
    <dialog id="modal-import-penilaian" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box rounded-3xl bg-white p-6 max-w-xl">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l4-4m0 0l4 4m-4-4v12" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-black text-lg text-slate-900">Import Nilai Kriteria dari Excel</h3>
                        <p class="text-xs text-slate-500">Unggah nilai alternatif siswa untuk periode aktif</p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('modal-import-penilaian').close()" class="btn btn-sm btn-circle btn-ghost">✕</button>
            </div>

            <form method="POST" action="{{ route('admin.penilaian.import') }}" enctype="multipart/form-data" class="mt-4 space-y-4">
                @csrf

                <!-- Unduh Format Dulu -->
                <div class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200 flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-700 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-xs text-emerald-900 flex-1">
                        <p class="font-bold">Tips Mempersiapkan Berkas Excel:</p>
                        <p class="mt-0.5 leading-relaxed">
                            Unduh template format resmi agar header kolom kriteria (C1, C2, dst) sesuai dengan kode kriteria sistem MIS AL KAUTSAR.
                        </p>
                        <a href="{{ route('admin.penilaian.template') }}" class="inline-flex items-center gap-1.5 mt-2 font-black text-emerald-800 underline hover:text-emerald-950">
                            <span>Unduh Template Format (.xlsx)</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Input File -->
                <div class="form-control w-full">
                    <label class="label p-0 mb-1.5"><span class="text-xs font-bold text-slate-800">Pilih Berkas Spreadsheet (.xlsx, .xls, .csv)</span></label>
                    <input type="file" name="file" required accept=".xlsx,.xls,.csv"
                        class="file-input file-input-bordered file-input-sm w-full rounded-xl bg-white border-slate-300 font-medium text-slate-900 focus:border-emerald-600 focus:outline-none" />
                    <span class="text-[10px] text-slate-400 mt-1">Maksimal ukuran file: 5 MB</span>
                </div>

                <!-- Format Guide -->
                <div class="p-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-700 space-y-1.5">
                    <p class="font-bold text-slate-900">Format Kolom Header Spreadsheet:</p>
                    <div class="p-2 bg-white rounded-xl border border-slate-200 font-mono text-[11px] text-emerald-800 overflow-x-auto">
                        nis | nama_siswa | C1 | C2 | C3 | C4 | C5
                    </div>
                    <ul class="list-disc pl-4 text-[11px] text-slate-500 space-y-0.5">
                        <li>Kolom <strong>nis</strong> atau <strong>nama_siswa</strong> berfungsi sebagai pengenal alternatif siswa.</li>
                        <li>Kolom <strong>C1, C2, dst</strong> dapat diisi dengan <strong>angka nilai sub-kriteria (1 s/d 5)</strong> atau teks nama sub-kriteria.</li>
                        <li>Sistem otomatis mencocokkan nilai terdekat dengan skala sub-kriteria yang telah dikonfigurasi.</li>
                    </ul>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modal-import-penilaian').close()" class="btn btn-ghost btn-sm rounded-xl text-slate-600">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm rounded-xl font-bold gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l4-4m0 0l4 4m-4-4v12" />
                        </svg>
                        Mulai Import Nilai
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</x-admin-layout>
