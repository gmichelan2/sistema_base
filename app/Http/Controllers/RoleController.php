<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        //para mostrar los roles de la app
        Gate::authorize('haveaccess','role.index');
        $tipo=$request->get('buscarPor');
        $palabra=$request->get('palabraClave');

        $roles= Role::buscarPor($tipo, $palabra)->paginate(10);
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        Gate::authorize('haveaccess','role.create');
        $permissions = Permission::get(); //igual que all()
        return view('role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Gate::authorize('haveaccess','role.create');
        //unique es unico en la tabla roles de acuerdo a la variable name
        //in:yes,no significa que espero yes o no en el campo nada más
        $request->validate([
            'name'=>'required|max:50|unique:roles,name',
            'slug'=>'required|max:50|unique:roles,slug'
        ]);

        $role=Role::create($request->all());
        if($request->get('permission')){//si marco permisos lo guardo y le asigno permisos
            $role->permissions()->sync($request->get('permission'));        
        }

        return redirect()->route('role.index')->with('status_success','Rol almacenado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //tambien aplica con el $this en lugar del Gate
        $this->authorize('haveaccess','role.show');
        
        $permission_role=[];
        foreach($role->permissions()->get() as $permission){
            $permission_role[]=$permission->id;
        }
        $permissions = Permission::get(); //igual que all()


        return view('role.view', compact('permissions', 'role','permission_role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //por model binding y no por $id
    public function edit(Role $role)
    {
        Gate::authorize('haveaccess','role.edit');
        //para obtener solo los ids de los permisos
        $permission_role=[];
        foreach($role->permissions()->get() as $permission){
            $permission_role[]=$permission->id;
        }
        $permissions = Permission::get(); //igual que all()


        return view('role.edit', compact('permissions', 'role','permission_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //tiene acceso
        Gate::authorize('haveaccess','role.edit');

        $request->validate(
            [
            'name'=>'required|max:50|unique:roles,name,'.$role->id,
            'slug'=>'required|max:50|unique:roles,name,'.$role->id,
        ]);

        $role->update($request->all());
        if($request->get('permission')){//si marco permisos lo guardo y le asigno permisos
            $role->permissions()->sync($request->get('permission'));        
        }

        return redirect()->route('role.index')->with('status_success','Rol actualizado exitosamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
        $this->authorize('haveaccess','role.destroy');
        $role->delete();
        return redirect()->route('role.index')->with('status_success','Rol eliminado exitosamente');
    }
}
