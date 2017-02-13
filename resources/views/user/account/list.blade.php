@extends('layouts.user_layout')
@section('title','User Accounts List')
@section('page_styles')
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/select2/select2-metronic.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/data-tables/DT_bootstrap.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/bootstrap-datepicker/css/datepicker.css')}}"/>
@endsection
@section('content')
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal fade" id="verify_account" tabindex="-1" role="verify_account" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Enter Verification Details</h4>
							
						</div>
							<div class="modal-body">
	{!! Form::open(array('url' => URL::to('/user/account/verify'),'class' => 'form-horizontal verification_form', 'id'=>'verification_form_id' )) !!}
	{!!Form::hidden('account_id',"",array('class'=>'form-control','id' => 'account_id')) !!}
						<div class="form-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-3">Amount1</label>
										<div class="col-md-9">
									
	{!!Form::text('amount1',"",array('class'=>'form-control','placeholder' => 'Enter Amount1','id' => 'amount1')) !!}
										</div>
									</div>
								</div>
								<!--/span-->
								<div class="col-md-6">
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
							<button type="button" class="btn blue" id="submit_verification" >Submit</button>
						</div>
						
					{!! Form::close()!!}	
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->

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
							<i class="fa fa-list"></i>
							
								Accounts List

							
						</li>
					
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			
			
						<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					

				</div>
			</div>
			<!-- END PAGE HEADER-->
			
	<div class="portlet box green">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-reorder"></i>Profile Info
			</div>
			
		</div>
		<div class="portlet-body form">
			<!-- BEGIN FORM-->
{!! Form::open(array('url' => URL::to('/user/dashboard/update'),'class' => 'form-horizontal' )) !!}
				<div class="form-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3">Name</label>
								<div class="col-md-9">
							
{!!Form::text('name',Input::old('name',Auth::user()->name),array('class'=>'form-control','placeholder' => 'Your Name')) !!}
								</div>
							</div>
						</div>
						<!--/span-->
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label col-md-3">Email</label>
								<div class="col-md-9">
{!!Form::text('email',Input::old('email',Auth::user()->email),array('class'=>'form-control','placeholder' => 'Your Email ID')) !!}
							
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
			
			
			
			
			
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<!-- Begin: life time stats -->
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-list"></i>Accounts Listing
							</div>
							<div class="actions">
								<a href="{{URL::to('/user/dashboard/create')}}" class="btn default yellow-stripe">
									<i class="fa fa-plus"></i>
									<span class="hidden-480">
										 New Account
									</span>
								</a>
								
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-container">
								
								<table class="table table-striped table-bordered table-hover" id="user_accounts_datatable_ajax">
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


<script type="text/javascript" src="{{asset('public/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}"></script>

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script type="text/javascript" src="{{asset('public/scripts/core/app.js')}}"></script>
<script src="{{asset('public/plugins/jquery-validation/dist/jquery.validate.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('public/scripts/core/datatable.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/custom/user-table-ajax.js')}}"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
        jQuery(document).ready(function() {    
           App.init();
           TableAjaxAccountsList.init();

			$("#amount1, #amount2").inputmask('$0.99', {
				rightAlign: false
			});


		
		$(document).on("click",".verification_button",function(){
			var account_id = $(this).attr('id');
			$("#account_id").val(account_id);
			   /*$.ajax({                    
				  url: project_url+"/user/account/verify",     
				  type: 'post', // performing a POST request
				  data : {
					user_id : user_id // will be accessible in $_POST['data1']
				  },                  
				  success: function(data)         
				  {
						alert(data);
					   if(data==1){
						   $("#"+user_id).text("Sent");
					   }
					   else{
						   $("#"+user_id).text("Send");
						   $("#notification-error").show();
						   $("#spErrorMessage").text(data);
						   $("#notification-error").fadeOut(5000);
					   }
				  },
				   beforeSend:function(){
					   $("#"+user_id).text("Sending...");
				   }    				   
				}); */
		   });
		   
		   AccountVerificationFormValidations.init();
		   
		   $("#submit_verification").click(function(){
			   var $form = $('#verification_form_id');
			   if($form.valid()){
				   $(this).text('Submiting...');
				   $(this).attr('disabled',true);
				   $form.submit();
			   }
		   });
		   
		 });
    </script>
@endsection
