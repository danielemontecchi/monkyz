<div class="form-group">
	<label for="{{ $field }}">{{ $params['title'] }}@if(in_array('required', array_keys($params['attributes']))) <strong>*</strong>@endif</label>
	<select name="{{ $field }}" id="{{ $field }}"
		size="1" class="form-control @if(!empty($params['attributes']['class'])){{ $params['attributes']['class'] }}@endif"
		@foreach($params['attributes'] as $k=>$v)
			@if($k!='class' && !empty($v))
				{{ $k }}="{{ $v }}"
			@endif
		@endforeach
	>
		@php
		$model = new Lab1353\Monkyz\Models\DynamicModel;
		$model->setTable($params['relation']['table']);
		$records_rel = $model->all();
		$f_v = $params['relation']['field_value'];
		$f_t = $params['relation']['field_text'];
		@endphp
		@foreach($records_rel as $r)
			<option value="{{ $r->$f_v }}"
			@if($record->$field==$r->$f_v)
				selected
			@endif
			>{{ $r->$f_t }}</option>
		@endforeach
	</select>
</div>