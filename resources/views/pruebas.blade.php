@extends('template.main')

@section('content')
    <a href="{{route('backup')}}" >Prueba Backup</a>
    <br>
    <a href="{{route('restore')}}" >Prueba Restore</a>
@endsection
@section('view','/pruebas.blade.php')
