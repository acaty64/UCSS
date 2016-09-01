\resources\views\auth\login.blade.php

@extends('admin.template.main')

@section('title','Login en admin')

@section('content')
	{!! Form::open(['route' => 'admin.auth.login', 'method' => 'POST']) !!}
		 {!! csrf_field() !!}
		<div>
			{!! Form::label('username','Código de Docente') !!}
			{!! Form::text('username',null,['class'=>'form-control','placeholder'=>'000000','required']) !!} 
		</div>
		<div>
			{!! Form::label('password','Password') !!}
			{!! Form::password('password',['class'=>'form-control','required' ]) !!}
		</div>

		<div>
			{!! Form::checkbox('remember', false) !!} Recuérdame
		</div>
			
		<div>
			{!! Form::submit('Acceder', ['class' => 'btn btn-primary']) !!}
		</div>

	{!! Form::close() !!}
@endsection
