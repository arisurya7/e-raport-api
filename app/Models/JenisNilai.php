<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class JenisNilai extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $primaryKey = 'id_jn';
    protected $table = 'jenis_nilai';

    protected $fillable = ['nama'];

    public function temajenis(){
        return $this->hasMany(TemaJenis::class);
    }

    public function nilaipengetahuan(){
        return $this->hasMany(NilaiPengetahuan::class);
    }
}