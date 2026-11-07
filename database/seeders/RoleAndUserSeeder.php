<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Roles
        $roleAdmin = Role::create(['name' => 'admin_tu']);
        $roleKepsek = Role::create(['name' => 'kepala_sekolah']);
        $roleOrtu = Role::create(['name' => 'orang_tua']);

        // 2. Buat Dummy Admin TU
        $admin = User::create([
            'name' => 'Admin Tata Usaha',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('password123'), // Biasakan pakai Hash
        ]);
        $admin->assignRole($roleAdmin);

        // 3. Buat Dummy Kepala Sekolah
        $kepsek = User::create([
            'name' => 'Bapak Kepala Sekolah',
            'email' => 'kepsek@sekolah.com',
            'password' => Hash::make('password123'),
        ]);
        $kepsek->assignRole($roleKepsek);

        // 4. Buat Dummy Orang Tua (Contoh 1 orang)
        $ortu = User::create([
            'name' => 'Bapak Budi (Ortu Siswa)',
            'email' => 'ortu@sekolah.com',
            'password' => Hash::make('password123'),
        ]);
        $ortu->assignRole($roleOrtu);

        $this->command->info('Roles dan Dummy Users berhasil dibuat!');
    }
}
