<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AkunOrtuController extends Controller
{
    /**
     * Tampilkan daftar akun orang tua beserta siswa yang tertaut.
     */
    public function index(Request $request)
    {
        $query = User::role('orang_tua')->with('siswas')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('siswas', function ($sub) use ($search) {
                        $sub->where('nama', 'like', "%{$search}%")
                            ->orWhere('nis', 'like', "%{$search}%")
                            ->orWhere('kelas', 'like', "%{$search}%");
                    });
            });
        }

        $akunOrtus = $query->paginate(10)->withQueryString();

        // Siswa yang belum memiliki akun orang tua
        $siswaBelumPunyaAkun = Siswa::whereNull('user_id_ortu')->orderBy('nama', 'asc')->get();

        return view('pages.admin.akun-ortu.index', compact('akunOrtus', 'siswaBelumPunyaAkun'));
    }

    /**
     * Tambah akun orang tua baru (dan opsional langsung tautkan ke siswa).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'siswa_id' => 'nullable|exists:siswas,id',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Berikan role orang_tua
            $user->assignRole('orang_tua');

            // Tautkan ke siswa jika dipilih
            if ($request->filled('siswa_id')) {
                Siswa::where('id', $request->siswa_id)->update([
                    'user_id_ortu' => $user->id,
                ]);
            }
        });

        return redirect()->route('admin.akun-ortu.index')
            ->with('success', 'Akun orang tua berhasil dibuat dan siap digunakan untuk login.');
    }

    /**
     * Buat akun orang tua cepat langsung dari halaman Data Siswa.
     */
    public function quickStoreForSiswa(Request $request, string $siswaId)
    {
        $siswa = Siswa::findOrFail($siswaId);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        DB::transaction(function () use ($request, $siswa) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('orang_tua');

            $siswa->update([
                'user_id_ortu' => $user->id,
            ]);
        });

        return back()->with('success', "Akun orang tua ({$request->email}) berhasil dibuat dan ditautkan ke siswa {$siswa->nama}.");
    }

    /**
     * Tautkan siswa ke akun orang tua yang sudah ada.
     */
    public function tautkanSiswa(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'user_id_ortu' => 'required|exists:users,id',
        ]);

        $siswa = Siswa::findOrFail($request->siswa_id);
        $user = User::findOrFail($request->user_id_ortu);

        $siswa->update(['user_id_ortu' => $user->id]);

        return back()->with('success', "Siswa {$siswa->nama} berhasil ditautkan ke akun orang tua {$user->name}.");
    }

    /**
     * Lepaskan tautan siswa dari akun orang tua.
     */
    public function lepasTautan(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
        ]);

        $siswa = Siswa::findOrFail($request->siswa_id);
        $siswa->update(['user_id_ortu' => null]);

        return back()->with('success', "Tautan akun orang tua untuk siswa {$siswa->nama} telah dilepaskan.");
    }

    /**
     * Perbarui data akun orang tua (nama, email, atau reset sandi).
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.akun-ortu.index')
            ->with('success', "Data akun orang tua {$user->name} berhasil diperbarui.");
    }

    /**
     * Hapus akun orang tua (siswa terkait otomatis di-null-kan foreign key-nya).
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        DB::transaction(function () use ($user) {
            Siswa::where('user_id_ortu', $user->id)->update(['user_id_ortu' => null]);
            $user->delete();
        });

        return redirect()->route('admin.akun-ortu.index')
            ->with('success', 'Akun orang tua berhasil dihapus dari sistem.');
    }
}
