<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class NilaiPengetahuan extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $primaryKey = 'id_np';
    protected $table = 'nilai_pengetahuan';
    protected $fillable = [
        'id_siswa', 
        'id_ta', 
        'id_mapel', 
        'id_kd', 
        'id_tema', 
        'id_jn', 
        'nilai',
    ];
}