@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de Usuarios</h2></div>

                <div class="card-body">
                @include('custom.message')
                <form class="form-inline my-2 my-lg-0">
                    <label for="exampleFormControlSelect1">Buscar por: </label>
                    <select name="buscarPor" class="form-control" id="exampleFormControlSelect1">
                        <option value="name">Nombres</option>
                        <option value="surname">Apellido</option>
                        <option value="email">Email</option>
                        <option value="username">Nombre de usuario</option>
                        <!--option value="role">Rol</option-->
                    </select>
                    <input name="palabraClave" class="form-control mr-sm-2" type="search" placeholder="Escriba aquí la palabra a buscar" aria-label="Search">
                    <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Buscar</button>
                  </form>
                @can('haveaccess','user.create')
                    <a href="{{route('user.create')}}" class="btn btn-primary float-right">Nuevo usuario</a>
                    <br>
                @endcan
                <br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombres</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Email</th>
                            <th scope="col">Nombre de usuario</th>
                            <th scope="col">Rol(es)</th>
                            <th colspan="3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                             @foreach($users as $user)
                             <tr>
                                <th scope="row">{{$user->id}}</th>
                                <td>{!!$user->name!!}</td>
                                <td>{!!$user->surname!!}</td>
                                <td>{!!$user->email!!}</td>
                                <td>{!!$user->username!!}</td>
                                <td>
                                   @if($user->roles!=null)
                                    @foreach($user->roles as $role)
                                        {{$role->name}}
                                        <br>
                                    @endforeach
                                   @endif 
                                {{-- @isset($user->roles[0]->name)
                                    {{$user->roles[0]->name}}
                                @endisset     --}}
                                </td>
                                <td>
                                @can('view',[$user, ['user.show','userown.show']])<!--Es con politica y no con gates-->
                                    <a class="btn btn-info" href="{{route('user.show', $user->id)}}">Mostrar</a>
                                @endcan
                                </td>
                                <td>
                                @can('update', [$user, ['user.edit','userown.edit']])
                                    @if($user->username!='admin')
                                        <a class="btn btn-success" href="{{route('user.edit', $user->id)}}">Editar</a>
                                    @else
                                        <a class="btn btn-success disabled" href="{{route('user.edit', $user->id)}}">Editar</a>
                                    @endif
                                @endcan    
                                </td>
                                <td>
                                @can('haveaccess','user.destroy')
                                    @if($user->username!=='admin')
                                        <form action="{{route('user.destroy', $user->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Borrar</button>
                                        </form>
                                    @else
                                        <form action="{{route('user.destroy', $user->id)}}" method="POST">
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
                        {{$users->links()}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection