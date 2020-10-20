<?php

namespace App\Traits;

trait UserTrait{
    public function roles(){//muchos a muchos devuelve todos los roles del usuario
        return $this->belongsToMany('App\Role')->withTimestamps();
     }

    public function havePermission($permission){
        foreach($this->roles as $role){//recorremos los roles que tiene el usuario
            foreach($role->permissions()->get() as $perm){
                if($perm->slug==$permission){
                    return true;
                }
            }
        }
        return false;
    }

    public function permissions(){//devuelve todos los permisos del usuario
        return $this->belongsToMany('App\Permission')->withTimestamps();
    }

    public function hasPermission2($perm){//este método deberia sustituir el havePermission ya qeu ahorra buscar por rol
        foreach($this->permissions as $permission){
            if($permission->slug==$perm){
                return true;
            }

        }
        return false;
    }

    public function isAdmin(){
        foreach($this->roles as $role){
            if($role->slug =='adminfullaccess'){
                return true;
            }
        }
        return false;
    }

    public function scopeBuscarPor($query, $tipo, $buscar){
        if(($tipo)&&($buscar)){
            return $query->where($tipo, 'like','%'.$buscar.'%')//para poner el texto buscado en negrita
            ->get()->map( function ($row) use ($buscar, $tipo){
                switch($tipo){
                    case 'name':
                        $row->name=preg_replace('/('.$buscar.')/i',"<b>$0</b>", $row->name);
                    break;
                    case 'surname':
                        $row->surname=preg_replace('/('.$buscar.')/i',"<b>$0</b>", $row->surname);
                    break;
                    case 'email':
                        $row->email=preg_replace('/('.$buscar.')/i',"<b>$0</b>", $row->email);
                    break;
                    case 'username':
                        $row->username=preg_replace('/('.$buscar.')/i',"<b>$0</b>", $row->username);
                    break;
                }
                return $row;
            });//i porque es insensitive */
        }
        else{
            return $query->with('roles')->orderBy('id', 'Desc');
        }

    }

}