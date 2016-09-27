<!doctype html>
<html lang="en">
<head>
	@include('monkyz::partials.head')
</head>

<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			@include('monkyz::partials.header')

			@include('monkyz::partials.sidebar')
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
            	@include('monkyz::partials.messages')

				@yield('content')
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

	@include('monkyz::partials.scripts')
</body>
</html>
