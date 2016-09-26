@extends('monkyz::layouts.monkyz')

@section('content')
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">{{ $table['title'] }} <small>&gt;</small> edit #{{ $record->id }}</h1>
					</div>
				</div>
@endsection