@extends('template.main')

@section('title','SILABO DEL CURSO: '.$wcurso)

@section('content')
	<embed src= {{$arch_pdf}} width="100%" height="800" margin-left:auto margin-right:auto></embed>
@endsection