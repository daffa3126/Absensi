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
            'password' => Hash::make('P@55word'),
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'Biya',
            'email' => 'karyawan@gmail.com',
            'password' => Hash::make('P@55word'),
            'role' => 'karyawan'
        ]);
    }
}
