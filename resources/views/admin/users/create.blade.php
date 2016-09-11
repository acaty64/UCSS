@extends('template.main')

@section('title','Crear Usuario')

@section('content')

	{!! Form::open(['route'=>'admin.users.store', 'method'=>'POST']) !!}

		<div class="form-group">
			{!! Form::label('username','Código') !!}
			{!! Form::text('username', null, ['class'=>'form-control', 'placeholder'=>'Código Docente','required']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('password','Contraseña') !!}
			{!! Form::password('password', ['class'=>'form-control', 'placeholder'=>'**********','required']) !!}
		</div>
		
		<div class="form-group">
			{!! Form::label('wdoc1','Nombres') !!}
			{!! Form::text('wdoc1', null, ['class'=>'form-control', 'placeholder'=>'Ingrese sus Nombres','required']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('wdoc2','Apellido Paterno') !!}
			{!! Form::text('wdoc2', null, ['class'=>'form-control', 'placeholder'=>'Ingrese su Apellido Paterno','required']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('wdoc3','Apellido Materno') !!}
			{!! Form::text('wdoc3', null, ['class'=>'form-control', 'placeholder'=>'Ingrese su Apellido Materno','required']) !!}
		</div>
		
		<div class="form-group">
			{!! Form::label('type','Tipo') !!}
			{!! Form::select('type',['usuario'=>'Docente','respon'=>'Responsable','admin'=>'Administrador'], null, ['class'=>'form-control', 'placeholder'=>'Seleccione el tipo','required']) !!}
		</div>
		<br>
		<div class="form-group">
			{!! Form::submit('Registrar', ['class'=>'btn btn-lg btn-primary']) !!}
		</div>

	{!! Form::close() !!}

@endsection