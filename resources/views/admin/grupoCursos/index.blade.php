@extends('template.main')

@section('title','Grupo de Cursos')

@section('content')
	<a href="{{ route('admin.grupoCursos.create') }}" class="btn btn-info">Crear Nuevo Grupo</a>
	<table class="table table-striped">
 		<thead>
 			<th>id</th>
 			<th>Código</th>
 			<th>Grupo</th>
 		</thead>
 		<tbody>
 			@foreach($grupoCursos as $grupoCurso)
 				<tr>
	 				<td>{{ $grupoCurso->id }}</td>
	 				<td>{{ $grupoCurso->cGrupo }}</td>
	 				<td>{{ $grupoCurso->grupo->wgrupo }}</td>
	 				<td>
	 					<a href="{{ route('admin.grupoCursos.edit', $grupoCurso->id) }}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" aria-hidden='true'></span></a>

	 					<a href="{{ route('admin.grupoCursos.destroy', $grupoCurso->id) }}" onclick='return confirm("Está seguro de eliminar?")' class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden='true'></a>

	 				</td>
	 			</tr>
 			@endforeach
 			
 		</tbody>
	</table>
	{!! $grupoCursos->render() !!}

@endsection