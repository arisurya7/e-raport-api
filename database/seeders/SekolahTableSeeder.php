<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sekolah;

class SekolahTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sekolah::create([
            'nama_sekolah' => 'SDN 1 Kemenuh',
            'telp' => '123567',
            'alamat' => 'Jl. Sutami',
            'kelurahan' => 'Kemenuh',
            'kecamatan' => 'Sukawati',
            'kabupaten' => 'Gianyar',
            'provinsi' => 'Bali'
        ]);

        Sekolah::create([
            'nama_sekolah' => 'SDN 2 Kemenuh',
            'telp' => '123567',
            'alamat' => 'Jl. Sutami',
            'kelurahan' => 'Kemenuh',
            'kecamatan' => 'Sukawati',
            'kabupaten' => 'Gianyar',
            'provinsi' => 'Bali'
        ]);

        Sekolah::create([
            'nama_sekolah' => 'SDN 3 Kemenuh',
            'telp' => '123567',
            'alamat' => 'Jl. Sutami',
            'kelurahan' => 'Kemenuh',
            'kecamatan' => 'Sukawati',
            'kabupaten' => 'Gianyar',
            'provinsi' => 'Bali'
        ]);

        Sekolah::create([
            'nama_sekolah' => 'SDN 4 Kemenuh',
            'telp' => '123567',
            'alamat' => 'Jl. Sutami',
            'kelurahan' => 'Kemenuh',
            'kecamatan' => 'Sukawati',
            'kabupaten' => 'Gianyar',
            'provinsi' => 'Bali'
        ]);

    }
}
