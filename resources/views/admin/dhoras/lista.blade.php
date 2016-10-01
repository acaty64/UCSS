<?php
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment; filename=DispHorarios.xls");
header("Content-Transfer-Encoding: binary ");
 
/*
http://www.lawebdelprogramador.com
*/
?>	
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>	
	<table class="table table-striped">
 		<thead>
 			<th>Código</th>
 			<th>Docente</th>
 			<th>Envío</th>
 			<th>Límite</th>
 			<th>Actualización</th>
 			<th>Status</th>
 		</thead>
 		<tbody>
 			@foreach($lista as $registro)
 				<tr>
 					<td>{{$registro['username']}}</td>
					<td>{{substr($registro['wdocente'],0,50)}}</td>
					<td>{{$registro['fenvio']}}</td>
					<td>{{$registro['flimite']}}</td>
					<td>{{$registro['updated_at']}}</td>
					<td>{{$registro['sw_actualizacion']}}</td>
	 			</tr>
 			@endforeach
 			
 		</tbody>
	</table>
</body>
