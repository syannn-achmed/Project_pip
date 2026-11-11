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
                <h1 class="text-2xl font-black tracking-tight text-base-content">Tambah Data Siswa</h1>
                <p class="text-xs text-base-content/60">Lengkapi identitas calon penerima bantuan Program Indonesia Pintar (PIP).</p>
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
            <form method="POST" action="{{ route('admin.siswa.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

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
                            <input type="text" name="nis" value="{{ old('nis') }}" required placeholder="Contoh: 202601001"
                                class="input input-bordered input-sm sm:input-md rounded-xl focus:outline-primary @error('nis') input-error @enderror" />
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold text-xs">Nama Lengkap Siswa <span class="text-error">*</span></span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Muhammad Rizky"
                                class="input input-bordered input-sm sm:input-md rounded-xl focus:outline-primary @error('nama') input-error @enderror" />
                        </div>

                        <!-- Kelas -->
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold text-xs">Kelas / Lokal <span class="text-error">*</span></span></label>
                            <input type="text" name="kelas" value="{{ old('kelas') }}" required placeholder="Contoh: VI A"
                                class="input input-bordered input-sm sm:input-md rounded-xl focus:outline-primary @error('kelas') input-error @enderror" />
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold text-xs">Jenis Kelamin <span class="text-error">*</span></span></label>
                            <select name="jk" required class="select select-bordered select-md w-full min-h-12 h-12 rounded-xl leading-normal focus:outline-primary" @error('jk') select-error @enderror">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('jk') === 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                                <option value="P" {{ old('jk') === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
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
                            <input type="text" name="nama_ortu" value="{{ old('nama_ortu') }}" required placeholder="Nama ayah/ibu/wali"
                                class="input input-bordered input-sm sm:input-md rounded-xl focus:outline-primary @error('nama_ortu') input-error @enderror" />
                        </div>

                        <!-- Pekerjaan Ortu -->
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold text-xs">Pekerjaan Orang Tua</span></label>
                            <input type="text" name="pekerjaan_ortu" value="{{ old('pekerjaan_ortu') }}" placeholder="Contoh: Buruh Harian Lepas, Petani "
                                class="input input-bordered input-sm sm:input-md rounded-xl focus:outline-primary" />
                        </div>

                        <!-- No Telp / WA -->
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold text-xs">Nomor Telepon / WhatsApp</span></label>
                            <input type="text" name="no_telp" value="{{ old('no_telp') }}" placeholder="Contoh: 081234567890"
                                class="input input-bordered input-sm sm:input-md rounded-xl focus:outline-primary" />
                        </div>

                        <!-- Tautkan Akun Ortu -->
                        <div class="form-control" x-data="{ buatBaru: false }">
                            <label class="label">
                                <span class="label-text font-bold text-xs text-slate-700">Akun Login Orang Tua (Portal Pengumuman)</span>
                            </label>
                            
                            <div class="space-y-2">
                                <div x-show="!buatBaru">
                                    <select name="user_id_ortu" class="select select-bordered select-md w-full min-h-12 h-12 rounded-xl leading-normal focus:outline-primary">
                                        <option value="">-- Pilih Akun Ortu Yang Sudah Ada (Opsional) --</option>
                                        @foreach ($ortuUsers as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id_ortu') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex items-center gap-2 pt-1">
                                    <input type="checkbox" id="buat_akun_ortu" name="buat_akun_ortu" value="1" x-model="buatBaru" class="checkbox checkbox-sm checkbox-primary rounded-md">
                                    <label for="buat_akun_ortu" class="text-xs font-semibold text-emerald-800 cursor-pointer">
                                        + Buatkan akun login baru sekaligus untuk orang tua ini
                                    </label>
                                </div>

                                <div x-show="buatBaru" x-cloak class="p-3 bg-emerald-50/70 border border-emerald-200 rounded-xl space-y-2 mt-2">
                                    <div>
                                        <label class="text-[11px] font-bold text-emerald-900 block">Email Login Orang Tua:</label>
                                        <input type="email" name="email_ortu_baru" value="{{ old('email_ortu_baru') }}" placeholder="Contoh: ortu.siswa@sekolah.com"
                                            class="input input-bordered input-sm w-full rounded-lg text-slate-900 bg-white font-medium border-slate-300">
                                    </div>
                                    <div>
                                        <label class="text-[11px] font-bold text-emerald-900 block">Kata Sandi (Default: password123):</label>
                                        <input type="text" name="password_ortu_baru" value="password123"
                                            class="input input-bordered input-sm w-full rounded-lg text-slate-900 bg-white font-medium border-slate-300">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="form-control sm:col-span-2">
                            <label class="label"><span class="label-text font-semibold text-xs">Alamat Domisili Siswa</span></label>
                            <textarea name="alamat" rows="2" placeholder="Alamat tempat tinggal lengkap..."
                                class="textarea textarea-bordered rounded-xl focus:outline-primary">{{ old('alamat') }}</textarea>
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

                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold text-xs">Unggah Pas Foto (Maks 2MB, JPG/PNG/WEBP)</span></label>
                        <input type="file" name="foto" accept="image/*" class="file-input file-input-bordered file-input-sm sm:file-input-md w-full rounded-xl" />
                    </div>
                </div>

                <!-- Tombol Simpan & Batal -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-base-200">
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-ghost btn-sm sm:btn-md rounded-xl">Batal</a>
                    <button type="submit" class="btn btn-primary btn-sm sm:btn-md rounded-xl px-6">
                        Simpan Data Siswa
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-admin-layout>
