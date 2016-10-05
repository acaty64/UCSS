@extends('template.main')
 
@section('title','Lista de Actualizaciones de Cursos Disponibles')

@section('content')
	<a href="{{ route('admin.dcursos.List2Excel') }}" class="btn btn-info">Exportar a Excel</a>
	<table class="table table-striped">
 		<thead>
 			<th>Codigo</th>
 			<th>Docente</th>
 			<th>Status</th>
 			<th>Envio</th>
 			<th>Limite</th>
 			<th>Actualizacion</th>
 			
 		</thead>
 		<tbody>
 			@foreach($lista as $registro)
 				<tr>
 					<td>{{$registro['username']}}</td>
					<td>{{substr($registro['wdocente'],0,50)}}</td>
					<td>{{$registro['sw_actualizacion']}}</td>
					@if($registro['status'] == 1)
						<td>{{$registro['fenvio']}}</td>
						<td>{{$registro['flimite']}}</td>
						<td>{{$registro['updated_at']}}</td>
					@endif					
	 			</tr>
 			@endforeach
 		</tbody>
	</table>
@endsection

@section('view','admin/dcursos/list.blade.php')
