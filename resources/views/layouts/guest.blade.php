<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SPK PIP MIS AL KAUTSAR') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('storage/logo.png') }}" onerror="this.onerror=null; this.href='{{ asset('logo.png') }}';">

        <!-- Fonts: Standar Tipografi Instansi Pemerintah / Dinas (Plus Jakarta Sans) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-slate-50 min-h-screen flex flex-col justify-between selection:bg-emerald-600 selection:text-white">
        <!-- Background subtle decoration -->
        <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden">
            <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-emerald-100/50 blur-3xl"></div>
            <div class="absolute top-1/2 -right-32 w-96 h-96 rounded-full bg-teal-100/40 blur-3xl"></div>
            <div class="absolute -bottom-32 left-1/3 w-96 h-96 rounded-full bg-emerald-50/60 blur-3xl"></div>
        </div>

        <!-- Header / Back to Welcome link -->
        <header class="w-full max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-gray-600 hover:text-emerald-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Beranda
            </a>
            <span class="text-xs font-medium text-gray-400">Madrasah Ibtidaiyah Swasta</span>
        </header>

        <!-- Main Card Section -->
        <main class="w-full flex flex-col justify-center items-center px-4 py-6 flex-1">
            <div class="text-center mb-6">
                <a href="{{ url('/') }}" class="inline-flex flex-col items-center group">
                    <div class="w-20 h-20 p-2 rounded-2xl bg-white shadow-md border border-emerald-100 group-hover:scale-105 transition-transform duration-200">
                        <x-application-logo class="w-full h-full" />
                    </div>
                    <h1 class="mt-3 text-xl font-extrabold text-gray-900 tracking-tight">MIS AL KAUTSAR</h1>
                    <p class="text-xs font-medium text-emerald-700">Sistem Pendukung Keputusan PIP (Metode SAW)</p>
                </a>
            </div>

            <div class="w-full sm:max-w-md bg-white p-6 sm:p-8 shadow-xl shadow-slate-200/50 border border-slate-100 rounded-3xl">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full py-4 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} MIS AL KAUTSAR &bull; Sistem Seleksi Penerima Bantuan PIP
        </footer>
    </body>
</html>
