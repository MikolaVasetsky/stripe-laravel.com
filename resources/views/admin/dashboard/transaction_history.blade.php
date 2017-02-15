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
							<i class="fa fa-home"></i>
							<a href="{{URL::to('/admin/dashboard')}}">
								Home
							</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							Transaction History
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
								<i class="fa fa-list"></i>Transaction History
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-container">
								<table class="table table-striped table-bordered table-hover" id="payment_history">
									<thead>
										<tr role="row" class="heading">
											<th width="5%">
												 Record&nbsp;#
											</th>
											<th width="15%">
												 Customer Name
											</th>
											<th width="15%">
												 Account Number
											</th>
											<th width="15%">
												 Amount(In Smallest Currency Unit)
											</th>
											<th width="15%">
												 Bank Currency
											</th>
											<th width="10%">
												 Transaction Id
											</th>
											<th width="10%">
												 Payment Status
											</th>
											<th width="10%">
												 View Account Details
											</th>
											<th width="10%">
												 Created At
											</th>
										</tr>
									</thead>
									<tbody>
										@foreach($historyArray as $history)
											<tr>
												<td>{{$history['id']}}</td>
												<td>{{$history['userName']}}</td>
												<td>{{$history['number']}}</td>
												<td>{{$history['amount']}}</td>
												<td>{{$history['currency']}}</td>
												<td>{{$history['paymentId']}}</td>
												<td>{{$history['paymentStatus']}}</td>
												<td><a href="{{URL::to('admin/customer/detail/'.$history['userId'])}}" class="btn green"><i class="fa fa-search"></i> View Account</a></td>
												<td>{{$history['createdAt']}}</td>
											</tr>
										@endforeach
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
<script type="text/javascript" src="{{asset('public/scripts/custom/admin-home.js')}}"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
        jQuery(document).ready(function() {
           	App.init();
			// TablePaymentHistory.init();
			$('#payment_history').DataTable();
        });
    </script>
@endsection
