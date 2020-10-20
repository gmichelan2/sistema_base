@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Editar Rol {{$role->name}}</h2></div>

                <div class="card-body">
                    @include('custom.message')

                    <form action="{{route('role.update', $role->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="container">
                            <h3>Datos permitidos para modificar</h3>
                            <hr>
                            <div class="form-group">
                                <label for="name">Nombre del rol</label>
                                <input type="text" class="form-control" id="name" placeholder="Nombre del rol" name="name"
                                value="{{old('name',$role->name)}}">
                            </div>
                            <div class="form-group">
                                <label for="slug">Identificador del rol</label>
                                <input type="text" class="form-control" id="slug" placeholder="Slug" name="slug" value="{{old('slug', $role->slug)}}">
                            </div>
                            <div class="form-group">
                                <label for="description">Descripción del rol</label>
                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Descripción">{{old('description', $role->description)}}</textarea>
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

                                @elseif(is_array($permission_role) && in_array("$permission->id",$permission_role))
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