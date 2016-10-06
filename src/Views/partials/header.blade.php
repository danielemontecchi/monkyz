
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
							<li>
								<a href="{{ config('app.url') }}" target="_blank">
									<i class="fa fa-external-link"></i>Go to website
								</a>
							</li>
						</ul>
	                </div>