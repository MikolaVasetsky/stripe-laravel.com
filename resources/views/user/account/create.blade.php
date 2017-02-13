@extends('layouts.user_layout')
@section('title','User Add Account')
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
							<i class="fa fa-home"></i>
							<a href="{{URL::to('/user/dashboard')}}">
								Home
							</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<i class="fa fa-home"></i>
								New Account
						</li>
					
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->


	<div class="portlet box green">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-reorder"></i>New Account Details
			</div>
			
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
{!! Form::open(array('url' => URL::to('/user/dashboard/create'),'class' => 'form-horizontal account_details' )) !!}

{!!Form::hidden('token',"",array('class'=>'form-control','id' => 'TokenIdentifier')) !!}
				<div class="form-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3">Account Number</label>
								<div class="col-md-9">
							
{!!Form::text('account_number',"",array('class'=>'form-control','placeholder' => 'Account Number','id' => 'AccountNumber')) !!}
								</div>
							</div>
						</div>
						<!--/span-->
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3">Routing Number</label>
								<div class="col-md-9">
{!!Form::text('routing_number',"",array('class'=>'form-control','placeholder' => 'Routing Number','id' => 'RoutingNumber')) !!}
								</div>
							</div>
						</div>
						<!--/span-->
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3">Account Holder Name</label>
								<div class="col-md-9">
					
{!!Form::text('account_holder_name',"",array('class'=>'form-control','placeholder' => 'Account Holder Full Name','id' => 'AccountHolderName')) !!}
								</div>
							</div>
						</div>
						<!--/span-->
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3">Account Holder Type</label>
								<div class="col-md-9">
{!!Form::select('account_holder_type',['individual'=>'Individual','company'=>'Company'], "", ['class' => 'form-control','id' => 'AccountHolderType']) !!}
								</div>
							</div>
						</div>
						<!--/span-->
					</div>
				
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3">Country</label>
								<div class="col-md-9">
								<select name="country" class ='form-control' onchange="populateCode();" placeholder ='Country' id='Country'>
									<option value="" attr="">Select</option>
									<option value="US" attr="USD">United States</option>
									<option value="CA" attr="CAD">Canada</option>
									<option value="AU" attr="AUD">Australia</option>
									<option value="JP" attr="JPY">Japan</option>
									<option value="UK" attr="EUR">United Kingdom</option>
									<option value="SG" attr="SGD">Singapore</option>
									<option value="HG" attr="HKD">Hong Kong</option>
									<option value="MX" attr="MXN">Mexico</option>
								</select>

								</div>
							</div>
						</div>
						<!--/span-->
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3">Currency</label>
								<div class="col-md-9">
{!!Form::text('currency',"",array('class'=>'form-control','placeholder' => 'Currency','id' => 'Currency')) !!}
								</div>
							</div>
						</div>
						<!--/span-->
					</div>
				</div>
				
				<div class="form-actions fluid">
					<div class="row">
						<div class="col-md-6">
							<div class="col-md-offset-3 col-md-9">
								<button class="btn blue" type="button" id="submit_button"><i style="display:none;float:right;vertical-align:middle" id="spinner" class="fa fa-spinner fa-spin"></i>&nbsp;Submit</button>	
								<a href="{{URL::to('/user/dashboard')}}" class="btn default">Cancel</a>
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
<!-- END PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
	//Stripe.setPublishableKey('pk_test_6pRNASCoBOKtIshFeQd4XMUh');
	Stripe.setPublishableKey('{{$stripe_public_key}}');
</script>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{asset('public/scripts/core/app.js')}}" type="text/javascript"></script>
<script src="{{asset('public/plugins/jquery-validation/dist/jquery.validate.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('public/scripts/custom/user-custom.js')}}"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
	jQuery(document).ready(function() {    
		App.init();
	   CustomerFormValidations.init();
	});
</script>
<script>
	function populateCode(){
		$('#Currency').val( $('#Country option:selected').attr('attr'));
	}
	
    function stripeResponseHandler(status, response) {
        //debugger;
        // Grab the form:
        var $form = $('.account_details');
        if (response.error) { // Problem!

            // Show the errors on the form:
            //alert(response.error.message);
            //$form.find('.bank-errors').text(response.error.message);
            $('#spErrorMessage').text(response.error.message);
            $('#notification-error').css('display', 'block');
            $('#spinner').css('display', 'none');
            $('#submit_button').prop('disabled', false); // Re-enable submission

        } else { // Token created!
            // Get the token ID:
            var token = response.id;

            // Insert the token into the form so it gets submitted to the server:
            $('#TokenIdentifier').val(token);
            // Submit the form:
            $form.get(0).submit();
        }
    }

	$("#submit_button").click(function(){
		var $form = $('.account_details');
		if($form.valid()){
				$('#spinner').css('display', 'block');

				var accountNumber = $('#AccountNumber').val();
				Stripe.bankAccount.validateAccountNumber(accountNumber, 'US')
				var routingNumber = $('#RoutingNumber').val();
				Stripe.bankAccount.validateRoutingNumber(routingNumber, 'US')

				// Disable the submit button to prevent repeated clicks:
				$('#submit_button').prop('disabled', true);

				// Request a token from Stripe:
				Stripe.bankAccount.createToken({
					country: $('#Country').val(),
					currency: $('#Currency').val(),
					routing_number: $('#RoutingNumber').val(),
					account_number: $('#AccountNumber').val(),
					account_holder_name: $('#AccountHolderName').val(),
					account_holder_type: $('#AccountHolderType').val()
				}, stripeResponseHandler);

				// Prevent the form from being submitted:
		}
	});
	
   
	
</script>


@endsection
