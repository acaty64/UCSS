@extends('template.main')

@section('title','Modificación de Datos Horaria del Docente: ' )

@section('content')

	<table>
		<thead>
			<tr>
				<th>LUN</th>
				<th>MAR</th>
				<th>MIE</th>
				<th>JUE</th>
				<th>VIE</th>
				<th>SAB</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($gfranjas as $gfranja) 
				<tr>
					@for ($i=1; $i < 7 ; $i++)
						<td>
							<div id='cD{{$i}}_H{{$gfranja->turno}}{{$gfranja->hora}}'>
							</div>
						</td>
					@endfor
				</tr>
			@endforeach
		</tbody>
	</table>

					
	<script	type="text/javascript">	


		<?php foreach	($franjas	as	$franja):	?>
			<?php	$xfranja	=	'D'.$franja->dia.'_H'.$franja->turno.$franja->hora;	?>			
			<?php	$xdiv 		=	'c'.$xfranja;	?>
			


			console.log("{{$xfranja}}");
			var 	container	=	document.getElementById("{{$xdiv}}");
			var checkbox = document.createElement('input');
			checkbox.type = "checkbox";
			checkbox.name = "{{$xfranja}}";
			checkbox.id = "{{$xfranja}}";
			{{dd($dhoras)}};
check('D1_H11',{{$dhoras}});
			var label = document.createElement('label')
			label.htmlFor = "{{$xfranja}}";
			label.appendChild(document.createTextNode("{{ $franja->wfranja }}"));
			container.appendChild(checkbox);
			container.appendChild(label);
		<?php endforeach	?>

		function check( xfranja, dhoras )
		{
			{{dd($dhoras)}}
			console.log(xfranja);

			console.log(dhoras[xfranja]);
			
		}
	</script>				
					



@endsection

