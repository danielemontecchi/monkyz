@extends('monkyz::layouts.monkyz')

@section('content')

				{{-- DATA --}}
				<div class="row">
					<div class="col-sm-4">
						<img src="http://wimg.ca/{{ config('app.url') }}"><br>
						<small><em>by <a href="http://wimg.ca/" target="_blank">wimg.ca</a></em></small>
					</div>
					<div class="col-sm-8">
						<h4 style="margin-top: 0px;">{{ config('app.url') }}</h4>
						<dl class="dl-horizontal">
							<dt>php</dt><dd>{{$data['php']}}</dd>
							<dt>web server</dt><dd>{{$data['web']}}</dd>
							<dt>server</dt><dd>{{$data['server']}}</dd>
						</dl>
					</div>
				</div>

				{{-- COUNTERS --}}
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
@endsection