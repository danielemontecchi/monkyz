@extends('monkyz::layouts.monkyz')

@section('content')
				@php
				$colors = ['success','info','warning','danger'];
				@endphp
				<div class="row">
					@foreach($counters as $section=>$params)
						<div class="col-lg-3 col-sm-6">
							<div class="card">
								<div class="content">
									<div class="row">
										<div class="col-xs-5">
											@php
											$color = $colors[array_rand($colors)];
											@endphp
											<div class="icon-big icon-{{$color}} text-center">
												<i class="{{ $params['icon'] }}"></i>
											</div>
										</div>
										<div class="col-xs-7">
											<div class="numbers">
												<p>{{ ucfirst($section) }}</p>
												{{ $params['count'] }}
											</div>
										</div>
									</div>
								</div>
								<div class="card-footer">
									<hr />
									<div class="stats text-right">
										<a href="{{ route('monkyz.dynamic.list', compact('section')) }}">
											view all records<i class="fa fa-chevron-right" aria-hidden="true"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
@endsection