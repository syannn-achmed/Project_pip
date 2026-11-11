<x-admin-layout>
    <div class="space-y-6 max-w-4xl mx-auto pb-12">

        <!-- Header & Breadcrumb -->
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-circle btn-ghost btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-base-content">Edit Data Siswa</h1>
                <p class="text-xs text-base-content/60">Perbarui biodata siswa: <span class="font-bold text-primary">{{ $siswa->nama }}</span> (NIS: {{ $siswa->nis }})</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-error bg-error/15 border border-error/30 text-error shadow-sm rounded-2xl py-3 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Card Form -->
        <div class="card bg-base-100 shadow-sm border border-base-200/90 rounded-2xl p-6 sm:p-8">
            <form method="POST" action="{{ route('admin.siswa.update', $siswa->id) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Section 1: Data Pokok Siswa -->
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-wider text-primary mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-primary inline-block"></span>
                        Identitas Siswa
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- NIS -->
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold text-xs">Nomor Induk Siswa (NIS) <span class="text-error">*</span></span></label>
                            <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" required
                                class="input input-bordered input-sm sm:input-md rounded-xl focus:outline-primary @error('nis') input-error @enderror" />
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold text-xs">Nama Lengkap Siswa <span class="text-error">*</span></span></label>
                            <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}" required
                                class="input input-bordered input-sm sm:input-md rounded-xl focus:outline-primary @error('nama') input-error @enderror" />
                        </div>

                        <!-- Kelas -->
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold text-xs">Kelas / Jurusan <span class="text-error">*</span></span></label>
                            <input type="text" name="kelas" value="{{ old('kelas', $siswa->kelas) }}" required
                                class="input input-bordered input-sm sm:input-md rounded-xl focus:outline-primary @error('kelas') input-error @enderror" />
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold text-xs">Jenis Kelamin <span class="text-error">*</span></span></label>
                            <select name="jk" required class="select select-bordered select-sm sm:select-md rounded-xl focus:outline-primary @error('jk') select-error @enderror">
                                <option value="L" {{ old('jk', $siswa->jk) === 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                                <option value="P" {{ old('jk', $siswa->jk) === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="divider my-2"></div>

                <!-- Section 2: Data Orang Tua / Wali -->
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-wider text-primary mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-primary inline-block"></span>
                        Data Orang Tua / Wali
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Nama Ortu -->
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold text-xs">Nama Orang Tua / Wali <span class="text-error">*</span></span></label>
                            <input type="text" name="nama_ortu" value="{{ old('nama_ortu', $siswa->nama_ortu) }}" required
                                class="input input-bordered input-sm sm:input-md rounded-xl focus:outline-primary @error('nama_ortu') input-error @enderror" />
                        </div>

                        <!-- No Telp / WA -->
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold text-xs">Nomor Telepon / WhatsApp</span></label>
                            <input type="text" name="no_telp" value="{{ old('no_telp', $siswa->no_telp) }}"
                                class="input input-bordered input-sm sm:input-md rounded-xl focus:outline-primary" />
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="form-control sm:col-span-2">
                            <label class="label"><span class="label-text font-semibold text-xs">Alamat Domisili Siswa</span></label>
                            <textarea name="alamat" rows="2"
                                class="textarea textarea-bordered rounded-xl focus:outline-primary">{{ old('alamat', $siswa->alamat) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="divider my-2"></div>

                <!-- Section 3: Berkas Foto -->
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-wider text-primary mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-primary inline-block"></span>
                        Pas Foto Siswa
                    </h2>

                    @if ($siswa->foto && Storage::disk('public')->exists($siswa->foto))
                        <div class="flex items-center gap-4 mb-4 p-3 bg-base-200/50 rounded-xl max-w-sm">
                            <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto Siswa" class="w-16 h-16 object-cover rounded-lg ring-1 ring-base-300" />
                            <div>
                                <span class="text-xs font-semibold text-base-content block">Foto Saat Ini</span>
                                <span class="text-[11px] text-base-content/50">Unggah foto baru jika ingin mengganti</span>
                            </div>
                        </div>
                    @endif

                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold text-xs">Ganti Pas Foto (Opsional, Maks 2MB)</span></label>
                        <input type="file" name="foto" accept="image/*" class="file-input file-input-bordered file-input-sm sm:file-input-md w-full rounded-xl" />
                    </div>
                </div>

                <!-- Tombol Simpan & Batal -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-base-200">
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-ghost btn-sm sm:btn-md rounded-xl">Batal</a>
                    <button type="submit" class="btn btn-primary btn-sm sm:btn-md rounded-xl px-6">
                        Perbarui Data Siswa
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-admin-layout>
