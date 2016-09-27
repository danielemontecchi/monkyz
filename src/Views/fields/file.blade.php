<div class="form-group">
	<label for="{{ $field }}">{{ $params['title'] }}</label>
	<input type="file" class="form-control {{ $params['attributes']['class'] }}"
		id="{{ $field }}" name="{{ $field }}"
		placeholder="{{ $params['title'] }}"
		@foreach($params['attributes'] as $k=>$v)
			@if($k!='class' && !empty($v))
				{{ $k }}="{{ $v }}"
			@endif
		@endforeach
	>
	@if(!empty({{ $record->$field }}))
		<img src="{{ asset('vendor/lab1353/monkyz/images/ext/'.strtolower(pathinfo($record->$field, PATHINFO_EXTENSION)).'.png') }}">
	@endif
</div>