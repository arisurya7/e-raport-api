<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Mapel extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $primaryKey = 'id_mapel';
    protected $table = 'mapel';
    protected $fillable = [
        'id_user',
        'nama_mapel',
        'kkm',
        'is_mulok',
        'is_religion'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kompetensidasar(){
        return $this->hasMany(KompetensiDasar::class);
    }
}