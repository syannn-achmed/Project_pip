<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kriteria untuk dropdown form tambah & filter
        $kriterias = Kriteria::orderBy('kode_kriteria', 'asc')->get();

        // Mulai query untuk Sub Kriteria
        $query = SubKriteria::with('kriteria');

        // Jika ada request filter dari dropdown, tambahkan ke query
        if ($request->filled('filter_kriteria')) {
            $query->where('kriteria_id', $request->filter_kriteria);
        }

        // Eksekusi query dengan pengurutan
        $subKriterias = $query->orderBy('kriteria_id', 'asc')
            ->orderBy('nilai', 'desc')
            ->get();

        return view('pages.admin.subkriteria.index', compact('kriterias', 'subKriterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'nama_subkriteria' => 'required|string|max:255',
            'nilai' => 'required|numeric|min:1|max:100',
        ]);

        SubKriteria::create([
            'kriteria_id' => $request->kriteria_id,
            'nama_subkriteria' => $request->nama_subkriteria,
            'nilai' => $request->nilai,
        ]);

        return back()->with('success', 'Opsi Jawaban (Sub Kriteria) berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $subKriteria = SubKriteria::findOrFail($id);
        $kriterias = Kriteria::orderBy('kode_kriteria', 'asc')->get();

        return view('pages.admin.subkriteria.edit', compact('subKriteria', 'kriterias'));
    }

    public function update(Request $request, string $id)
    {
        $subKriteria = SubKriteria::findOrFail($id);

        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'nama_subkriteria' => 'required|string|max:255',
            'nilai' => 'required|numeric|min:1|max:100',
        ]);

        $subKriteria->update([
            'kriteria_id' => $request->kriteria_id,
            'nama_subkriteria' => $request->nama_subkriteria,
            'nilai' => $request->nilai,
        ]);

        return redirect()->route('admin.subkriteria.index')
            ->with('success', 'Opsi Jawaban (Sub Kriteria) berhasil diperbarui.');
    }


    public function destroy(string $id)
    {
        // 1. Cari data berdasarkan ID secara manual
        $subkriteria = SubKriteria::findOrFail($id);

        // 2. Validasi penghapusan
        if (\App\Models\Penilaian::where('sub_kriteria_id', $subkriteria->id)->exists()) {
            return back()->with('error', 'Gagal! Sub Kriteria ini sedang dipakai pada data penilaian siswa.');
        }

        // 3. Eksekusi hapus
        $subkriteria->delete();

        return back()->with('success', 'Sub Kriteria berhasil dihapus.');
    }
}
