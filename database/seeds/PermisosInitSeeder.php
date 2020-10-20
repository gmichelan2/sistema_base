<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Permission;
use Illuminate\Support\Facades\Hash;//encripta las contraseñas
use Illuminate\Support\Facades\DB;

class PermisosInitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   //borro tablas sin modelos con truncate
        //DB::statement("SET FOREIGN_KEY_CHECKS=0;");//desabilitamos los foreign keys mysql
        //DB::statement("SET session_replication_role = 'replica';");//postgres
        //DB::table('role_user')->truncate();
        //DB::table('permission_role')->truncate();
        //DB::statement("SET session_replication_role = 'origin';");//postgress
        //DB::statement("SET FOREIGN_KEY_CHECKS=1;");//habilitamos los foreign mysql 

        //Permission::truncate();
        //Role::truncate();

        //user admin
        $userAdmin= User::where('username','admin')->first();
        if($userAdmin){
            $userAdmin->delete();
        }

        $userAdmin= User::create([
            'name' => 'admin',
            'surname' =>'admin',
            'email' => 'admin@epen.gov.ar',
            'username' =>'admin',
            'password' => Hash::make('admin')//hay que establecer un password privado pero estandar
        ]);

       /* $userbasic= User::create([
            'name' => 'gaston',
            'surname' =>'michelan',
            'nick' =>'gmichelan',
            'password' => Hash::make('gmichelan')//hay que establecer un password privado pero estandar
        ]);*/

        //rol admin
        $rolAdmin=Role::create([
            'name'=>'Admin',
            'slug'=>'adminfullaccess',
            'description'=>'Administrador del sistema'
        ]);

        $rolBasic=Role::create([
            'name'=>'Usuario básico',
            'slug'=>'basicuser',
            'description'=>'Usuario básico del sistema'
        ]);

        //tabla_role_user
        $userAdmin->roles()->sync([$rolAdmin->id]);

        //permisos
        $permission_all=[];
        $permission_basic=[];
        //permission role
        $permission=Permission::create([
            'name'=>'Listar roles',
            'slug'=>'role.index',
            'description'=>'Un usuario puede listar roles'
        ]);

        $permission_all[]=$permission->id;

        $permission=Permission::create([
            'name'=>'Mostrar rol',
            'slug'=>'role.show',
            'description'=>'Un usuario puede ver un rol'
        ]);

        $permission_all[]=$permission->id;

        $permission=Permission::create([
            'name'=>'Crear rol',
            'slug'=>'role.create',
            'description'=>'Un usuario puede crear un rol'
        ]);

        $permission_all[]=$permission->id;

        $permission=Permission::create([
            'name'=>'Editar roles',
            'slug'=>'role.edit',
            'description'=>'Un usuario puede modificar un rol'
        ]);

        $permission_all[]=$permission->id;

        $permission=Permission::create([
            'name'=>'Eliminar roles',
            'slug'=>'role.destroy',
            'description'=>'Un usuario puede eliminar un rol'
        ]);

        $permission_all[]=$permission->id;

        //permisos user
        $permission=Permission::create([
            'name'=>'Listar usuarios',
            'slug'=>'user.index',
            'description'=>'Listar los usuarios del sistema'
        ]);

        $permission_all[]=$permission->id;

        $permission=Permission::create([
            'name'=>'Mostrar usuario',
            'slug'=>'user.show',
            'description'=>'Mostrar la información de un usuario'
        ]);

        $permission_all[]=$permission->id;

        $permission=Permission::create([
            'name'=>'Editar usuario',
            'slug'=>'user.edit',
            'description'=>'Modificar la información de un usuario'
        ]);

        $permission_all[]=$permission->id;

        $permission=Permission::create([
            'name'=>'Eliminar un usuario',
            'slug'=>'user.destroy',
            'description'=>'Elimina un usuario de la base de datos'
        ]);

        $permission_all[]=$permission->id;

        $permission=Permission::create([
            'name'=>'Crear un usuario',
            'slug'=>'user.create',
            'description'=>'Crea un usuario en la base de datos'
        ]);

        $permission_all[]=$permission->id;

        $permission=Permission::create([
            'name'=>'Ver propio usuario',
            'slug'=>'userown.show',
            'description'=>'El usuario tiene acceso solamente a ver su informacion (para no admins)'
        ]);

        $permission_all[]=$permission->id;
        $permission_basic[]=$permission->id;

        $permission=Permission::create([
            'name'=>'Editar mi propio usuario',
            'slug'=>'userown.edit',
            'description'=>'El usuario puede solamente editar su propia información (para no admins)'
        ]);

        $permission_all[]=$permission->id;
        $permission_basic[]=$permission->id;

        
       /* $permission=Permission::create([
            'name'=>'permiso de prueba',
            'slug'=>'permission.prueba',
            'description'=>'prueba'
        ]);*/

        //table permission_role
        $rolAdmin->permissions()->sync($permission_all);//le metemos todos lso permisos al rol admin
        $rolBasic->permissions()->sync($permission_basic);//le metemos todos lso permisos al rol basico

        //tambien le metemos los permisos al usuario admin, así es más fácil administrarlos desde tabla permission_user
        $userAdmin->permissions()->sync($permission_all);

        //$userAdmin->permissions()->attach($permission->id);
    
    }
}
