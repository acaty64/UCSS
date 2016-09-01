@extends('template.main')

<!--@section('title','Modificación de Disponibilidad de Cursos: '.$dcursos[1]->user->wDocente($dcursos[1]->user_id) )
-->

@section('content')
<table>
	<tbody>
		<tr>
															<!-- $dcursos[0]->user_id -->
		<!-- HAY ERROR AL TRATAR DE TRANSFERIR $dcursos EN LUGAR DE $dcursos[0]->user_id]  -->
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
		<hr />
		<tr>
			<td colspan='2' style="text-align:center">SELECCIONE PARA VER EL SILABO DEL CURSO</td>
		</tr>
		<tr>
			<td style = "width:90%" > Curso para visualizar el sílabo</td>
			<td>Acción</td>
		</tr>
		<tr>
			<td style = "width:90%">
				{!! Form::select('$xgrupo', $lxgrupos, null, ['class'=>'chosen-select select-curso', 'include_group_label_in_selected'=>'true']) !!}
			</td>
			<td style = "width:20%">
				
			</td>

		</tr>
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