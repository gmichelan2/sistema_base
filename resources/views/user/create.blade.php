@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Crear Usuario</h2></div>

                <div class="card-body">
                    @include('custom.message')

                    <form action="{{route('user.store')}}" method="POST">
                        @csrf

                        <div class="container">
                            <h3>Datos requeridos</h3>
                            <hr>
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" placeholder="Nombres" name="name"
                                value="{{old('name')}}" required autocomplete="name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="surname" placeholder="Apellido" name="surname" value="{{old('surname')}}" required autocomplete="surname">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="email" placeholder="Direccion de email" name="email" value="{{old('email')}}" required autocomplete="email">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="username" placeholder="Nombre de usuario" name="username" value="{{old('username')}}" required autocomplete="username">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="password" placeholder="Password" name="password" value="{{old('password')}}" required autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="password-confirm" placeholder="Repita el password" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <hr>
                            <h3>Roles</h3>
                            @foreach($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="role_{{$role->id}}"
                                    value="{{$role->id}}"
                                    name="role[]"
                                    @if(is_array(old('role')) && in_array("$role->id",old('role')))
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
                            <!--div class="form-group">
                                <select class="form-comtrol" name="role" id="role">
                                @foreach($roles as $role)
                                    @if($role->slug!='adminfullaccess')
                                        <option value="{{$role->id}}"
                                            @if($role->slug=='basicuser')
                                            selected
                                            @endif
                                            >
                                            {{$role->name}}
                                        </option>
                                    @endif
                                @endforeach
                                </select>
                            </div-->
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