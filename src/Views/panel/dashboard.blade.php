@extends('monkyz::layouts.monkyz')

@section('scripts')
	@if(!empty($settings['dashboard_analytics']) && is_array($analytics))
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script>
			google.charts.load('current', {packages: ['corechart', 'line']});
			google.charts.setOnLoadCallback(drawBackgroundColor);

			function drawBackgroundColor() {
				  var data = new google.visualization.DataTable();
				  data.addColumn('string', 'Date');
				  data.addColumn('number', 'Visitors');
				  data.addColumn('number', 'Page views');

				  data.addRows([
					@php
						$i = 0;
						$numItems = count($analytics['TotalVisitorsAndPageViews']);
						foreach ($analytics['TotalVisitorsAndPageViews'] as $value) {
							echo '[
								\''.$value['date']->day.'/'.$value['date']->month.'\',
								'.$value['visitors'].',
								'.$value['pageViews'].'
							]';
							if (++$i !== $numItems) echo ',';
						};
					@endphp
				  ]);

				  var options = {
					hAxis: {
					  axisTitlesPosition: 'none'
					},
					vAxis: {
					  axisTitlesPosition: 'none'
					},
					chartArea: {left:50,top:10,width:'80%',height:'80%'},
					backgroundColor: 'transparent'
				  };

				  var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
				  chart.draw(data, options);
				}
		</script>
	@endif
@endsection

@section('content')

{{dump($settings)}}
				{{-- DATA --}}
				<div class="row">
					@if(!empty($settings['dashboard_screenshot']))
						<div class="col-sm-4">
							<img src="http://wimg.ca/{{ config('app.url') }}" class="img-rounded img-responsive">
						</div>
					@endif
					@if(!empty($settings['dashboard_serverinfo']))
						<div class="col-sm-7">
							<div class="card">
								<div class="header">
									<h4 class="title"><i class="fa fa-server" aria-hidden="true"></i> Server Info</h4>
								</div>
								<div class="content">
									<dl class="dl-horizontal">
										@foreach($serverinfo as $k=>$v)
											<dt>{{$k}}</dt><dd>{{$v}}</dd>
										@endforeach
									</dl>
								</div>
							</div>
						</div>
					@endif
				</div>

				{{-- COUNTERS --}}
				@if(!empty($settings['dashboard_counters']))
					@php
					$colors = ['success','info','warning','danger'];
					@endphp
					<p>&nbsp;</p>
					<div class="row">
						@foreach($counters as $section=>$params)
							@if($settings['counters_'.$section])
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
							@endif
						@endforeach
					</div>
				@endif

				{{-- ANALYTICS --}}
				@if(!empty($settings['dashboard_analytics']))
					<div class="row">
						<div class="col-xs-12">
							@if(is_array($analytics))
								<div id="chart_div"></div>
							@elseif(!empty($analytics))
								<div class="alert alert-danger">
                                    <button type="button" aria-hidden="true" class="close">×</button>
                                    <span>{!! $analytics !!}</span>
                                </div>
							@endif
						</div>
					</div>
				@endif
@endsection