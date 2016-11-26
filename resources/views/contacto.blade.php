@extends('template.main')
@section('title','Contacto')
@section('content')
	<div class='panel-body'>
		{!!Form::open(['route'=>'solicitud.store','method'=>'POST','enctype'=>'multipart/form-data'])!!}
		{!! csrf_field() !!}
		<div class = 'container col-xs-8 col-xs-offset-2'>
			<div class="form-group">
				{!! Form::label('name1','Nombres') !!}
				{!! Form::text('name1',null,['class'=>'form-control','placeholder' => 'Ingrese sus nombres','required'])!!}
			</div>
			<div class="form-group">
				{!! Form::label('name2','Apellido Paterno') !!}
				{!! Form::text('name2',null,['class'=>'form-control','placeholder' => 'Ingrese su apellido paterno','required'])!!}
			</div>
			<div class="form-group">
				{!! Form::label('name3','Apellido Materno') !!}
				{!! Form::text('name3',null,['class'=>'form-control','placeholder' => 'Ingrese su apellido materno','required'])!!}
			</div>
			<div class="row">
			<div class="form-group col-xs-4">
				{!! Form::label('dni','Documento de Identidad') !!}
				{!! Form::text('dni',null,['class'=>'form-control','placeholder' => 'Ingrese su DNI','required'])!!}
			</div>
			<div class="form-group col-xs-8">
				{!! Form::label('email','Correo Electrónico') !!}
				{!! Form::email('email',null,['class'=>'form-control','placeholder' => 'Ingrese su correo electrónico','required'])!!}
			</div>
			</div>
			<div class="form-group">
				{!! Form::label('cv','Curriculum Vitae - Adjunte un archivo PDF máximo 5 Mb') !!}
				{!! Form::file('cv',['class'=>'form-control','required'])!!}
	        </div>

	        <div class="form-group">
				{!!Form::submit('Enviar', ['class'=>'btn btn-primary'])!!}
			</div>
		</div>
		{!!Form::close()!!}
	</div>
@endsection
@section('view','/contacto.blade.php')

