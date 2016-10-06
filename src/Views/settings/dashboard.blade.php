@extends('monkyz::layouts.monkyz')

@section('content')
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<form method="post" action="#">
					<div class="header">
						<h4 class="title">
							Counters
						</h4>
					</div>
					<div class="content">
						@foreach($tables as $table=>$params)
							@if($params['visible'])
								<div class="row">
									<div class="col-xs-8">
										{{ ucfirst($table) }}
									</div>
									<div class="col-xs-4">
										<input type="checkbox" checked data-toggle="switch" class="ct-primary"/>
									</div>
								</div>
							@endif
						@endforeach
						<button type="submit" class="btn btn-fill btn-info"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save settings</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection