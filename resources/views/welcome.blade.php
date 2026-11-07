<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MIS AL KAUTSAR - Sistem Pendukung Keputusan Seleksi PIP Metode SAW</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('storage/logo.png') }}" onerror="this.onerror=null; this.href='{{ asset('logo.png') }}';">

    <!-- Fonts: Standar Tipografi Instansi Pemerintah / Dinas (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.23/dist/full.min.css" rel="stylesheet" type="text/css" />
</head>
<body class="font-sans antialiased text-gray-800 bg-slate-50 selection:bg-emerald-600 selection:text-white">

    <!-- 1. TOP ANNOUNCEMENT BAR -->
    <div class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 text-white text-xs py-2 px-4 border-b border-emerald-700/50">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-400 text-gray-950 uppercase tracking-wider">
                    Resmi
                </span>
                <span>Madrasah Ibtidaiyah Swasta (MIS) AL KAUTSAR &bull; Kemenag RI</span>
            </div>
            <div class="flex items-center gap-4 text-emerald-200 text-[11px]">
                @if ($periodeAktif)
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Periode Berjalan: <strong class="text-white">{{ $periodeAktif->nama_periode }}</strong> ({{ $periodeAktif->tahun_ajaran }})
                    </span>
                @else
                    <span>Belum ada periode seleksi aktif</span>
                @endif
            </div>
        </div>
    </div>

    <!-- 2. NAVBAR UTAMA -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand & Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-3.5 group">
                    <div class="w-12 h-12 p-1 rounded-2xl bg-white shadow-md border border-emerald-100 group-hover:scale-105 transition-transform flex items-center justify-center">
                        <img src="{{ asset('storage/logo.png') }}" alt="Logo MIS AL KAUTSAR" class="w-full h-full object-contain" onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                    </div>
                    <div>
                        <span class="block text-lg font-black text-gray-900 tracking-tight leading-none">MIS AL KAUTSAR</span>
                        <span class="block text-xs font-semibold text-emerald-700 tracking-wide mt-1">SPK Program Indonesia Pintar</span>
                    </div>
                </a>

                <!-- Navigation Links (Desktop) -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-gray-600">
                    <a href="#beranda" class="hover:text-emerald-700 transition">Beranda</a>
                    <a href="#tentang" class="hover:text-emerald-700 transition">Tentang PIP</a>
                    <a href="#kriteria" class="hover:text-emerald-700 transition">Kriteria SAW</a>
                    <a href="#alur" class="hover:text-emerald-700 transition">Alur Seleksi</a>
                    <a href="#kontak" class="hover:text-emerald-700 transition">Kontak</a>
                </nav>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Buka Dashboard ({{ Auth::user()->name }})
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/25 hover:shadow-lg transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Masuk ke Sistem
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- 3. HERO SECTION -->
    <section id="beranda" class="relative overflow-hidden pt-12 pb-20 lg:pt-20 lg:pb-28 bg-gradient-to-b from-white via-emerald-50/30 to-slate-50">
        <!-- Background Blur Spheres -->
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-gradient-to-tr from-emerald-200/40 via-teal-100/40 to-transparent blur-3xl pointer-events-none -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

                <!-- Left Column: Copywriting -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100/80 border border-emerald-200 text-emerald-800 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        Sistem Pendukung Keputusan (SPK) Berbasis SAW
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-950 tracking-tight leading-[1.15]">
                        Penyaluran Bantuan PIP yang <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-700 via-teal-600 to-emerald-800">Obyektif & Tepat Sasaran</span> di MIS AL KAUTSAR
                    </h1>

                    <p class="text-base sm:text-lg text-gray-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Memastikan setiap siswa berhak dan membutuhkan mendapatkan hak bantuan pendidikan Program Indonesia Pintar (PIP) secara transparan, akuntabel, dan bebas dari pertimbangan subyektif menggunakan metode perhitungan matematis <em>Simple Additive Weighting</em>.
                    </p>

                    <!-- CTA Actions -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm shadow-xl shadow-emerald-600/25 hover:shadow-2xl transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Masuk Portal Seleksi
                        </a>
                        <a href="#kriteria" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-white hover:bg-slate-100 text-gray-800 font-bold text-sm border border-slate-200 shadow-sm transition">
                            Lihat 5 Kriteria Penilaian
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                    </div>

                    <!-- Mini Trust Badges -->
                    <div class="pt-4 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-xs text-gray-500 font-medium">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            100% Bebas Rekayasa
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Data Masking Privasi Ortu
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            SK Pengesahan DomPDF
                        </div>
                    </div>
                </div>

                <!-- Right Column: School Showcase Card -->
                <div class="lg:col-span-5">
                    <div class="relative mx-auto max-w-md">
                        <!-- Glow behind card -->
                        <div class="absolute -inset-1.5 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-3xl blur-lg opacity-30"></div>

                        <div class="relative bg-white rounded-3xl p-6 sm:p-8 shadow-2xl border border-slate-100 space-y-6">
                            <!-- Card Header: Madrasah Emblem -->
                            <div class="text-center space-y-3 pb-6 border-b border-slate-100">
                                <div class="w-24 h-24 mx-auto p-2 rounded-2xl bg-gradient-to-b from-emerald-50 to-white shadow-inner border border-emerald-100 flex items-center justify-center">
                                    <img src="{{ asset('storage/logo.png') }}" alt="Logo MIS AL KAUTSAR" class="w-full h-full object-contain" onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                                </div>
                                <div>
                                    <h3 class="text-xl font-black text-gray-950">MIS AL KAUTSAR</h3>
                                    <p class="text-xs font-semibold text-emerald-700 uppercase tracking-widest mt-0.5">Madrasah Ibtidaiyah Swasta</p>
                                    <p class="text-[11px] text-gray-400 mt-1 italic">"Membentuk Generasi Qurani, Cerdas, dan Berakhlakul Karimah"</p>
                                </div>
                            </div>

                            <!-- Live Statistics Mini Widget -->
                            <div class="grid grid-cols-2 gap-3 text-center">
                                <div class="p-3.5 rounded-2xl bg-emerald-50/60 border border-emerald-100">
                                    <span class="text-[11px] font-bold uppercase text-emerald-800 tracking-wider">Total Siswa Terdata</span>
                                    <div class="text-2xl font-black text-emerald-950 mt-0.5">{{ $totalSiswa }}</div>
                                    <span class="text-[10px] text-emerald-700">Calon Alternatif</span>
                                </div>
                                <div class="p-3.5 rounded-2xl bg-amber-50/60 border border-amber-100">
                                    <span class="text-[11px] font-bold uppercase text-amber-800 tracking-wider">Kriteria Aktif</span>
                                    <div class="text-2xl font-black text-amber-950 mt-0.5">{{ $kriterias->count() }}</div>
                                    <span class="text-[10px] text-amber-700">Total Bobot 100%</span>
                                </div>
                            </div>

                            <!-- Quick Access Prompt -->
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 text-xs space-y-2">
                                <span class="font-bold text-gray-700 block">Tiga Gerbang Akses Resmi:</span>
                                <ul class="space-y-1.5 text-gray-600">
                                    <li class="flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        <strong>Admin TU:</strong> Kelola data siswa, kriteria & penilaian
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-teal-600"></span>
                                        <strong>Kepala Madrasah:</strong> Pengesahan & cetak SK laporan
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        <strong>Orang Tua Siswa:</strong> Pengumuman transparan & aman
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 4. HIGHLIGHTS & KEUNGGULAN SISTEM -->
    <section class="py-12 bg-white border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-200 transition">
                    <div class="p-3 rounded-xl bg-emerald-600 text-white shrink-0 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Metode SAW Akurat</h4>
                        <p class="text-xs text-gray-500 mt-1">Normalisasi matriks terbobot matematis menjamin perankingan yang adil.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-200 transition">
                    <div class="p-3 rounded-xl bg-teal-600 text-white shrink-0 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Privasi Terjaga</h4>
                        <p class="text-xs text-gray-500 mt-1">Pengumuman publik menyamarkan nama dan NIS siswa untuk menjaga martabat keluarga.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-200 transition">
                    <div class="p-3 rounded-xl bg-amber-500 text-white shrink-0 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Impor & Ekspor Excel</h4>
                        <p class="text-xs text-gray-500 mt-1">Dukungan spreadsheet massal memudahkan integrasi data EMIS / Dapodik madrasah.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-200 transition">
                    <div class="p-3 rounded-xl bg-blue-600 text-white shrink-0 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Laporan SK Resmi PDF</h4>
                        <p class="text-xs text-gray-500 mt-1">Format cetak berkop resmi MIS AL KAUTSAR lengkap dengan tanda tangan Kepala Madrasah.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 5. TENTANG PIP DI MIS AL KAUTSAR -->
    <section id="tentang" class="py-16 sm:py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">
                        Bantuan Operasional Pendidikan
                    </div>
                    <h2 class="text-3xl font-black text-gray-950 tracking-tight">
                        Tentang Program Indonesia Pintar (PIP) di Lingkungan Madrasah
                    </h2>
                    <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
                        Program Indonesia Pintar (PIP) melalui Kementerian Agama dan Kementerian Pendidikan bertujuan untuk membantu anak-anak usia sekolah dari keluarga kurang mampu agar tetap mendapatkan layanan pendidikan hingga tamat jenjang pendidikan dasar.
                    </p>
                    <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
                        Di <strong>MIS AL KAUTSAR</strong>, penyaluran bantuan ini dilakukan melalui proses seleksi ketat dan transparan. Dengan menerapkan Sistem Pendukung Keputusan berbasis metode <em>Simple Additive Weighting</em> (SAW), madrasah menjamin bahwa setiap dana bantuan yang terbatas benar-benar disalurkan kepada siswa dengan tingkat urgensi tertinggi.
                    </p>

                    <div class="pt-2 grid grid-cols-2 gap-4">
                        <div class="border-l-4 border-emerald-600 pl-4 py-1">
                            <span class="block text-2xl font-black text-gray-900">100%</span>
                            <span class="text-xs text-gray-500 font-medium">Bebas Intervensi Subyektif</span>
                        </div>
                        <div class="border-l-4 border-amber-500 pl-4 py-1">
                            <span class="block text-2xl font-black text-gray-900">5 Indikator</span>
                            <span class="text-xs text-gray-500 font-medium">Kriteria Sosial & Ekonomi</span>
                        </div>
                    </div>
                </div>

                <!-- Visual Box -->
                <div class="bg-gradient-to-br from-emerald-800 to-teal-900 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 opacity-10">
                        <img src="{{ asset('storage/logo.png') }}" alt="" class="w-64 h-64 object-contain" onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                    </div>
                    <h3 class="text-xl font-black mb-3">Visi Keadilan Pendidikan MIS AL KAUTSAR</h3>
                    <p class="text-emerald-100 text-xs sm:text-sm leading-relaxed mb-6">
                        "Tidak boleh ada siswa MIS AL KAUTSAR yang terhambat belajarnya karena keterbatasan biaya. Melalui sistem SPK SAW, penentuan prioritas bantuan PIP menjadi amanah, dapat dipertanggungjawabkan di hadapan orang tua dan Allah SWT."
                    </p>

                    <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/15 text-xs space-y-2">
                        <div class="flex items-center justify-between font-semibold">
                            <span>Prinsip Seleksi:</span>
                            <span class="text-amber-300">Akuntabel & Adil</span>
                        </div>
                        <p class="text-white/80 text-[11px]">
                            Semua data pendukung (penghasilan, kepemilikan kartu bantuan, status yatim, tanggungan, dan jarak) diverifikasi secara berkala oleh tim panitia madrasah.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. 5 KRITERIA SELEKSI SAW -->
    <section id="kriteria" class="py-16 sm:py-24 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto space-y-4 mb-14">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">
                    Transparansi Bobot Penilaian
                </div>
                <h2 class="text-3xl font-black text-gray-950 tracking-tight">
                    5 Indikator Kriteria Seleksi Penerima PIP
                </h2>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                    Setiap kriteria memiliki bobot persentase dan sifat atribut (<em>Benefit</em> atau <em>Cost</em>) yang ditentukan sesuai regulasi petunjuk teknis PIP.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @php
                    $defaultKriterias = [
                        ['kode' => 'C1', 'nama' => 'Penghasilan Orang Tua', 'tipe' => 'cost', 'bobot' => 25, 'desc' => 'Semakin kecil penghasilan keluarga, semakin besar peluang mendapatkan prioritas bantuan.'],
                        ['kode' => 'C2', 'nama' => 'Kartu Bantuan (KIP/KKS/PKH)', 'tipe' => 'benefit', 'bobot' => 25, 'desc' => 'Kepemilikan kartu perlindungan sosial resmi dari pemerintah menjadi bukti sah kemiskinan.'],
                        ['kode' => 'C3', 'nama' => 'Status Orang Tua', 'tipe' => 'benefit', 'bobot' => 20, 'desc' => 'Siswa yatim piatu atau yatim diprioritaskan demi menjaga keberlanjutan sekolah anak.'],
                        ['kode' => 'C4', 'nama' => 'Tanggungan Keluarga', 'tipe' => 'benefit', 'bobot' => 15, 'desc' => 'Banyaknya jumlah anak atau tanggungan dalam satu Kartu Keluarga yang dibiayai.'],
                        ['kode' => 'C5', 'nama' => 'Jarak Rumah ke Madrasah', 'tipe' => 'benefit', 'bobot' => 15, 'desc' => 'Beban ongkos harian transportasi siswa dari kediaman menuju madrasah.'],
                    ];
                    $displayList = $kriterias->isNotEmpty() ? $kriterias : collect($defaultKriterias);
                @endphp

                @foreach ($displayList as $item)
                    @php
                        $kode = is_array($item) ? $item['kode'] : $item->kode_kriteria;
                        $nama = is_array($item) ? $item['nama'] : $item->nama_kriteria;
                        $tipe = is_array($item) ? $item['tipe'] : $item->tipe;
                        $bobot = is_array($item) ? $item['bobot'] : $item->bobot;
                        $desc = is_array($item) ? $item['desc'] : ($item->keterangan ?? '-');
                    @endphp
                    <div class="p-5 rounded-3xl bg-slate-50 border border-slate-200/80 hover:border-emerald-500 hover:shadow-lg transition-all flex flex-col justify-between group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-1 rounded-xl bg-emerald-600 text-white font-black text-xs">{{ $kode }}</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $tipe === 'cost' ? 'bg-rose-100 text-rose-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $tipe }}
                                </span>
                            </div>
                            <h4 class="font-extrabold text-sm text-gray-900 group-hover:text-emerald-700 transition leading-snug">
                                {{ $nama }}
                            </h4>
                            <p class="text-xs text-gray-500 leading-relaxed">
                                {{ $desc }}
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-slate-200 flex items-center justify-between">
                            <span class="text-[11px] text-gray-400 font-medium">Bobot SAW</span>
                            <span class="font-black text-emerald-800 text-base">{{ $bobot }}%</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Catatan Aturan SAW -->
            <div class="mt-8 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-900 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-700 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Total akumulasi seluruh bobot kriteria dalam sistem dijamin <strong>tepat 100%</strong> sesuai prinsip normalisasi SAW.</span>
                </div>
                <span class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider">Terverifikasi Sistem</span>
            </div>
        </div>
    </section>

    <!-- 7. ALUR KERJA SELEKSI -->
    <section id="alur" class="py-16 sm:py-24 bg-slate-50 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto space-y-4 mb-14">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">
                    Tahapan Operasional
                </div>
                <h2 class="text-3xl font-black text-gray-950 tracking-tight">
                    4 Langkah Alur Penyeleksian Bantuan
                </h2>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
                    Bagaimana data siswa diproses dari awal pendaftaran hingga penetapan Surat Keputusan resmi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <!-- Step 1 -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-sm relative">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-800 font-black text-sm flex items-center justify-center mb-4">
                        01
                    </div>
                    <h3 class="font-extrabold text-base text-gray-900 mb-2">Pendataan Siswa</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Pengumpulan biodata pendaftar, pas foto, dan nomor identitas (NIS/NISN) via form manual atau berkas Excel.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-sm relative">
                    <div class="w-10 h-10 rounded-2xl bg-teal-100 text-teal-800 font-black text-sm flex items-center justify-center mb-4">
                        02
                    </div>
                    <h3 class="font-extrabold text-base text-gray-900 mb-2">Input Penilaian</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Panitia TU memasukkan nilai alternatif tiap siswa berdasarkan skala sub-kriteria riil yang telah divalidasi.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-sm relative">
                    <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-800 font-black text-sm flex items-center justify-center mb-4">
                        03
                    </div>
                    <h3 class="font-extrabold text-base text-gray-900 mb-2">Kalkulasi SAW</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Sistem melakukan normalisasi matriks (Benefit vs Cost) dan menghitung nilai preferensi (V) secara otomatis.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-sm relative">
                    <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-800 font-black text-sm flex items-center justify-center mb-4">
                        04
                    </div>
                    <h3 class="font-extrabold text-base text-gray-900 mb-2">Pengesahan & SK</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Kepala Madrasah meninjau kuota dan mengesahkan SK penetapan resmi yang dapat diunduh dalam format PDF.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- 8. PORTAL LOGIN / AKSES SESUAI ROLE -->
    <section class="py-16 sm:py-24 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto space-y-4 mb-12">
                <h2 class="text-3xl font-black text-gray-950 tracking-tight">
                    Masuk Melalui Portal Peran Anda
                </h2>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Sistem ini terbagi menjadi tiga peran dengan kewenangan dan tampilan khusus.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Admin TU Card -->
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200 hover:border-emerald-500 transition-all space-y-4 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center mb-4 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-black text-gray-950">Admin Tata Usaha</h3>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                            Mengelola data periode, master kriteria dan bobot, data siswa alternatif, serta mengeksekusi perhitungan SAW.
                        </p>
                    </div>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition">
                        Masuk Admin TU &rarr;
                    </a>
                </div>

                <!-- Kepsek Card -->
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200 hover:border-teal-500 transition-all space-y-4 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-teal-600 text-white flex items-center justify-center mb-4 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-black text-gray-950">Kepala Madrasah</h3>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                            Memantau rekapitulasi data pendaftar, meninjau hasil perangkingan, dan mencetak berkas Surat Keputusan penetapan resmi.
                        </p>
                    </div>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs shadow-sm transition">
                        Masuk Kepala Madrasah &rarr;
                    </a>
                </div>

                <!-- Ortu Card -->
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200 hover:border-amber-500 transition-all space-y-4 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center mb-4 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-black text-gray-950">Orang Tua / Wali</h3>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                            Memeriksa status kelayakan putra-putri secara mandiri atau melihat pengumuman umum yang disamarkan demi privasi.
                        </p>
                    </div>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs shadow-sm transition">
                        Masuk Portal Orang Tua &rarr;
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- 9. FOOTER RESMI MIS AL KAUTSAR -->
    <footer id="kontak" class="bg-gradient-to-b from-gray-900 to-black text-white pt-16 pb-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b border-gray-800">

                <!-- Col 1: Identity & Logo -->
                <div class="md:col-span-5 space-y-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 p-1 rounded-2xl bg-white shadow-md flex items-center justify-center">
                            <img src="{{ asset('storage/logo.png') }}" alt="Logo MIS AL KAUTSAR" class="w-full h-full object-contain" onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                        </div>
                        <div>
                            <span class="block text-lg font-black text-white tracking-tight leading-none">MIS AL KAUTSAR</span>
                            <span class="block text-xs font-semibold text-emerald-400 mt-1">Madrasah Ibtidaiyah Swasta</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 leading-relaxed max-w-sm">
                        Lembaga pendidikan Islam tingkat dasar yang berkomitmen mengintegrasikan kurikulum nasional dan nilai-nilai keislaman untuk mencetak generasi berkarakter luhur.
                    </p>
                    <div class="text-xs text-gray-400 space-y-1">
                        <p><strong>Status:</strong> Terakreditasi Kementerian Agama RI</p>
                        <p><strong>NPSN / NSM:</strong> Terdaftar Resmi</p>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div class="md:col-span-3 space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-400">Tautan Sistem</h4>
                    <ul class="space-y-2 text-xs text-gray-400">
                        <li><a href="#beranda" class="hover:text-white transition">Beranda Utama</a></li>
                        <li><a href="#tentang" class="hover:text-white transition">Tentang Program PIP</a></li>
                        <li><a href="#kriteria" class="hover:text-white transition">5 Indikator Bobot SAW</a></li>
                        <li><a href="#alur" class="hover:text-white transition">Alur Seleksi 4 Langkah</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Halaman Masuk (Login)</a></li>
                    </ul>
                </div>

                <!-- Col 3: Contact & Address -->
                <div class="md:col-span-4 space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-400">Sekretariat Madrasah</h4>
                    <div class="text-xs text-gray-400 space-y-2 leading-relaxed">
                        <p class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Jl. Pendidikan No. 12, Kelurahan / Desa Makmur</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>(021) 88997766 / 0812-3456-7890</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>misalkautsar@kemenag.go.id</span>
                        </p>
                    </div>
                </div>

            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} <strong>MIS AL KAUTSAR</strong>. Hak Cipta Dilindungi Undang-Undang.</p>
                <p class="text-gray-400">Sistem Pendukung Keputusan Seleksi PIP Metode SAW</p>
            </div>
        </div>
    </footer>

</body>
</html>
