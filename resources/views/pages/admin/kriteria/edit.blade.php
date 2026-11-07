<x-admin-layout>
    <div class="max-w-4xl mx-auto pb-12 pt-2">

        <!-- Header & Top Navigation -->
        <div class="flex items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.kriteria.index') }}"
                   class="inline-flex items-center justify-center w-11 h-11 rounded-2xl bg-base-100 border border-base-200 shadow-sm text-base-content/70 hover:text-primary hover:border-primary/40 hover:shadow transition-all duration-200"
                   title="Kembali ke Data Kriteria">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs font-semibold uppercase tracking-wider text-warning">Mode Pembaruan</span>
                        <span class="text-xs text-base-content/30">•</span>
                        <span class="text-xs text-base-content/50 font-mono">Kode: {{ $kriteria->kode_kriteria }}</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-base-content">
                        Edit Kriteria Penilaian
                    </h1>
                </div>
            </div>

            <!-- Sisa Alokasi Bobot Chip -->
            <div class="hidden sm:inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-base-100 border border-base-200/80 shadow-sm text-xs font-medium text-base-content/70">
                <span class="w-2 h-2 rounded-full bg-primary"></span>
                Maksimal Alokasi: <span class="font-mono font-bold text-primary">{{ $sisaBobot }}%</span>
            </div>
        </div>

        <form action="{{ route('admin.kriteria.update', $kriteria->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <!-- Main Form Body (Left Column) -->
                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-base-100 rounded-3xl border border-base-200/90 shadow-sm p-6 sm:p-8 space-y-6">

                        <div>
                            <h2 class="text-lg font-bold text-base-content">Parameter Kriteria</h2>
                            <p class="text-xs sm:text-sm text-base-content/60 mt-0.5">
                                Perbarui identitas kriteria, sifat benefit/cost, dan pembagian persentase bobot SAW.
                            </p>
                        </div>

                        <!-- Baris 1: Kode & Nama Kriteria -->
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                            <!-- Kode Kriteria -->
                            <div class="sm:col-span-4 space-y-2">
                                <label for="kode_kriteria" class="text-xs font-bold uppercase tracking-wider text-base-content/70 block">
                                    Kode <span class="text-error">*</span>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-base-content/40 group-focus-within:text-primary transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="kode_kriteria"
                                        name="kode_kriteria"
                                        placeholder="Cth: C1"
                                        class="input input-bordered w-full pl-10 pr-4 h-12 rounded-2xl bg-base-200/20 text-sm font-mono font-bold focus:bg-base-100 focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 @error('kode_kriteria') input-error border-error @enderror"
                                        value="{{ old('kode_kriteria', $kriteria->kode_kriteria) }}"
                                        required
                                    />
                                </div>
                                @error('kode_kriteria')
                                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Kriteria -->
                            <div class="sm:col-span-8 space-y-2">
                                <label for="nama_kriteria" class="text-xs font-bold uppercase tracking-wider text-base-content/70 block">
                                    Nama Kriteria <span class="text-error">*</span>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-base-content/40 group-focus-within:text-primary transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="nama_kriteria"
                                        name="nama_kriteria"
                                        placeholder="Cth: Penghasilan Orang Tua"
                                        class="input input-bordered w-full pl-10 pr-4 h-12 rounded-2xl bg-base-200/20 text-sm font-medium focus:bg-base-100 focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 @error('nama_kriteria') input-error border-error @enderror"
                                        value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}"
                                        required
                                    />
                                </div>
                                @error('nama_kriteria')
                                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Baris 2: Tipe Kriteria & Bobot (%) -->
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                            <!-- Tipe Kriteria -->
                            <div class="sm:col-span-6 space-y-2">
                                <label for="tipe" class="text-xs font-bold uppercase tracking-wider text-base-content/70 block">
                                    Tipe Karakteristik <span class="text-error">*</span>
                                </label>
                                <div class="relative">
                                    <select
                                        id="tipe"
                                        name="tipe"
                                        class="select select-bordered w-full h-12 rounded-2xl bg-base-200/20 text-sm font-medium focus:bg-base-100 focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 @error('tipe') select-error border-error @enderror"
                                        required>
                                        <option value="benefit" {{ old('tipe', $kriteria->tipe) == 'benefit' ? 'selected' : '' }}>
                                            📈 Benefit (Makin tinggi makin baik)
                                        </option>
                                        <option value="cost" {{ old('tipe', $kriteria->tipe) == 'cost' ? 'selected' : '' }}>
                                            📉 Cost (Makin rendah makin baik)
                                        </option>
                                    </select>
                                </div>
                                @error('tipe')
                                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bobot (%) -->
                            <div class="sm:col-span-6 space-y-2">
                                <div class="flex items-center justify-between">
                                    <label for="bobot" class="text-xs font-bold uppercase tracking-wider text-base-content/70">
                                        Bobot Persentase (%) <span class="text-error">*</span>
                                    </label>
                                    <span class="text-[11px] font-mono text-primary font-bold">Maks: {{ $sisaBobot }}%</span>
                                </div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-base-content/40 group-focus-within:text-primary transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="number"
                                        id="bobot"
                                        name="bobot"
                                        min="1"
                                        max="{{ $sisaBobot }}"
                                        placeholder="Cth: 25"
                                        class="input input-bordered w-full pl-10 pr-4 h-12 rounded-2xl bg-base-200/20 text-sm font-mono font-bold focus:bg-base-100 focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 @error('bobot') input-error border-error @enderror"
                                        value="{{ old('bobot', $kriteria->bobot) }}"
                                        required
                                    />
                                </div>
                                @error('bobot')
                                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Baris 3: Keterangan (Opsional) -->
                        <div class="space-y-2">
                            <label for="keterangan" class="text-xs font-bold uppercase tracking-wider text-base-content/70 block">
                                Keterangan & Deskripsi Acuan
                            </label>
                            <textarea
                                id="keterangan"
                                name="keterangan"
                                rows="3"
                                placeholder="Jelaskan alasan penetapan bobot atau dasar verifikasi berkas untuk kriteria ini..."
                                class="textarea textarea-bordered w-full rounded-2xl bg-base-200/20 text-sm focus:bg-base-100 focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 leading-relaxed">{{ old('keterangan', $kriteria->keterangan) }}</textarea>
                            @error('keterangan')
                                <p class="text-xs text-error mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <!-- Guidance & Action Card (Right Column) -->
                <div class="lg:col-span-4 space-y-6">

                    <!-- Information Insight Box -->
                    <div class="bg-gradient-to-br from-base-100 to-base-200/30 rounded-3xl border border-base-200/90 shadow-sm p-6 space-y-4">
                        <div class="flex items-center gap-2.5">
                            <div class="p-2 rounded-xl bg-info/10 text-info">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-wider text-base-content/70">Aturan Bobot SAW</span>
                        </div>

                        <div class="p-3 rounded-2xl bg-base-100 border border-base-200 space-y-1">
                            <span class="text-[11px] text-base-content/60 block">Batas Maksimal Input:</span>
                            <div class="text-2xl font-black font-mono text-primary">{{ $sisaBobot }}%</div>
                            <p class="text-[11px] text-base-content/50 leading-tight">
                                Angka ini adalah akumulasi bobot kriteria ini ditambah sisa ruang kosong dari total 100%.
                            </p>
                        </div>

                        <ul class="text-xs text-base-content/70 space-y-2.5 leading-relaxed pt-1">
                            <li class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                                <span><strong>Benefit</strong>: Nilai alternatif tertinggi mendapat skor normalisasi 1.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                                <span><strong>Cost</strong>: Nilai alternatif terendah mendapat skor normalisasi 1.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Panel -->
                    <div class="bg-base-100 rounded-3xl border border-base-200/90 shadow-sm p-6 space-y-3">
                        <button type="submit" class="btn btn-primary w-full h-12 rounded-2xl gap-2 font-bold shadow-lg shadow-primary/20 hover:shadow-primary/30 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Perbarui Kriteria
                        </button>

                        <a href="{{ route('admin.kriteria.index') }}" class="btn btn-ghost w-full h-12 rounded-2xl text-base-content/60 hover:text-base-content hover:bg-base-200/60 font-semibold transition-colors">
                            Batalkan
                        </a>
                    </div>

                </div>

            </div>
        </form>

    </div>
</x-admin-layout>
