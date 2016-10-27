@extends('monkyz::layouts.monkyz')

@section('content')

				{{-- DATA --}}
				<div class="row">
					@if(!empty($settings['dashboard']['screenshot']))
						<div class="col-sm-4">
							<img src="http://wimg.ca/{{ config('app.url') }}" class="img-rounded img-responsive">
							<small><em>by <a href="http://wimg.ca/" target="_blank">wimg.ca</a></em></small>
						</div>
					@endif
					@if(!empty($settings['dashboard']['serverinfo']))
						<div class="col-sm-8">
							<div class="card">
								<div class="header">
									<h4 class="title"><i class="fa fa-server" aria-hidden="true"></i> Server Info</h4>
								</div>
								<div class="content">
									<dl class="dl-horizontal">
										@foreach($server as $k=>$v)
											<dt>{{$k}}</dt><dd>{{$v}}</dd>
										@endforeach
									</dl>
								</div>
							</div>
						</div>
					@endif
				</div>

				{{-- COUNTERS --}}
				@if(!empty($settings['dashboard']['counters']))
	 				@php
					$colors = ['success','info','warning','danger'];
					@endphp
					<p>&nbsp;</p>
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
				@endif
@endsection