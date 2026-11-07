<x-admin-layout>
    <div class="space-y-6 pb-10">

        <!-- 1. Header Halaman & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="p-2.5 rounded-2xl bg-primary/10 text-primary mt-1 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="text-xs font-bold uppercase tracking-wider text-primary">Matriks Keputusan</span>
                        <span class="text-xs text-base-content/30">•</span>
                        <span class="text-xs text-base-content/50">Bobot SAW (W)</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-base-content">Data Kriteria</h1>
                    <p class="text-xs sm:text-sm text-base-content/65 mt-0.5">Atur indikator penilaian, kategori
                        benefit/cost, dan alokasi total bobot 100%.</p>
                </div>
            </div>

            <div class="tooltip tooltip-bottom sm:tooltip-left"
                data-tip="{{ $totalBobot >= 100 ? 'Total bobot sudah 100%, tidak dapat menambah kriteria lagi' : 'Tambah kriteria baru' }}">
                <a href="{{ route('admin.kriteria.create') }}"
                    class="btn btn-primary rounded-xl gap-2 shadow-sm {{ $totalBobot >= 100 ? 'btn-disabled opacity-50' : 'shadow-primary/20 hover:shadow-primary/30' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Kriteria
                </a>
            </div>
        </div>

        <!-- 2. Flash Messages (Alert Sukses & Error) -->
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

        <!-- 3. Smart Weight Indicator Card -->
        <div class="card bg-base-100 shadow-sm border border-base-200/90 rounded-2xl p-5 sm:p-6 transition-all">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                <div class="space-y-1">
                    <div class="flex items-center gap-2.5">
                        <h2 class="text-base sm:text-lg font-extrabold text-base-content">
                            Total Bobot Terkumpul:
                        </h2>
                        <span
                            class="text-xl sm:text-2xl font-black font-mono {{ $totalBobot == 100 ? 'text-success' : 'text-warning' }}">
                            {{ $totalBobot }}%
                        </span>
                        @if ($totalBobot == 100)
                            <span class="badge badge-success badge-sm text-white font-bold gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Seimbang
                            </span>
                        @else
                            <span class="badge badge-warning badge-sm text-white font-bold gap-1">
                                Belum 100%
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-base-content/60 leading-relaxed">
                        @if ($totalBobot == 100)
                            Seluruh bobot telah genap 100%. Algoritma normalisasi SAW siap dijalankan secara valid.
                        @else
                            Sisa bobot yang belum teralokasi: <span
                                class="font-bold font-mono text-base-content">{{ 100 - $totalBobot }}%</span>. Sesuaikan
                            kembali bobot kriteria.
                        @endif
                    </p>
                </div>

                <!-- Progress Bar & Indicator -->
                <div class="w-full lg:w-72 space-y-1.5">
                    <div class="flex justify-between text-xs font-mono font-medium text-base-content/60">
                        <span>0%</span>
                        <span>50%</span>
                        <span>100%</span>
                    </div>
                    <progress
                        class="progress {{ $totalBobot == 100 ? 'progress-success' : 'progress-warning' }} h-2.5 w-full bg-base-200"
                        value="{{ $totalBobot }}" max="100"></progress>
                </div>
            </div>
        </div>

        <!-- 4. Table Card Konten -->
        <div class="card bg-base-100 shadow-sm border border-base-200/90 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table table-hover w-full">
                    <thead
                        class="bg-base-200/50 text-base-content/70 text-xs uppercase tracking-wider border-b border-base-200">
                        <tr>
                            <th class="w-24 text-center">Kode</th>
                            <th>Nama Kriteria</th>
                            <th class="w-36">Tipe Karakteristik</th>
                            <th class="w-48">Bobot (%)</th>
                            <th class="w-36 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-base-200 text-sm">
                        @forelse ($kriterias as $item)
                            <tr class="hover:bg-base-200/40 transition-colors">
                                <!-- Kode Kriteria -->
                                <td class="text-center">
                                    <span
                                        class="badge badge-ghost font-mono font-bold text-xs px-2.5 py-2 rounded-lg bg-base-200 text-base-content">
                                        {{ $item->kode_kriteria }}
                                    </span>
                                </td>

                                <!-- Nama Kriteria -->
                                <td>
                                    <div class="font-bold text-base-content">{{ $item->nama_kriteria }}</div>
                                    <span class="text-xs text-base-content/40">Alternatif Penilaian PIP</span>
                                </td>

                                <!-- Tipe Kriteria (Benefit / Cost) -->
                                <td>
                                    @if ($item->tipe == 'benefit')
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-success/15 text-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                            </svg>
                                            Benefit
                                        </div>
                                    @else
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-error/15 text-error">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                            </svg>
                                            Cost
                                        </div>
                                    @endif
                                </td>

                                <!-- Bobot Kriteria -->
                                <td>
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="font-mono font-extrabold text-sm text-primary w-12">{{ $item->bobot }}%</span>
                                        <div class="w-24 bg-base-200 h-2 rounded-full overflow-hidden hidden sm:block">
                                            <div class="bg-primary h-full rounded-full"
                                                style="width: {{ $item->bobot }}%"></div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Aksi (Sub Kriteria & Edit) -->
                                <!-- Aksi (Sub Kriteria & Edit) -->
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <!-- Tombol Sub Kriteria (Selalu Aktif) -->
                                        <div class="tooltip tooltip-top" data-tip="Kelola Sub Kriteria">
                                            <a href="{{ route('admin.subkriteria.index') }}"
                                                class="btn btn-ghost btn-sm text-xs font-semibold gap-1.5 rounded-lg text-primary hover:bg-primary/10 transition-colors {{ request()->routeIs('admin.subkriteria.*') ? 'active' : '' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                                </svg>
                                                <span class="hidden md:inline">Sub Kriteria</span>
                                            </a>
                                        </div>

                                        <!-- Tombol Edit (SELALU AKTIF, meski total bobot sudah 100%) -->
                                        <div class="tooltip tooltip-top" data-tip="Edit Nama, Tipe & Bobot Kriteria">
                                            <a href="{{ route('admin.kriteria.edit', $item->id) }}"
                                                class="btn btn-ghost btn-square btn-sm text-warning hover:bg-warning/10 rounded-lg transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        </div>

                                        <form action="{{ route('admin.kriteria.destroy', $item->id) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-error join-item text-white"
                                                onclick="return confirm('Hapus Kriteria ini? Semua opsi jawaban di dalamnya juga akan terhapus!')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <div class="p-3 bg-base-200 rounded-full text-base-content/40">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <h3 class="text-base font-semibold text-base-content">Belum ada data kriteria
                                        </h3>
                                        <p class="text-xs text-base-content/60 max-w-sm">Mulai definisikan parameter
                                            kriteria seleksi seperti Penghasilan Orang Tua, Jumlah Tanggungan, dan
                                            Prestasi.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Summary -->
            @if (count($kriterias) > 0)
                <div
                    class="p-4 border-t border-base-200 bg-base-100 flex flex-col sm:flex-row items-center justify-between text-xs text-base-content/60 gap-2">
                    <div>
                        Menampilkan <span class="font-bold text-base-content">{{ count($kriterias) }}</span> kriteria
                        aktif
                    </div>
                    <div class="text-xs text-base-content/50">
                        * Tipe <strong>Benefit</strong> bernilai makin baik jika tinggi, tipe <strong>Cost</strong>
                        bernilai makin baik jika rendah
                    </div>
                </div>
            @endif
        </div>

    </div>
</x-admin-layout>
