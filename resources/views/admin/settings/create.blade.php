@extends('layouts.layout')
@section('title','Charge Customer')
@section('page_styles')
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/select2/select2-metronic.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/data-tables/DT_bootstrap.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/bootstrap-datepicker/css/datepicker.css')}}"/>
@endsection
@section('content')
			<div id="notification-error" style="font-size:14px;display:none;" class="alert alert-danger" >
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>
					Error:
					</strong>
					  <span id="spErrorMessage"></span>
			</div>

			<!-- BEGIN PAGE HEADER-->
			

			
			
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					
					<ul class="page-breadcrumb breadcrumb">
						
						<li>
							<i class="fa fa-cog"></i>
				
								Settings

						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			
	<div class="portlet box green">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-reorder"></i>Required Settings For App
			</div>
			
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
{!! Form::open(array('url' => URL::to('/admin/settings/create'),'class' => 'form-horizontal ', 'id'=>'settings_form' )) !!}
				<div class="form-body">

					<div class="form-group">
						<label class="col-md-3 control-label">Notification Email</label>
						<div class="col-md-4">
							
								<!--<input type="email" placeholder="Email Address" class="form-control">-->
{!!Form::text('notification_email',Input::old('notification_email',App\AppSettings::get_option_value_by_key('notification_email')),array('class'=>'form-control','placeholder' => 'Enter Email','autocomplete' => 'off')) !!}								
						
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"> Password</label>
						<div class="col-md-4">
							
{!! Form::password('admin_password',array('id'=>'admin_password', 'class'=>'form-control placeholder-no-fix', 'placeholder' => 'Please Enter Password','autocomplete' => 'off')) !!}

								
						
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Srtipe Api Mode</label>
						<div class="col-md-9">
						@if(App\AppSettings::get_option_value_by_key('stripe_api_mode') == "live")
							<div class="radio-list">
								<label class="radio-inline">
										<span>
		{!!Form::radio('stripe_api_mode', 'test', false, array('class' => 'stripe_api_mode','id' => 'srtipe_api_test'))!!}
											
										</span>
									Test
									
								</label>
								<label class="radio-inline">
									<span>{!!Form::radio('stripe_api_mode', 'live',true, array('class'=>'stripe_api_mode','id'=>'srtipe_api_live'))!!}</span>Live</label>
								<label class="radio-inline">
								
							</div>
						@else
							<div class="radio-list">
								<label class="radio-inline">
										<span>
		{!!Form::radio('stripe_api_mode', 'test', true, array('class' => 'stripe_api_mode','id' => 'srtipe_api_test'))!!}
											
										</span>
									Test
									
								</label>
								<label class="radio-inline">
									<span>{!!Form::radio('stripe_api_mode', 'live',false, array('class'=>'stripe_api_mode','id'=>'srtipe_api_live'))!!}</span>Live</label>
								<label class="radio-inline">
								
							</div>
						@endif
						</div>
					</div>
				<div class="stripe_live">	
					<div class="form-group">
						<label class="col-md-3 control-label"> Public Key</label>
						<div class="col-md-4">
							
								<!--<input type="email" placeholder="Email Address" class="form-control">-->
{!!Form::text('live_stripe_public_key',Input::old('live_stripe_public_key',App\AppSettings::get_option_value_by_key('live_stripe_public_key')),array('class'=>'form-control','placeholder' => 'Enter Stripe Live Public Key')) !!}								
						
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">  Secret Key</label>
						<div class="col-md-4">
							
{!!Form::text('live_stripe_secret_key',Input::old('live_stripe_secret_key',App\AppSettings::get_option_value_by_key('live_stripe_secret_key')),array('class'=>'form-control','placeholder' => 'Enter Stripe Live Secret Key')) !!}	

						</div>

					</div>
				</div>	
				<div class="stripe_test">	
					<div class="form-group">
						<label class="col-md-3 control-label"> Public Key</label>
						<div class="col-md-4">
							
								<!--<input type="email" placeholder="Email Address" class="form-control">-->
{!!Form::text('test_stripe_public_key',Input::old('test_stripe_public_key',App\AppSettings::get_option_value_by_key('test_stripe_public_key')),array('class'=>'form-control','placeholder' => 'Enter Stripe Test Public Key')) !!}								
						
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">  Secret Key</label>
						<div class="col-md-4">
							
{!!Form::text('test_stripe_secret_key',Input::old('test_stripe_secret_key',App\AppSettings::get_option_value_by_key('test_stripe_secret_key')),array('class'=>'form-control','placeholder' => 'Enter Stripe Test Secret Key')) !!}	

						</div>
					</div>
				</div>
					
		
				</div>
				<div class="form-actions fluid">
					<div class="col-md-offset-3 col-md-9">
						
					{!!Form::submit('Submit',array('class'=>'btn blue')) !!}
					<a href="{{URL::to('/admin/dashboard')}}" class="btn default">Cancel</a>
						
					</div>
				</div>
				{!! Form::close()!!}
			<!-- END FORM-->
		</div>
	</div>
			

@endsection

@section('page_scripts')
<script type="text/javascript" src="{{asset('public/plugins/select2/select2.min.js')}}"></script>


<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script type="text/javascript" src="{{asset('public/scripts/core/app.js')}}"></script>
<script src="{{asset('public/plugins/jquery-validation/dist/jquery.validate.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('public/scripts/custom/admin-settings.js')}}"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
        jQuery(document).ready(function() {    
           App.init();
		   SettingsFormValidations.init();
		  
		   var mode_val = $('.stripe_api_mode:checked').val();
		   change_stripe_mode(mode_val);
		   
		   jQuery(document).on('click','.stripe_api_mode',function(){
			   var mode = jQuery(this).val();
			   change_stripe_mode(mode);
		   });
		   
		   function change_stripe_mode(mode){
			   
			   if(mode == "live"){
					jQuery(".stripe_live").show();
					jQuery(".stripe_test").hide();
				}
				if(mode == "test"){
					jQuery(".stripe_live").hide();
					jQuery(".stripe_test").show();
				}
		   }
			
        });
    </script>
@endsection
