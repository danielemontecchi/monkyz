@extends('monkyz::layouts.monkyz')

@section('content')
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<form method="get" action="{{ route('monkyz.tools.files.clean') }}">
					<div class="header">
						<h4 class="title">
							Clean Temporary
						</h4>
					</div>
					<div class="content">
						@if($c_files>0)
							<p class="text-warning"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <b>{{$c_files}}</b> temporary files</p>
							<p>Cleaning temporary files uploaded.</p>
							<button type="submit" class="btn btn-fill btn-info"><i class="fa fa-trash" aria-hidden="true"></i>Clean</button>
						@else
							<p class="text-success"><i class="fa fa-check-circle-o" aria-hidden="true"></i> no temporary files</p>
						@endif
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection