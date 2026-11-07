<x-admin-layout>
    <div class="space-y-6">

        <!-- 1. Header Halaman & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="p-2.5 rounded-xl bg-primary/10 text-primary mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-base-content">Data Periode</h1>
                    <p class="text-sm text-base-content/65 mt-0.5">Kelola tahun ajaran, kuota, dan status aktif seleksi
                        SPK PIP.</p>
                </div>
            </div>

            <a href="{{ route('admin.periode.create') }}" class="btn btn-primary gap-2 shadow-sm rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Periode
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success mb-6 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 text-white"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-white font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-error mb-6 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6 text-white"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-white font-medium">{{ session('error') }}</span>
            </div>
        @endif
        <!-- 2. Card Konten: Filter Toolbar + Tabel -->
        <div class="card bg-base-100 shadow-sm border border-base-200 rounded-2xl overflow-hidden">

            <!-- Toolbar Filter & Search -->
            <div class="p-4 sm:p-5 border-b border-slate-200 bg-slate-50/70">
                <form method="GET" class="flex flex-col md:flex-row gap-3 items-center justify-between">
                    <!-- Search Input -->
                    <div class="relative w-full md:w-80">
                        <span
                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama periode / TA..."
                            class="input input-sm input-bordered w-full pl-9 rounded-xl font-semibold text-slate-900 bg-white border-slate-300 placeholder:text-slate-400 focus:border-emerald-600 focus:outline-none" />
                    </div>

                    <!-- Filter Dropdown & Reset -->
                    <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                        <div class="relative w-full sm:w-44">
                            <select name="status_aktif"
                                class="select select-sm select-bordered w-full rounded-xl text-xs font-semibold text-slate-900 bg-white border-slate-300 focus:border-emerald-600 focus:outline-none">
                                <option value="" class="text-slate-900 font-bold">Semua Status</option>
                                <option value="1" {{ request('status_aktif') === '1' ? 'selected' : '' }} class="text-slate-900 font-medium">Aktif
                                </option>
                                <option value="0" {{ request('status_aktif') === '0' ? 'selected' : '' }} class="text-slate-900 font-medium">Tidak
                                    Aktif</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-sm btn-primary rounded-xl gap-1.5 font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filter
                        </button>

                        @if (request()->filled('search') || request()->filled('status_aktif'))
                            <a href="{{ url()->current() }}"
                                class="btn btn-sm btn-ghost text-slate-600 hover:text-rose-600 rounded-xl">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            <!-- Tabel Data -->
            <div class="overflow-x-auto">
                <table class="table table-hover w-full">
                    <thead
                        class="bg-base-200/50 text-base-content/70 text-xs uppercase tracking-wider border-b border-base-200">
                        <tr>
                            <th class="w-16 text-center">No</th>
                            <th>Nama Periode</th>
                            <th>Tahun Ajaran</th>
                            <th class="w-36 text-center">Status</th>
                            <th class="w-32 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-base-200 text-sm">
                        @forelse ($periodes as $index => $item)
                            <tr class="hover:bg-base-200/40 transition-colors">
                                <td class="text-center font-mono text-xs text-base-content/60">{{ $index + 1 }}</td>

                                <td>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-base-200 flex items-center justify-center text-primary font-bold text-xs">
                                            {{ strtoupper(substr($item->nama_periode, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-base-content">{{ $item->nama_periode }}</div>
                                            <div class="text-xs text-base-content/50">ID Periode: #{{ $item->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge badge-ghost badge-sm font-medium font-mono text-base-content/80">
                                        {{ $item->tahun_ajaran }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    @if ($item->status_aktif)
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-success/15 text-success">
                                            <span class="w-1.5 h-1.5 rounded-full bg-success animate-pulse"></span>
                                            Aktif
                                        </div>
                                    @else
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-base-200 text-base-content/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-base-content/30"></span>
                                            Tidak Aktif
                                        </div>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <!-- Trigger Button Detail dengan Tooltip & Ikon Modern -->
                                        <div class="tooltip tooltip-top" data-tip="Lihat Detail">
                                            <label for="detail_modal_{{ $item->id }}"
                                                class="btn btn-ghost btn-square btn-sm text-info hover:bg-info/10 rounded-lg cursor-pointer transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </label>
                                        </div>

                                        <!-- Checkbox Toggle Modal -->
                                        <input type="checkbox" id="detail_modal_{{ $item->id }}"
                                            class="modal-toggle" />
                                        <div class="modal modal-bottom sm:modal-middle" role="dialog">
                                            <div
                                                class="modal-box p-0 bg-base-100 rounded-3xl border border-base-200/90 shadow-2xl overflow-hidden max-w-lg">

                                                <!-- Header Modal -->
                                                <div
                                                    class="p-6 border-b border-base-200 bg-base-200/30 flex items-center justify-between">
                                                    <div class="flex items-center gap-3">
                                                        <div
                                                            class="w-10 h-10 rounded-2xl bg-primary/10 text-primary flex items-center justify-center font-bold">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h3
                                                                class="font-extrabold text-base sm:text-lg text-base-content leading-tight">
                                                                Detail Periode Seleksi
                                                            </h3>
                                                            <p class="text-xs text-base-content/50">Parameter sistem
                                                                dan log waktu pembuatan</p>
                                                        </div>
                                                    </div>

                                                    <!-- Tombol X Silang Cepat -->
                                                    <label for="detail_modal_{{ $item->id }}"
                                                        class="btn btn-ghost btn-circle btn-sm text-base-content/50 hover:text-base-content hover:bg-base-200/60 transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </label>
                                                </div>

                                                <!-- Body: Data Breakdown -->
                                                <div class="p-6 space-y-3">

                                                    <!-- Nama Periode -->
                                                    <div
                                                        class="flex items-center justify-between p-3.5 rounded-2xl bg-base-200/30 border border-base-200/60">
                                                        <div class="flex items-center gap-2.5 text-base-content/70">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="w-4 h-4 text-base-content/40" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor"
                                                                stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                            </svg>
                                                            <span
                                                                class="text-xs font-semibold uppercase tracking-wider">Nama
                                                                Periode</span>
                                                        </div>
                                                        <span
                                                            class="font-bold text-sm text-base-content text-right">{{ $item->nama_periode }}</span>
                                                    </div>

                                                    <!-- Tahun Ajaran -->
                                                    <div
                                                        class="flex items-center justify-between p-3.5 rounded-2xl bg-base-200/30 border border-base-200/60">
                                                        <div class="flex items-center gap-2.5 text-base-content/70">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="w-4 h-4 text-base-content/40" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor"
                                                                stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            <span
                                                                class="text-xs font-semibold uppercase tracking-wider">Tahun
                                                                Ajaran</span>
                                                        </div>
                                                        <span
                                                            class="font-mono font-semibold text-sm text-base-content px-2.5 py-0.5 rounded-lg bg-base-100 border border-base-200">
                                                            {{ $item->tahun_ajaran }}
                                                        </span>
                                                    </div>

                                                    <!-- Status Aktif -->
                                                    <div
                                                        class="flex items-center justify-between p-3.5 rounded-2xl bg-base-200/30 border border-base-200/60">
                                                        <div class="flex items-center gap-2.5 text-base-content/70">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="w-4 h-4 text-base-content/40" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor"
                                                                stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <span
                                                                class="text-xs font-semibold uppercase tracking-wider">Status
                                                                Seleksi</span>
                                                        </div>
                                                        <div>
                                                            @if ($item->status_aktif)
                                                                <div
                                                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-success/15 text-success">
                                                                    <span class="relative flex h-2 w-2">
                                                                        <span
                                                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-success opacity-75"></span>
                                                                        <span
                                                                            class="relative inline-flex rounded-full h-2 w-2 bg-success"></span>
                                                                    </span>
                                                                    Aktif
                                                                </div>
                                                            @else
                                                                <div
                                                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-base-200 text-base-content/60">
                                                                    <span
                                                                        class="w-1.5 h-1.5 rounded-full bg-base-content/30"></span>
                                                                    Tidak Aktif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <!-- Dibuat Pada -->
                                                    <div
                                                        class="flex items-center justify-between p-3.5 rounded-2xl bg-base-200/30 border border-base-200/60">
                                                        <div class="flex items-center gap-2.5 text-base-content/70">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="w-4 h-4 text-base-content/40" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor"
                                                                stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <span
                                                                class="text-xs font-semibold uppercase tracking-wider">Dibuat
                                                                Pada</span>
                                                        </div>
                                                        <span
                                                            class="font-mono text-xs text-base-content/70">{{ $item->created_at->format('d M Y, H:i') }}
                                                            WITA</span>
                                                    </div>

                                                </div>

                                                <!-- Footer / Action Area -->
                                                <div
                                                    class="p-4 sm:p-5 border-t border-base-200 bg-base-100 flex items-center justify-end">
                                                    <label for="detail_modal_{{ $item->id }}"
                                                        class="btn btn-neutral btn-sm rounded-xl px-5 font-semibold">
                                                        Selesai
                                                    </label>
                                                </div>

                                            </div>

                                            <!-- Backdrop untuk menutup modal saat klik di luar kotak -->
                                            <label class="modal-backdrop bg-base-content/30 backdrop-blur-sm"
                                                for="detail_modal_{{ $item->id }}">Close</label>
                                        </div>

                                        <!-- Edit Action -->
                                        <div class="tooltip tooltip-top" data-tip="Edit Periode">
                                            <a href="{{ route('admin.periode.edit', $item->id) }}"
                                                class="btn btn-ghost btn-square btn-sm text-warning hover:bg-warning/10 rounded-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        </div>

                                        <!-- Delete Action -->
                                        @if ($item->penilaians()->exists() || $item->status_aktif)
                                            <!-- Tombol Hapus Disabled (Terkunci) -->
                                            <div class="tooltip tooltip-top"
                                                data-tip="{{ $item->status_aktif ? 'Tidak bisa dihapus: Periode sedang aktif' : 'Tidak bisa dihapus: Ada histori penilaian' }}">
                                                <button type="button"
                                                    class="btn btn-ghost btn-square btn-sm text-base-content/25 bg-base-200/40 cursor-not-allowed rounded-lg"
                                                    disabled>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="1.8">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @else
                                            <!-- Tombol Hapus Aktif (Periode Kosong / Belum Ada Relasi) -->
                                            <div class="tooltip tooltip-top" data-tip="Hapus Periode Kosong">
                                                <form action="{{ route('admin.periode.destroy', $item->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-ghost btn-square btn-sm text-error hover:bg-error/10 rounded-lg transition-colors"
                                                        onclick="return confirm('Yakin ingin menghapus periode kosong ini?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <div class="p-3 bg-base-200 rounded-full text-base-content/40">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-base font-semibold text-base-content">Belum ada data periode
                                        </h3>
                                        <p class="text-xs text-base-content/60 max-w-sm">Mulai tambahkan tahun ajaran
                                            atau periode seleksi baru untuk proses perhitungan SAW.</p>
                                        <a href="{{ route('admin.periode.create') }}"
                                            class="btn btn-sm btn-primary mt-2 rounded-lg gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Tambah Data Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Optional: Footer Table Summary -->
            @if (count($periodes) > 0)
                <div
                    class="p-4 border-t border-base-200 bg-base-100 flex flex-col sm:flex-row items-center justify-between text-xs text-base-content/60 gap-2">
                    <div>
                        Menampilkan <span class="font-bold text-base-content">{{ count($periodes) }}</span> periode
                        terdaftar
                    </div>
                    <div class="text-xs text-base-content/50">
                        * Periode aktif akan otomatis menjadi rujukan saat penilaian siswa
                    </div>
                </div>
            @endif

        </div>

    </div>
</x-admin-layout>
