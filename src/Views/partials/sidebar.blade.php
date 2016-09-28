

			<div class="navbar-default sidebar" role="navigation">
				<div class="sidebar-nav navbar-collapse">
					<ul class="nav" id="side-menu">
						<li>
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
									<li>
										<a href="{{ route('monkyz.dynamic.list', $table) }}" class="@if($section_name==$table) active @endif">
											{!! $params['icon'] !!}{{ $params['title'] }}
										</a>
									</li>
								@endif
							@endif
						@endforeach
					</ul>
				</div>
				<!-- /.sidebar-collapse -->
			</div>
			<!-- /.navbar-static-side -->
		</nav>