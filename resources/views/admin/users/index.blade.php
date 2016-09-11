@extends('template.main')

@section('title','Lista de Usuarios')

@section('content')
	<hr>
		<a href="{{ route('admin.users.create') }}" class="btn btn-info">Registrar Nuevo Usuario</a>
		<!-- INICIO DEL BUSCADOR  -->
		{!! Form::open(['route' => 'admin.users.index', 'method'=>'GET', 'class'=>'navbar-form pull-right']) !!}
			<div class="input-group">
				{!! Form::text('wdocente', null, ['class'=>'form-control', 'placeholder'=>'Buscar docente...', 'aria-describedby'=>'search']) !!}
				<span class="input-group-addon" id='search'><span class="glyphicon glyphicon-search" "aria-hidden"="true"></span></span>
			</div>
		{!! Form::close() !!}
	</hr>
	<!-- FIN DEL BUSCADOR -->
	<table class="table table-striped">
 		<thead>
 			<th>id</th>
 			<th>Código</th>
 			<th>Docente</th>
 			<th>Tipo</th>
 			<th>Acción</th>
 		</thead>
 		<tbody>
 			
 			@foreach($users as $user)
 				<tr>
	 				<td>{{ $user->id }}</td>
	 				<td>{{ $user->username }}</td>
	 				<!--  ACTIVAR CUANDO SE MODIFIQUE DATA docentes <td>{{ $user->wDocente($user->id) }}</td>-->
	 				<td>{{ substr($user->wdocente($user->id),0,50) }}</td>
	 				<td>
	 					@if($user->type == 'usuario')
	 						<span class="label label-warning">{{$user->type}}</span>
	 					@elseif ($user->type == 'respon') 
	 						<span class="label label-success">{{$user->type}}</span>
	 					@elseif ($user->type =='admin') 
	 						<span class="label label-danger">{{$user->type}}</span>
	 					@endif
	 				</td>	
	 				<td>

	 					<a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning" data-toggle="tooltip" title="Modificar usuario"><span class="glyphicon glyphicon-wrench" aria-hidden='true'></span></a>

	 					<a href="{{ route('admin.users.editpass', $user->id) }}" class="btn btn-danger" data-toggle="tooltip" title="Modificar password"><span class="glyphicon glyphicon-lock" aria-hidden='true'></span></a>
	 					
	 					<a href="{{ route('admin.users.destroy', $user->id) }}" onclick='return confirm("Está seguro de eliminar el registro?")' class="btn btn-danger" data-toggle="tooltip" title="Eliminar usuario"><span class="glyphicon glyphicon-trash" aria-hidden='true'></a>

	 					<a href="{{ route('admin.datausers.edit', $user->id) }}" class="btn btn-success" data-toggle="tooltip" title="Modificar datos usuario"><span class="glyphicon glyphicon-earphone" aria-hidden='true'></span></a>

	 					<a href="{{ route('admin.dhoras.edit', $user->id) }}" class="btn btn-success" data-toggle="tooltip" title="Disponibilidad Horaria"><span class="glyphicon glyphicon-calendar" aria-hidden='true'></span></a>

	 					<a href="{{ route('admin.dcursos.edit', $user->id) }}" class="btn btn-success" data-toggle="tooltip" title="Disponibilidad de Cursos"><span class="glyphicon glyphicon-list-alt" aria-hidden='true'></span></a>
	 					
	 					<a href="{{ route('PDF.usuario', $user->id) }}" class="btn btn-primary" data-toggle="tooltip" title="Ver PDF"><span class="glyphicon glyphicon-eye-open" aria-hidden='true'></span></a>
	 					<!--MODELO INVOICE Route::get('pdf', 'PdfController@invoice'); -->
	 					<!-- route('pdf', 'PDFController@invoice') -->
	 					<!-- a href="{{ route('pdf', 'PDFController@invoice') }}" class="btn btn-success">Invoice</a-->
	 					
	 				</td>
	 			</tr>
 			@endforeach
 			
 		</tbody>
	</table>
	{!! $users->render() !!}

@endsection
