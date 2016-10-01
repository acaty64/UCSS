@extends('template.main')

@section('title','Disponibilidad Horaria del Docente: ' . $wdocente->wdocente($wdocente->id) )

@section('content')
	{!! Form::model($dhoras, array('route' => ['admin.dhoras.update', $dhoras->id], 'method' => 'PUT')) !!}
	<input type="hidden" name="user_id" value="{{ $wdocente->id }}"></input>
	<input type="hidden" name="dhoras_id" value="{{ $dhoras->id }}"></input>
	<table class="horario">
		<thead>
			<tr>
				<th><div class = 'horario-header'>LUNES</div></th>
				<th><div class = 'horario-header'>MARTES</div></th>
				<th><div class = 'horario-header'>MIÉRCOLES</div></th>
				<th><div class = 'horario-header'>JUEVES</div></th>
				<th><div class = 'horario-header'>VIERNES</div></th>
				<th><div class = 'horario-header'>SÁBADO</div></th>
			</tr>
		</thead>
		<tbody >
			@foreach ($gfranjas as $gfranja) 
				<tr class = 'horario-franja'>
					@for ($i=1; $i < 7 ; $i++)
						<td class = 'horario-dia'>
							<div id='cD{{$i}}_H{{$gfranja->turno}}{{$gfranja->hora}}' class = 'horario-hora'>
							</div>
						</td>
					@endfor
				</tr>
			@endforeach
		</tbody>
	</table>
	<div class="form-group">
		@if( $sw_cambio == '1' )
			{!! Form::submit('Grabar modificaciones', ['class'=>'btn btn-primary']) !!}
		@else
			<p style="color:red">
				La fecha límite de modificación ha expirado. Si necesita modificar su disponibilidad comuníquese con la coordinación académica.
			</p>
		@endif
		{!! Form::close() !!}
	</div>	
					
	<script	type="text/javascript">	
		<?php $ahoras = $dhoras->toArray() ?>
	
		<?php foreach	($franjas	as	$franja):	?>
			<?php	$xfranja	=	'D'.$franja->dia.'_H'.$franja->turno.$franja->hora;	?>			
			<?php	$xdiv 		=	'c'.$xfranja;	?>

//console.log("{{$xfranja}}");
			var 	container	=	document.getElementById("{{$xdiv}}");
			var checkbox = document.createElement('input');
			checkbox.type = "checkbox";
			checkbox.name = "{{$xfranja}}";
			checkbox.id = "{{$xfranja}}";

			check("{{$xfranja}}");
			var label = document.createElement('label');
			label.htmlFor = "{{$xfranja}}";
			label.appendChild(document.createTextNode("{{ $franja->wfranja }}"));
			container.appendChild(checkbox);
			container.appendChild(label);
		<?php endforeach	?>

		function check( xfranja )
		{
//console.log("Franja: ",xfranja);
			<?php foreach ($ahoras as $xcampo => $value): ?>
//console.log( "Campo: ","{{$xcampo}}" );
				if("{{$xcampo}}" == xfranja)
				{
//console.log("Valor: ","{{$value}}");
					if("{{$value}}" == "1")
					{
//console.log("checked");
						checkbox.checked = 'checked';
					}
				}
			
			<?php endforeach ?>
		}
	</script>				
@endsection

@section('view','admin/dhoras/edit.blade.php')
