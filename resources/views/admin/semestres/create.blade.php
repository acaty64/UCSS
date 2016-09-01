@extends('template.main')

@section('title','Crear Semestre')

@section('content')
	{!! Form::open(['route'=>'admin.semestres.store', 'method'=>'POST']) !!}

		<table>
			
			<tbody>
				<tr>
					<td>{!! Form::label('semestre','Semestre') !!}
						{!! Form::text('semestre', null, ['class'=>'form-control', 'placeholder'=>'Semestre','required']) !!}
					</td>
					<td>
						{!! Form::label('swactivo','Activo') !!}
						{{ Form::hidden('swactivo', 0) }}
 						{{ Form::checkbox('swactivo', '1',0, ['class'=>'checkbox'] )}}
					</td>
				</tr>
				<tr>
					<td>
						{!! Form::label('inicio','inicio') !!}
						{!! Form::text('inicio', null, ['class'=>'form-control','']) !!}
					</td>
					<td>
						{!! Form::label('fin','fin') !!}
						{!! Form::text('fin', null, ['class'=>'form-control','']) !!}
					</td>
					<td>
						{!! Form::label('cierredisp','cierredisp') !!}
						{!! Form::text('cierredisp', null, ['class'=>'form-control','']) !!}
					</td>
					<td>
						{!! Form::label('cierredata','cierredata') !!}
						{!! Form::text('cierredata', null, ['class'=>'form-control','']) !!}
					</td>
				</tr>
			</tbody>
		</table>

		<div class="form-group">
			{!! Form::submit('Registrar', ['class'=>'btn btn-lg btn-primary']) !!}
		</div>
	{!! Form::close() !!}

@endsection