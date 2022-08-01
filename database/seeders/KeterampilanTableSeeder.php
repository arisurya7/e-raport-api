<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Keterampilan;

class KeterampilanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Keterampilan::create([
            'nama' => 'Kinerja Praktik'
        ]);

        Keterampilan::create([
            'nama' => 'Kinerja Produk'
        ]);

        Keterampilan::create([
            'nama' => 'Proyek'
        ]);
    }
}
