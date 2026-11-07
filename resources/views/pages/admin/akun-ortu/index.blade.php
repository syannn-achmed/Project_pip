<x-admin-layout>
    <div class="space-y-6 pb-12">

        <!-- 1. Header Halaman -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="p-2.5 rounded-2xl bg-emerald-600/10 text-emerald-700 mt-1 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Akses Portal Mandiri</span>
                        <span class="text-xs text-slate-300">•</span>
                        <span class="text-xs text-slate-500">Keluarga Peserta Didik</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900">Manajemen Akun Orang Tua</h1>
                    <p class="text-xs sm:text-sm text-slate-600 mt-0.5">Kelola akun pengguna bagi wali murid agar dapat memantau status penyaluran PIP anak secara mandiri.</p>
                </div>
            </div>

            <!-- Tombol Tambah Akun -->
            <button onclick="document.getElementById('modal-tambah-ortu').showModal()"
                class="btn btn-primary btn-sm rounded-xl gap-2 font-bold shadow-sm shadow-emerald-700/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Akun Ortu
            </button>
        </div>

        <!-- 2. Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success bg-emerald-50 border border-emerald-300 text-emerald-800 shadow-sm rounded-2xl flex items-center gap-3 py-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error bg-rose-50 border border-rose-300 text-rose-800 shadow-sm rounded-2xl py-3">
                <ul class="text-xs font-semibold list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- 3. Toolbar & Filter -->
        <div class="card bg-white shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-200 bg-slate-50/70">
                <form method="GET" action="{{ route('admin.akun-ortu.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="relative w-full sm:w-80">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama, email, atau anak..."
                            class="input input-bordered input-sm w-full pl-9 rounded-xl font-semibold text-slate-900 bg-white border-slate-300 placeholder:text-slate-400 focus:border-emerald-600 focus:outline-none" />
                    </div>

                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button type="submit" class="btn btn-primary btn-sm rounded-xl font-bold flex-1 sm:flex-none">
                            Cari
                        </button>
                        @if (request()->filled('search'))
                            <a href="{{ route('admin.akun-ortu.index') }}" class="btn btn-ghost btn-sm rounded-xl text-slate-600">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- 4. Tabel Akun Orang Tua -->
            <div class="overflow-x-auto">
                <table class="table table-md w-full">
                    <thead class="bg-slate-100 text-slate-700 text-xs uppercase tracking-wider font-bold border-b border-slate-200">
                        <tr>
                            <th class="w-12 text-center">No</th>
                            <th>Nama Orang Tua / Wali</th>
                            <th>Email Login</th>
                            <th>Siswa Tertaut (Anak)</th>
                            <th>Tautan Siswa</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($akunOrtus as $index => $ortu)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="text-center font-bold text-slate-500">
                                    {{ $akunOrtus->firstItem() + $index }}
                                </td>

                                <!-- Nama Ortu -->
                                <td>
                                    <div class="font-bold text-slate-900">{{ $ortu->name }}</div>
                                    <span class="text-[11px] text-slate-400">Didaftarkan: {{ $ortu->created_at->format('d M Y') }}</span>
                                </td>

                                <!-- Email -->
                                <td>
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 font-mono text-xs font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                        </svg>
                                        {{ $ortu->email }}
                                    </div>
                                </td>

                                <!-- Siswa Tertaut -->
                                <td>
                                    @if ($ortu->siswas->isNotEmpty())
                                        <div class="space-y-1.5">
                                            @foreach ($ortu->siswas as $anak)
                                                <div class="flex items-center justify-between gap-2 p-1.5 px-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                                                    <div>
                                                        <span class="font-bold text-slate-900">{{ $anak->nama }}</span>
                                                        <span class="text-slate-500">({{ $anak->kelas }} • NIS: {{ $anak->nis }})</span>
                                                    </div>
                                                    <form method="POST" action="{{ route('admin.siswa.lepas-akun-ortu') }}" onsubmit="return confirm('Lepaskan tautan siswa {{ $anak->nama }}?')">
                                                        @csrf
                                                        <input type="hidden" name="siswa_id" value="{{ $anak->id }}">
                                                        <button type="submit" class="text-rose-600 hover:text-rose-800 text-[11px] font-bold px-1" title="Lepas Tautan">
                                                            ✕ Lepas
                                                        </button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="badge badge-warning badge-sm font-semibold text-slate-900">Belum Ada Siswa Tertaut</span>
                                    @endif
                                </td>

                                <!-- Tautkan Siswa Baru Dropdown -->
                                <td>
                                    @if ($siswaBelumPunyaAkun->isNotEmpty())
                                        <form method="POST" action="{{ route('admin.siswa.tautkan-akun-ortu') }}" class="flex items-center gap-1.5">
                                            @csrf
                                            <input type="hidden" name="user_id_ortu" value="{{ $ortu->id }}">
                                            <select name="siswa_id" required class="select select-bordered select-xs rounded-lg font-medium text-slate-900 bg-white border-slate-300 max-w-[160px]">
                                                <option value="" disabled selected>+ Pilih Siswa</option>
                                                @foreach ($siswaBelumPunyaAkun as $s)
                                                    <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->kelas }})</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-xs btn-outline btn-primary rounded-lg font-bold">
                                                Tautkan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[11px] text-slate-400">Semua siswa sudah tertaut</span>
                                    @endif
                                </td>

                                <!-- Aksi Edit / Hapus -->
                                <td class="text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <!-- Edit Modal Trigger -->
                                        <button onclick="openEditModal({{ $ortu->id }}, '{{ addslashes($ortu->name) }}', '{{ addslashes($ortu->email) }}')"
                                            class="btn btn-ghost btn-xs text-blue-600 hover:bg-blue-50 rounded-lg" title="Edit Akun & Reset Sandi">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Hapus Akun Form -->
                                        <form method="POST" action="{{ route('admin.akun-ortu.destroy', $ortu->id) }}"
                                            onsubmit="return confirm('Hapus akun orang tua {{ $ortu->name }}? Siswa terkait akan menjadi tidak tertaut.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-ghost btn-xs text-rose-600 hover:bg-rose-50 rounded-lg" title="Hapus Akun">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <div class="font-bold text-slate-600">Belum Ada Akun Orang Tua Terdaftar</div>
                                    <p class="text-xs text-slate-400 mt-1">Klik tombol "Tambah Akun Ortu" untuk mendaftarkan akun baru.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($akunOrtus->hasPages())
                <div class="p-4 border-t border-slate-200 bg-slate-50/50">
                    {{ $akunOrtus->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- MODAL 1: Tambah Akun Orang Tua -->
    <dialog id="modal-tambah-ortu" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box rounded-3xl bg-white p-6 max-w-lg">
            <h3 class="font-black text-lg text-slate-900 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                Tambah Akun Orang Tua Baru
            </h3>
            <p class="text-xs text-slate-500 mt-1">Buat kredensial login orang tua dan opsional langsung tautkan ke siswa.</p>

            <form method="POST" action="{{ route('admin.akun-ortu.store') }}" class="space-y-4 mt-5">
                @csrf

                <!-- Nama Lengkap -->
                <div class="form-control">
                    <label class="label"><span class="label-text font-bold text-xs text-slate-700">Nama Orang Tua / Wali <span class="text-rose-500">*</span></span></label>
                    <input type="text" name="name" required placeholder="Contoh: Budi Santoso"
                        class="input input-bordered input-sm rounded-xl font-medium text-slate-900 bg-white border-slate-300 focus:border-emerald-600 focus:outline-none" />
                </div>

                <!-- Email -->
                <div class="form-control">
                    <label class="label"><span class="label-text font-bold text-xs text-slate-700">Alamat Email Login <span class="text-rose-500">*</span></span></label>
                    <input type="email" name="email" required placeholder="Contoh: budi.santoso@sekolah.com"
                        class="input input-bordered input-sm rounded-xl font-medium text-slate-900 bg-white border-slate-300 focus:border-emerald-600 focus:outline-none" />
                </div>

                <!-- Password -->
                <div class="form-control">
                    <label class="label"><span class="label-text font-bold text-xs text-slate-700">Kata Sandi (Minimal 6 karakter) <span class="text-rose-500">*</span></span></label>
                    <input type="text" name="password" required value="password123"
                        class="input input-bordered input-sm rounded-xl font-medium text-slate-900 bg-white border-slate-300 focus:border-emerald-600 focus:outline-none" />
                    <span class="text-[10px] text-slate-400 mt-1">Sandi standar awal: <code>password123</code></span>
                </div>

                <!-- Tautkan Siswa -->
                <div class="form-control">
                    <label class="label"><span class="label-text font-bold text-xs text-slate-700">Tautkan ke Siswa (Opsional)</span></label>
                    <select name="siswa_id" class="select select-bordered select-sm rounded-xl font-medium text-slate-900 bg-white border-slate-300 focus:border-emerald-600 focus:outline-none">
                        <option value="">-- Jangan Tautkan Dulu --</option>
                        @foreach ($siswaBelumPunyaAkun as $s)
                            <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->kelas }} • NIS: {{ $s->nis }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-action pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modal-tambah-ortu').close()" class="btn btn-ghost btn-sm rounded-xl">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm rounded-xl font-bold">Simpan & Buat Akun</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <!-- MODAL 2: Edit Akun Orang Tua -->
    <dialog id="modal-edit-ortu" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box rounded-3xl bg-white p-6 max-w-lg">
            <h3 class="font-black text-lg text-slate-900 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                Edit Akun Orang Tua
            </h3>
            <p class="text-xs text-slate-500 mt-1">Perbarui nama, email, atau atur ulang kata sandi pengguna.</p>

            <form id="form-edit-ortu" method="POST" action="" class="space-y-4 mt-5">
                @csrf
                @method('PUT')

                <!-- Nama Lengkap -->
                <div class="form-control">
                    <label class="label"><span class="label-text font-bold text-xs text-slate-700">Nama Orang Tua / Wali</span></label>
                    <input type="text" id="edit-name" name="name" required
                        class="input input-bordered input-sm rounded-xl font-medium text-slate-900 bg-white border-slate-300 focus:border-blue-600 focus:outline-none" />
                </div>

                <!-- Email -->
                <div class="form-control">
                    <label class="label"><span class="label-text font-bold text-xs text-slate-700">Alamat Email Login</span></label>
                    <input type="email" id="edit-email" name="email" required
                        class="input input-bordered input-sm rounded-xl font-medium text-slate-900 bg-white border-slate-300 focus:border-blue-600 focus:outline-none" />
                </div>

                <!-- Reset Password -->
                <div class="form-control">
                    <label class="label"><span class="label-text font-bold text-xs text-slate-700">Ganti Sandi Baru (Kosongkan jika tidak diubah)</span></label>
                    <input type="text" name="password" placeholder="Masukkan kata sandi baru jika ingin reset..."
                        class="input input-bordered input-sm rounded-xl font-medium text-slate-900 bg-white border-slate-300 focus:border-blue-600 focus:outline-none" />
                </div>

                <div class="modal-action pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modal-edit-ortu').close()" class="btn btn-ghost btn-sm rounded-xl">Batal</button>
                    <button type="submit" class="btn btn-primary bg-blue-600 hover:bg-blue-700 border-blue-600 btn-sm rounded-xl font-bold text-white">Simpan Perubahan</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <script>
        function openEditModal(id, name, email) {
            const form = document.getElementById('form-edit-ortu');
            form.action = "{{ url('admin/akun-ortu') }}/" + id;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('modal-edit-ortu').showModal();
        }
    </script>
</x-admin-layout>
