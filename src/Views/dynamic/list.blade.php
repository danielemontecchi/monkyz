@extends('monkyz::layouts.monkyz')

@section('content')
				<div class="row page-header">
					<div class="col-lg-8">
						<h1><i class="{{ $table['icon'] }}"></i>{{ $table['title'] }} <small>list</small></h1>
					</div>
					<div class="col-lg-4 text-right">
						<a href="{{ route('monkyz.dynamic.add', compact('section')) }}" class="btn btn-success">
							<i class="fa fa-plus" aria-hidden="true"></i>Create
						</a>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									@foreach($fields as $field=>$params)
										@if($params['in_list'])
											<th>{{ $params['title'] }}</th>
										@endif
									@endforeach
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($records as $record)
									<tr>
										@foreach($fields as $field=>$params)
											@if($params['in_list'])
												{!! Lab1353\Monkyz\Helpers\FieldsHelper::renderInList($params, $record[$field]) !!}
											@endif
										@endforeach
										<td align="right">
											<a href="{{ route('monkyz.dynamic.edit', [ 'id'=>$record['id'], 'section'=>$section ]) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i>Edit</a>
											<a href="{{ route('monkyz.dynamic.delete', [ 'id'=>$record['id'], 'section'=>$section ]) }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i>Delete</a>
										</td>
									</tr>
								@endforeach
							</tbody>
							<tfoot></tfoot>
						</table>
					</div>
				</div>
@endsection