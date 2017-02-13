@extends('layouts.login_layout')
@section('title','Login Panel')
@section('page_styles')
<link rel="stylesheet" type="text/css" href="{{asset('public/css/pages/login.css')}}"/>
@endsection
@section('content')
<div class="content">
	<!-- BEGIN LOGIN FORM -->
	{!! Form::open(array('url' => URL::to('/login'),'class'=>'login-form')) !!}
	<!--<form class="login-form" action="{{URL::to('/')}}" method="post">-->
		<h3 class="form-title">Login to your account.</h3>
		 @if (count($errors) > 0 || Session::has('message') || Session::has('error'))

		 @if(Session::has('message'))

		  <div style="font-size:14px" class="alert alert-success">

			   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

				 <span>{{Session::get('message')}}</span>

			  @else

			   <div style="font-size:14px" class="alert alert-danger">

					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

						  <span>{{Session::get('error')}}</span>

				   @endif

				  <ul>
					  @foreach($errors->all() as $error)

							  <li>{{ $error }}</li>

					  @endforeach

				  </ul>

				</div>
			 @endif
		<div class="alert alert-danger display-hide">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<span>
				 Enter your email and password.
			</span>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Username</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				{!! Form::text('email','',array('id'=>'','class'=>'form-control placeholder-no-fix','placeholder' => 'Please Enter your Email','autocomplete' => 'off')) !!}
				
				<!--<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username"/> -->
				
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Password</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				{!! Form::password('password',array('class'=>'form-control placeholder-no-fix', 'placeholder' => 'Please Enter your Password','autocomplete' => 'off')) !!}
				<!--<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>-->
			</div>
		</div>
		<div class="form-actions">
			<!--<label class="checkbox">
			<input type="checkbox" name="remember" value="1"/> Remember me </label>-->
			<!--<button type="submit" class="btn green pull-right">
			Login <i class="m-icon-swapright m-icon-white"></i>
			</button>-->
			{!! Form::submit('Login', array('class'=>'btn green pull-right')) !!}
		</div>
	{!! Form::close() !!}
	<!-- END LOGIN FORM -->
</div>
@endsection
@section('page_scripts')
<script src="{{asset('public/plugins/jquery-validation/dist/jquery.validate.min.js')}}" type="text/javascript"></script>
<!--<script src="{{asset('public/plugins/select2/select2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/scripts/core/app.js')}}" type="text/javascript"></script>-->
<script src="{{asset('public/scripts/custom/login.js')}}" type="text/javascript"></script>
<script>
	jQuery(document).ready(function() {     
	 /* App.init();*/
	  Login.init();
	});
</script>
<!-- END JAVASCRIPTS -->
@endsection
