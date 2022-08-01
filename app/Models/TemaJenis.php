<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class TemaJenis extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $primaryKey = 'id_tj';
    protected $table = 'tema_jenis';
    protected $fillable = ['id_tema', 'id_jn'];

    public function tema(){
        return $this->belongsTo(Tema::class, 'id_tema');
    }

    public function jenisnilai(){
        return $this->belongsTo(JenisNilai::class, 'id_jn');
    }
}