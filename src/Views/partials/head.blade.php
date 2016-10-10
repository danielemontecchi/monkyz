<title>Monkyz</title>

<!-- METATAG -->

<!-- info -->
<meta name="description" content="dynamic and autonomous Administration Panel for Laravel 5">
<meta name="author" content="lab1353">
<meta name="publisher" content="www.1353.it">
<meta name="copyright" content="www.1353.it">
<!-- formatting -->
<meta charset="utf-8">
<meta http-equiv="content-language" content="{{Lang::getLocale()}}">
<!-- favicon -->
<link rel="icon" href="{{ $monkyz_assets }}images/logo/monkyz_favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="{{ $monkyz_assets }}images/logo/monkyz_favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="{{ $monkyz_assets }}images/logo/monkyz_favicon.ico" type="image/vnd.microsoft.icon">
<!-- icons -->
<link rel="icon" sizes="192x192" href="{{ $monkyz_assets }}images/logo/monkyz_192.png">
<link rel="icon" sizes="128x128" href="{{ $monkyz_assets }}images/logo/monkyz_128.png">
<link rel="apple-touch-icon" href="{{ $monkyz_assets }}images/logo/monkyz_60.png">
<link rel="apple-touch-icon" sizes="76x76" href="{{ $monkyz_assets }}images/logo/monkyz_76.png">
<link rel="apple-touch-icon" sizes="120x120" href="{{ $monkyz_assets }}images/logo/monkyz_120.png">
<link rel="apple-touch-icon" sizes="128x128" href="{{ $monkyz_assets }}images/logo/monkyz_128.png">
<link rel="apple-touch-icon" sizes="152x152" href="{{ $monkyz_assets }}images/logo/monkyz_152.png">
<link rel="apple-touch-icon-precomposed" sizes="128x128" href="{{ $monkyz_assets }}images/logo/monkyz_128.png">
<!-- mobile -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=yes">
<!-- theme color -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="theme-color" content="#66615b">
<meta name="msapplication-navbutton-color" content="#66615b">
<meta name="apple-mobile-web-app-status-bar-style" content="#66615b">
<!-- robots -->
<meta name="robots" content="noindex, NOFOLLOW">
<meta name="googlebot" content="NOINDEX, NOFOLLOW">
<meta name="googlebot-news" content="nosnippet">

<!-- CSS -->

<!-- Bootstrap core CSS     -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Pace Theme -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
<!-- Google Fonts -->
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
<!-- Fonts and icons -->
<link href="//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
@if(!empty($scripts['datatables']))
	<!--  Datatables     -->
	{{-- //cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.css --}}
	{{-- //cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css --}}
	<link href="//cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.css">
@endif
<!-- Custom CSS -->
<link href="{{ $monkyz_assets }}css/monkyz.min.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
