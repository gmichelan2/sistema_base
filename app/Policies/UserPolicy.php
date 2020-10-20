<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $useraa es usuario autenticado por eso la a
     * @return mixed
     */
    public function viewAny(User $usera)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $usera
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $usera, User $user, $perm=null)
    {
        //si buscamos dentro del usuario autenticado y verificamos que el primer permiso
        //que es el global user.show corresponde al admin
        if($usera->havePermission($perm[0])){
            return true;
        }else{
            if($usera->havePermission($perm[1])){//tiene el own permission{
                return $usera->id === $user->id;//entonces si el usuario actual es el usuaario que le esto dando por paametro
            }
            else{
                return false;
            }
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $usera
     * @return mixed
     */
    public function create(User $usera)
    {
        return $usera->havePermission('user.create');
    }

    public function store(User $usera){
        return $usera->havePermission('user.create');
    }


    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $usera
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $usera, User $user, $perm=null)
    {
        
         //si buscamos dentro del usuario autenticado y verificamos que el primer permiso
        //que es el global user.show corresponde al admin
        if($usera->havePermission($perm[0])){
            return true;
        }else{
            if($usera->havePermission($perm[1])){//tiene el own permission{
                return $usera->id === $user->id;//entonces si el usuario actual es el usuaario que le esto dando por paametro
            }
            else{
                return false;
            }
        }

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $usera
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $usera, User $user)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $usera
     * @param  \App\User  $user
     * @return mixed
     */
    public function restore(User $usera, User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $usera
     * @param  \App\User  $user
     * @return mixed
     */
    public function forceDelete(User $usera, User $user)
    {
        //
    }
}
