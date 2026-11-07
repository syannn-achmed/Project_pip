<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SiswaExport;
use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with('ortu')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('nama_ortu', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('jk')) {
            $query->where('jk', $request->jk);
        }

        $siswas = $query->paginate(10)->withQueryString();
        $kelasList = Siswa::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');
        $ortuUsers = User::role('orang_tua')->orderBy('name')->get();

        return view('pages.admin.siswa.index', compact('siswas', 'kelasList', 'ortuUsers'));
    }

    public function create()
    {
        // Ambil akun user dengan role orang_tua jika ada
        $ortuUsers = User::role('orang_tua')->orderBy('name')->get();
        return view('pages.admin.siswa.create', compact('ortuUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|max:30|unique:siswas,nis',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'jk' => 'required|in:L,P',
            'nama_ortu' => 'required|string|max:255',
            'pekerjaan_ortu' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:30',
            'alamat' => 'nullable|string',
            'user_id_ortu' => 'nullable|exists:users,id',
            'email_ortu_baru' => 'nullable|email|unique:users,email',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['foto', 'buat_akun_ortu', 'email_ortu_baru', 'password_ortu_baru']);

        // Jika dicentang buat akun orang tua baru secara otomatis
        if ($request->boolean('buat_akun_ortu') && $request->filled('email_ortu_baru')) {
            $ortuUser = User::create([
                'name' => $request->nama_ortu,
                'email' => $request->email_ortu_baru,
                'password' => \Illuminate\Support\Facades\Hash::make($request->input('password_ortu_baru', 'password123')),
            ]);
            $ortuUser->assignRole('orang_tua');
            $data['user_id_ortu'] = $ortuUser->id;
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswas', 'public');
        }

        Siswa::create($data);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $ortuUsers = User::role('orang_tua')->orderBy('name')->get();

        return view('pages.admin.siswa.edit', compact('siswa', 'ortuUsers'));
    }

    public function update(Request $request, string $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis' => 'required|string|max:30|unique:siswas,nis,' . $id,
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'jk' => 'required|in:L,P',
            'nama_ortu' => 'required|string|max:255',
            'pekerjaan_ortu' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:30',
            'alamat' => 'nullable|string',
            'user_id_ortu' => 'nullable|exists:users,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['foto']);

        if ($request->hasFile('foto')) {
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $data['foto'] = $request->file('foto')->store('siswas', 'public');
        }

        $siswa->update($data);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);

        if ($siswa->penilaians()->exists()) {
            return redirect()->route('admin.siswa.index')
                ->with('error', 'Gagal! Siswa ini sudah memiliki riwayat penilaian. Hapus data penilaian terlebih dahulu atau nonaktifkan.');
        }

        if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->delete();

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new SiswaExport, 'Data_Siswa_PIP_' . date('Ymd_His') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            Excel::import(new SiswaImport, $request->file('file'));
            return redirect()->route('admin.siswa.index')
                ->with('success', 'Data siswa berhasil diimpor dari file Excel.');
        } catch (\Exception $e) {
            return redirect()->route('admin.siswa.index')
                ->with('error', 'Gagal mengimpor file: ' . $e->getMessage());
        }
    }
}
