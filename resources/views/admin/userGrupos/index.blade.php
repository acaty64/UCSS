
@extends('template.main')

@section('title','Responsables')

@section('content')

	<table class="table table-striped">
 		<thead>
 			<th>id</th>
 			<th>Código</th>
 			<th>Docente</th>
 			<th>Grupo</th>
 			<th>Acción</th>
 		</thead>
 		<tbody>
 			@foreach($users as $user)
 				<tr>
	 				<td>{{ $user->id }}</td>
	 				<td>{{ $user->username }}</td>
	 				<td>{{ $user->wdocente($user->id) }}</td>
	 				<td>@if (empty($user->usergrupo->grupo->wgrupo))	
	 						<div class='label label-danger'>ASOCIE UN GRUPO</div>
	 					@else 
	 						<div class='label label-success'>{{$user->usergrupo->grupo->wgrupo}}</div>
	 					@endif
	 				</td>
	 				<!-- BOTONES -->
	 				<td>
	 					<a href="{{ route('admin.usergrupos.edit', $user) }}" class="btn btn-warning"><span class="glyphicon glyphicon-plus" aria-hidden='true' data-toggle="tooltip" title="Asociar o Modificar Grupo"></span></a>
	 					@if (!empty($user->usergrupo->grupo->wgrupo))
	 						<a href="{{ route('admin.usergrupos.destroy', $user->id) }}" onclick='return confirm("Está seguro de eliminar?")' class="btn btn-danger" data-toggle="tooltip" title="Disociar grupo"><span class="glyphicon glyphicon-remove-circle" aria-hidden='true'></a>
	 					@endif

	 				</td>
	 			</tr>
 			@endforeach
 			
 		</tbody>
	</table>
	{!! $users->render() !!}
@endsection

@section('view','admin/userGrupos/index.blade.php')