<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAjaran;

class TahunAjaranTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TahunAjaran::create([
            'semester' => '1',
            'tahun' => '2021/2022'
        ]);

        TahunAjaran::create([
            'semester' => '2',
            'tahun' => '2021/2022'
        ]);
    }
}
