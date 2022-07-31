<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id_sekolah' => 1,
            'username' => 'user1',
            'password' => Hash::make('123'),
            'firstname' => 'User',
            'lastname' => 'Satu',
            'role' => 'admin',
            'email' => 'user1@gmail.com',
            'nip' => '1234',
            'token'=>'f9a7a8d618b03edbc9742ee8465f6804c46e2a4d16278750bfb9e73e7c4a3e79d60dd8af16b960b5',
            'gelar' => 'S.Pd.',
        ]);

        User::create([
            'id_sekolah' => 2,
            'username' => 'user2',
            'password' => Hash::make('123'),
            'firstname' => 'User',
            'lastname' => 'Dua',
            'role' => 'guru',
            'email' => 'user2@gmail.com',
            'nip' => '1234',
            'gelar' => 'S.Pd.',
        ]);

        User::create([
            'id_sekolah' => 3,
            'username' => 'user3',
            'password' => Hash::make('123'),
            'firstname' => 'User',
            'lastname' => 'Tiga',
            'role' => 'guru',
            'email' => 'user3@gmail.com',
            'nip' => '1234',
            'gelar' => 'S.Pd.',
        ]);

        User::create([
            'id_sekolah' => 4,
            'username' => 'user4',
            'password' => Hash::make('123'),
            'firstname' => 'User',
            'lastname' => 'Empat',
            'role' => 'guru',
            'email' => 'user4@gmail.com',
            'nip' => '1234',
            'gelar' => 'S.Pd.',
        ]);
    }
}
