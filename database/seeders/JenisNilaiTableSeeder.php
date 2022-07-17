<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisNilai;

class JenisNilaiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisNilai::create([
            'nama' => 'Nilai Harian'
        ]);
        JenisNilai::create([
            'nama' => 'Nilai UTS'
        ]);
        JenisNilai::create([
            'nama' => 'Nilai UAS'
        ]);
    }
}
