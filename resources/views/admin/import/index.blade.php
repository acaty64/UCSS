@extends('template.main')

@section('title','Importación de datos')

@section('content')     
	{!! Form::open(['route' => 'import.updata', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
		<div class="form-group" id="grupo">
			{!! Form::label('lsubtipo','Tipo') !!}
			{!! Form::select('subtipo',$subtipo,null,['class'=>'form-control', 'placeholder'=>'Seleccione el tipo de archivo a importar','required']) !!}
			{!! Form::label('fileuser','Archivo:') !!}
			{!! Form::file('fileuser') !!}
			
			<input type="hidden" name="user_id" value="{{Auth::User()->id}}"></input>
		</div>
		<div class="form-group">
			{!! Form::submit('Importar Datos', ['class'=>'btn btn-primary', 'onclick'=>'return confirm("Está seguro de reemplazar todos los registros del archivo?")']) !!}
		</div>
	{!! Form::close() !!}

@endsection
@section('view','admin/import/index.blade.php')
@section('js')
<script>
	$(document).ready(function(){
		console.log('Carga de js. document ready')
		$(".form-control").change(function(){
			console.log($( this ).val())
			$filename = '99'.concat($( this ).val())
			console.log($filename)

			var container =	document.getElementById("grupo");
			var input = document.createElement('input');
			input.type = 'hidden';
			input.name = "filename";
			input.value = $filename;
			container.appendChild(input);
		});
	});
</script>
@endsection