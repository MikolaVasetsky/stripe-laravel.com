@extends('layouts.layout')
@section('title','Customer payment history')
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
							<i class="fa fa-users"></i>
							<a href="{{URL::to('/admin/customer/list')}}">
								Customers
							</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<i class="fa fa-list"></i>
							<a href="{{URL::to('/admin/customer/detail/'.$user_info->id)}}">
								Customer Details
							</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
				
				
								Customer Bank Transaction History
			
		
						</li>
					
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<!-- Begin: life time stats -->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-list"></i>Bank Transaction History
							</div>
							<div class="actions">
								<a class="btn green m-icon" href="{{URL::to('/admin/customer/detail/'.$user_info->id)}}"><i class="m-icon-swapleft m-icon-white"></i>
									Back 
								</a>
						
							</div>
							
						</div>
						
						<!-- Account Info Start Here -->
					 <div class="form-body">
					 <h4>Account Info</h4>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label col-md-3">Name</label>
									<div class="col-md-9">
								: {{$user_info->name}}
									</div>
								</div>
							</div>
							<!--/span-->
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label col-md-3">Email Id</label>
									<div class="col-md-9">
									: {{$user_info->email}}
									</div>
								</div>
							</div>
							<!--/span-->
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label col-md-3">Account Number</label>
									<div class="col-md-9">
										: {{$user_account_info->account_number}}
									</div>
								</div>
							</div>
							<!--/span-->
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label col-md-3">Routing Number</label>
									<div class="col-md-9">
										: {{$user_account_info->routing_number}}
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
										: {{$user_account_info->account_holder_name}}
									</div>
								</div>
							</div>
							<!--/span-->
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label col-md-3">Account Holder Type</label>
									<div class="col-md-9">
										: {{$user_account_info->account_holder_type}}
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
										: {{$user_account_info->country}}
									</div>
								</div>
							</div>
							<!--/span-->
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label col-md-3">Currency</label>
									<div class="col-md-9">
										: {{$user_account_info->currency}}
									</div>
								</div>
							</div>
							<!--/span-->
						</div>
					</div>

						<!--Account Info end here -->
						<div class="portlet-body">
							<div class="table-container">
								
								<table class="table table-striped table-bordered table-hover" id="account_payment_history">
								<thead>
								<tr role="row" class="heading">
									
									<th width="5%">
										 Record&nbsp;#
									</th>
									<th width="15%">
										 Charge Amount(In smallest currency unit)
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

@endsection

@section('page_scripts')
<script type="text/javascript" src="{{asset('public/plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/plugins/data-tables/jquery.dataTables.js')}}"></script>
<script type="text/javascript" src="{{asset('public/plugins/data-tables/DT_bootstrap.js')}}"></script>
<script type="text/javascript" src="{{asset('public/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script type="text/javascript" src="{{asset('public/scripts/core/app.js')}}"></script>

<script type="text/javascript" src="{{asset('public/scripts/core/datatable.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/custom/admin-customer.js')}}"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
        jQuery(document).ready(function() {    
           App.init();

			TableCustomerAccountPaymentHistory.init({{$user_account_info->id}});

        });
    </script>
@endsection
