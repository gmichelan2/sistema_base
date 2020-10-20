@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Formulario de cambio de contraseña</h2></div>
                <div class="card-body">
                    @include('custom.message')
                    <form action="{{route('passwordown.update', $user->id)}}" method="POST">
                        @csrf
                        <div class="container">
                        <h3>Modificar contraseña de la cuenta {{$user->nick}}</h3>
                            <hr>
                            <div class="form-group">
                                <label for="password">Ingrese nueva contraseña</label-->
                                <input type="text" class="form-control" id="password" placeholder="Contraseña" name="contrasenia"
                                value="">
                            </div>
                            <div class="form-group">
                                <label for="passwordrep">Repita la contraseña</label-->
                                <input type="passwordrep" class="form-control" id="passwordrep" placeholder="Repita contraseña" name="repetircontrasenia"
                                value="">
                            </div>
                            <hr>
                            <input type="submit" class="btn btn-success" name="Confirmar" value="Confirmar">
                            <a class="btn btn-danger" href="{{route('user.show', $user->id)}}">Volver</a> 
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection