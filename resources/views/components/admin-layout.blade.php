<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SPK PIP MIS AL KAUTSAR') }} - Admin TU</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/logo.png') }}" onerror="this.onerror=null; this.href='{{ asset('logo.png') }}';">

    <!-- Fonts: Standar Tipografi Instansi Pemerintah / Dinas (Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-base-200 text-base-content min-h-screen">

    <div class="drawer lg:drawer-open">
        <input id="admin-drawer" type="checkbox" class="drawer-toggle" />

        <!-- Konten Utama -->
        <div class="drawer-content flex flex-col min-h-screen">

            <!-- Navbar Atas Sticky -->
            <header class="navbar bg-base-100/90 backdrop-blur border-b border-base-300 sticky top-0 z-30 px-4 sm:px-6">
                <div class="flex-none lg:hidden">
                    <label for="admin-drawer" aria-label="open sidebar" class="btn btn-square btn-ghost btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="inline-block w-5 h-5 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                </div>

                <div class="flex-1 px-2 flex items-center gap-3">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo MIS AL KAUTSAR" class="w-8 h-8 object-contain rounded-lg lg:hidden" onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                    <div>
                        <span class="text-base sm:text-lg font-black tracking-tight text-primary">MIS AL KAUTSAR</span>
                        <span class="hidden sm:inline-block ml-2 text-xs font-semibold text-base-content/60 bg-base-200 px-2 py-0.5 rounded-md">Portal Admin TU</span>
                    </div>
                </div>

                <!-- Bagian Kanan Navbar (Quick Action & Profile Ringkas) -->
                <div class="flex-none gap-2">
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button"
                            class="btn btn-ghost btn-circle avatar placeholder ring-1 ring-primary/20">
                            <div class="bg-primary text-primary-content rounded-full w-9">
                                <span class="text-xs font-semibold">AD</span>
                            </div>
                        </div>
                        <ul tabindex="0"
                            class="mt-3 z-[1] p-2 shadow-lg menu menu-sm dropdown-content bg-base-100 rounded-box w-52 border border-base-200">
                            <li class="menu-title px-4 py-2">
                                <span class="font-semibold text-xs uppercase tracking-wider text-base-content/60">Akun
                                    Admin</span>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit"
                                        class="text-error hover:bg-error/10 w-full flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Area Konten Dinamis -->
            <main class="flex-1 p-4 md:p-6 lg:p-8 max-w-7xl w-full mx-auto">
                {{ $slot }}
            </main>
        </div>

        <!-- Sidebar Navigation -->
        <aside class="drawer-side z-40">
            <label for="admin-drawer" aria-label="close sidebar" class="drawer-overlay"></label>

            <div class="flex flex-col w-72 min-h-full bg-base-100 border-r border-base-300">
                <!-- Header Brand Sidebar -->
                <a href="{{ route('admin.dashboard') }}" class="p-4 border-b border-base-200 flex items-center gap-3 hover:bg-base-200/50 transition">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo MIS AL KAUTSAR" class="w-10 h-10 object-contain rounded-xl p-1 bg-white shadow-sm border border-base-200" onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
                    <div class="overflow-hidden">
                        <h2 class="text-sm font-black leading-tight text-base-content tracking-tight truncate">MIS AL KAUTSAR</h2>
                        <span class="text-[11px] text-primary font-bold block truncate">SPK PIP • Metode SAW</span>
                    </div>
                </a>

                <!-- Navigation List -->
                <ul class="menu menu-md p-4 w-full gap-1 flex-1">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="active font-medium rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    <!-- Menu Title: Data Master -->
                    <li class="menu-title mt-4 text-xs font-bold uppercase tracking-wider text-base-content/50">Data
                        Master</li>
                    <li>
                        <a href="{{ route('admin.periode.index') }}"
                            class="{{ request()->routeIs('admin.periode.*') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Data Periode
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.siswa.index') }}"
                            class="{{ request()->routeIs('admin.siswa.*') ? 'active' : '' }} rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Data Siswa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.kriteria.index') }}"
                            class="{{ request()->routeIs('admin.kriteria.*') ? 'active' : '' }} rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Kriteria & Bobot
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.subkriteria.index') }}"
                            class="{{ request()->routeIs('admin.subkriteria.*') ? 'active' : '' }} rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Sub Kriteria
                        </a>
                    </li>

                    <!-- Menu Title: Sistem Keputusan -->
                    <li class="menu-title mt-4 text-xs font-bold uppercase tracking-wider text-base-content/50">Sistem
                        Keputusan</li>
                    <li>
                        <a href="{{ route('admin.penilaian.index') }}"
                            class="{{ request()->routeIs('admin.penilaian.*') ? 'active' : '' }} rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Penilaian Siswa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.saw.index') }}"
                            class="{{ request()->routeIs('admin.saw.*') ? 'active' : '' }} rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Hasil Perhitungan (SAW)
                        </a>
                    </li>

                    <!-- Menu Title: Laporan & Menu Baru -->
                    <li class="menu-title mt-4 text-xs font-bold uppercase tracking-wider text-base-content/50">Laporan
                    </li>
                    <li>
                        <details open>
                            <summary class="rounded-lg font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Rekap & Laporan
                            </summary>
                            <ul>
                                <li>
                                    <a href="{{ route('admin.laporan.index') }}"
                                        class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }} rounded-lg flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                        </svg>
                                        Cetak Laporan
                                    </a>
                                </li>
                            </ul>
                        </details>
                    </li>
                </ul>

                <div class="divider my-0"></div>

                <!-- Footer Sidebar / Logout Section -->
                <div class="p-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="btn btn-outline btn-error btn-sm w-full justify-start gap-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>
    </div>

</body>

</html>
