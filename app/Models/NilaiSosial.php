<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class NilaiSosial extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $primaryKey = 'id_sosial';
    protected $table = 'nilai_sosial';
    protected $fillable = [
        'id_siswa', 
        'id_ta', 
        'jujur', 
        'disiplin', 
        'tanggung_jawab', 
        'santun', 
        'peduli',
        'percaya_diri',
        'deskripsi'
    ];
}