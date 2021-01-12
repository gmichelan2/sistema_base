@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Ver usuario {{$user->name}}</h2></div>
                <div class="card-body">
                    @include('custom.message')
                        <div class="container">
                        <h3>Datos del usuario</h3>
                            <hr>
                            <div class="form-group">
                                <label for="name">Nombres</label-->
                                <input type="name" class="form-control" id="name" placeholder="Nombre del usuario" name="name"
                                value="{{old('name',$user->name)}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="surname">Apellido</label-->
                                <input type="surname" class="form-control" id="surname" placeholder="Nombre del usuario" name="surname"
                                value="{{old('surname',$user->surname)}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="email">Dirección de email</label-->
                                <input type="email" class="form-control" id="email" placeholder="Email del usuario" name="email"
                                value="{{old('email',$user->email)}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="username">Nombre Usuario</label-->
                                <input type="text" class="form-control" id="username" placeholder="username" name="username" value="{{old('username', $user->username)}}" disabled>
                            </div>
                            <div class="form-group">
                                <a href="{{route('passwordown.edit', $user->id)}}" class="btn btn-danger">Modificar contraseña</a>
                            </div>
                            <hr>
                            <h3>Roles asignados:</h3>
                            @can('isAdmin')
                                @foreach($roles as $role)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="role_{{$role->id}}"
                                        value="{{$role->id}}"
                                        name="role[]"
                                        @if(is_array(old('role')) && in_array("$role->id",old('role')))
                                            checked
                                        @elseif(is_array($role_user) && in_array("$role->id",$role_user))
                                            checked
                                        @endif
                                        disabled
                                        >
                                        <label class="form-check-label" for="role_{{$role->id}}">
                                        {{$role->id}}
                                        -
                                        {{$role->name}}
                                        <em>({{$role->description}})</em>
                                    </label>
                                    </div>
                                @endforeach
                                <hr>
                                <h3>Permisos asignados</h3>
                                @foreach($permissions as $permission)
                                <div class="form-check">
                                    <input disable class="form-check-input" type="checkbox" id="permission_{{$permission->id}}"
                                    value="{{$permission->id}}"
                                    name="permission[]"
                                    
                                    @if(is_array(old('permission')) && in_array("$permission->id",old('permission')))
                                    checked

                                    @elseif(is_array($permission_user) && in_array("$permission->id",$permission_user))
                                    checked
                                    @endif
                                    disabled>
                                    <label class="form-check-label" for="permission_{{$permission->id}}">
                                        {{$permission->id}}
                                        -
                                        {{$permission->name}}
                                        <em>({{$permission->description}})</em>
                                    </label>
                                    </div>
                                @endforeach
                            @endcan
                            @cannot('isAdmin')
                            @foreach($roles as $role)
                                <ul>
                                @if(in_array("$role->id",$role_user))
                                    <li>{{$role->name}}<em>({{$role->description}})</em></li>
                                @endif
                                </ul>
                                @endforeach
                            @endcannot
                            <!--div class="form-group">
                                <select disabled class="form-comtrol" name="roles" id="roles">
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}"
                                    @isset($user->roles[0]->name)
                                        @if($role->name==$user->roles[0]->name)
                                        selected
                                        @endif
                                    @endisset
                                    >{{$role->name}}</option>
                                @endforeach
                                </select>
                            </div-->
                            <hr>
                            @if($user->username!='admin')
                                <a class="btn btn-success" href="{{route('user.edit',$user->id)}}">Editar</a>
                            @else
                                <a class="btn btn-success disabled" href="{{route('user.edit',$user->id)}}">Editar</a>
                            @endif
                            <!--a class="btn btn-danger" href="{{route('user.index')}}">Volver</a-->
                            @cannot('isAdmin')
                                <a class="btn btn-danger" href="{{route('home')}}">Volver</a>
                            @endcannot
                            @can('isAdmin')
                                <a class="btn btn-danger" href="{{route('user.index')}}">Volver</a>
                            @endcan
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection