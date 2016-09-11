@extends('template.main')

@section('title','Lista de Envíos de Correos Electrónicos')

@section('content')

	<hr>
		<a href="{{ route('admin.menvios.create') }}" class="btn btn-info">Crear nuevo envio de correos electrónicos</a>
		<!-- INICIO DEL BUSCADOR  -->
		{!! Form::open(['route' => 'admin.menvios.index', 'method'=>'GET', 'class'=>'navbar-form pull-right']) !!}
			<div class="input-group">
				{!! Form::text('tipo', null, ['class'=>'form-control', 'placeholder'=>'Filtrar por tipo de envio...', 'aria-describedby'=>'search']) !!}
				<span class="input-group-addon" id='search'><span class="glyphicon glyphicon-search" "aria-hidden"="true"></span></span>
			</div>
		{!! Form::close() !!}
	</hr>
	<!-- FIN DEL BUSCADOR -->
	<table class="table table-striped">
 		<thead>
 			<th>Id</th>
 			<th>Tipo</th>
 			<th>Fecha de envio</th>
 			<th>Fecha límite</th>
 			<th>Enviados</th>
 			<th>Respuestas</th>
 			<th>Acción</th>
 		</thead>
 		<tbody>
 			@foreach($Menvios as $envio )
 				<tr>
 					<td>
 						{{ $envio->id }}
 					</td>
 					<td>
 						{{ $envio->tipo }}
 					</td>
 					<td>
 						{{ $envio->fenvio }}
 					</td>
 					<td>
 						{{ $envio->flimite }}
 					</td>
 					<td>
 						 <span class="badge">{{ $envio->envios }}</span>
 					</td>
 					<td>
 						<span class="badge">{{ $envio->rptas }}</span>
 					</td>
	 				<td>
	 					@if($envio->envios == 0 or $envio->fenvio == date('Y-m-d'))
	 						<a href="{{ route('admin.menvios.dshow', $envio->id ) }}" class="btn btn-success" data-toggle="tooltip" title="Agregar Docentes a Comunicar"><span class="glyphicon glyphicon-plus-sign" aria-hidden='true'></span></a>
	 					@else
	 						<a href="{{ route('admin.menvios.show', $envio->id ) }}" class="btn btn-primary" data-toggle="tooltip" title="Ver Docentes Comunicados"><span class="glyphicon glyphicon-eye-open" aria-hidden='true'></span></a>
	 					@endif
	 					<a href="{{ route('admin.menvios.destroy', $envio->id) }}" onclick='return confirm("Está seguro de eliminar este envio?")' class="btn btn-danger" data-toggle="tooltip" title="Eliminar envio"><span class="glyphicon glyphicon-trash" aria-hidden='true'></a>
	 					@if($envio->envios != 0 and $envio->fenvio == date('Y-m-d'))
	 						<a href="{{ route('admin.envios.send', $envio->id ) }}" class="btn btn-success" data-toggle="tooltip" title="Enviar los correos electrónicos"><span class="glyphicon glyphicon-send" aria-hidden='true'></span></a>
	 					@endif

	 				</td>
	 			</tr>
 			@endforeach 			
 		</tbody>
	</table>
	{!! $Menvios->render() !!}
@endsection
