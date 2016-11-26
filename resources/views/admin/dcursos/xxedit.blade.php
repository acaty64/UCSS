@extends('template.main')

@section('title','Disponibilidad de Cursos: '.substr($docente->wDocente($docente->id),0,50) )

@section('content')
<p>Agregue o elimine los cursos que está dispuesto a dictar en el presente semestre dentro del recuadro Cursos.</p>
<p>Grabe la información modificada o confirme los cursos presentados.</p>
<br>
<table>
	<tbody>
		<!-- INICIO Formulario para seleccionar disponibilidad de cursos -->
		<tr>			
			{!! Form::open(['route' => ['admin.dcursos.update', $docente->id ], 'method'=>'PUT']) !!}
				{!! Form::label('cursos','Cursos') !!}
				<!-- select(nombre del campo, lista de opciones, array con opciones seleccionadas,[opciones chosen]) -->
				<span>
				{!! Form::select('cursos[]', $lcursos, $ch_cursos, ['multiple class'=>'chosen-select select-curso', 'multiple']) !!}
				</span>
		</tr>
		<hr>
		<tr style = "margin-bottom: 20px">
			@if($sw_cambio == '1')
				{!! Form::submit('Grabar o Confirmar cursos', ['class'=>'btn btn-primary']) !!}		
			@else
				<p style="color:red">
					La fecha límite de modificación ha expirado. Si necesita modificar su disponibilidad comuníquese con la coordinación académica.
				</p>
			@endif
			{!! Form::close() !!}
		</tr>
		<!-- FIN Formulario para seleccionar disponibilidad de cursos -->
		<hr />
		<!-- INICIO Formulario para ver silabo de cursos -->
		<tr>			
			<td colspan='2' style="text-align:center">VISUALIZACIÓN DE SÍLABOS DE TODOS LOS CURSOS</td>
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