@extends('template.main')

@section('title','Prioridad de Docentes del curso '.$dcursos->first()->curso->wcurso)

@section('content')
		<a href="{{ route('admin.grupocursos.index',$dcursos->first()->curso->grupocurso->grupo_id)}}" class="btn btn-info">Regresar al índice</a>
	<table class="table table-striped">
 		<thead>
 			<th>id</th>
 			<th>prioridad</th>
 			<th>Código</th>
 			<th>Curso</th>
 		</thead>
 		<tbody>
 			@foreach($dcursos as $dcurso)
 				<tr>
	 				<td>{{ $dcurso->id }}</td>
	 				<td>{{ $dcurso->prioridad }}</td>
	 				<td>{{ $dcurso->user->username }}</td>
	 				<td>{{ $dcurso->user->wdoc2 }}</td>
	 				<td>
						<a href="{{ route('admin.grupocursos.uporden', $dcurso->id) }}" name='{{$dcurso->prioridad}}' class="btn btn-success" data-toggle="tooltip" title="Subir"><span class="glyphicon glyphicon-menu-up" aria-hidden='true'></span></a>
						<a href="{{ route('admin.grupocursos.downorden', $dcurso->id) }}" class="btn btn-danger" data-toggle="tooltip" title="Bajar" onclick="javascript:evento_down(this);"><span class="glyphicon glyphicon-menu-down" aria-hidden='true'></span></a>
	 				</td>
	 			</tr>
 			@endforeach
 			
 		</tbody>
	</table>
@endsection

@section('view','admin/grupocursos/orden.blade.php')