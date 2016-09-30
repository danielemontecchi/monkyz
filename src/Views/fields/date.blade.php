<div class="form-group">
	<label for="{{ $field }}">{{ $params['title'] }}@if(in_array('required', array_keys($params['attributes']))) <strong>*</strong>@endif</label>
	<input type="date" class="form-control @if(!empty($params['attributes']['class'])){{ $params['attributes']['class'] }}@endif"
		id="{{ $field }}" name="{{ $field }}"
		placeholder="{{ $params['title'] }}" value="{{ $record->$field }}"
		@foreach($params['attributes'] as $k=>$v)
			@if($k!='class' && !empty($v))
				{{ $k }}="{{ $v }}"
			@endif
		@endforeach
	>
</div>