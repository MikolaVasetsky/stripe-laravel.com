<!DOCTYPE html>
<html lang="en" class="no-js">
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>@yield('title')</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="{{asset('public/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('public/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('public/plugins/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css"/>

<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<!--<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/select2/select2-metronic.css')}}"/>-->

<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link rel="stylesheet" type="text/css" href="{{asset('public/css/style-metronic.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/css/style.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/css/style-responsive.css')}}"/>
<!--<link rel="stylesheet" type="text/css" href="{{asset('public/css/plugins.css')}}"/>-->
<link rel="stylesheet" type="text/css" href="{{asset('public/css/themes/default.css')}}"/>

@yield('page_styles')

<link rel="stylesheet" type="text/css" href="{{asset('public/css/custom.css')}}"/>

<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- BEGIN BODY -->
<body class="login">

<!-- BEGIN LOGO -->
<div class="logo">
	<a href="index.html">
		<!--<img src="{{asset('public/img/logo-big.png')}}" alt=""/>-->
	</a>
</div>
<noscript><div style="font-size:14px;max-width: 360px;
    margin: 10px auto;" class="alert alert-danger">

				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

					  <span><strong>Error: </strong>Please enable JavaScript in your browser for better use of the website.</span></div></noscript>
	
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
@yield('content')
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
{{date("Y")}} &copy; copyright.
</div>
<!-- END COPYRIGHT -->

<script src="{{asset('public/plugins/jquery-1.10.2.min.js')}}" type="text/javascript"></script>
<!--<script src="{{asset('public/plugins/jquery-migrate-1.2.1.min.js')}}" type="text/javascript"></script>-->
<script src="{{asset('public/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>

<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->

@yield('page_scripts')

<!-- END PAGE LEVEL SCRIPTS -->

</body>
<!-- END BODY -->
</html>