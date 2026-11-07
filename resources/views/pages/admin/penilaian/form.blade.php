<x-admin-layout>
    <div class="space-y-6 max-w-4xl mx-auto pb-12">

        <!-- Header & Breadcrumb -->
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.penilaian.index') }}" class="btn btn-circle btn-ghost btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-base-content">Form Evaluasi Penilaian Siswa</h1>
                <p class="text-xs text-base-content/60">
                    Periode Aktif: <span class="font-bold text-primary">{{ $periodeAktif->nama_periode }} ({{ $periodeAktif->tahun_ajaran }})</span>
                </p>
            </div>
        </div>

        <!-- Student Summary Card -->
        <div class="card bg-base-100 shadow-sm border border-base-200/90 rounded-2xl p-5 flex flex-col sm:flex-row items-center gap-4">
            <div class="avatar placeholder">
                <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary overflow-hidden ring-1 ring-primary/20">
                    @if ($siswa->foto && Storage::disk('public')->exists($siswa->foto))
                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama }}" class="object-cover w-full h-full" />
                    @else
                        <span class="text-lg font-bold">{{ strtoupper(substr($siswa->nama, 0, 2)) }}</span>
                    @endif
                </div>
            </div>
            <div class="space-y-1 text-center sm:text-left flex-1">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                    <h2 class="text-lg font-extrabold text-base-content">{{ $siswa->nama }}</h2>
                    <span class="badge badge-neutral badge-sm">{{ $siswa->kelas }}</span>
                </div>
                <div class="text-xs text-base-content/60 flex flex-wrap items-center justify-center sm:justify-start gap-3">
                    <span>NIS: <strong class="font-mono text-base-content/80">{{ $siswa->nis }}</strong></span>
                    <span>•</span>
                    <span>Nama Ortu: <strong class="text-base-content/80">{{ $siswa->nama_ortu }}</strong></span>
                    <span>•</span>
                    <span>JK: <strong class="text-base-content/80">{{ $siswa->jk === 'L' ? 'Laki-laki' : 'Perempuan' }}</strong></span>
                </div>
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

        <!-- Form Kriteria & Sub Kriteria -->
        <div class="card bg-base-100 shadow-sm border border-base-200/90 rounded-2xl p-6 sm:p-8">
            <form method="POST" action="{{ route('admin.penilaian.update', $siswa->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    @foreach ($kriterias as $kriteria)
                        @php
                            $selectedSub = old("kriteria.{$kriteria->id}", $existingPenilaians[$kriteria->id] ?? '');
                        @endphp
                        <div class="p-4 sm:p-5 rounded-2xl bg-base-200/30 border border-base-200 hover:border-primary/30 transition-all">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="badge badge-primary font-bold text-xs">{{ $kriteria->kode_kriteria }}</span>
                                    <h3 class="font-bold text-base text-base-content">{{ $kriteria->nama_kriteria }}</h3>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="badge {{ $kriteria->tipe === 'benefit' ? 'badge-success text-white' : 'badge-warning text-white' }} badge-xs font-semibold uppercase">
                                        {{ $kriteria->tipe }}
                                    </span>
                                    <span class="text-xs font-semibold text-base-content/60">Bobot: {{ $kriteria->bobot }}%</span>
                                </div>
                            </div>

                            @if ($kriteria->keterangan)
                                <p class="text-xs text-base-content/50 mb-3">{{ $kriteria->keterangan }}</p>
                            @endif

                            <div class="form-control">
                                <select name="kriteria[{{ $kriteria->id }}]" required
                                    class="select select-bordered select-sm sm:select-md rounded-xl w-full focus:outline-primary bg-base-100">
                                    <option value="">-- Pilih Indikator / Opsi Nilai --</option>
                                    @foreach ($kriteria->subKriterias as $sub)
                                        <option value="{{ $sub->id }}" {{ (string) $selectedSub === (string) $sub->id ? 'selected' : '' }}>
                                            {{ $sub->nama_subkriteria }} (Skor: {{ $sub->nilai }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Submit / Cancel -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-base-200">
                    <a href="{{ route('admin.penilaian.index') }}" class="btn btn-ghost btn-sm sm:btn-md rounded-xl">Batal</a>
                    <button type="submit" class="btn btn-primary btn-sm sm:btn-md rounded-xl px-6 gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Penilaian
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-admin-layout>
