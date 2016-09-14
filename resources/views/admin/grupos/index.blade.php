@extends('template.main')

@section('title','Grupo de Cursos')

@section('content')
	<a href="{{ route('admin.grupos.create') }}" class="btn btn-info">Crear Nuevo Grupo</a>
	<table class="table table-striped">
 		<thead>
 			<th>id</th>
 			<th>Código</th>
 			<th>Grupo</th>
 		</thead>
 		<tbody>
 			@foreach($grupos as $grupo)
 				<tr>
	 				<td>{{ $grupo->id }}</td>
	 				<td>{{ $grupo->cgrupo }}</td>
	 				<td>{{ $grupo->wgrupo }}</td>
	 				<td>
	 					<a href="{{ route('admin.grupos.edit', $grupo->id) }}" class="btn btn-warning" data-toggle="tooltip" title="Editar Grupo"><span class="glyphicon glyphicon-wrench" aria-hidden='true'></span></a>

	 					<a href="{{ route('admin.grupocursos.index', $grupo->id) }}" class="btn btn-warning" data-toggle="tooltip" title="Prioridad de Docentes"><span class="glyphicon glyphicon-sort" aria-hidden='true'></span></a>

	 					<a href="{{ route('admin.grupos.destroy', $grupo->id) }}" onclick='return confirm("Está seguro de eliminar el grupo?")' class="btn btn-danger" data-toggle="tooltip" title="Eliminar Grupo"><span class="glyphicon glyphicon-remove-circle" aria-hidden='true'></a>

	 				</td>
	 			</tr>
 			@endforeach
 			
 		</tbody>
	</table>
	{!! $grupos->render() !!}

@endsection

@section('view','admin/grupos/index.blade.php')