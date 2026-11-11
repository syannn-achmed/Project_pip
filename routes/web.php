<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Kepsek\DashboardController as KepsekDashboard;

Route::get('/', function (\Illuminate\Http\Request $request) {
    // 1. Ambil seluruh periode yang ada untuk filter dropdown
    $periodes = \App\Models\Periode::orderBy('tahun_ajaran', 'desc')->get();

    // 2. Tentukan periode yang dipilih: jika ada request('periode_id'), gunakan itu; jika tidak, gunakan periode yang aktif
    $selectedPeriodeId = $request->input('periode_id');
    if ($selectedPeriodeId) {
        $targetPeriode = \App\Models\Periode::find($selectedPeriodeId);
    } else {
        $targetPeriode = \App\Models\Periode::where('status_aktif', true)->first();
    }

    $periodeAktif = \App\Models\Periode::where('status_aktif', true)->first();
    $totalSiswa = \App\Models\Siswa::count();
    $kriterias = \App\Models\Kriteria::orderBy('kode_kriteria', 'asc')->get();

    $hasilSaws = collect();
    $totalLolos = 0;
    $totalTidakLolos = 0;

    if ($targetPeriode) {
        $query = \App\Models\HasilSaw::with('siswa')
            ->where('periode_id', $targetPeriode->id)
            ->orderBy('peringkat', 'asc');

        // Filter NIS spesifik
        if ($request->filled('nis')) {
            $nisSearch = trim($request->nis);
            $query->whereHas('siswa', function ($q) use ($nisSearch) {
                $q->where('nis', 'like', "%{$nisSearch}%");
            });
        }

        // Filter Nama spesifik
        if ($request->filled('nama')) {
            $namaSearch = trim($request->nama);
            $query->whereHas('siswa', function ($q) use ($namaSearch) {
                $q->where('nama', 'like', "%{$namaSearch}%");
            });
        }

        // Filter Kelas
        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }

        // Filter Status Lolos / Tidak Lolos
        if ($request->filled('status')) {
            $query->where('status_penerimaan', $request->status);
        }

        $allHasil = \App\Models\HasilSaw::where('periode_id', $targetPeriode->id)->get();
        $totalLolos = $allHasil->where('status_penerimaan', 'Lolos')->count();
        $totalTidakLolos = $allHasil->where('status_penerimaan', 'Tidak Lolos')->count();

        $hasilSaws = $query->paginate(15)->withQueryString();
    }

    $kelasList = \App\Models\Siswa::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

    return view('welcome', compact(
        'periodes',
        'targetPeriode',
        'periodeAktif',
        'totalSiswa',
        'kriterias',
        'hasilSaws',
        'kelasList',
        'totalLolos',
        'totalTidakLolos'
    ));
})->name('home');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin_tu')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('kepala_sekolah')) {
        return redirect()->route('kepsek.dashboard');
    }

    // Jika user tanpa role admin/kepsek
    abort(403, 'Akses tidak diizinkan. Hubungi Administrator.');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin_tu'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::resource('periode', App\Http\Controllers\Admin\PeriodeController::class);
    Route::resource('kriteria', App\Http\Controllers\Admin\KriteriaController::class);
    Route::resource('subkriteria', App\Http\Controllers\Admin\SubKriteriaController::class)->except(['create', 'show']);

    // Data Siswa & Import/Export Excel
    Route::get('siswa/export', [App\Http\Controllers\Admin\SiswaController::class, 'export'])->name('siswa.export');
    Route::post('siswa/import', [App\Http\Controllers\Admin\SiswaController::class, 'import'])->name('siswa.import');
    Route::resource('siswa', App\Http\Controllers\Admin\SiswaController::class);

    // Penilaian Siswa (Input Nilai per Kriteria & Import Excel)
    Route::get('penilaian/template', [App\Http\Controllers\Admin\PenilaianController::class, 'template'])->name('penilaian.template');
    Route::post('penilaian/import', [App\Http\Controllers\Admin\PenilaianController::class, 'import'])->name('penilaian.import');
    Route::resource('penilaian', App\Http\Controllers\Admin\PenilaianController::class)->only(['index', 'edit', 'update']);

    // Perhitungan SAW & Perangkingan
    Route::get('saw', [App\Http\Controllers\Admin\HasilSawController::class, 'index'])->name('saw.index');
    Route::post('saw/proses', [App\Http\Controllers\Admin\HasilSawController::class, 'proses'])->name('saw.proses');

    // Rekap & Laporan
    Route::get('laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/pdf', [App\Http\Controllers\Admin\LaporanController::class, 'cetakPdf'])->name('laporan.pdf');
});


// ROUTE KHUSUS KEPALA SEKOLAH
Route::middleware(['auth', 'role:kepala_sekolah'])->prefix('kepsek')->name('kepsek.')->group(function () {
    Route::get('/dashboard', [KepsekDashboard::class, 'index'])->name('dashboard');
    Route::get('laporan/pdf', [App\Http\Controllers\Admin\LaporanController::class, 'cetakPdf'])->name('laporan.pdf');
});

require __DIR__ . '/auth.php';
