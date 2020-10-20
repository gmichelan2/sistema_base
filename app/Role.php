<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //es: desde aqui
    //en: from here
    protected $fillable = [
        'name','slug', 'description',
    ];

    public function users(){//muchos a muchos
       return $this->belongsToMany('App\User')->withTimestamps();
    }

    public function permissions(){//muchos a muchos
        return $this->belongsToMany('App\Permission')->withTimestamps();
        //dd($this->belongsToMany('App\Permission')->withTimestamps());
     }

     public function scopeBuscarPor($query, $tipo, $buscar){
         if(($tipo)&&($buscar)){
             return $query->where($tipo, 'like', '%'.$buscar.'%')->get()->map( function ($row) use ($buscar, $tipo){
                switch($tipo){
                    case 'name':
                        $row->name=preg_replace('/('.$buscar.')/i',"<b>$0</b>", $row->name);
                    break;
                    case 'slug':
                        $row->slug=preg_replace('/('.$buscar.')/i',"<b>$0</b>", $row->slug);
                    break;
                }
                return $row;
            });
         }
         else{
             return $query->orderBy('id', 'Desc');
         }
     }
}
