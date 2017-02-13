@extends('layouts.layout')
@section('title','Update Customer Details')
@section('page_styles')
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/select2/select2-metronic.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/data-tables/DT_bootstrap.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/bootstrap-datepicker/css/datepicker.css')}}"/>
@endsection
@section('content')
				<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					
					<ul class="page-breadcrumb breadcrumb">
						
						<li>
							<i class="fa fa-home"></i>
							<a href="{{URL::to('/admin/dashboard')}}">
								Home
							</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
						<i class="fa fa-home"></i>
								Update Customer Details
						</li>
					
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->


	<div class="portlet box green">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-reorder"></i>Update Customer Details
			</div>
			
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
{!! Form::open(array('url' => URL::to('/admin/customer/update/'.$user->id),'class' => 'form-horizontal customer_details' )) !!}
				<div class="form-body">
					<div class="form-group">
						<label class="col-md-3 control-label">Name</label>
						<div class="col-md-4">
							<!--<input type="text" placeholder="Enter Full Name" class="form-control">-->
{!!Form::text('name',Input::old('name',$user->name),array('class'=>'form-control','placeholder' => 'Enter Full Name')) !!}
							
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Email Address</label>
						<div class="col-md-4">
							
								<!--<input type="email" placeholder="Email Address" class="form-control">-->
{!!Form::text('email',Input::old('email',$user->email),array('class'=>'form-control','placeholder' => 'Enter Email','autocomplete' => 'off')) !!}								
						
						</div>
					</div>
					<!--<div class="form-group">
						<label class="col-md-3 control-label"> Password</label>
						<div class="col-md-4">
							
{!! Form::password('password',array('id'=>'password', 'class'=>'form-control placeholder-no-fix', 'placeholder' => 'Please Enter your Password','autocomplete' => 'off')) !!}

								
						
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Confirm Password</label>
						<div class="col-md-4">
							
{!! Form::password('cpassword',array('class'=>'form-control placeholder-no-fix', 'placeholder' => 'Enter Same Password Again.','autocomplete' => 'off')) !!}

								
						
						</div>
					</div>-->
				</div>
				<div class="form-actions fluid">
					<div class="col-md-offset-3 col-md-9">
						
					{!!Form::submit('Submit',array('class'=>'btn blue')) !!}
					{!!Form::button('Cancel',array('class'=>'btn default')) !!}
						
					</div>
				</div>
				{!! Form::close()!!}
			<!-- END FORM-->
		</div>
	</div>
		
@endsection

@section('page_scripts')
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{asset('public/scripts/core/app.js')}}" type="text/javascript"></script>
<script src="{{asset('public/plugins/jquery-validation/dist/jquery.validate.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('public/scripts/custom/admin-customer.js')}}"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
        jQuery(document).ready(function() {
			App.init();			
           CustomerFormValidations.init();
        });
    </script>
@endsection
