@if (Session::has('success'))
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

		{{ Session::get('success') }}
	</div>
@endif
@if (Session::has('error'))
	<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

		{{ Session::get('error') }}
	</div>
@endif