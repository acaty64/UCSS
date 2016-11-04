@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Bienvenido</div>
                
                <div class="panel-body">
                    <hr>
                    Si ha recibido usted el correo de requerimiento de disponibilidad de horarios y cursos haga click en el extremo superior derecho (Login) para identificarse.
                
                    <hr>
                    Si usted no ha recibido nuestro correo de invitación haga click en el siguiente enlace para asignarle un acceso de usuario. <a href="{{ route('solicitud.index') }}" class="btn btn-info">Correo de contacto</a>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('view','/welcome.blade.php')