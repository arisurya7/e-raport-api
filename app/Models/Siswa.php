<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Siswa extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $primaryKey = 'id_siswa';
    protected $table = 'siswa';
    protected $fillable = [
        'id_user',
        'username',
        'password',
        'nis',
        'nisn',
        'nama_siswa',
        'nama_panggilan',
        'ttl',
        'jenis_kelamin',
        'agama',
        'alamat',
        'kelas'
    ];
}