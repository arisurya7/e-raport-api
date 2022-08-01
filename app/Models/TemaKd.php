<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class TemaKd extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $primaryKey = 'id_tkd';
    protected $table = 'tema_kd';
    protected $fillable = ['id_tema', 'id_kd'];

    public function kompetensidasar(){
        return $this->belongsTo(KompetensiDasar::class, 'id_kd');
    }

    public function tema(){
        return $this->belongsTo(Tema::class, 'id_tema');
    }
}