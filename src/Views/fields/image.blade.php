<div class="form-group">
	<label for="{{ $field }}">{{ $params['title'] }}</label>
	<input type="file" class="form-control {{ $params['attributes']['class'] }}"
		id="{{ $field }}" name="{{ $field }}"
		placeholder="{{ $params['title'] }}"  accept=".jpg,.jpeg,.png"
		@foreach($params['attributes'] as $k=>$v)
			@if($k!='class' && !empty($v))
				{{ $k }}="{{ $v }}"
			@endif
		@endforeach
	>
	@if(!empty({{ $record->$field }}))
		<img src="{{ $record->$field }}">
	@endif
</div>