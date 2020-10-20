@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de Roles</h2></div>
                @include('custom.message')
                <div class="card-body">
                    <form class="form-inline my-2 my-lg-0">
                        <label for="exampleFormControlSelect1">Buscar por: </label>
                        <select name="buscarPor" class="form-control" id="exampleFormControlSelect1">
                            <option value="name">Nombre</option>
                            <option value="slug">Clave</option>
                            <!--option value="role">Rol</option-->
                        </select>
                        <input name="palabraClave" class="form-control mr-sm-2" type="search" placeholder="Escriba aquí la palabra a buscar" aria-label="Search">
                        <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Buscar</button>
                      </form>
                @can('haveaccess','role.create')
                    <a href="{{route('role.create')}}" class="btn btn-primary float-right">Nuevo Rol</a>       
                    <br>
                    <br>
                @endcan
            
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Clave</th>
                            <th scope="col">Descripción</th>
                            <th colspan="3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                             @foreach($roles as $role)
                             <tr>
                                <th scope="row">{{$role->id}}</th>
                                <td>{!!$role->name!!}</td>
                                <td>{!!$role->slug!!}</td>
                                <td>{!!$role->description!!}</td>

                                <td>
                                @can('haveaccess','role.show')
                                    <a class="btn btn-info" href="{{route('role.show', $role->id)}}">Mostrar</a></td>
                                @endcan
                                <td>
                                @can('haveaccess','role.edit')
                                    @if($role->slug!='adminfullaccess')
                                        <a class="btn btn-success" href="{{route('role.edit', $role->id)}}">Editar</a></td>
                                    @else
                                    <a class="btn btn-success disabled" href="{{route('role.edit', $role->id)}}">Editar</a></td>
                                    @endif
                                @endcan
                                <td>
                                @can('haveaccess','role.destroy')
                                    @if($role->slug!=='adminfullaccess')
                                        <form action="{{route('role.destroy', $role->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Borrar</button>
                                        </form>
                                    @else
                                    <form action="{{route('role.destroy', $role->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-secondary" disabled>Borrar</button>
                                        </form>
                                    @endif
                                @endcan
                                </td>
                                
                            </tr>
                            @endforeach
                            
                        </tbody>
                        </table>
                        {{$roles->links()}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection