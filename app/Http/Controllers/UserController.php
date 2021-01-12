<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use App\Permission;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $this->authorize('haveaccess','user.index');

        $tipo=$request->get('buscarPor');
        $palabra=$request->get('palabraClave');
        $users= User::buscarPor($tipo,$palabra)->paginate(20);
        //($users->items);
        //dd($users);
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',User::class);//usamos el método create de la politica y le pasamos el modelo
        $roles = Role::get(); //igual que all()
        $users=DB::connection('rh_db_connection')->table('rh_agente')->where('activo',true)->orderBy('apellido','ASC')->get();
        return view('user.create', compact('roles','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $this->authorize('store', User::class);
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'surname'=>'required|string|max:255',
        //     'email'=>'required|email',
        //     'username' =>'required|string|max:255|unique:users,username',
        //     'password' => 'required|string|min:8|confirmed',
        //     'role'=>'required',
        // ]);
        $request->validate([
            'cuil'=>'required|unique:users,cuil',
            'role'=>'required'
        ]);

        //$request->merge(['password'=>Hash::make($request->get('password'))]);
        $usuario=DB::connection("rh_db_connection")->table('rh_agente')->where('cuil',$request->get('cuil'))->get();
        $cuenta=DB::connection('seguridad_db_connection')->table('usuario')->where('usu_agente',$usuario[0]->agente)->get();
        $email=$cuenta[0]->usu_mail;
        $username=explode('@',$email);
        $username=$username[0];
        $nuevoUsuario=[ 'name'=>$usuario[0]->nombre,
                        'surname'=>$usuario[0]->apellido,
                        'email'=>$email,
                        'username'=>$username,
                        'cuil'=>$usuario[0]->cuil,
                        'password'=>Hash::make($usuario[0]->doc_numero),
                        'changedpassword'=>0
                        ];
        $user=User::create($nuevoUsuario);

        //al crear el nuevo usuario debo meterle los permisos del role asignado en la tabla permission_user
        $user->roles()->sync($request->get('role'));
        $permisos=[];
        foreach($user->roles as $role){//por cada rol tomo los id de los permisos
            foreach($role->permissions as $perm){//tomo los permisos de cada rol
                if(!in_array(strval($perm->id), $permisos)){
                    $permisos[]=$perm->id;
                }
            }
        }
        //hay que agregar siempre por default los permisos bpasicos de usuario que son los referidos
        //a ver su perfil y editar su información (userown.show y userown.edit)
        $permiso=Permission::where('slug','userown.show')->first();
        $permiso2=Permission::where('slug','userown.edit')->first();
        $permisos[]=$permiso->id;
        $permisos[]=$permiso2->id;

        $user->permissions()->sync($permisos);//sincronizo los permisos obtenidos

        return redirect()->route('user.index')->with('status_success','Usuario creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        $this->authorize('view', [$user, ['user.show','userown.show']]);//política le paso varias variables

        $permission_user=[];
        foreach($user->permissions()->get() as $permission){
            $permission_user[]=$permission->id;//id de los permisos del usuario
        }

        $role_user=[];
        foreach($user->roles as $role){
            $role_user[]=$role->id;
        }

        $roles = Role::orderBy('name')->get(); //igual que all() todos los roles declarados
        $permissions= Permission::get();//todos lso permisos declarados


        return view('user.view', compact('roles', 'user','permissions', 'permission_user','role_user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        $this->authorize('update', [$user, ['user.edit','userown.edit']]);//política le paso varias variables

        $permission_user=[];
        foreach($user->permissions()->get() as $permission){
            $permission_user[]=$permission->id;//id de los permisos del usuario
        }

        $role_user=[];
        foreach($user->roles as $role){
            $role_user[]=$role->id;
        }

        $roles = Role::orderBy('name')->get(); //igual que all()
        $permissions= Permission::get();//todos lso permisos declarados


        return view('user.edit', compact('roles', 'user', 'permissions', 'permission_user', 'role_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    { 
        //dd(Auth::user());
        //hay que tener en cuenta si el usuario que edita es admin o es user comun
        if(Auth::user()->isAdmin()){
            $request->validate(
                [
                'name'=>'required|max:50|unique:users,name,'.$user->id,
                'surname'=>'max:50|unique:users,surname,'.$user->id,
               // 'nick'=>'required|max:50|unique:users,nick,'.$user->id,
                'role'=>'required'//que el admin nunca se olvide de seleccionar un rol aunque sea el básico
            ]);
    
            $user->update($request->all());//colocas los atributos fillables en los datos del usuario
            $user->roles()->sync($request->get('role'));//sincronizas los roles del usuario 

            //ahora hay que sincronizar los permisos del usuario, tanto si estan dentro de un rol o si le agregaron permisos individuales
            $perm=$request->get('permission');
            //dd($request);
            foreach($user->roles as $role){
                foreach($role->permissions as $permission){
                    if(!in_array("'".$permission->id."'", $perm)){
                        $perm[]=$permission->id;
                    }
                }
            }

            //ya obtenidos todos los permisos sincronizo de nuevo todos los permisos del usuario
            //dd($perm);
            $user->permissions()->sync($perm);

            //redirecciona al index ya que tiene acceso por ser admin o tener permiso de admin
            return redirect()->route('user.show', compact('user'))->with('status_success','Usuario actualizado exitosamente');
        }
        else{//es user comun solo edita su info personal
            $request->validate(
                [
                'name'=>'required|max:50|unique:users,name,'.$user->id,
                'surname'=>'max:50|unique:users,surname,'.$user->id,
                //'nick'=>'required|max:50|unique:users,nick,'.$user->id,
            ]);

            $user->update($request->all());
            //redirecciona solo a su info personal
            return redirect()->route('user.show', compact('user'))->with('status_success','Tus datos han sido actualizados exitosamente');
        }
    }

    public function editContraseña(User $user){
        //dd($user);
        $this->authorize('update', [$user, ['user.edit','userown.edit']]);//política le paso el usuario y los slugs de los permisos
        
        return view('user.password', compact('user'));
    }

    public function updateContraseña(Request $request , User $user){
        //dd($request);
        $request->validate(
            [
            'contrasenia'=>'required|min:8|same:repetircontrasenia',
            'repetircontrasenia'=>'required|min:8',
        ]);

        $request->merge(['contrasenia'=>Hash::make($request->get('contrasenia'))]);

        $updatedUser=User::find($user->id);
        $updatedUser->password=$request->get('contrasenia');
        $updatedUser->save();

        return redirect()->route('user.show', compact('user'))->with('status_success', 'Contraseña modificada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $this->authorize('haveaccess','user.destroy');
        $user->delete();

        return redirect()->route('user.index')->with('status_success','Usuario eliminado exitosamente');
    }

    public function resetPrimerIngreso(){
        //dd(Auth::user());
        $user=User::find(Auth::user()->id);
        //dd($user);
        return view('user.resetpassword', compact('user'));
    }
}
