@extends('layouts.user_layout')
@section('title','User Cards List')
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
					<a href="{{URL::to('/user/dashboard')}}">
						Home
					</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<i class="fa fa-list"></i>
					Cards List
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
						<i class="fa fa-list"></i>Cards Listing
					</div>
					<div class="actions">
						<a href="{{route('user.card.create')}}" class="btn default yellow-stripe">
							<i class="fa fa-plus"></i>
							<span class="hidden-480">
								New Card
							</span>
						</a>
					</div>
				</div>
				<div class="portlet-body">
					<div class="table-container">
						<table class="table table-striped table-bordered table-hover" id="user_cards">
							<thead>
								<tr role="row" class="heading">
									<th width="5%">
								 		Index&nbsp;#
									</th>
									<th width="15%">
										Card.No.
									</th>
									<th width="15%">
										Expiry month/year
									</th>
									<th width="10%">
										Brand
									</th>
									<th width="10%">
										Country
									</th>
									<th width="10%">
										Add date
									</th>
									<th width="10%">
										Actions
									</th>
								</tr>
							</thead>
							<tbody>
								@forelse($cards as $card)
									<tr>
										<td>{{$card->id}}</td>
										<td>{{$card->cardNumber}}</td>
										<td>{{$card->expiry}}</td>
										<td>{{$card->brand}}</td>
										<td>{{$card->country}}</td>
										<td>{{$card->created_at}}</td>
										<td>
											<form action="{{route('user.card.destroy', $card->id)}}" method="POST">
												<input type="hidden" name="_token" value="{{csrf_token()}}">
												<input type="hidden" name="_method" value="DELETE">
												<input type="submit" value="Delete" class="btn btn-sm btn-danger">
											</form>
										</td>
									</tr>
									@empty
										<h4>No Record Data</h4>
								@endforelse
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
<script type="text/javascript" src="{{asset('public/scripts/custom/custom.js')}}"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function($) {
        App.init();
        $('#user_cards').DataTable();
	});
</script>
@endsection
