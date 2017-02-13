@extends('layouts.user_layout')
@section('title','User Add Account')
@section('page_styles')
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/select2/select2.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/select2/select2-metronic.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/data-tables/DT_bootstrap.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/bootstrap-datepicker/css/datepicker.css')}}"/>
@endsection
@section('content')
	test 2
		
@endsection

@section('page_scripts')
<!-- END PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{asset('public/scripts/core/app.js')}}" type="text/javascript"></script>
<script src="{{asset('public/plugins/jquery-validation/dist/jquery.validate.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('public/scripts/custom/user-custom.js')}}"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
	jQuery(document).ready(function() {    
		App.init();
	   // CustomerFormValidations.init();
	});
</script>


@endsection
