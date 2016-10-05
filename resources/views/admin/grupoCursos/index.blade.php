@extends('template.main')

@section('title','Cursos del grupo '.$cursos[0]->grupo->wgrupo)

@section('content')
	<table class="table table-striped">
 		<thead>
 			<th>id</th>
 			<th>Código</th>
 			<th>Curso</th>
 			<th>Acción</th>
 		</thead>
 		<tbody>
 			@foreach($cursos as $curso)
 				<tr>
	 				<td>{{ $curso->curso_id }}</td>
	 				<td>{{ $curso->curso->ccurso }}</td>
	 				<td>{{ $curso->curso->wcurso }}</td>
	 				<td>
	 					<a href="{{ route('admin.grupocursos.orden', $curso->curso_id) }}" class="btn btn-warning" data-toggle="tooltip" title="Seleccionar" name="Seleccionar"><span class="glyphicon glyphicon-menu-right" aria-hidden='true'></span></a>
	 					@if($curso->sw_cambio == '0')
	 						<span style="Color:red">PENDIENTE</span>
	 					@else 
	 						<span style="Color:green">Actualizado</span>
	 					@endif
	 				</td>
	 			</tr>
 			@endforeach
 			
 		</tbody>
	</table>

@endsection

@section('view','admin/grupocursos/index.blade.php')