<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kriterias = Kriteria::orderBy('kode_kriteria', 'asc')->get();
        $totalBobot = Kriteria::sum('bobot'); // Hitung total bobot saat ini

        return view('pages.admin.kriteria.index', compact('kriterias', 'totalBobot'));
    }

    public function create()
    {
        $totalBobotSaatIni = Kriteria::sum('bobot');
        $sisaBobot = 100 - $totalBobotSaatIni;

        return view('pages.admin.kriteria.create', compact('sisaBobot'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kriteria' => 'required|string|unique:kriterias,kode_kriteria|max:10',
            'nama_kriteria' => 'required|string|max:255',
            'tipe' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string'
        ]);

        // Proteksi Logika Bisnis: Cek apakah bobot baru melebih batas 100%
        $totalBobotSaatIni = Kriteria::sum('bobot');
        if (($totalBobotSaatIni + $request->bobot) > 100) {
            return back()->withInput()->with('error', 'Gagal! Total keseluruhan bobot tidak boleh lebih dari 100. Sisa bobot yang bisa diinput adalah: ' . (100 - $totalBobotSaatIni));
        }

        Kriteria::create($request->all());

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Kriteria baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $kriteria = Kriteria::findOrFail($id);

        // Hitung sisa bobot DILUAR bobot kriteria yang sedang diedit ini
        $totalBobotLain = Kriteria::where('id', '!=', $id)->sum('bobot');
        $sisaBobot = 100 - $totalBobotLain;

        return view('pages.admin.kriteria.edit', compact('kriteria', 'sisaBobot'));
    }

    public function update(Request $request, string $id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $request->validate([
            'kode_kriteria' => 'required|string|max:10|unique:kriterias,kode_kriteria,' . $id,
            'nama_kriteria' => 'required|string|max:255',
            'tipe' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string'
        ]);

        // Cek total bobot (Total bobot lain + bobot inputan baru)
        $totalBobotLain = Kriteria::where('id', '!=', $id)->sum('bobot');
        if (($totalBobotLain + $request->bobot) > 100) {
            return back()->withInput()->with('error', 'Gagal! Total keseluruhan bobot melebihi 100%. Maksimal bobot yang bisa diinput untuk kriteria ini adalah: ' . (100 - $totalBobotLain) . '%');
        }

        $kriteria->update($request->all());

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Data kriteria berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $kriteria = Kriteria::findOrFail($id);

        // Standar Industri: Cegah hapus jika sudah ada penilaian siswa yang memakai kriteria ini
        if (\App\Models\Penilaian::where('kriteria_id', $id)->exists()) {
            return back()->with('error', 'Gagal dihapus! Kriteria ini sudah digunakan pada data penilaian siswa.');
        }

        $kriteria->delete(); // Sub kriteria otomatis terhapus karena cascadeOnDelete di migration

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Kriteria dan opsi jawabannya berhasil dihapus.');
    }
}
