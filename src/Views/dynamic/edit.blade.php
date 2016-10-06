@extends('monkyz::layouts.monkyz')

@section('content')

	@php
	$key_value = 0;
	$fields_files = false;
	@endphp
	@foreach($fields as $field=>$params)
		@if($params['type']=='key')
			@php
			$key_value = $record->$field;
			@endphp
		@endif
		@if(in_array($params['input'], ['file','image']))
			@php
			$fields_files = true;
			@endphp
		@endif
	@endforeach
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<form action="{{ route('monkyz.dynamic.save', compact('section')) }}" method="post" @if($fields_files) enctype="multipart/form-data" @endif>
		            <div class="content">
						@foreach($fields as $field=>$params)
							@if($params['in_edit'])
								@if (view()->exists('monkyz::fields.'.$params['input']))
									@include('monkyz::fields.'.$params['input'])
								@else
									@include('monkyz::fields.text')
								@endif
							@endif
						@endforeach
					</div>
					<div class="card-footer">
						<a href="{{ route('monkyz.dynamic.list', compact('section')) }}" class="btn btn-info">
							<i class="fa fa-chevron-left" aria-hidden="true"></i>Back to list
						</a>
						<button type="submit" class="btn btn-success">
							@if ($is_add_mode)
								<i class="fa fa-plus" aria-hidden="true"></i>Create
							@else
								<i class="fa fa-floppy-o" aria-hidden="true"></i>Save
							@endif
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection