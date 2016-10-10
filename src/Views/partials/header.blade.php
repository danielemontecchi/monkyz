
	                <div class="navbar-header">
						<button type="button" class="navbar-toggle">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar bar1"></span>
							<span class="icon-bar bar2"></span>
							<span class="icon-bar bar3"></span>
						</button>
						<a class="navbar-brand" href="#">{!! $page_title !!}</a>
	                </div>
	                <div class="collapse navbar-collapse">

						<ul class="nav navbar-nav navbar-right">
							<li>
								<a href="#">
									<img src="{{ $monkyz_assets }}images/flags/{{ strtoupper(Lang::getLocale()) }}.png" alt="" />
								</a>
							</li>
							<li id="gotosite" class="icon">
								<a href="{{ config('app.url') }}" target="_blank">
									<i class="fa fa-external-link"></i>
								</a>
							</li>
							<li class="spacer"></li>
							<li id="user" class="image">
								<a href="#">
									<img src="{{ $user['image'] }}" class="img-circle" />
									{{ $user['name'] }}
								</a>
							</li>
							<li id="logout" class="icon">
								<a href="{{route('monkyz.users.logout')}}">
									<i class="fa fa-power-off"></i>
								</a>
							</li>
						</ul>
	                </div>