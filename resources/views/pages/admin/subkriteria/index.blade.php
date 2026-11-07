<x-admin-layout>
    <div class="space-y-6 pb-12">

        <!-- 1. Header Halaman -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="p-2.5 rounded-2xl bg-primary/10 text-primary mt-1 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-xs font-bold uppercase tracking-wider text-primary">Parameter
                            Alternatif</span>
                        <span class="text-xs text-base-content/30">•</span>
                        <span class="text-xs text-base-content/50">Konversi Nilai Crisp SAW</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-base-content">Data Sub Kriteria</h1>
                    <p class="text-xs sm:text-sm text-base-content/65 mt-0.5">Kelola rentang opsi jawaban serta
                        standarisasi bobot rating skala 1–5.</p>
                </div>
            </div>

            <!-- Tombol Kembali ke Kriteria Induk -->
            <a href="{{ route('admin.kriteria.index') }}" class="btn btn-outline btn-sm rounded-xl gap-2 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Lihat Kriteria Induk
            </a>
        </div>

        <!-- 2. Flash Messages -->
        @if (session('success'))
            <div
                class="alert alert-success bg-success/15 border border-success/30 text-success shadow-sm rounded-2xl flex items-center gap-3 py-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div
                class="alert alert-error bg-error/15 border border-error/30 text-error shadow-sm rounded-2xl flex items-center gap-3 py-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        <!-- 3. Grid Form & Tabel Data -->
        <div class="grid items-start">
            <!-- Form Tambah (Kiri - Sticky) -->
            <div class="lg:col-span-4 sticky lg:top-20 z-10">
                <div class="card bg-base-100 shadow-sm border border-base-200/90 rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-base-200 bg-base-100/50 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-8 h-8 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <h2 class="text-base font-bold text-base-content">Tambah Opsi Baru</h2>
                        </div>
                        <span class="badge badge-sm badge-ghost text-xs">Form Input</span>
                    </div>

                    <div class="card-body p-5">
                        <form action="{{ route('admin.subkriteria.store') }}" method="POST" class="space-y-4">
                            @csrf

                            <!-- Dropdown Kriteria -->
                            <div class="form-control w-full space-y-1.5">
                                <label class="label p-0">
                                    <span
                                        class="label-text font-semibold text-xs uppercase tracking-wider text-base-content/70">
                                        Kriteria Induk <span class="text-error">*</span>
                                    </span>
                                </label>
                                <div class="relative">
                                    <select name="kriteria_id"
                                        class="select select-bordered w-full rounded-xl text-sm focus:border-primary focus:outline-none"
                                        required>
                                        <option value="" disabled selected>-- Pilih Kriteria Induk --</option>
                                        @foreach ($kriterias as $krit)
                                            <option value="{{ $krit->id }}">
                                                {{ $krit->kode_kriteria }} - {{ $krit->nama_kriteria }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Input Nama Subkriteria -->
                            <div class="form-control w-full space-y-1.5">
                                <label class="label p-0">
                                    <span
                                        class="label-text font-semibold text-xs uppercase tracking-wider text-base-content/70">
                                        Nama Opsi / Interval Jawaban <span class="text-error">*</span>
                                    </span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="nama_subkriteria"
                                        placeholder="Contoh: Rp 1.000.000 - Rp 3.000.000"
                                        class="input input-bordered w-full rounded-xl text-sm focus:border-primary focus:outline-none"
                                        required />
                                </div>
                            </div>

                            <!-- Input Nilai Rating -->
                            <div class="form-control w-full space-y-1.5">
                                <div class="flex items-center justify-between">
                                    <label class="label p-0">
                                        <span
                                            class="label-text font-semibold text-xs uppercase tracking-wider text-base-content/70">
                                            Nilai Rating (1–5) <span class="text-error">*</span>
                                        </span>
                                    </label>
                                    <span class="text-[11px] text-base-content/40 font-mono">Skala Crisp</span>
                                </div>
                                <div class="relative">
                                    <input type="number" name="nilai" min="1" max="5"
                                        placeholder="Nilai angka 1 - 5"
                                        class="input input-bordered w-full rounded-xl text-sm font-mono focus:border-primary focus:outline-none"
                                        required />
                                </div>
                                <span class="text-[11px] text-base-content/50">Makin tinggi angka, makin diprioritaskan
                                    (Benefit).</span>
                            </div>

                            <div class="pt-2">
                                <button type="submit"
                                    class="btn btn-primary w-full rounded-xl gap-2 font-bold shadow-md shadow-primary/20 hover:shadow-primary/30 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan Opsi Jawaban
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Data (Kanan) -->
        <div class="card bg-base-100 shadow-sm border border-base-200/90 rounded-3xl overflow-hidden md:col-span-2">
            <div class="card-body p-0">

                <!-- HEADER & FILTER BAR -->
                <div
                    class="p-4 sm:p-5 border-b border-base-200 bg-base-100/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5">
                        <div
                            class="w-8 h-8 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-base-content leading-tight">Daftar Opsi Jawaban</h2>
                            <span class="text-xs text-base-content/50">Total {{ count($subKriterias) }} data
                                terdaftar</span>
                        </div>
                    </div>

                    <!-- Form Filter Otomatis -->
                    <form action="{{ route('admin.subkriteria.index') }}" method="GET"
                        class="flex items-center gap-2 w-full sm:w-auto">
                        <div class="relative w-full sm:w-64">
                            <span
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                            </span>
                            <select name="filter_kriteria"
                                class="select select-bordered select-sm w-full pl-9 rounded-xl text-xs font-semibold text-slate-900 bg-white border-slate-300 focus:border-emerald-600 focus:outline-none"
                                onchange="this.form.submit()">
                                <option value="" class="text-slate-900 font-bold">-- Semua Kriteria Induk --</option>
                                @foreach ($kriterias as $krit)
                                    <option value="{{ $krit->id }}"
                                        {{ request('filter_kriteria') == $krit->id ? 'selected' : '' }} class="text-slate-900 font-medium">
                                        {{ $krit->kode_kriteria }} - {{ $krit->nama_kriteria }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tombol Reset Filter -->
                        @if (request('filter_kriteria'))
                            <a href="{{ route('admin.subkriteria.index') }}"
                                class="btn btn-sm btn-ghost text-rose-600 hover:bg-rose-50 rounded-xl px-2.5"
                                title="Reset Filter">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span class="text-xs font-bold">Reset</span>
                            </a>
                        @endif
                    </form>
                </div>

                <!-- TABEL DATA -->
                <div class="overflow-x-auto">
                    <table class="table table-hover w-full">
                        <thead
                            class="bg-base-200/50 text-base-content/70 text-xs uppercase tracking-wider border-b border-base-200">
                            <tr>
                                <th class="w-48">Kriteria Induk</th>
                                <th>Opsi Jawaban</th>
                                <th class="w-32 text-center">Nilai (Rating)</th>
                                <th class="w-24 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-base-200 text-sm">
                            @forelse ($subKriterias as $item)
                                <tr class="hover:bg-base-200/40 transition-colors">
                                    <!-- Kriteria Induk -->
                                    <td>
                                        <div class="flex items-start gap-2.5">
                                            <span
                                                class="badge badge-ghost font-mono font-bold text-xs px-2 py-1.5 rounded-lg bg-base-200 text-primary border border-base-300">
                                                {{ $item->kriteria->kode_kriteria }}
                                            </span>
                                            <div>
                                                <div
                                                    class="font-semibold text-xs sm:text-sm text-base-content leading-tight">
                                                    {{ $item->kriteria->nama_kriteria }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Opsi Jawaban -->
                                    <td>
                                        <div class="font-medium text-base-content">{{ $item->nama_subkriteria }}
                                        </div>
                                    </td>

                                    <!-- Nilai Rating -->
                                    <td class="text-center">
                                        <div
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl font-mono font-black text-xs bg-primary/10 text-primary border border-primary/20">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-3.5 w-3.5 text-warning fill-warning" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            {{ $item->nilai }}
                                        </div>
                                    </td>

                                    <!-- Aksi -->
                                    <td class="text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <!-- Edit -->
                                            <div class="tooltip tooltip-top" data-tip="Edit Opsi">
                                                <a href="{{ route('admin.subkriteria.edit', $item->id) }}"
                                                    class="btn btn-ghost btn-square btn-sm text-warning hover:bg-warning/10 rounded-lg transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            </div>

                                            <!-- Hapus -->
                                            <div class="tooltip tooltip-top" data-tip="Hapus Opsi">
                                                <form action="{{ route('admin.subkriteria.destroy', $item->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-ghost btn-square btn-sm text-error hover:bg-error/10 rounded-lg transition-colors"
                                                        onclick="return confirm('Hapus opsi ini?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-12">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <div class="p-3 bg-base-200 rounded-full text-base-content/40">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                            </div>
                                            <h3 class="text-base font-semibold text-base-content">Belum ada opsi
                                                jawaban</h3>
                                            <p class="text-xs text-base-content/60 max-w-sm">
                                                {{ request('filter_kriteria') ? 'Tidak ditemukan opsi untuk kriteria yang dipilih.' : 'Belum ada data sub kriteria yang ditambahkan.' }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>



    </div>
</x-admin-layout>
