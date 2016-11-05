@extends('layouts.app')

@section('title','Login')

@section('content')
<div class="container">
	<div class="row">
        <div class="col-md-4 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Identifíquese</div>
	                <div class="panel-body">
						{!! Form::open(['route' => 'auth.login', 'method' => 'POST']) !!}
							 {!! csrf_field() !!}
							<div>
								{!! Form::label('username','Código de Docente') !!}
								{!! Form::text('username',null,['class'=>'form-control','placeholder'=>'000000','required']) !!} 
							</div>
							<div>
								{!! Form::label('password','Password') !!}
								{!! Form::password('password',['class'=>'form-control','required' ]) !!}
							</div>
							<br>
							<!--div>
								{!! Form::checkbox('remember', false) !!} Recuérdame
							</div-->
							<br>
							<div>
								{!! Form::submit('Acceder', ['class' => 'btn btn-primary']) !!}
							</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('view','login')
