<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta charset="utf-8"/>
<title>@yield('title','Dashboard')</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="{{asset('public/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('public/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('public/plugins/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
@yield('page_styles')
<!-- END PAGE LEVEL PLUGIN STYLES -->
<!-- BEGIN THEME STYLES -->
<link rel="stylesheet" type="text/css" href="{{asset('public/css/style-metronic.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/css/style.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/css/style-responsive.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/css/plugins.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/css/themes/default.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/css/custom.css')}}"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">

<!-- BEGIN HEADER -->
<div class="header navbar navbar-fixed-top">
	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="header-inner">
		<!-- BEGIN LOGO -->
		<a class="navbar-brand" href="index.html">
			<!--<img src="{{asset('public/img/logo.png')}}" alt="logo" class="img-responsive"/>-->
		</a>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<img src="{{asset('public/img/menu-toggler.png')}}" alt=""/>
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<ul class="nav navbar-nav pull-right">

			<!-- BEGIN USER LOGIN DROPDOWN -->
			<li class="dropdown user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<!--<img alt="" src="{{asset('public/img/avatar1_small.jpg')}}"/>-->
					<span class="username">
					{{ Auth::user()->name}}
					</span>
					<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<!--<li>
						<a href="extra_profile.html">
							<i class="fa fa-user"></i> My Profile
						</a>
					</li>
					<li class="divider">
					</li>-->
					<li>
						<a href="{{ URL::to('/logout')}}">
							<i class="fa fa-key"></i> Log Out
						</a>
					</li>
				</ul>
			</li>
			<!-- END USER LOGIN DROPDOWN -->
		</ul>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<!-- add "navbar-no-scroll" class to disable the scrolling of the sidebar menu -->
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone">
					</div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<!--<li class="start active ">
					<a href="index.html">
						<i class="fa fa-home"></i>
						<span class="title">
							Dashboard
						</span>
						<span class="selected">
						</span>
					</a>
				</li>-->
				@if( Request::is('user/dashboard/*') || Request::is('user/dashboard') )                                    
					<li class="start active">                                @else                                     
					<li>                                
					@endif	
					<a href="javascript:;">
						<i class="fa fa-home"></i>
						<span class="title">
							Home
						</span>
						<span class="arrow ">
						</span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="{{URL::to('/user/dashboard')}}">
								<i class="fa fa-users"></i>
								List Accounts
							</a>
						</li>
						<li>
							<a href="{{URL::to('/user/dashboard/create')}}">
								<i class="fa fa-plus"></i>
								New Account
							</a>
						</li>
					</ul>
				</li>
				
				<li class="last ">
					<a href="{{ URL::to('/logout')}}">
						<i class="fa fa-sign-out"></i>
						<span class="title">
							Logout
						</span>
					</a>
				</li>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
		<noscript><div style="font-size:14px" class="alert alert-danger">

				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

					  <span><strong>Error: </strong>Please enable JavaScript in your browser for better use of the website.</span></div></noscript>
		@if (count($errors) > 0 || Session::has('message') || Session::has('error'))

		 @if(Session::has('message'))

		  <div style="font-size:14px" class="alert alert-success">

			   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

				 <span><strong>Success: </strong>{{Session::get('message')}}</span>

		  @else

		   <div style="font-size:14px" class="alert alert-danger">

				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

					  <span><strong>Error: </strong> {{Session::get('error')}}</span>

			   @endif

			  <ul>
				  @foreach($errors->all() as $error)

						  <li>{{ $error }}</li>

				  @endforeach

			  </ul>

			</div>
		 @endif	
		
		
		@yield('content')
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="footer">
	<div class="footer-inner">
	{{date("Y")}} &copy; Copyright.
	</div>
	<div class="footer-tools">
		<span class="go-top">
			<i class="fa fa-angle-up"></i>
		</span>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<script>
	var project_url="{{ URL::to('/')}}";
</script>
<script src="{{asset('public/plugins/jquery-1.10.2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/plugins/jquery-migrate-1.2.1.min.js')}}" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{asset('public/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>

<script src="{{asset('public/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/plugins/jquery.cokie.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/plugins/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<script type="text/javascript">

 jQuery(document).ready(function() {   
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
 });
 /*Used add active class to submenu*/
$(function(){
	$('.sub-menu a').filter(function(){return this.href==location.href}).parent().addClass('active').siblings().removeClass('active')
	$('.sub-menu a').click(function(){
		$(this).parent().addClass('active').siblings().removeClass('active')	
	})
})
</script> 

<!-- BEGIN PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
@yield('page_scripts')
	<!-- END PAGE LEVEL SCRIPTS -->
<!-- END JAVASCRIPTS -->



</body>
<!-- END BODY -->
</html>