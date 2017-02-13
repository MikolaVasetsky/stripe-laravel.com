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
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					
					<ul class="page-breadcrumb breadcrumb">
						
						<li>
							<i class="fa fa-users"></i>
							
								Customers
							
							
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
								<i class="fa fa-list"></i>Customers Listing
							</div>
							<div class="actions">
								<a href="{{URL::to('/admin/customer/create')}}" class="btn default yellow-stripe">
									<i class="fa fa-plus"></i>
									<span class="hidden-480">
										 New Customer
									</span>
								</a>
								
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-container">
								
								<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
								<thead>
								<tr role="row" class="heading">
									
									<th width="5%">
										 Record&nbsp;#
									</th>
									<th width="15%">
										 Name
									</th>
									<th width="15%">
										 Email
									</th>
									<th width="10%">
										 Created At
									</th>
									<th width="10%">
										 Login Details
									</th>
									<th width="10%">
										 Account Details
									</th>
									
									<th width="10%">
										 Actions
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
           TableAjaxCustomerList.init();
		
		   $(document).on("click",".send_login_details",function(){
			
			   var user_id = $(this).attr('id');
			   $.ajax({                    
				  url: project_url+"/admin/customer/senddetails",     
				  type: 'post', // performing a POST request
				  data : {
					user_id : user_id // will be accessible in $_POST['data1']
				  },                  
				  success: function(data)         
				  {
						//alert(data);
					   if(data==1){
						   $("#"+user_id).text("Login Details Sent.");
					   }
					   else{
						   $("#"+user_id).text("Send Login Details");
						   $("#notification-error").show();
						   $("#spErrorMessage").text(data);
						   $("#notification-error").fadeOut(5000);
					   }
				  },
				   beforeSend:function(){
					   $("#"+user_id).text("Sending...");
				   }/*,
					error: function(XMLHttpRequest, textStatus, errorThrown) { 
						alert("Status: " + textStatus); alert("Error: " + errorThrown); 
					}  */     				   
				}); 
		   });
        });
    </script>
@endsection
