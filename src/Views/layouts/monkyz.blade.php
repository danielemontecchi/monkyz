<!doctype html>
<html lang="en">
<head>
	@include('monkyz::partials.head')
</head>

<body>
	<div id="wrapper">

		<!-- Navigation -->
		<div class="sidebar" data-background-color="brown" data-active-color="warning">

			@include('monkyz::partials.sidebar')
		</nav>

		<div class="main-panel">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					@include('monkyz::partials.header')
	        </nav>
	        <div class="content">
	            <div class="container-fluid">
					@include('monkyz::partials.messages')

					@yield('content')
				</div>
			</div>
			@include('monkyz::partials.footer')
	    </div>
	</div>

	@include('monkyz::partials.scripts')
</body>
</html>
