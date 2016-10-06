
			<div class="logo">
				<a href="{{ route('monkyz.dashboard') }}" class="simple-text">
					<img src="{{ $monkyz_assets }}images/logo/monkyz_logo_white_80.png" />
				</a>
			</div>
	    	<div class="sidebar-wrapper" id="scroll-sidebar">
				<div class="user">
	                <div class="photo">
	                    <img src="{{ Lab1353\Monkyz\Helpers\UserHelper::gravatar('d.montecchi@yahoo.it', 72) }}" />
	                </div>
	                <div class="info">
	                    <a data-toggle="collapse" href="#collapseExample" class="collapsed">
	                        Daniele Montecchi
	                        <!-- <b class="caret"></b> -->
	                    </a>
	                    <!-- <div class="collapse" id="collapseExample">
	                        <ul class="nav">
	                            <li><a href="#profile">My Profile</a></li>
	                            <li><a href="#editprofile">Edit Profile</a></li>
	                            <li><a href="#settings">Settings</a></li>
	                        </ul>
	                    </div> -->
	                </div>
	            </div>{{$section_name}}
	            <ul class="nav">
					<li @if($route_name=='dashboard')class="active"@endif>
						<a href="{{ route('monkyz.dashboard') }}"><i class="fa fa-dashboard fa-fw"></i>Dashboard</a>
					</li>

					@foreach($tables as $table => $params)
						@if(!empty($table))
							@if($params['visible'])
								<li @if($section_name==$table)class="active"@endif>
									<a href="{{ route('monkyz.dynamic.list', $table) }}">
										<i class="{!! $params['icon'] !!} fa-fw" aria-hidden="true"></i>{{ $params['title'] }}
									</a>
								</li>
							@endif
						@endif
					@endforeach

					<li @if(starts_with($route_name, 'settings.'))class="active"@endif>
	                    <a data-toggle="collapse" href="#settings" @if(starts_with($route_name, 'settings.'))aria-expanded="true"@endif>
	                        <i class="fa fa-cogs fa-fw"></i>
	                        <p>Settings
                                <b class="caret"></b>
                            </p>
	                    </a>
                        <div class="collapse @if(starts_with($route_name, 'settings.'))in @endif" id="settings">
							<ul class="nav">
								<li @if($route_name=='settings.dashboard')class="active"@endif><a href="{{ route('monkyz.settings.dashboard') }}">Dashboard</a></li>
							</ul>
						</div>
					</li>
	            </ul>
	    	</div>