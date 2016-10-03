<div class="form-group">
	<label for="{{ $field }}">@if(!empty($params['title'])){{ $params['title'] }}@else{{ $field }}@endif</label>
	<input type="hidden"
		id="{{ $field }}" name="{{ $field }}"
		placeholder="{{ $params['title'] }}" value="{{ $record->$field }}"
		@foreach($params['attributes'] as $k=>$v)
			@if(!empty($k) && $k!='required')
				{{ $k }}="{{ $v }}"
			@endif
		@endforeach
	>
	<pre>{{ htmlentities($record->$field) }}</pre>
</div>