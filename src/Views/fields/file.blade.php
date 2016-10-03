<div class="form-group">
	<label for="{{ $field }}">{{ $params['title'] }}@if(in_array('required', array_keys($params['attributes']))) <strong>*</strong>@endif</label>
	<input type="hidden" id="{{ $field }}_old" name="{{ $field }}_old" value="{{ $record->$field }}" />
	<input type="file" class="form-control @if(!empty($params['attributes']['class'])){{ $params['attributes']['class'] }}@endif"
		id="{{ $field }}" name="{{ $field }}"
		placeholder="{{ $params['title'] }}"
		@if(!empty($params['attributes']))
			@foreach($params['attributes'] as $k=>$v)
				@if(!empty($k))
					{{ $k }}="{{ $v }}"
				@endif
			@endforeach
		@endif
	>
	@if(!empty($record->$field))
		@php
		$hfile = new Lab1353\Monkyz\Helpers\FileHelper();
		$url = $hfile->getUrlFromParams($params, $record->$field);
		$icon = $hfile->getUrlFileTypeIcon($record->$field);
		@endphp
		<a href="{{ $url }}" target="_blank">
			<img src="{{ $icon }}" class="img-thumbnail">
		</a>
	@endif
</div>