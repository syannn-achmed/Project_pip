<x-admin-layout>
    <div class="space-y-6 pb-10">

        <!-- 1. Header Halaman & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="p-2.5 rounded-2xl bg-primary/10 text-primary mt-1 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-xs font-bold uppercase tracking-wider text-primary">Data Master</span>
                        <span class="text-xs text-base-content/30">•</span>
                        <span class="text-xs text-base-content/50">Alternatif Calon Penerima</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-base-content">Data Siswa</h1>
                    <p class="text-xs sm:text-sm text-base-content/65 mt-0.5">Kelola biodata calon penerima PIP dan berkas foto.</p>
                </div>
            </div>

            <!-- Action Buttons: Tambah, Export, Import -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.siswa.export') }}" class="btn btn-outline btn-success btn-sm rounded-xl gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export Excel
                </a>

                <button onclick="document.getElementById('modal-import-siswa').showModal()" class="btn btn-outline btn-info btn-sm rounded-xl gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l4-4m0 0l4 4m-4-4v12" />
                    </svg>
                    Import Excel
                </button>

                <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary btn-sm rounded-xl gap-2 shadow-sm shadow-primary/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Siswa
                </a>
            </div>
        </div>

        <!-- 2. Flash Messages (Alert Sukses & Error) -->
        @if (session('success'))
            <div class="alert alert-success bg-success/15 border border-success/30 text-success shadow-sm rounded-2xl flex items-center gap-3 py-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error bg-error/15 border border-error/30 text-error shadow-sm rounded-2xl flex items-center gap-3 py-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        <!-- 3. Toolbar Filter & Search -->
        <div class="card bg-white shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-200 bg-slate-50/70">
                <form method="GET" action="{{ route('admin.siswa.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <!-- Search Input -->
                    <div class="relative w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari NIS, nama siswa, ortu..."
                            class="input input-bordered input-sm w-full pl-9 rounded-xl font-semibold text-slate-900 bg-white border-slate-300 placeholder:text-slate-400 focus:border-emerald-600 focus:outline-none" />
                    </div>

                    <!-- Filter Kelas -->
                    <div>
                        <select name="kelas"
    class="select select-bordered w-full h-12 min-h-12 text-base leading-normal rounded-xl focus:outline-primary"
    onchange="this.form.submit()">
                            <option value="" class="text-slate-900 font-bold">-- Semua Kelas --</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }} class="text-slate-900 font-medium">
                                    Kelas {{ $kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter JK -->
                    <div>
                        <select name="jk"
    class="select select-bordered w-full h-12 min-h-12 text-base leading-normal rounded-xl focus:outline-primary"
    onchange="this.form.submit()">
                            <option value="" class="text-slate-900 font-bold">-- Semua Jenis Kelamin --</option>
                            <option value="L" {{ request('jk') == 'L' ? 'selected' : '' }} class="text-slate-900 font-medium">Laki-laki (L)</option>
                            <option value="P" {{ request('jk') == 'P' ? 'selected' : '' }} class="text-slate-900 font-medium">Perempuan (P)</option>
                        </select>
                    </div>

                    <!-- Action Cari & Reset -->
                    <div class="flex items-center gap-2">
                        <button type="submit" class="btn btn-primary btn-sm rounded-xl font-bold flex-1">Filter</button>
                        @if (request()->hasAny(['search', 'kelas', 'jk']))
                            <a href="{{ route('admin.siswa.index') }}" class="btn btn-ghost btn-sm rounded-xl text-slate-600">Reset</a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- 4. Tabel Siswa -->
            <div class="overflow-x-auto">
                <table class="table table-md w-full">
                    <thead class="bg-base-200/50 text-base-content/70 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="w-16">Foto</th>
                            <th>NIS & Nama Lengkap</th>
                            <th>Kelas / JK</th>
                            <th>Orang Tua / Wali</th>
                            <th>Kontak & Alamat</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-base-200 text-sm">
                        @forelse ($siswas as $siswa)
                            <tr class="hover:bg-base-200/30 transition-colors">
                                <!-- Foto -->
                                <td>
                                    <div class="avatar placeholder">
                                        <div class="w-11 h-11 rounded-xl bg-base-300 text-base-content/60 overflow-hidden ring-1 ring-base-300">
                                            @if ($siswa->foto && Storage::disk('public')->exists($siswa->foto))
                                                <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama }}" class="object-cover w-full h-full" />
                                            @else
                                                <span class="text-xs font-bold">{{ strtoupper(substr($siswa->nama, 0, 2)) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Identitas -->
                                <td>
                                    <div class="font-bold text-base-content">{{ $siswa->nama }}</div>
                                    <div class="text-xs font-mono text-base-content/50">NIS: {{ $siswa->nis }}</div>
                                </td>

                                <!-- Kelas & JK -->
                                <td>
                                    <div class="badge badge-neutral badge-sm font-semibold">{{ $siswa->kelas }}</div>
                                    <div class="text-xs text-base-content/60 mt-1">
                                        {{ $siswa->jk === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </div>
                                </td>

                                <!-- Data Ortu -->
                                <td>
                                    <div class="font-medium text-base-content">{{ $siswa->nama_ortu }}</div>
                                </td>

                                <!-- Kontak & Alamat -->
                                <td>
                                    <div class="text-xs text-base-content/80 font-mono">{{ $siswa->no_telp ?? '-' }}</div>
                                    <div class="text-xs text-base-content/50 line-clamp-1 max-w-[180px]">{{ $siswa->alamat ?? '-' }}</div>
                                </td>

                                <!-- Aksi -->
                                <td class="text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-ghost btn-xs btn-square text-info hover:bg-info/10" title="Edit Siswa">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        <form method="POST" action="{{ route('admin.siswa.destroy', $siswa->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa {{ $siswa->nama }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-ghost btn-xs btn-square text-error hover:bg-error/10" title="Hapus Siswa">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 text-base-content/50">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <span class="font-medium text-sm">Belum ada data siswa yang tercatat.</span>
                                        <a href="{{ route('admin.siswa.create') }}" class="btn btn-link btn-xs text-primary">Tambah Siswa Sekarang</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 5. Pagination Footer -->
            @if ($siswas->hasPages())
                <div class="p-4 border-t border-base-200">
                    {{ $siswas->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- Modal Import Excel -->
    <dialog id="modal-import-siswa" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box rounded-2xl">
            <h3 class="font-bold text-lg text-base-content">Import Data Siswa dari Excel</h3>
            <p class="text-xs text-base-content/60 mt-1">Unggah file spreadsheet format <code>.xlsx</code>, <code>.xls</code>, atau <code>.csv</code>.</p>

            <form method="POST" action="{{ route('admin.siswa.import') }}" enctype="multipart/form-data" class="mt-4 space-y-4">
                @csrf
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-semibold text-xs">Pilih File Excel</span></label>
                    <input type="file" name="file" required accept=".xlsx,.xls,.csv" class="file-input file-input-bordered file-input-sm w-full rounded-xl" />
                </div>

                <div class="p-3 bg-base-200/50 rounded-xl text-xs text-base-content/70 space-y-1">
                    <p class="font-semibold text-base-content">Format kolom baris pertama (Heading):</p>
                    <p class="font-mono text-[11px]">nis | nama | kelas | jk | nama_ortu | no_telp | alamat</p>
                </div>

                <div class="modal-action">
                    <button type="button" onclick="document.getElementById('modal-import-siswa').close()" class="btn btn-ghost btn-sm rounded-xl">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm rounded-xl">Unggah & Import</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</x-admin-layout>
