<x-admin-layout>
    <div class="max-w-4xl mx-auto pb-12 pt-2">

        <!-- Header & Top Navigation -->
        <div class="flex items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.subkriteria.index') }}"
                   class="inline-flex items-center justify-center w-11 h-11 rounded-2xl bg-base-100 border border-base-200 shadow-sm text-base-content/70 hover:text-primary hover:border-primary/40 hover:shadow transition-all duration-200"
                   title="Kembali ke Data Sub Kriteria">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs font-semibold uppercase tracking-wider text-warning">Mode Pembaruan</span>
                        <span class="text-xs text-base-content/30">•</span>
                        <span class="text-xs text-base-content/50 font-mono">Sub Kriteria ID: #{{ $subKriteria->id }}</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-base-content">
                        Edit Sub Kriteria
                    </h1>
                </div>
            </div>

            <!-- Current Rating Chip -->
            <div class="hidden sm:inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-base-100 border border-base-200/80 shadow-sm text-xs font-medium text-base-content/70">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-warning fill-warning" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Nilai Bobot Saat Ini: <span class="font-bold text-base-content font-mono">{{ $subKriteria->nilai }}</span>
            </div>
        </div>

        <form action="{{ route('admin.subkriteria.update', $subKriteria->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <!-- Main Form Body (Left Column) -->
                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-base-100 rounded-3xl border border-base-200/90 shadow-sm p-6 sm:p-8 space-y-6">

                        <div>
                            <h2 class="text-lg font-bold text-base-content">Detail Opsi & Konversi Nilai</h2>
                            <p class="text-xs sm:text-sm text-base-content/60 mt-0.5">
                                Pastikan penetapan kriteria induk dan rentang opsi jawaban sesuai dengan acuan rumus SAW.
                            </p>
                        </div>

                        <div class="space-y-5">
                            <!-- Dropdown Kriteria Induk -->
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="kriteria_id" class="text-xs font-bold uppercase tracking-wider text-base-content/70">
                                        Kriteria Induk <span class="text-error">*</span>
                                    </label>
                                    <span class="text-[11px] text-base-content/40 font-mono">Relasi Utama</span>
                                </div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-base-content/40 group-focus-within:text-primary transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <select
                                        id="kriteria_id"
                                        name="kriteria_id"
                                        class="select select-bordered w-full pl-12 pr-4 h-12 rounded-2xl bg-base-200/20 text-sm font-medium focus:bg-base-100 focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 @error('kriteria_id') select-error border-error @enderror"
                                        required>
                                        @foreach ($kriterias as $krit)
                                            <option value="{{ $krit->id }}" {{ old('kriteria_id', $subKriteria->kriteria_id) == $krit->id ? 'selected' : '' }}>
                                                {{ $krit->kode_kriteria }} — {{ $krit->nama_kriteria }} ({{ ucfirst($krit->tipe) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('kriteria_id')
                                    <div class="flex items-center gap-1.5 text-xs text-error mt-1.5 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Input Nama Opsi / Jawaban -->
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="nama_subkriteria" class="text-xs font-bold uppercase tracking-wider text-base-content/70">
                                        Nama Opsi / Interval Jawaban <span class="text-error">*</span>
                                    </label>
                                    <span class="text-[11px] text-base-content/40 font-mono">Teks Parameter</span>
                                </div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-base-content/40 group-focus-within:text-primary transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="nama_subkriteria"
                                        name="nama_subkriteria"
                                        placeholder="Contoh: Rp 1.000.000 - Rp 3.000.000"
                                        class="input input-bordered w-full pl-12 pr-4 h-12 rounded-2xl bg-base-200/20 text-sm font-medium focus:bg-base-100 focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 @error('nama_subkriteria') input-error border-error focus:ring-error/10 @enderror"
                                        value="{{ old('nama_subkriteria', $subKriteria->nama_subkriteria) }}"
                                        required
                                    />
                                </div>
                                @error('nama_subkriteria')
                                    <div class="flex items-center gap-1.5 text-xs text-error mt-1.5 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Input Nilai Bobot (Rating) -->
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="nilai" class="text-xs font-bold uppercase tracking-wider text-base-content/70">
                                        Nilai Bobot (Rating Crisp) <span class="text-error">*</span>
                                    </label>
                                    <span class="text-[11px] text-base-content/40 font-mono">Skala 1 - 5</span>
                                </div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-base-content/40 group-focus-within:text-primary transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="number"
                                        id="nilai"
                                        name="nilai"
                                        min="1"
                                        max="5"
                                        placeholder="Cth: 4"
                                        class="input input-bordered w-full pl-12 pr-4 h-12 rounded-2xl bg-base-200/20 text-sm font-mono font-bold focus:bg-base-100 focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 @error('nilai') input-error border-error focus:ring-error/10 @enderror"
                                        value="{{ old('nilai', $subKriteria->nilai) }}"
                                        required
                                    />
                                </div>
                                @error('nilai')
                                    <div class="flex items-center gap-1.5 text-xs text-error mt-1.5 font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
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
                                <span>Perubahan nilai rating akan langsung mempengaruhi perhitungan pada matriks normalisasi SAW.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                                <span>Pastikan penamaan interval tidak tumpang tindih dengan opsi lain di kriteria yang sama.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Panel -->
                    <div class="bg-base-100 rounded-3xl border border-base-200/90 shadow-sm p-6 space-y-3">
                        <button type="submit" class="btn btn-primary w-full h-12 rounded-2xl gap-2 font-bold shadow-lg shadow-primary/20 hover:shadow-primary/30 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Perbarui Data Opsi
                        </button>

                        <a href="{{ route('admin.subkriteria.index') }}" class="btn btn-ghost w-full h-12 rounded-2xl text-base-content/60 hover:text-base-content hover:bg-base-200/60 font-semibold transition-colors">
                            Batalkan
                        </a>
                    </div>

                </div>

            </div>
        </form>

    </div>
</x-admin-layout>
