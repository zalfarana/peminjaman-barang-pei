<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{ 
    /**
     * Seed the application's database.
     */
    public function run()
    {
       User::create([
        'id_user' => '202304004',
        'nama' => 'Zalfa Noor',
        'email' => 'zalfaranatask@gmail.com',
        'role' => 'Mahasiswa',
        'password' => Hash::make('1234'),
        'no_hp' => '081221099567'
       ]);


    }
}
