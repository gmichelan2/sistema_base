@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Editando usuario {{$user->name}}</h2></div>

                <div class="card-body">
                    @include('custom.message')

                    <form action="{{route('user.update', $user->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="container">
                            <h3>Datos</h3>
                            <hr>
                            <div class="form-group">
                                <label for="name">Nombres</label-->
                                <input type="name" class="form-control" id="name" placeholder="Nombre del usuario" name="name"
                                value="{{old('name',$user->name)}}">
                            </div>
                            <div class="form-group">
                                <label for="surname">Apellido</label-->
                                <input type="surname" class="form-control" id="surname" placeholder="Nombre del usuario" name="surname"
                                value="{{old('surname',$user->surname)}}">
                            </div>
                            @can('isAdmin')
                                <div class="form-group">
                                    <label for="email">Email</label-->
                                    <input type="email" class="form-control" id="email" placeholder="email del usuario" name="email"
                                    value="{{old('email',$user->email)}}">
                                </div>
                                <hr>
                                <h3>Roles del usuario</h3> 
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
                                        @if($role->slug=='adminfullaccess')
                                            disabled
                                        @endif
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
                                        >
                                        <label class="form-check-label" for="permission_{{$permission->id}}">
                                            {{$permission->id}}
                                            -
                                            {{$permission->name}}
                                            <em>({{$permission->description}})</em>
                                        </label>
                                    </div>
                                @endforeach
                                <!--div class="form-group">
                                    <select class="form-comtrol" name="roles" id="roles">
                                    @foreach($roles as $role)
                                        @if($role->slug!=='adminfullaccess')
                                            <option value="{{$role->id}}"
                                            @isset($user->roles[0]->name)
                                                @if($role->name==$user->roles[0]->name)
                                                selected
                                                @endif
                                            @endisset
                                            >{{$role->name}}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                </div-->
                            @endcan
                            <hr>
                            <input type="submit" class="btn btn-primary" value="Guardar">
                            </div>
                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection