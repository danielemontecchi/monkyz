<div class="form-group">
	<label>
		<input type="checkbox"
			id="{{ $field }}" name="{{ $field }}"
			value="1" @if((bool)$record->$field) checked @endif
		@foreach($params['attributes'] as $k=>$v)
			@if(!empty($k))
				{{ $k }}="{{ $v }}"
			@endif
		@endforeach
	>
		{{ $params['title'] }}
	</label>
</div>