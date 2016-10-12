@extends('template.main')

@section('title','Importación de datos')
	 
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Uploading files with laravel 5</div>
                <div class="panel-body">
                    {!! Form::open(array('url' => 'uploads/save', 'method' => 'post', 'files' => true)) !!}
 
                        <div class="form-group">
                            {!! Form::label('file', 'File') !!}
                            <span class="btn btn-default btn-file">
                               Select a file {!! Form::file('file') !!}
                            </span>
                        </div>
 
                        <div class="form-group">
                            {!! Form::submit('Send', ["class" => "btn btn-success btn-block"]) !!}
                        </div>
 
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
	<hr>
	{!! Form::open($tipos, array('route' => array('admin.import.updata', $tipos), 'method' => 'GET')) !!}
		<div class="form-group">
			{!! Form::label('tipo','Tipo') !!}
			{!! Form::select('tipo',$tipos,null,['class'=>'form-control', 'placeholder'=>'Seleccione el tipo de archivo a importar','required']) !!}
		</div>
		<div class="form-group">
			{!! Form::submit('Importar Datos', ['class'=>'btn btn-primary']) !!}
		</div>
	{!! Form::close() !!}

@endsection
@section('view','admin/import/upload.blade.php')
@section('js')

@endsection