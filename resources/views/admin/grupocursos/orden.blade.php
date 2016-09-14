@extends('template.main')

@section('title','Prioridad de Docentes del curso '.$dcursos->first()->curso->wcurso)

@section('content')

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

						<a href="{{ route('admin.grupocursos.uporden', $dcurso->id) }}" name='{{$dcurso->prioridad}}' class="btn btn-warning" data-toggle="tooltip" title="Subir"><span class="glyphicon glyphicon-menu-up" aria-hidden='true'></span></a>

						
						<a href="{{ route('admin.grupocursos.downorden', $dcurso->id) }}" class="btn btn-warning" data-toggle="tooltip" title="Bajar" onclick="javascript:evento_down(this);"><span class="glyphicon glyphicon-menu-down" aria-hidden='true'></span></a>
	 				</td>
	 			</tr>
 			@endforeach
 			
 		</tbody>
	</table>
@endsection

@section('js')
	<script type="text/javascript">
		function evento_up($obj){
console.log($obj.name);
		

			{{$plucked = $dcursos->pluck('id')}};
			

		}
	</script>
@endsection

@section('view','admin/grupocursos/orden.blade.php')