@extends('template.main')

@section('title','Crear Nuevo Envío')

@section('content')

	{!! Form::open(['route'=>'admin.menvios.store', 'method'=>'POST']) !!}

		<div>
			{!! Form::label('tipo','Tipo') !!}
			{!! Form::select('tipo',['disp'=>'Disponibilidad','hora'=>'Horarios Asignados','data'=>'Datos Usuarios'], null, ['class'=>'form-control', 'placeholder'=>'Seleccione el tipo','required']) !!}
		</div>
		<br>
		<div>
			{!! Form::label('flimite','Fecha límite') !!}
			{!! Form::date('flimite', \Carbon\Carbon::now()) !!}
		</div>	
		<br>
		<div>
			{!! Form::label('tx_need','Asunto del correo') !!}
			{!! Form::textarea('tx_need', null, ['class'=>'form-control', 'placeholder'=>'Ingrese el asunto (máximo 255 caracteres)','required']) !!}
		</div>
		<br>		
		<div class="form-group">
			{!! Form::submit('Grabar', ['class'=>'btn btn-lg btn-primary']) !!}
		</div>

	{!! Form::close() !!}

@endsection

@section('view','admin/envios/create.blade.php')	