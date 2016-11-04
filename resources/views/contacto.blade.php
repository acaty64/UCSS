@extends('layouts.app')
@section('title','Contacto')
@section('content')
	<div class='panel-body' style="">
	{!!Form::open(['route'=>'solicitud.store','method'=>'POST'])!!}

		<div class="form-group" style="width: 60%">
			{!! Form::label('name1','Nombres') !!}
			{!! Form::text('name1',null,['class'=>'form-control','placeholder' => 'Ingrese sus nombres'])!!}
		</div>
		<div class="form-group" style="width: 60%">
			{!! Form::label('name2','Apellido Paterno') !!}
			{!! Form::text('name2',null,['class'=>'form-control','placeholder' => 'Ingrese su apellido paterno'])!!}
		</div>
		<div class="form-group" style="width: 60%">
			{!! Form::label('name3','Apellido Materno') !!}
			{!! Form::text('name3',null,['class'=>'form-control','placeholder' => 'Ingrese su apellido materno'])!!}
		</div>
		<div class="form-group" style="width: 60%">
			{!! Form::label('dni','Documento de Identidad') !!}
			{!! Form::text('dni',null,['class'=>'form-control','placeholder' => 'Ingrese el número de su DNI'])!!}
		</div>
		<div class="form-group" style="width: 60%">
			{!! Form::label('email','Correo Electrónico') !!}
			{!! Form::text('email',null,['class'=>'form-control','placeholder' => 'Ingrese su correo electrónico'])!!}
		</div>
		<div class="form-group" style="width: 60%">
			{!!Form::submit('Enviar', ['class'=>'btn btn-primary'])!!}
		</div>
	{!!Form::close()!!}
	</div>
@endsection
@section('view','/contacto.blade.php')


