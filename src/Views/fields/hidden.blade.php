<input type="hidden"
	id="{{ $field }}" name="{{ $field }}"
	placeholder="{{ $params['title'] }}" value="{{ $record->$field }}"
	@foreach($params['attributes'] as $k=>$v)
		@if(!empty($k))
			{{ $k }}="{{ $v }}"
		@endif
	@endforeach
>