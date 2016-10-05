
			<div class="logo">
				<a href="{{ route('monkyz.dashboard') }}" class="simple-text">
					<img src="{{ $monkyz_assets }}images/logo/monkyz_logo_white_80.png" />
				</a>
			</div>
	    	<div class="sidebar-wrapper">
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
	            </div>
	            <ul class="nav">
					<li @if($section_name=='monkyz')class="active"@endif>
						<a href="{{ route('monkyz.dashboard') }}"><i class="fa fa-dashboard fa-fw"></i>Dashboard</a>
					</li>
					<!--
					<li>
						<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>Charts<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a href="flot.html">Flot Charts</a>
							</li>
							<li>
								<a href="morris.html">Morris.js Charts</a>
							</li>
						</ul>
					</li>-->

					@foreach($tables as $table => $params)
						@if(!empty($table))
							@if($params['visible'])
								<li @if($section_name==$table)class="active"@endif>
									<a href="{{ route('monkyz.dynamic.list', $table) }}">
										<i class="{!! $params['icon'] !!}" aria-hidden="true"></i>{{ $params['title'] }}
									</a>
								</li>
							@endif
						@endif
					@endforeach
	            </ul>
	    	</div>