<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('storage/logo.png') }}" alt="Logo MIS AL KAUTSAR" class="w-12 h-12 object-contain rounded-xl p-1 bg-white shadow-sm border border-gray-100" onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                <div>
                    <h2 class="font-extrabold text-2xl text-gray-900 leading-tight">
                        {{ __('Dashboard Kepala Sekolah') }}
                    </h2>
                    <p class="text-xs text-emerald-700 font-semibold mt-0.5">MIS AL KAUTSAR &bull; SPK Penentuan Penerima PIP (Metode SAW)</p>
                </div>
            </div>
            @if ($periodeAktif && $hasilSaws->isNotEmpty())
                <a href="{{ route('kepsek.laporan.pdf', ['periode_id' => $periodeAktif->id]) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Unduh Laporan Keputusan (PDF)
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Card Ringkasan Eksekutif -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Periode Seleksi</span>
                    <div class="text-lg font-black text-gray-900 mt-1">{{ $periodeAktif ? $periodeAktif->nama_periode : 'Belum Ada' }}</div>
                    <p class="text-xs text-blue-600 font-semibold mt-1">{{ $periodeAktif ? 'T.A ' . $periodeAktif->tahun_ajaran : '-' }}</p>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Total Alternatif Pendaftar</span>
                    <div class="text-2xl font-black text-gray-900 mt-1">{{ $totalSiswa }}</div>
                    <p class="text-xs text-gray-500 mt-1">Calon penerima terdata</p>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Siswa Dinyatakan Lolos</span>
                    <div class="text-2xl font-black text-emerald-600 mt-1">{{ $totalLolos }}</div>
                    <p class="text-xs text-gray-500 mt-1">Sesuai kuota rekomendasi</p>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Status Validasi</span>
                    <div class="text-lg font-black text-gray-900 mt-1">
                        {{ $hasilSaws->isNotEmpty() ? 'Siap Disahkan' : 'Menunggu Admin' }}
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $hasilSaws->count() }} siswa selesai dihitung</p>
                </div>
            </div>

            <!-- Tabel Hasil Seleksi untuk Pengesahan Kepala Sekolah -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="font-black text-lg text-gray-900">Daftar Hasil Perangkingan Seleksi PIP</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Hasil kalkulasi obyektif berbasis metode SAW berdasarkan bobot indikator kriteria.</p>
                    </div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Hasil Resmi</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-700">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold">
                            <tr>
                                <th class="py-3 px-6 text-center w-16">Rank</th>
                                <th class="py-3 px-6">NIS & Nama Siswa</th>
                                <th class="py-3 px-6">Kelas</th>
                                <th class="py-3 px-6">Nama Orang Tua / Wali</th>
                                <th class="py-3 px-6 font-mono">Skor Preferensi (V)</th>
                                <th class="py-3 px-6">Status Rekomendasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($hasilSaws as $item)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 text-center font-bold text-gray-900">
                                        #{{ $item->peringkat }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-gray-900">{{ $item->siswa->nama }}</div>
                                        <div class="text-xs text-gray-400 font-mono">NIS: {{ $item->siswa->nis }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-gray-100 text-gray-800">
                                            {{ $item->siswa->kelas }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-xs text-gray-600">
                                        {{ $item->siswa->nama_ortu }}
                                    </td>
                                    <td class="py-4 px-6 font-mono font-bold text-blue-600">
                                        {{ number_format($item->nilai_akhir, 4) }}
                                    </td>
                                    <td class="py-4 px-6">
                                        @if ($item->status_penerimaan === 'Lolos')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Lolos PIP
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                Tidak Lolos
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-gray-400">
                                        Belum ada hasil kalkulasi SAW yang disahkan oleh Admin Tata Usaha untuk periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
