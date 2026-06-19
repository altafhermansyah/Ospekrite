<?php

namespace Database\Seeders;

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

        User::create([
            'nama_lengkap' => 'Dewa Ganteng',
            'nim' => '775577',
            'email' => 'admin@ospek.com',
            'no_whatsapp' => '081234567890',
            'fakultas' => 'STEI-K',
            'password' => \Illuminate\Support\Facades\Hash::make('timjago'),
            'role' => 'dewa',
        ]);
    }
}
