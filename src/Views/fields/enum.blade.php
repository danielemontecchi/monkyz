<div class="form-group">
	<label for="{{ $field }}">{{ $params['title'] }}@if(in_array('required', array_keys($params['attributes']))) <strong>*</strong>@endif</label>
	<select name="{{ $field }}" id="{{ $field }}"
		size="1" class="form-control @if(!empty($params['attributes']['class'])){{ $params['attributes']['class'] }}@endif"
		@if(!empty($params['attributes']))
			@foreach($params['attributes'] as $k=>$v)
				@if(!empty($k))
					{{ $k }}="{{ $v }}"
				@endif
			@endforeach
		@endif
	>
		@php
		$enum = Lab1353\Monkyz\Helpers\FieldsHelper::getEnum($section, $field);
		@endphp
		@foreach($enum as $v=>$t)
			<option value="{{ $v }}"
			@if($record->$field==$v)
				selected
			@endif
			>{{ $t }}</option>
		@endforeach
	</select>
</div>