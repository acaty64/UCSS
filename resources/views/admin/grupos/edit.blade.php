@extends('template.main')

@section('title','Modificar Grupo de Cursos '.$grupo->wgrupo)

@section('content')

	{!! Form::model($grupo, array('route' => array('admin.grupos.update', $grupo), 'method' => 'PUT')) !!}

		<div class="form-group">
			{!! Form::label('wgrupo','Descripción del Grupo') !!}
			{!! Form::text('wgrupo', $grupo->wgrupo, ['class'=>'form-control', 'placeholder'=>'Ingrese la descripción del grupo','required']) !!}
		</div>

		<div class="form-group">
			{!! Form::submit('Grabar modificación de la descripción del grupo', ['class'=>'btn btn-primary']) !!}
		</div>

	{!! Form::close() !!}

	<!-- MODIFICACION DE CURSOS DEL GRUPO -->
	{!! Form::open(['route' => ['admin.grupocursos.update', $grupo->id ], 'method'=>'PUT']) !!}

		<div class="form-group">
				{!! Form::select('cursos[]', $lcursos, $ch_cursos, ['multiple class'=>'chosen-select select-curso', 'multiple']) !!}
		</div>
			{!! Form::submit('Grabar modificaciones de los cursos del grupo', ['class'=>'btn btn-primary']) !!}
		</div>
	{!! Form::close() !!}
@endsection

@section('js')
	<script>
		$(".select-curso").chosen({
			placeholder_text_multiple:"Haga click aquí para seleccionar los cursos",
			width: "95%"
		}); 
	</script>
@endsection

@section('view','admin/grupos/edit.blade.php')