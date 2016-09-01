@extends('template.main')

@section('title','Modificación de Disponibilidad de Cursos' )

@section('content')
	
		<table class="table table-striped">
			<caption>Docente: {{$dcursos[1]->user->wDocente($dcursos[1]->user_id)}}</caption>
			<thead>
				
				<tr>
					<th>Id</th>
					<th>Codigo</th>
					<th>Grupos Temáticos</th>
					<th>Acción</th>
				</tr>
			</thead>
				{!! Form::open(['route'=>'admin.dcursos.store', 'method'=>'POST']) !!}
			<tbody>
					<td>
						<div class='form-group'>
							{!! Form::label('cursos','Cursos') !!}
							{!! Form::select('cursos[]', $lcursos, $ch_cursos, ['multiple class'=>'chosen-select select-curso', 'multiple']) !!}
	
						</div>
					</td>
				
			</tbody>
			{!! Form::close() !!}
		</table>

@endsection
<!--*******************************-->
@section('js')
	<script>
		$(".select-curso").chosen({
			placeholder_text_multiple:"Seleccione los cursos",
			width: "95%"
		}); 
	</script>
@endsection