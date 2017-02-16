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
		<strong>Error:</strong>
		<span id="spErrorMessage"></span>
	</div>

	<!-- BEGIN PAGE HEADER-->
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN PAGE TITLE & BREADCRUMB-->
			<ul class="page-breadcrumb breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					Home
				</li>
			</ul>
			<!-- END PAGE TITLE & BREADCRUMB-->
		</div>
	</div>
	<!-- END PAGE HEADER-->

	<div class="portlet box green">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-reorder"></i>Charge Customer
			</div>
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
			{!! Form::open(array('url' => URL::to('/admin/dashboard/createcharge'),'class' => 'form-horizontal' ,'id'=>'customer_charge_form')) !!}
				{!! Form::hidden('type', '', ['id' => 'type']) !!}
				<div class="form-body">
					<div style="display: none;z-index:9999;" class="dataTables_processing" id=""><img src="{{URL::to('public/img/loading-spinner-grey.gif')}}"><span>&nbsp;&nbsp;Loading...</span></div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3">Select Customer</label>
								<div class="col-md-9">
									{!!Form::select('customer_id',[''=>'Select Customer ']+$customers_list, Input::old('customer_id'), array('class'=>'form-control', 'id' => 'customer_id')) !!}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3">Select Account</label>
								<div class="col-md-9">
									{!!Form::select('account_id', [''=>'Select Customer Account'],Input::old('account_id'), array('class'=>'form-control', 'id' => 'account_id')) !!}
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3">Amount</label>
								<div class="col-md-9">
									{!!Form::text('amount',Input::old('amount'),array('class'=>'form-control','placeholder' => 'Enter Amount','id' => 'Amount')) !!}
								</div>
							</div>
						</div>
						<!--/span-->
						<!--<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3">Account Holder Type</label>
								<div class="col-md-9">
									{!!Form::select('account_holder_type',['individual'=>'Individual','company'=>'Company'], "", ['class' => 'form-control','id' => 'AccountHolderType']) !!}
								</div>
							</div>
						</div>-->
						<!--/span-->
					</div>
				</div>

				<div class="form-actions fluid">
					<div class="row">
						<div class="col-md-6">
							<div class="col-md-offset-3 col-md-9">
								<button class="btn blue" type="submit" > Submit</button>
							</div>
						</div>
						<div class="col-md-6">
						</div>
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
	<script type="text/javascript" src="{{asset('public/scripts/custom/admin-home.js')}}"></script>

	<script type="text/javascript" src="{{asset('public/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}"></script>
	<!-- END PAGE LEVEL SCRIPTS -->
	<script>
	    jQuery(document).ready(function() {    
	       App.init();
		   ChargeCustomerFormValidations.init();
		   GetCustomerAccounts.init();

			$("#Amount").inputmask('$999.999.99', {
	            numericInput: true,
	            rightAlignNumerics: false,
	            greedy: false,
	        });

	        $(document).on('change', '#account_id', function() {
	        	$('#type').val($('#account_id :selected').data('type'))
	        });
	    });
	</script>
@endsection
