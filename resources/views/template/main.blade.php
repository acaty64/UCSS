<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>@yield('title','UCSS-FCEC')</title>
	<link rel="stylesheet" href="{{ asset('plugins\bootstrap\css\bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins\chosen\chosen.css') }}">
	<link rel="stylesheet" href="{{ asset('css\estilos.css') }}">
</head>
<body class='admin-body'>
	@include('template.partials.nav')
	<section class='section-admin'>
		<div class='panel panel-default'>
			<div class='panel-heading'>
				<h3 class='panel-title'>
					@yield('title')
				</h3>
			</div>	
		</div>
		<div class='panel-body'>
		    @include('flash::message')
			@include('template.partials.errors')
			@yield('content')
		</div>
	</section>
	
	<script src="{{ asset('plugins\jquery\js\jquery-3.1.0.js') }}"></script>
	<script src="{{ asset('plugins\bootstrap\js\bootstrap.js') }}"></script>
	<script src="{{ asset('plugins\chosen\chosen.jquery.js') }}"></script>

	@yield('js')
	<div class="panel-footer">
		@include('template.partials.footer')
	</div>


</body>
</html>