@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Crear Rol</h2></div>

                <div class="card-body">
                    @include('custom.message')

                    <form action="{{route('role.store')}}" method="POST">
                        @csrf

                        <div class="container">
                            <h3>Datos requeridos</h3>
                            <hr>
                            <div class="form-group">
                                <!--label for="name">Email address</label-->
                                <input type="text" class="form-control" id="name" placeholder="Nombre del rol" name="name"
                                value="{{old('name')}}">
                            </div>
                            <div class="form-group">
                                <!--label for="exampleFormControlInput1">Email address</label-->
                                <input type="text" class="form-control" id="slug" placeholder="Slug" name="slug" value="{{old('slug')}}">
                                <small class="text-muted">Nombre corto descriptivo. Ej: adm, usrbasic, etc</small>
                            </div>
                            <div class="form-group">
                                <!--label for="exampleFormControlTextarea1">Example textarea</label-->
                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Descripción">{{old('description')}}</textarea>
                            </div>

                            <hr>
                            <h3>Lista de permisos</h3>
                            @foreach($permissions as $permission)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="permission_{{$permission->id}}"
                                value="{{$permission->id}}"
                                name="permission[]"
                                
                                @if(is_array(old('permission')) && in_array("$permission->id",old('permission')))
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