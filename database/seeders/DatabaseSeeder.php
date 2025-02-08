<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $tahunAjaran = TahunAjaran::create([
            'tahun_ajaran' => "2024/2025",
            'is_active' => true,
        ]);

        $adm = Jurusan::create([
            'nama' => "administrasi perkantoran",
            'is_active' => true,
        ]);

        $tkj = Jurusan::create([
            'nama' => "tkj",
            'is_active' => true,
        ]);

        Kelas::create([
            'tahun_ajaran_id' => $tahunAjaran->id,
            'jurusan_id' => $adm->id,
            'nama' => 'Kelas 1 ADM',
        ]);

        Kelas::create([
            'tahun_ajaran_id' => $tahunAjaran->id,
            'jurusan_id' => $tkj->id,
            'nama' => 'Kelas 1 TKJ',
        ]);

        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('qwerty123')
        ]);
    }
}
