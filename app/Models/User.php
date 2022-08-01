<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $primaryKey = 'id_user';
    protected $hidden = [
        'password',
    ];
    
    protected $fillable = [
        'email',
        'username', 
        'password',
        'firstname', 
        'lastname', 
        'role',
        'nip', 
        'gelar',
        'id_sekolah',
        'token' 
    ];

    public function mapel(){
        return $this->hasMany(Mapel::class);
    }

    public function kompetensidasar(){
        return $this->hasManyThrough(KompetensiDasar::class, Mapel::class);
    }

    public function siswa(){
        return $this->hasMany(Siswa::class);
    }

    public function sekolah(){
        return $this->hasOne(Sekolah::class);
    }
}
