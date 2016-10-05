@extends('template.main')

@section('title','Importación de datos')

@section('content')

FALTA SUBIR EL ARCHIVO AL SERVIDOR /public/CSV

	<hr>
	{!! Form::open($tipos, array('route' => array('admin.import.updata', $tipos), 'method' => 'GET')) !!}
		<div class="form-group">
			{!! Form::label('tipo','Tipo') !!}
			{!! Form::select('tipo',$tipos,null,['class'=>'form-control', 'placeholder'=>'Seleccione el tipo de archivo a importar','required']) !!}
		</div>
		<div class="form-group">
			{!! Form::submit('Importar Datos', ['class'=>'btn btn-primary']) !!}
		</div>
	{!! Form::close() !!}

@endsection
@section('view','admin/import/index.blade.php')
@section('js')

@endsection