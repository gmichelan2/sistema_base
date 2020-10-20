@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Estás mirando el rol {{$role->name}}</h2></div>

                <div class="card-body">
                    @include('custom.message')

                    <form action="{{route('role.update', $role->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="container">
                            <h3>Datos</h3>
                            <hr>
                            <div class="form-group">
                                <label for="name">Nombre del rol</label>
                                <input type="email" class="form-control" id="name" placeholder="Nombre del rol" name="name"
                                value="{{old('name',$role->name)}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="slug">Identificador del rol</label>
                                <input type="text" class="form-control" id="slug" placeholder="Slug" name="slug" value="{{old('slug', $role->slug)}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="description">Descripción del rol</label>
                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Descripción" readonly>{{old('description', $role->description)}}</textarea>
                            </div>

                            <hr>
                            <h3>Lista de permisos</h3>
                            @foreach($permissions as $permission)
                            <div class="form-check">
                                <input disable class="form-check-input" type="checkbox" value="" id="permission_{{$permission->id}}"
                                value="{{$permission->id}}"
                                name="permission[]"
                                
                                @if(is_array(old('permission')) && in_array("$permission->id",old('permission')))
                                checked

                                @elseif(is_array($permission_role) && in_array("$permission->id",$permission_role))
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
                            <hr>
                            @if($role->slug!='adminfullaccess')
                                <a class="btn btn-success" href="{{route('role.edit',$role->id)}}">Editar</a>
                            @else
                                <a class="btn btn-success disabled" href="{{route('role.edit',$role->id)}}">Editar</a>
                            @endif
                            <a class="btn btn-danger" href="{{route('role.index')}}">Volver</a>
                            
                            </div>
                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection