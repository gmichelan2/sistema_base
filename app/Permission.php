<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    protected $fillable = [
        'name','slug', 'description',
    ];

    public function roles(){//muchos a muchos
        return $this->belongsToMany('App\Role')->withTimestamps();
     }

    public function users(){//pertenece a muchos usuarios, devuelve todos esos usuariosA
        return $this->belongsToMany('App\User')->withTimestapms();

    }
}
