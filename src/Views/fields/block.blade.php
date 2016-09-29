<div class="form-group">
	<label for="{{ $field }}">{{ $params['title'] }}</label>
	<input type="hidden"
		id="{{ $field }}" name="{{ $field }}"
		placeholder="{{ $params['title'] }}" value="{{ $record->$field }}"
		@foreach($params['attributes'] as $k=>$v)
			@if(!empty($k))
				{{ $k }}="{{ $v }}"
			@endif
		@endforeach
	>
	<pre>{{ htmlentities($record->$field) }}</pre>
</div>