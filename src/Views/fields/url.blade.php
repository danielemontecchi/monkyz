<div class="form-group">
	<label for="{{ $field }}">{{ $params['title'] }}</label>
	<input type="url" class="form-control {{ $params['attributes']['class'] }}"
		id="{{ $field }}" name="{{ $field }}"
		placeholder="{{ $params['title'] }}" value="{{ $record->$field }}"
		@foreach($params['attributes'] as $k=>$v)
			@if($k!='class' && !empty($v))
				{{ $k }}="{{ $v }}"
			@endif
		@endforeach
	>
</div>