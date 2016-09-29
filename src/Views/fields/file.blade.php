<div class="form-group">
	<label for="{{ $field }}">{{ $params['title'] }}@if(in_array('required', array_keys($params['attributes']))) <strong>*</strong>@endif</label>
	<input type="file" class="form-control {{ $params['attributes']['class'] }}"
		id="{{ $field }}" name="{{ $field }}"
		placeholder="{{ $params['title'] }}"
		@foreach($params['attributes'] as $k=>$v)
			@if($k!='class' && !empty($v))
				{{ $k }}="{{ $v }}"
			@endif
		@endforeach
	>
	@if(!empty($record->$field))
		<a href="{{ Lab1353\Monkyz\Helpers\FieldsHelper::getFileUrl($section, $field, $record->$field) }}" target="_blank">
			<img src="{{ Lab1353\Monkyz\Helpers\FieldsHelper::getUrlFileTypeIcon($record->$field) }}" class="img-thumbnail">
		</a>
	@endif
</div>