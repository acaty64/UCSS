@extends('template.main')
@section('title','Bienvenido')
@section('content')
<div class="container">
        <div class="panel panel-default col-xs-8 col-xs-offset-1">                
            <div class="row">
                <div class="col-xs-12">
                   <br>
                    Si ha recibido usted el correo de requerimiento de disponibilidad de horarios y cursos haga click en el extremo superior derecho (Login) para identificarse.
                    <br> 
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-12">
                Si usted no ha recibido nuestro correo de invitación haga click en el siguiente enlace <a href="{{ route('solicitud.index') }}" class="btn btn-info btn-xs">Correo de contacto</a> para asignarle un acceso de usuario.
                <br><br>
                </div>
            </div>
        </div>
</div>
@endsection
@section('view','/welcome.blade.php')