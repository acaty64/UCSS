@extends('template.main')

@section('title','Datos del Usuario')



@section('content')
	
	{!! Form::open(['route'=>'admin.datausers.store', 'method'=>'POST']) !!}

		<div class="form-group">
			{!! Form::label('email1','email UCSS') !!}
			{!! Form::email('email1', null, ['class'=>'form-control', 'placeholder'=>'example@gmail.ucss.pe','required']) !!}
		</div>

		<div class="form-group">
			{!! Form::label('email2','email personal') !!}
			{!! Form::email('email2', null, ['class'=>'form-control', 'placeholder'=>'example@yahoo.com.pe','required']) !!}
		</div>



		<div class="form-group">
			{!! Form::submit('Registrar', ['class'=>'btn btn-primary']) !!}
		</div>

	{!! Form::close() !!}

@endsection
