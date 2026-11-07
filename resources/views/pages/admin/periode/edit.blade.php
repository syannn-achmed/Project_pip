<x-admin-layout>
    <div class="max-w-4xl mx-auto pb-12 pt-2">

        <!-- Header & Top Navigation -->
        <div class="flex items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.periode.index') }}"
                   class="inline-flex items-center justify-center w-11 h-11 rounded-2xl bg-base-100 border border-base-200 shadow-sm text-base-content/70 hover:text-primary hover:border-primary/40 hover:shadow transition-all duration-200"
                   title="Kembali ke Daftar Periode">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs font-semibold uppercase tracking-wider text-warning">Mode Pembaruan</span>
                        <span class="text-xs text-base-content/30">•</span>
                        <span class="text-xs text-base-content/50 font-mono">ID: #{{ $periode->id }}</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-base-content">
                        Edit Periode Seleksi
                    </h1>
                </div>
            </div>

            <!-- Current Status Badge -->
            <div class="hidden sm:inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-base-100 border border-base-200/80 shadow-sm text-xs font-medium">
                @if ($periode->status_aktif)
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-success opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-success"></span>
                    </span>
                    <span class="text-success font-semibold">Sedang Aktif</span>
                @else
                    <span class="inline-flex rounded-full h-2 w-2 bg-base-content/30"></span>
                    <span class="text-base-content/60">Tidak Aktif</span>
                @endif
            </div>
        </div>

        <form action="{{ route('admin.periode.update', $periode->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <!-- Main Form Body (Left Column) -->
                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-base-100 rounded-3xl border border-base-200/90 shadow-sm p-6 sm:p-8 space-y-6">

                        <div>
                            <h2 class="text-lg font-bold text-base-content">Pembaruan Parameter</h2>
                            <p class="text-xs sm:text-sm text-base-content/60 mt-0.5">
                                Sesuaikan kembali nama periode atau rentang tahun ajaran sesuai kebutuhan seleksi PIP.
                            </p>
                        </div>

                        <div class="space-y-5">
                            <!-- Input Nama Periode -->
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="nama_periode" class="text-xs font-bold uppercase tracking-wider text-base-content/70">
                                        Nama Periode <span class="text-error">*</span>
                                    </label>
                                    <span class="text-[11px] text-base-content/40 font-mono">Label Unik</span>
                                </div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-base-content/40 group-focus-within:text-primary transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="nama_periode"
                                        name="nama_periode"
                                        placeholder="Contoh: Ganjil 2026/2027"
                                        class="input input-bordered w-full pl-12 pr-4 h-12 rounded-2xl bg-base-200/20 text-sm font-medium focus:bg-base-100 focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 @error('nama_periode') input-error border-error focus:ring-error/10 @enderror"
                                        value="{{ old('nama_periode', $periode->nama_periode) }}"
                                        required
                                    />
                                </div>
                                @error('nama_periode')
                                    <div class="flex items-center gap-1.5 text-xs text-error mt-1.5 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Input Tahun Ajaran -->
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="tahun_ajaran" class="text-xs font-bold uppercase tracking-wider text-base-content/70">
                                        Tahun Ajaran <span class="text-error">*</span>
                                    </label>
                                    <span class="text-[11px] text-base-content/40 font-mono">Format YYYY/YYYY</span>
                                </div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-base-content/40 group-focus-within:text-primary transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="tahun_ajaran"
                                        name="tahun_ajaran"
                                        placeholder="Contoh: 2026/2027"
                                        class="input input-bordered w-full pl-12 pr-4 h-12 rounded-2xl bg-base-200/20 text-sm font-medium focus:bg-base-100 focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 @error('tahun_ajaran') input-error border-error focus:ring-error/10 @enderror"
                                        value="{{ old('tahun_ajaran', $periode->tahun_ajaran) }}"
                                        required
                                    />
                                </div>
                                @error('tahun_ajaran')
                                    <div class="flex items-center gap-1.5 text-xs text-error mt-1.5 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Toggle Status Card -->
                        <div class="pt-4 border-t border-base-200">
                            <label class="relative flex items-center justify-between p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-base-200/40 to-base-200/10 border border-base-200 hover:border-primary/30 transition-all duration-200 cursor-pointer select-none">
                                <div class="flex items-start gap-3.5 pr-4">
                                    <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0 mt-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-base-content">Status Periode Aktif</div>
                                        <p class="text-xs text-base-content/60 leading-relaxed mt-0.5">
                                            Jika diaktifkan, periode aktif lainnya akan otomatis dinonaktifkan dan perhitungan SAW akan difokuskan pada periode ini.
                                        </p>
                                    </div>
                                </div>
                                <input
                                    type="checkbox"
                                    name="status_aktif"
                                    class="toggle toggle-primary toggle-md shrink-0 focus:outline-none"
                                    value="1"
                                    {{ old('status_aktif', $periode->status_aktif) ? 'checked' : '' }}
                                />
                            </label>
                        </div>

                    </div>
                </div>

                <!-- Guidance & Action Card (Right Column) -->
                <div class="lg:col-span-4 space-y-6">

                    <!-- Information Insight Box -->
                    <div class="bg-gradient-to-br from-base-100 to-base-200/30 rounded-3xl border border-base-200/90 shadow-sm p-6 space-y-4">
                        <div class="flex items-center gap-2.5">
                            <div class="p-2 rounded-xl bg-warning/10 text-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-wider text-base-content/70">Catatan Pembaruan</span>
                        </div>

                        <ul class="text-xs text-base-content/70 space-y-3 leading-relaxed">
                            <li class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                                <span>Mengubah tahun ajaran tidak akan menghapus data penilaian siswa yang sudah diinput sebelumnya.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                                <span>Pastikan penamaan tetap konsisten dengan data laporan agar tidak membingungkan pihak verifikator.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Panel -->
                    <div class="bg-base-100 rounded-3xl border border-base-200/90 shadow-sm p-6 space-y-3">
                        <button type="submit" class="btn btn-primary w-full h-12 rounded-2xl gap-2 font-bold shadow-lg shadow-primary/20 hover:shadow-primary/30 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Perbarui Data
                        </button>

                        <a href="{{ route('admin.periode.index') }}" class="btn btn-ghost w-full h-12 rounded-2xl text-base-content/60 hover:text-base-content hover:bg-base-200/60 font-semibold transition-colors">
                            Batalkan
                        </a>
                    </div>

                </div>

            </div>
        </form>

    </div>
</x-admin-layout>
