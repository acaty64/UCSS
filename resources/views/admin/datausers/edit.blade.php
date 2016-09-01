@extends('template.main')

@section('title','Modificación de Datos del Docente: ' . $datauser->user->wdocente($datauser->user_id))

@section('content')
	{!! Form::model($datauser, array('route' => array('admin.datausers.update', $datauser->id), 'method' => 'PUT')) !!}

		<div class="form-group">
			{!! Form::label('fono1','Teléfono Celular') !!}
			{!! Form::number('fono1', $datauser->fono1, ['class'=>'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('fono2','Teléfono Fijo') !!}
			{!! Form::number('fono2', $datauser->fono2, ['class'=>'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('email1','Correo Electrónico Principal') !!}
			{!! Form::email('email1', $datauser->email1, ['class'=>'form-control', 'placeholder'=>'example@ucss.edu.pe']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('email2','Correo Electrónico Alternativo') !!}
			{!! Form::email('email2', $datauser->email2, ['class'=>'form-control', 'placeholder'=>'example@gmail.com']) !!}
		</div>

		<div class="form-group">
			<tr>
				<td>
				{{ Form::hidden('whatsapp', 0) }}
				{{ Form::checkbox('whatsapp', $datauser->whatsapp, ' ',['class'=>'checkbox'] )}}
				</td>	
			    <td>
					{!! Form::label('whatsapp','Marque la casilla si tiene instalado Whatsapp') !!}
				</td>	
			</tr>
		</div>

		<div class="form-group">
			{!! Form::submit('Grabar modificaciones', ['class'=>'btn btn-primary']) !!}
			
		</div>

	{!! Form::close() !!}
@endsection