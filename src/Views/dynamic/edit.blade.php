@extends('monkyz::layouts.monkyz')

@section('content')
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">{{ $table['title'] }} <small>edit <strong>#{{ $record->id }}</strong></small></h1>
					</div>
				</div>
@endsection