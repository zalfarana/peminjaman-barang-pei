<?php

namespace Database\Seeders;
use App\Models\Mahasiswa;
use Faker\Factory as Faker;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MhsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $x = Faker::create('id_ID');
        for($i=0; $i<10;$i++) {
        Mahasiswa::create([
            'nim' => $x->numerify('#########'),
            'nm_mhs' => $x->name,
            'nm_prodi' => 'Teknologi Rekayasa Perangkat Lunak',
            'jeniskel' => $x->randomElement(['L', 'P']),
            'email' => $x->email,
            'telp' => $x->numerify('#########'),
            'foto' => 'default.jpg'
        ]);
        }
    }
}
