<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Kepsek\DashboardController as KepsekDashboard;
use App\Http\Controllers\Ortu\DashboardController as OrtuDashboard;

Route::get('/', function (\Illuminate\Http\Request $request) {
    $periodeAktif = \App\Models\Periode::where('status_aktif', true)->first();
    $totalSiswa = \App\Models\Siswa::count();
    $kriterias = \App\Models\Kriteria::orderBy('kode_kriteria', 'asc')->get();

    $hasilSaws = collect();
    $totalLolos = 0;
    $totalTidakLolos = 0;

    if ($periodeAktif) {
        $query = \App\Models\HasilSaw::with('siswa')
            ->where('periode_id', $periodeAktif->id)
            ->orderBy('peringkat', 'asc');

        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }

        if ($request->filled('status')) {
            $query->where('status_penerimaan', $request->status);
        }

        if ($request->filled('q')) {
            $qSearch = $request->q;
            $query->whereHas('siswa', function ($q) use ($qSearch) {
                $q->where('nama', 'like', "%{$qSearch}%")
                  ->orWhere('nis', 'like', "%{$qSearch}%");
            });
        }

        $allHasil = \App\Models\HasilSaw::where('periode_id', $periodeAktif->id)->get();
        $totalLolos = $allHasil->where('status_penerimaan', 'Lolos')->count();
        $totalTidakLolos = $allHasil->where('status_penerimaan', 'Tidak Lolos')->count();

        $hasilSaws = $query->paginate(15)->withQueryString();
    }

    $kelasList = \App\Models\Siswa::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

    return view('welcome', compact('periodeAktif', 'totalSiswa', 'kriterias', 'hasilSaws', 'kelasList', 'totalLolos', 'totalTidakLolos'));
})->name('home');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin_tu')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('kepala_sekolah')) {
        return redirect()->route('kepsek.dashboard');
    } elseif ($user->hasRole('orang_tua')) {
        return redirect()->route('ortu.dashboard');
    }

    // Jika tidak punya role (misal user nyasar/baru)
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
    Route::post('siswa/{siswa}/buat-akun-ortu', [App\Http\Controllers\Admin\AkunOrtuController::class, 'quickStoreForSiswa'])->name('siswa.buat-akun-ortu');
    Route::post('siswa/tautkan-akun-ortu', [App\Http\Controllers\Admin\AkunOrtuController::class, 'tautkanSiswa'])->name('siswa.tautkan-akun-ortu');
    Route::post('siswa/lepas-akun-ortu', [App\Http\Controllers\Admin\AkunOrtuController::class, 'lepasTautan'])->name('siswa.lepas-akun-ortu');
    Route::resource('siswa', App\Http\Controllers\Admin\SiswaController::class);

    // Manajemen Akun Orang Tua
    Route::resource('akun-ortu', App\Http\Controllers\Admin\AkunOrtuController::class)->except(['create', 'show', 'edit']);

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

// ROUTE KHUSUS ORANG TUA
Route::middleware(['auth', 'role:orang_tua'])->prefix('ortu')->name('ortu.')->group(function () {
    Route::get('/dashboard', [OrtuDashboard::class, 'index'])->name('dashboard');
});

require __DIR__ . '/auth.php';
