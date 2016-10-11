<div class="form-group">
	<label for="{{ $field }}">{{ $params['title'] }}@if(in_array('required', array_keys($params['attributes']))) <strong>*</strong>@endif</label>
	<textarea class="form-control wysiwyg @if(!empty($params['attributes']['class'])){{ $params['attributes']['class'] }}@endif"
		id="{{ $field }}" name="{{ $field }}"
		placeholder="{{ $params['title'] }}"
		rows="10"
		@if(!empty($params['attributes']))
			@foreach($params['attributes'] as $k=>$v)
				@if(!empty($k))
					{{ $k }}="{{ $v }}"
				@endif
			@endforeach
		@endif
	>{!! $record->$field !!}</textarea>
</div>