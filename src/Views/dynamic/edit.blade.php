@extends('monkyz::layouts.monkyz')

@section('content')

	@php
	$key_value = 0;
	$fields_files = false;
	$fields_editor = false;
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
		@if($params['input']=='editor')
			@php
			$fields_editor = true;
			@endphp
		@endif
	@endforeach
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<form action="{{ route('monkyz.dynamic.save', compact('section')) }}" method="post" @if($fields_files) enctype="multipart/form-data" @endif>
					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
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
						<button type="submit" class="btn btn-success" id="submitClose" name="submitClose" value="true">
							@if ($is_add_mode)
								<i class="fa fa-plus" aria-hidden="true"></i>Create and close
							@else
								<i class="fa fa-floppy-o" aria-hidden="true"></i>Save and close
							@endif
						</button>
						<button type="submit" class="btn btn-success" id="submitContinue" name="submitContinue" value="true">
							@if ($is_add_mode)
								<i class="fa fa-plus" aria-hidden="true"></i>Create and edit
							@else
								<i class="fa fa-floppy-o" aria-hidden="true"></i>Save and continue edit
							@endif
						</button>
						@if (!$is_add_mode && !$last_edit)
							<button type="submit" class="btn btn-success" id="submitNext" name="submitNext" value="true">
								<i class="fa fa-floppy-o" aria-hidden="true"></i>Save and edit next&nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i>
							</button>
						@endif
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('css')
	@if($fields_editor)
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.min.css" />
	@endif
@endsection

@section('scripts')
	@if($fields_editor)
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.all.min.js"></script>
		@if(Lang::getLocale()=='it')
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/locales/bootstrap-wysihtml5.it-IT.js"></script>
		@else
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/locales/bootstrap-wysihtml5.en-US.min.js"></script>
		@endif
		
		<script>
			$(document).ready(function(){
				$('.wysiwyg').wysihtml5({
					"font-styles": false, //Font styling, e.g. h1, h2, etc. Default true
					"color": false, //Button to change color of font  
					"emphasis": true, //Italics, bold, etc. Default true
					"blockquote": true, //Blockquote  
					"lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
					"html": false, //Button which allows you to edit the generated HTML. Default false
					"link": true, //Button to insert a link. Default true
					"image": true, //Button to insert an image. Default true,
					"smallmodals": true,
					toolbar: {
						"fa": true
					},
					@if(Lang::getLocale()=='it')
					"locale": "it-IT"
					@else
					"locale": "en-US"
					@endif
				});
			});
		</script>
	@endif
@endsection