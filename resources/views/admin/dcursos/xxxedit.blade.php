@extends('template.main')

@section('title','Modificación de Disponibilidad de Cursos' )

<!--*******************************-->
<!--@section('content') -->

	<!--caption>{{$dcursos[1]->user->wDocente($dcursos[1]->user_id)}}</caption->

	{!! Form::open(['route'=>'admin.dcursos.store', 'method'=>'POST']) !!}
		< table class="table table-striped" >
			<thead>
				<tr>
					<th>Grupos</th>
					<th>Cursos</th>
					<th>Accion</th>
				</tr>
			</thead>
			<tbody>
				@foreach($grupos as $grupo)
					<tr>
					hola
						<$grupo = $grupo->wgrupo;
						dd($grupos);
						<$lcursos = GrupoCurso::sSemestre()->sGrupo($grupo->cgrupo)->get();
						< lists('wcurso','curso_id'); -->
						<!--dd($lcursos);

						<td>{{ Form::select(wgrupo, $lcursos, null ,['seleccione el curso ...'] }}</td>
						{{ Form::select(ccurso, $lcursos, null ,['seleccione el curso ...'] }}
		
						
					</tr>
				@endforeach
			</tbody>
		</table>

	
	{!! Form::close() !!}
-->
	
<!--@endsection -->

<!--*******************************-->
<!--@section('js')
 $(".my_select_box").chosen({
    disable_search_threshold: 10,
    no_results_text: "Oops, nothing found!",
    width: "95%"
  }); -->

<!--@endsection -->


@foreach($grupos as $grupo)
						<tr>
							<td>
								{{$grupo->id}}
							</td>
							<td>
								{{$grupo->cgrupo}}
							</td>
							<td>
								{{$grupo->wgrupo}}
							</td>
							@{!! $lcursos = App\GrupoCurso::sSemestre()->sGrupo($grupo->cgrupo)->lists('ccurso','curso_id') !!}
							<td>
								
								


								
							</td>
						</tr>
 
					@endforeach