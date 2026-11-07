<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('storage/logo.png') }}" alt="Logo MIS AL KAUTSAR" class="w-12 h-12 object-contain rounded-xl p-1 bg-white shadow-sm border border-gray-100" onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                <div>
                    <h2 class="font-extrabold text-2xl text-gray-900 leading-tight">
                        {{ __('Portal Informasi Orang Tua / Wali Siswa') }}
                    </h2>
                    <p class="text-xs text-emerald-700 font-semibold mt-0.5">MIS AL KAUTSAR &bull; Transparansi Penyaluran Bantuan Program Indonesia Pintar (PIP)</p>
                </div>
            </div>
            @if ($periodeAktif)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                    Periode: {{ $periodeAktif->nama_periode }}
                </span>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- 1. KARTU HASIL SELEKSI ANAK SAYA -->
            @if ($hasilAnak->isNotEmpty())
                <div class="space-y-4">
                    <h3 class="font-black text-lg text-gray-900 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        Status Seleksi Putra / Putri Anda
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($hasilAnak as $item)
                            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between relative overflow-hidden">
                                <div class="flex items-start gap-4">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-100 overflow-hidden ring-1 ring-gray-200 shrink-0">
                                        @if ($item->siswa->foto && Storage::disk('public')->exists($item->siswa->foto))
                                            <img src="{{ asset('storage/' . $item->siswa->foto) }}" alt="{{ $item->siswa->nama }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center font-bold text-gray-400 text-lg">
                                                {{ strtoupper(substr($item->siswa->nama, 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-extrabold text-base text-gray-900">{{ $item->siswa->nama }}</h4>
                                            <span class="px-2 py-0.5 text-xs font-semibold rounded bg-gray-100 text-gray-700">{{ $item->siswa->kelas }}</span>
                                        </div>
                                        <p class="text-xs text-gray-500 font-mono">NIS: {{ $item->siswa->nis }}</p>
                                        <p class="text-xs text-gray-500">Orang Tua / Wali: <strong>{{ $item->siswa->nama_ortu }}</strong></p>
                                    </div>
                                </div>

                                <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                                    <div>
                                        <span class="text-xs text-gray-400 block font-medium">Peringkat & Skor SAW</span>
                                        <span class="font-black text-gray-900 text-lg">#{{ $item->peringkat }} <span class="text-xs font-mono text-blue-600 font-bold">({{ number_format($item->nilai_akhir, 4) }})</span></span>
                                    </div>

                                    <div>
                                        @if ($item->status_penerimaan === 'Lolos')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-extrabold bg-emerald-500 text-white shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Lolos Bantuan PIP
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-gray-100 text-gray-600">
                                                Belum Masuk Kuota
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- Banner Pencarian Cek NIS jika Akun Belum Ditautkan -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-6 sm:p-8 text-white shadow-md">
                    <div class="max-w-2xl space-y-3">
                        <span class="px-3 py-1 bg-white/20 text-white text-xs font-bold rounded-full uppercase tracking-wider">Cek Status Penerima</span>
                        <h3 class="text-2xl font-black">Cari Status Pengajuan PIP Siswa</h3>
                        <p class="text-sm text-white/90">
                            Masukkan Nomor Induk Siswa (NIS) putra/putri Anda untuk memeriksa hasil perhitungan seleksi Program Indonesia Pintar.
                        </p>

                        <form method="GET" action="{{ route('ortu.dashboard') }}" class="pt-2 flex flex-col sm:flex-row gap-2 max-w-md">
                            <input type="text" name="nis" value="{{ request('nis') }}" required placeholder="Masukkan Nomor NIS siswa..."
                                class="px-4 py-2.5 rounded-xl text-gray-900 text-sm focus:outline-none flex-1 shadow-sm" />
                            <button type="submit" class="px-5 py-2.5 bg-gray-900 hover:bg-black font-bold text-sm rounded-xl transition shadow-sm">
                                Periksa Status
                            </button>
                        </form>

                        @if (request()->filled('nis') && !$searchSiswa)
                            <p class="text-xs text-rose-200 mt-2 font-semibold">
                                Data siswa dengan nomor NIS {{ request('nis') }} tidak ditemukan. Harap periksa kembali nomor NIS Anda.
                            </p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- 2. PENGUMUMAN SELEKSI UMUM DENGAN DATA MASKING (KEAMANAN PRIVASI) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <h3 class="font-black text-lg text-gray-900">Pengumuman Transparansi Seleksi PIP</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Demi menjaga privasi siswa, data nama dan NISN pada daftar publik disamarkan (*Data Masking*).</p>
                    </div>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">
                        Data Masked
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-700">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold">
                            <tr>
                                <th class="py-3 px-6 text-center w-16">Rank</th>
                                <th class="py-3 px-6">Nama Siswa (Disamarkan)</th>
                                <th class="py-3 px-6">NIS</th>
                                <th class="py-3 px-6">Kelas</th>
                                <th class="py-3 px-6 font-mono">Skor SAW (V)</th>
                                <th class="py-3 px-6">Status Rekomendasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($pengumumanUmum as $item)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="py-4 px-6 text-center font-bold text-gray-900">
                                        #{{ $item['peringkat'] }}
                                    </td>
                                    <td class="py-4 px-6 font-mono font-semibold text-gray-800">
                                        {{ $item['masked_nama'] }}
                                    </td>
                                    <td class="py-4 px-6 font-mono text-xs text-gray-400">
                                        {{ $item['masked_nis'] }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-gray-100 text-gray-800">
                                            {{ $item['kelas'] }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 font-mono font-bold text-blue-600">
                                        {{ number_format($item['nilai_akhir'], 4) }}
                                    </td>
                                    <td class="py-4 px-6">
                                        @if ($item['status_penerimaan'] === 'Lolos')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Lolos PIP
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                                Tidak Lolos
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-gray-400">
                                        Pengumuman seleksi belum diterbitkan untuk periode ini.
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
