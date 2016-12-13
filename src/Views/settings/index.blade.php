@extends('monkyz::layouts.monkyz')

@section('content')
	<form method="post" action="{{route('monkyz.settings.save')}}" autocomplete="off">
		{!! csrf_field() !!}

		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="header">
						<h4 class="title">
							Dashboard
						</h4>
					</div>
					<div class="content">
						<div class="row">
							<div class="col-xs-8">Screenshot</div>
							<div class="col-xs-4">
								<input type="hidden" id="dashboard_screenshot" name="dashboard_screenshot" value="0" />
								<input type="checkbox" id="dashboard_screenshot" name="dashboard_screenshot" @if($settings['dashboard_screenshot']) checked @endif data-toggle="switch" class="ct-primary" value="1" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-8">Server info</div>
							<div class="col-xs-4">
								<input type="hidden" id="dashboard_serverinfo" name="dashboard_serverinfo" value="0" />
								<input type="checkbox" id="dashboard_serverinfo" name="dashboard_serverinfo" @if($settings['dashboard_serverinfo']) checked @endif data-toggle="switch" class="ct-primary" value="1" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-8">Analytics</div>
							<div class="col-xs-4">
								<input type="hidden" id="dashboard_analytics" name="dashboard_analytics" value="0" />
								<input type="checkbox" id="dashboard_analytics" name="dashboard_analytics" @if($settings['dashboard_analytics']) checked @endif data-toggle="switch" class="ct-primary" value="1" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-8">Counters</div>
							<div class="col-xs-4">
								<input type="hidden" id="dashboard_counters" name="dashboard_counters" value="0" />
								<input type="checkbox" id="dashboard_counters" name="dashboard_counters" @if($settings['dashboard_counters']) checked @endif data-toggle="switch" class="ct-primary" value="1" />
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="card">
					<div class="header">
						<h4 class="title">
							Counters
						</h4>
					</div>
					<div class="content">
						@foreach($tables as $table=>$params)
							<div class="row">
								<div class="col-xs-8">
									{{ ucfirst($table) }}
								</div>
								<div class="col-xs-4">
									<input type="hidden" id="counters_{{$table}}" name="counters_{{$table}}" value="0" />
									<input type="checkbox" id="counters_{{$table}}" name="counters_{{$table}}" @if(!empty($settings['counters_'.$table])) checked @endif data-toggle="switch" class="ct-primary" value="1" />
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="header">
						<h4 class="title">Google Analytics</h4>
					</div>
					<div class="content">
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group">
                                    <label class="col-sm-4">View ID</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="analytics_viewid" name="analytics_viewid" value="{{$settings['analytics_viewid']}}" class="form-control" />
                                    </div>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<hr class="hr" />
	
		<div class="row">
			<div class="col-md-6">
				<a href="{{ route('monkyz.settings.default') }}" id="settingsResetDefault" class="btn btn-fill btn-info"><i class="fa fa-recycle" aria-hidden="true"></i>Reset Default</a>
			</div>
			<div class="col-md-6 text-right">
				<button type="submit" class="btn btn-fill btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save settings</button>
			</div>
		</div>

	</form>
@endsection