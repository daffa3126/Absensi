<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Daffa',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'Biya',
            'email' => 'karyawan@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan'
        ]);

        // ================================================================
        // INI BAGIAN YANG DIUBAH
        // Kita akan membuat 500 user dengan role 'karyawan' secara otomatis.
        // Factory akan membuat nama dan email yang unik untuk setiap user.
        // ================================================================
        // User::factory()->count(500)->create([
        //     'password' => Hash::make('P@55word'),
        //     'role' => 'karyawan'
        // ]);
    }
}
