@extends('template.main')

@section('title','Exportación/Importación de datos')

@section('content')     
	<p>Host: {{$name_host}}</p>
	<table class="table table-striped">
		<thead>
				<th>Acción</th>
				<th>Descripción</th>
		</thead>
		<tbody>
			@if($name_host == 'LOCALHOST')
				<tr>
					<td>
						<a href="{{ route('acciones.exportLocal',$fileDown) }}" class="btn btn-danger" data-toggle="tooltip" title="Exportar">Exportar</a>
					</td>
					<td><p>Crea archivo de Copia de Seguridad: {{$fileDown}}</p></td>
				</tr>
				<tr>
					<td>
						<a href="{{ route('acciones.importLocal') }}" class="btn btn-success" data-toggle="tooltip" title="Importar">Importar</a>
					</td>
					<td><p>Seleccione archivo de Respaldo a Importar: {{$fileUp}}</p></td>
				</tr>
			@endif
			@if($name_host == 'SERVER')
				<tr>
					<td>
						<a href="{{ route('acciones.exportServer') }}" class="btn btn-danger" data-toggle="tooltip" title="Exportar">Exportar</a>
					</td>
					<td><p>Crea archivo de Copia de Seguridad: {{$fileDown}}</p></td>
				</tr>
				<tr>
					<td>
						<a href="{{ route('acciones.importServer') }}" class="btn btn-success" data-toggle="tooltip" title="Importar">Importar</a>
					</td>
					<td><p>Seleccione archivo de Respaldo a Importar: {{$fileUp}}</p></td>
				</tr>
			@endif
		</tbody>
	</table>
	<p>Mensaje: {{$mensaje}}</p>



@endsection
@section('view','admin/acciones/index.blade.php')
