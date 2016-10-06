<div class="form-group">
	<label class="checkbox">
		<input type="checkbox"
			id="{{ $field }}" name="{{ $field }}"
			data-toggle="checkbox"
			value="1" @if((bool)$record->$field) checked @endif
		@if(!empty($params['attributes']))
			@foreach($params['attributes'] as $k=>$v)
				@if(!empty($k))
					{{ $k }}="{{ $v }}"
				@endif
			@endforeach
		@endif
	>
		{{ $params['title'] }}
	</label>
</div>