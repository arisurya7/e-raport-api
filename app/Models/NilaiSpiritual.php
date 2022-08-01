<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class NilaiSpiritual extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $primaryKey = 'id_spiritual';
    protected $table = 'nilai_spiritual';
    protected $fillable = [
        'id_siswa', 
        'id_ta', 
        'ketaatan_beribadah', 
        'berprilaku_bersyukur', 
        'berdoa', 
        'toleransi',
        'deskripsi'
    ];
}