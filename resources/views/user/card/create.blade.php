@extends('layouts.user_layout')

@section('title','User Add Card')

@section('page_styles')
	<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/select2/select2.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/select2/select2-metronic.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/data-tables/DT_bootstrap.css')}}"/>
	<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/bootstrap-datepicker/css/datepicker.css')}}"/>
@endsection

@section('content')

	<div class="row">
		<div class="col-md-12">
			<ul class="page-breadcrumb breadcrumb">
				<li>
					<i class="fa fa-home"></i>
					<a href="{{URL::to('/user/dashboard')}}">
						Home
					</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<i class="fa fa-list"></i>
					New Card
				</li>
			</ul>
		</div>
	</div>

	<div class="portlet box green">
	    <div class="portlet-title">
	        <div class="caption">
	            <i class="fa fa-reorder">
	            </i>
	            New Card Details
	        </div>
	    </div>
	    <div class="portlet-body form">
	        <div class="form-body">
		        {!! Form::open(['url' => route('user.card.store'), 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'add_card_form']) !!}

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('card_number', 'Card Number', ['class' => 'control-label col-md-3']) !!}
								<div class="col-md-9">
									{!!Form::text('card_number',"",array('class'=>'form-control','placeholder' => 'Card Number','id' => 'card_number')) !!}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('country', 'Country', ['class' => 'control-label col-md-3']) !!}
								<div class="col-md-9">
									<select name="country" class="form-control" placeholder="Country" id="country">
										<option value="" attr="">Select</option>
										<option value="US">United States</option>
										<option value="CA">Canada</option>
										<option value="AU">Australia</option>
										<option value="JP">Japan</option>
										<option value="UK">United Kingdom</option>
										<option value="SG">Singapore</option>
										<option value="HG">Hong Kong</option>
										<option value="MX">Mexico</option>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('expiry', 'Card Expiry', ['class' => 'control-label col-md-3']) !!}
								<div class="col-md-9">
									{!!Form::text('expiry',"",array('class'=>'form-control','placeholder' => 'Card Expiry','id' => 'expiry')) !!}
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('card_cvc', 'Card CVC', ['class' => 'control-label col-md-3']) !!}
								<div class="col-md-9">
									{!!Form::text('card_cvc',"",array('class'=>'form-control','placeholder' => 'Card CVC','id' => 'card_cvc')) !!}
								</div>
							</div>
						</div>
					</div>

					<div class="form-actions fluid">
						<div class="row">
							<div class="col-md-6">
								<div class="col-md-9">
									<input type="submit" class="btn blue" value="Save">
									<i style="display:none;" id="spinner" class="fa fa-spinner fa-spin"></i>
									<div class="has-error">
										<span class="help-block" id="error_add_card"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				{!! Form::close() !!}
		    </div>
	    </div>
	</div>
@endsection

@section('page_scripts')
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
	<script src="{{asset('public/scripts/core/app.js')}}" type="text/javascript"></script>
	<script src="{{asset('public/plugins/jquery-validation/dist/jquery.validate.min.js')}}" type="text/javascript"></script>
	<script type="text/javascript" src="{{asset('public/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('public/scripts/custom/custom.js')}}"></script>

	<script>
		jQuery(document).ready(function() {
			App.init();

			Stripe.setPublishableKey('{{$stripePublicKey}}');

			$("#expiry").inputmask("y/m", {
            	"placeholder": "yyyy/mm"
        	});

			$("#card_number").inputmask("9999999999999999");
		});
	</script>
@endsection
