<!doctype html>
<html lang="{{Lang::getLocale()}}">
<head>
	@include('monkyz::partials.head')
</head>
<body>
    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" data-color="" data-image="{{ $monkyz_assets }}images/background/background-{{rand(1,5)}}.jpg">
        <!--   you can change the color of the filter page using: data-color="blue | azure | green | orange | red | purple" -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                            <form method="post" action="{{ route('monkyz.users.login') }}">
                                {{ csrf_field() }}
                                <div class="card" data-background="color" data-color="blue">
                                    <div class="header">
										<img src="{{ $monkyz_assets }}images/logo/monkyz_light_80.png" />
                                    </div>
                                    <div class="content">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" id="email" placeholder="Enter email" class="form-control input-no-border">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" name="password" id="password" placeholder="Password" class="form-control input-no-border">
                                        </div>
                                        <div class="form-group">
                                            <label class="checkbox">
                                                <input type="checkbox" id="remember" name="remember" value="1" data-toggle="checkbox" /> Remember me
                                            </label>
                                        </div>
                                    </div>
                                    <div class="footer text-center">
                                        <button type="submit" class="btn btn-fill btn-success btn-wd ">Let's go</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        	<footer class="footer footer-transparent">
                <div class="container">
					@include('monkyz::partials.footer')
                </div>
            </footer>
        </div>
    </div>

	@include('monkyz::partials.scripts')

    <script src="{{ $monkyz_assets }}js/login.min.js"></script>
</body>
</html>
