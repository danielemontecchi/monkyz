@extends('monkyz::layouts.monkyz')

@section('content')
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<form method="get" action="{{ route('monkyz.tools.files.clean') }}">
					<div class="header">
						<h4 class="title">
							Temp Files
						</h4>
					</div>
					<div class="content">
						<p>Cleaning temp files uploaded in: <code>public/{{config('monkyz.path_public_temp')}}</code></p>
						@if($c_files>0)
							<p class="text-warning"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <b>{{$c_files}}</b> temp files</p>
							<button type="submit" class="btn btn-fill btn-info"><i class="fa fa-trash" aria-hidden="true"></i>Clean files</button>
						@else
							<p class="text-success"><i class="fa fa-check-circle-o" aria-hidden="true"></i> no files in temp folder</p>
						@endif
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection