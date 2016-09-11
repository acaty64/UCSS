@if(count($errors) > 0)
		<div class="alert alert-danger" role='alert' class="close">
			<ul>
				@foreach ($errors -> all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif