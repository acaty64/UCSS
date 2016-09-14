@extends('template.main')

@section('title','Modificación de Disponibilidad de Cursos: '.substr($dcursos[1]->user->wDocente($dcursos[1]->user_id),0,50) )


@section('content')
<table>
	<tbody>
		<!-- INICIO Formulario para seleccionar disponibilidad de cursos -->
		<tr>			
			{!! Form::open(['route' => ['admin.dcursos.update', $docente->id ], 'method'=>'PUT']) !!}
				{!! Form::label('cursos','Cursos') !!}
				<!-- select(nombre del campo, lista de opciones, array con opciones seleccionadas,[opciones chosen]) -->
				{!! Form::select('cursos[]', $lcursos, $ch_cursos, ['multiple class'=>'chosen-select select-curso', 'multiple']) !!}
		</tr>
		<hr />
		<tr style = "margin-bottom: 20px">
				{!! Form::submit('Grabar modificaciones', ['class'=>'btn btn-primary']) !!}
			{!! Form::close() !!}
		</tr>
		<!-- FIN Formulario para seleccionar disponibilidad de cursos -->
		<hr />
		<!-- INICIO Formulario para ver silabo de cursos -->
		<tr>			
			<td colspan='2' style="text-align:center">SELECCIONE PARA VER EL SILABO DEL CURSO</td>
		</tr>
		<tr>
			<td style = "width:90%" >Curso para visualizar el sílabo</td>
			<td style = "width:20%" >Acción</td>
		</tr>
		{!! Form::open(['route' => 'PDF.silaboCurso', 'method'=>'PUT']) !!}
		<tr>
			<td style = "width:70%">
				{!! Form::select('curso_id', $lxgrupos, null, ['class'=>'chosen-select select-curso', 'include_group_label_in_selected'=>'true']) !!}
			</td>
			<td style = "width:20%">
				{!! Form::submit('Ver silabo' ,['class'=>'btn btn-primary']) !!}
				{!! Form::close() !!}
			</td>
		</tr>
		<!-- FIN Formulario para ver silabo de cursos -->
	</tbody>
</table>


@endsection
<!--*******************************-->
@section('js')
	<script>
		$(".select-curso").chosen({
			placeholder_text_multiple:"Haga click aquí para seleccionar los cursos",
			width: "95%"
		}); 
	</script>
@endsection

@section('view','admin/dcursos/edit.blade.php')	