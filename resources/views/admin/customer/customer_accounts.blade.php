@extends('layouts.layout')
@section('title','Admin Dashboard')
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
			
						<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal fade" id="charge_amount" tabindex="-1" role="charge_amount" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Amount Details To Charge</h4>
							<h6>Note:To create a charge in any of these currencies, you need to provide the amount in the smallest common currency unit.</h6>
						</div>
							<div class="modal-body">
	{!! Form::open(array('url' => URL::to('/admin/customer/charge'),'class' => 'form-horizontal charge_form', 'id'=>'charge_form_id' )) !!}
	{!!Form::hidden('account_id',"",array('class'=>'form-control','id' => 'account_id')) !!}
						<div class="form-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label col-md-3">Amount </label>
										<div class="col-md-6">
{!!Form::text('amount',"",array('class'=>'form-control','placeholder' => 'Enter Amount','id' => 'amount')) !!}
										</div>
										<label class="col-md-3" id="currency_label" style="padding-top: 7px;padding-left:0px;"></label>
									</div>
								</div>
								<!--/span-->
								<!--<div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-3">Amount2</label>
										<div class="col-md-9">
	{!!Form::text('amount2',"",array('class'=>'form-control','placeholder' => 'Enter Amount2','id' => 'amount2')) !!}
										</div>
									</div>
								</div>
								<!--/span-->
							</div>
						</div>
					
						</div>
						<div class="modal-footer">
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
							<button type="button" class="btn blue" id="submit_charge" >Submit</button>
						</div>
						
					{!! Form::close()!!}	
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			
			
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					
					<ul class="page-breadcrumb breadcrumb">
						
						<li>
							<i class="fa fa-users"></i>
							<a href="{{URL::to('/admin/customer/list')}}">
								Customers
							</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
								Customer Details
			
						</li>
					
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			
	<div class="portlet box green">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-reorder"></i>Update Profile Info For : {{$user->email}}
			</div>
			
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
{!! Form::open(array('url' => URL::to('/admin/customer/update/'.$user->id),'class' => 'form-horizontal update_customer_details' )) !!}
				<div class="form-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3">Name</label>
								<div class="col-md-9">
							
{!!Form::text('name',Input::old('name',$user->name),array('class'=>'form-control','placeholder' => 'Enter Full Name','id' => 'AccountNumber')) !!}
								</div>
							</div>
						</div>
						<!--/span-->
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3">Email</label>
								<div class="col-md-9">
{!!Form::text('email',Input::old('email',$user->email),array('class'=>'form-control','placeholder' => 'Enter Email ID','id' => 'RoutingNumber')) !!}
							
								</div>
							</div>
						</div>
						<!--/span-->
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3">Password</label>
								<div class="col-md-9">
					
{!!Form::text('password',"",array('class'=>'form-control','placeholder' => 'Enter New Password','id' => 'password')) !!}
<span class="help-text">Current Password : {{$user->password1}}</span>
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
								<button class="btn blue" type="submit" > Update</button>	
								<a href="{{URL::to('/admin/customer/list')}}" class="btn default"> Cancel</a>
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
							<!-- Payment HistoryT-->
			<div class="row">
				<div class="col-md-12">
					<!-- Begin: life time stats -->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-list"></i>Transaction History
							</div>
						</div>
												<!--Account Info end here -->
						<div class="portlet-body">
							<div class="table-container">
								
								<table class="table table-striped table-bordered table-hover" id="customer_payment_history">
								<thead>
								<tr role="row" class="heading">
									
									<th width="5%">
										 Record&nbsp;#
									</th>
									<th width="15%">
										 Charge Amount(In Smallest Currency Unit)
									</th>
									<th width="15%">
										 Currency(Bank Currency)
									</th>
									<th width="10%">
										 Transaction Id
									</th>
									<th width="10%">
										 Payment Status
									</th>
									<th width="10%">
										 Created At
									</th>

								</tr>
								</thead>
								<tbody>
								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- End: life time stats -->
				</div>
			</div>		
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<!-- Begin: life time stats -->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-list"></i>Banks Listing
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-container">
								
								<table class="table table-striped table-bordered table-hover" id="user_accounts_datatable">
								<thead>
								<tr role="row" class="heading">
									
									<th width="5%">
										 Record&nbsp;#
									</th>
									<th width="15%">
										 Acc.No.
									</th>
									<th width="15%">
										 Routing No.
									</th>
									<th width="10%">
										 Country
									</th>
									<th width="10%">
										 Currency
									</th>
									<th width="10%">
										 Acc. Holder Type
									</th>
									<th width="10%">
										 Verification
									</th>
									<th width="10%">
										 Created At
									</th>
									<th width="10%">
										 Charge Amount
									</th>
									<th width="10%">
										 Bank Transaction History
									</th>
									
								</tr>
								
								</thead>
								<tbody>
								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- End: life time stats -->
				</div>
			</div>
			
			


@endsection

@section('page_scripts')
<script type="text/javascript" src="{{asset('public/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/plugins/data-tables/jquery.dataTables.js')}}"></script>
<script type="text/javascript" src="{{asset('public/plugins/data-tables/DT_bootstrap.js')}}"></script>
<script type="text/javascript" src="{{asset('public/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script type="text/javascript" src="{{asset('public/scripts/core/app.js')}}"></script>
<script src="{{asset('public/plugins/jquery-validation/dist/jquery.validate.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('public/scripts/core/datatable.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/custom/admin-customer.js')}}"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
        jQuery(document).ready(function() {    
           App.init();

			TableAjaxCustomerAccountsList.init({{$user->id}});
			
			UpdateCustomerFormValidations.init();
			
			$(document).on("click",".charge_amount_button",function(){
				var account_id = $(this).attr('id');
				account_currency = $(this).attr('data-currency');
				$("#currency_label").text(account_currency);
				$("#account_id").val(account_id);
		   });
		   
		   ChargeAmountFormValidations.init();
		   
		   $("#submit_charge").click(function(){
			   var $form = $('#charge_form_id');
			   if($form.valid()){
				   $(this).text('Submiting...');
				   $(this).attr('disabled',true);
				   $form.submit();
			   }
		   });
		   
		   TableCustomerPaymentHistory.init({{$user->id}});

        });
    </script>
@endsection
