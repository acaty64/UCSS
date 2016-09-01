@extends('template.main')

@section('title','Lista de Semestres')

@section('content')
	<a href="{{ route('admin.semestres.create') }}" class="btn btn-info">Registrar Nuevo Semestre</a>
	<table class="table table-striped">
 		<thead>
 			<th>id</th>
 			<th>Semestre</th>
 			<th>Activo</th>
 			<th>Inicio</th>
 			<th>Fin</th>
 			<th>Cierre Dispon.</th>
 			<th>Cierre Datos</th>
 		</thead>
 		<tbody>
 			@foreach($semestres as $semestre)
 				<tr>
	 				<td>{{ $semestre->id }}</td>
	 				<td>{{ $semestre->semestre }}</td>
	 				<td>{{ Form::hidden('swactivo', 0) }}
	 					{{ Form::checkbox('swactivo', '1',$semestre->swactivo, ['class'=>'checkbox'] )}}</td>
	 				<td>{{ $semestre->inicio }}</td>
	 				<td>{{ $semestre->fin }}</td>	
	 				<td>{{ $semestre->cierredisp }}</td>	
	 				<td>{{ $semestre->cierredata }}</td>		
	 				<td>
	 					<a href="{{ route('admin.semestres.edit', $semestre->id) }}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" aria-hidden='true'></span></a>

	 					<a href="{{ route('admin.semestres.destroy', $semestre->id) }}" onclick='return confirm("Está seguro de eliminar?")' class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden='true'></a>

	 				</td>
	 			</tr>
 			@endforeach
 			
 		</tbody>
	</table>
	{!! $semestres->render() !!}

@endsection