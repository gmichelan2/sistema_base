@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Resetear contraseña</h2></div>
                <div class="card-body">
                    @include('custom.message')
                    <form action="{{route('passwordown.update', $user->id)}}" method="POST">
                        @csrf
                        <div class="container">
                        <h3>Como es su primer ingreso, debe modificar la contraseña {{$user->username}}</h3>
                            <hr>
                            <div class="form-group">
                                <label for="password">Ingrese nueva contraseña</label-->
                                <input type="password" class="form-control" id="password" placeholder="Contraseña" name="contrasenia" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="passwordrep">Repita la contraseña</label-->
                                <input type="password" class="form-control" id="passwordrep" placeholder="Repita contraseña" name="repetircontrasenia"
                                value="" autocomplete="off">
                            </div>
                            <hr>
                            <input type="submit" class="btn btn-success" name="Confirmar" value="Confirmar"> 
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection