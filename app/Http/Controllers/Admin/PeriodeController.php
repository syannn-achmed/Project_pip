<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $periodes = Periode::latest()
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('nama_periode', 'like', "%{$request->search}%")
                        ->orWhere('tahun_ajaran', 'like', "%{$request->search}%");
                });
            })
            ->when($request->filled('status_aktif'), function ($q) use ($request) {
                $q->where('status_aktif', $request->status_aktif);
            })
            ->get();

        return view('pages.admin.periode.index', compact('periodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.periode.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tahun_ajaran' => 'required|string|max:50',
        ]);

        $isAktif = $request->has('status_aktif'); // True jika toggle dicentang

        // 2. Gunakan DB Transaction agar aman
        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $isAktif) {

            // Jika user menceklis "Aktif", nonaktifkan semua periode lain terlebih dahulu
            if ($isAktif) {
                Periode::where('status_aktif', true)->update(['status_aktif' => false]);
            }

            // Simpan data periode baru
            Periode::create([
                'nama_periode' => $request->nama_periode,
                'tahun_ajaran' => $request->tahun_ajaran,
                'status_aktif' => $isAktif,
            ]);
        });

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode baru berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $periode = Periode::findOrFail($id);
        return view('pages.admin.periode.edit', compact('periode'));
    }

    public function update(Request $request, string $id)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tahun_ajaran' => 'required|string|max:50',
        ]);

        $periode = Periode::findOrFail($id);
        $isAktif = $request->has('status_aktif');

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $periode, $isAktif) {
            // Jika user mengubah status menjadi "Aktif", nonaktifkan periode lain
            if ($isAktif && !$periode->status_aktif) {
                Periode::where('id', '!=', $periode->id)
                    ->where('status_aktif', true)
                    ->update(['status_aktif' => false]);
            }

            // Update data
            $periode->update([
                'nama_periode' => $request->nama_periode,
                'tahun_ajaran' => $request->tahun_ajaran,
                'status_aktif' => $isAktif,
            ]);
        });

        return redirect()->route('admin.periode.index')
            ->with('success', 'Data periode berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $periode = Periode::findOrFail($id);

        // Aturan 1: Jangan hapus periode yang sedang berjalan/aktif
        if ($periode->status_aktif) {
            return redirect()->route('admin.periode.index')
                ->with('error', 'Periode yang sedang aktif tidak dapat dihapus.');
        }

        // Aturan 2 (Standar Industri): Cek apakah periode ini sudah punya histori transaksi
        // Jika sudah ada yang dinilai, tolak penghapusan. Minta user membiarkannya sebagai "Arsip".
        if ($periode->penilaians()->exists() || $periode->hasilSaws()->exists()) {
            return redirect()->route('admin.periode.index')
                ->with('error', 'Gagal! Periode ini sudah memiliki data riwayat penilaian siswa. Cukup nonaktifkan periode ini sebagai arsip historis.');
        }

        // Jika lolos kedua aturan di atas (berarti ini periode kosong/salah input), baru boleh di-SoftDelete
        $periode->delete();

        return redirect()->route('admin.periode.index')
            ->with('success', 'Data periode berhasil dihapus.');
    }
}
