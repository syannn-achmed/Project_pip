<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Periode;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $periodeAktif = Periode::where('status_aktif', true)->first();
        $totalKriteria = Kriteria::count();

        $query = Siswa::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('kelas', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        $siswas = $query->paginate(10)->withQueryString();

        // Hitung progres penilaian per siswa pada periode aktif
        $penilaianSummary = [];
        if ($periodeAktif) {
            $penilaianSummary = Penilaian::where('periode_id', $periodeAktif->id)
                ->select('siswa_id', DB::raw('count(id) as total'))
                ->groupBy('siswa_id')
                ->pluck('total', 'siswa_id')
                ->toArray();
        }

        $kelasList = Siswa::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

        return view('pages.admin.penilaian.index', compact('siswas', 'periodeAktif', 'totalKriteria', 'penilaianSummary', 'kelasList'));
    }

    public function edit(string $siswaId)
    {
        $periodeAktif = Periode::where('status_aktif', true)->first();

        if (!$periodeAktif) {
            return redirect()->route('admin.penilaian.index')
                ->with('error', 'Tidak ada periode seleksi yang sedang aktif. Silakan aktifkan periode terlebih dahulu.');
        }

        $siswa = Siswa::findOrFail($siswaId);
        $kriterias = Kriteria::with('subKriterias')->orderBy('kode_kriteria', 'asc')->get();

        if ($kriterias->isEmpty()) {
            return redirect()->route('admin.kriteria.index')
                ->with('error', 'Data kriteria belum tersedia. Buat kriteria dan sub kriteria terlebih dahulu.');
        }

        // Ambil nilai yang sudah pernah diinput untuk siswa ini di periode aktif
        $existingPenilaians = Penilaian::where('periode_id', $periodeAktif->id)
            ->where('siswa_id', $siswa->id)
            ->pluck('sub_kriteria_id', 'kriteria_id')
            ->toArray();

        return view('pages.admin.penilaian.form', compact('siswa', 'periodeAktif', 'kriterias', 'existingPenilaians'));
    }

    public function update(Request $request, string $siswaId)
    {
        $periodeAktif = Periode::where('status_aktif', true)->first();

        if (!$periodeAktif) {
            return redirect()->route('admin.penilaian.index')
                ->with('error', 'Periode aktif tidak ditemukan.');
        }

        $siswa = Siswa::findOrFail($siswaId);
        $kriterias = Kriteria::all();

        // Validasi: pastikan setiap kriteria dipilih sub-kriterianya
        $rules = [];
        $messages = [];
        foreach ($kriterias as $kriteria) {
            $rules["kriteria.{$kriteria->id}"] = 'required|exists:sub_kriterias,id';
            $messages["kriteria.{$kriteria->id}.required"] = "Kriteria [{$kriteria->kode_kriteria}] {$kriteria->nama_kriteria} wajib dinilai.";
        }

        $request->validate($rules, $messages);

        DB::transaction(function () use ($request, $periodeAktif, $siswa, $kriterias) {
            foreach ($kriterias as $kriteria) {
                $subKriteriaId = $request->input("kriteria.{$kriteria->id}");

                Penilaian::updateOrCreate(
                    [
                        'periode_id' => $periodeAktif->id,
                        'siswa_id' => $siswa->id,
                        'kriteria_id' => $kriteria->id,
                    ],
                    [
                        'sub_kriteria_id' => $subKriteriaId,
                    ]
                );
            }
        });

        return redirect()->route('admin.penilaian.index')
            ->with('success', "Penilaian untuk siswa {$siswa->nama} berhasil disimpan.");
    }
}
