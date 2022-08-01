<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Tema extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $primaryKey = 'id_tema';
    protected $table = 'tema';
    protected $fillable = ['id_mapel', 'nama_tema'];

    public function temakd(){
        return $this->hasMany(TemaKd::class);
    }

    public function temajenis(){
        return $this->hasMany(TemaJenis::class);
    }

    public function mapel(){
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }
}