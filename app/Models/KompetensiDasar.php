<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class KompetensiDasar extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $primaryKey = 'id_kd';
    protected $table = 'kompetensi_dasar';
    protected $fillable = ['id_mapel', 'kode_kd', 'kategori_kd', 'deskripsi_kd'];

    public function mapel(){
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }

    public function temakd(){
        return $this->hasMany(TemaKd::class);
    }

    public function nilaiketerampilan(){
        return $this->hasMany(NilaiKeterampilan::class);
    }

    public function nilaipengetahuan(){
        return $this->hasMany(NilaiPengetahuan::class);
    }
}