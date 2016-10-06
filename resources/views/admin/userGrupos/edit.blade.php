@extends('template.main')

@section('title','Designar Grupo Responsable '.$usergrupo->user->wdocente($usergrupo->user->id)." : Código ".$usergrupo->user->username)

@section('content')
	{!! Form::model($usergrupo, array('route' => array('admin.usergrupos.update', $usergrupo->user_id), 'method' => 'PUT')) !!}
		<div class="form-group">	
			{!! Form::label('grupo','Designe el grupo: ') !!}
			<!-- Form::select('size', array('L' => 'Large', 'S' => 'Small'), 'S'); -->
			{!! Form::select('grupo', $grupos, $usergrupo->grupo_id, ['class'=>'form-control', 'placeholder'=> 'Seleccione el grupo asignado...', 'required']) !!}
		</div>	
		<div class="form-group">	
			{!! Form::submit('Grabar modificaciones', ['class'=>'btn btn-primary']) !!}
		</div>	

	{!! Form::close() !!}
@endsection

@section('view','admin/userGrupos/edit.blade.php')