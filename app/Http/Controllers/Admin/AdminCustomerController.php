<?php namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\User;
use App\UserAccounts;
use App\PaymentHistory;
use App\CommonFunctions;
use App\AppSettings;
class AdminCustomerController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
		
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return view('admin.customer.create');
	}
	
	public function postCreate()
	{
		
		$rules = array(
			'email' => 'required|unique:users,email',
			'password'=> 'required'
		);
	   $messages = [
			   'email.required' => 'Email is a required field.!',
			   'email.unique'   => 'Customer with this email already exist!',
			   'password'=> 'Password is a required field.',
		   ];
		  $validator = Validator::make(Input::all(), $rules, $messages);
		  if(!$validator->fails())
		  {
			include(app_path() . Config::get("constants.STRIPE_INIT_PATH"));
			$stripe_secret_key = AppSettings::stripe_secret_api_key();
			\Stripe\Stripe::setApiKey($stripe_secret_key);

			// Get the bank token submitted by the form
			//$token_id = $_POST['token'];

			// Create a Customer
			$customer = \Stripe\Customer::create(array(
				"email"       => Input::get('email'),
				"description" => "Customer for ".Input::get('email'))
			);
			$customer_info_object = json_encode($customer);
			$customer_info_array  = json_decode($customer_info_object,true);
			
			$customer_id          = $customer_info_array['id'];
			
			$add_user            = new User;
			$add_user->name      = Input::get('name');
			$add_user->email     = Input::get('email');
			$add_user->password  = Hash::make(Input::get('password'));
			$add_user->password1 = Input::get('password');
			$add_user->role      = 'customer';
			$add_user->stripe_customer      = $customer_id;
			$add_user->save();
			if($add_user->id){
				return Redirect::to('admin/dashboard')->with('message','Customer Added Successfully!!!');    
			}
		  }
		  else{
			  return Redirect::back()->with('error', 'Please fix following errors.')->withErrors($validator)->withInput();
		  } 

	}
	
	public function getList()
	{
		return view('admin.customer.list');
	}
	
	public function anyCustomerslist()
	{
	
		$query = User::where('role','!=','admin');
		$iTotalRecords = $query->count();
		$iDisplayLength = intval($_REQUEST['iDisplayLength']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($_REQUEST['iDisplayStart']);
		$sEcho = intval($_REQUEST['sEcho']);

		$records = array();
		$records["aaData"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		$sort_col           = Input::get('iSortCol_0');
		$sort_order         = Input::get('sSortDir_0'); 
		
		$order_by = "id";

		if($sort_col == 1)
		{
			$order_by="name";
		}
		else if($sort_col == 2){
			$order_by="email";
		}
//echo $order_by."--".$sort_order;
	    $allrecords	= $query->orderBy($order_by,$sort_order)->get();
	 

	  foreach($allrecords as $key=>$value) {
		
		$id = ($key + 1);
		$records["aaData"][] = array(
		  $id,
		  $value->name,
		  $value->email,
		  CommonFunctions::formated_date_time($value->created_at),
		 '<button type="button" id="'.$value->id.'" class="btn blue send_login_details"> Send Login Details</button>',
		 '<a class="btn green" href="'.URL::to('/admin/customer/detail/'.$value->id).'"><i class="fa fa-search"></i> View Account</a>',
		 
		  '<span><a href="'.URL::to("/admin/customer/delete/".$value->id).'" onclick="return confirm(\'Are you sure to delete this customer?\')"  class="btn btn-xs default"><i class="fa fa-trash-o"></i> Delete</a></span>',
		  
		  
		  
		  
	   );
	  }

	  if (isset($_REQUEST["sAction"]) && $_REQUEST["sAction"] == "group_action") {
		$records["sStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
		$records["sMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
	  }

	  $records["sEcho"] = $sEcho;
	  $records["iTotalRecords"] = $iTotalRecords;
	  $records["iTotalDisplayRecords"] = $iTotalRecords;
	  
	  echo json_encode($records);
	}
	
	
	
	public function getUpdate($id)
	{
		$user_info = User::find($id);
		//echo "<pre>";print_r($user_info);die;
		return view('admin.customer.update',array('user'=>$user_info));
	}
	
	public function postUpdate($id)
	{
		
		$rules = array(
			'email' => 'required|unique:users,email,'.$id,
		);
	   $messages = [
			   'email.required' => 'Email is a required field.!',
			   'email.unique'   => 'Customer with this email already exist!',
		   ];
		  $validator = Validator::make(Input::all(), $rules, $messages);
		  if(!$validator->fails())
		  {
			$update_user = User::find($id);
			$update_user->name = Input::get('name');
			$update_user->email = Input::get('email');
			$password = Input::get('password');
			
			if( $password !="" ){
				
				$update_user->password = Hash::make(Input::get('password'));
				$update_user->password1 = Input::get('password');
			}
			$saved = $update_user->save();
			if($saved){
				return Redirect::to('admin/customer/detail/'.$id)->with('message','Customer Details Updated Successfully!!!');    
			}
		  }
		  else{
			  return Redirect::back()->with('error', 'Please fix following errors.')->withErrors($validator)->withInput();
		  } 
	}
	
	public function anyDelete($id)
	{
		$user = User::find($id);
		
		$user_acounts = UserAccounts::where('user_id','=',$id)->get();
	
		foreach($user_acounts as $u_key => $u_value){
			
			$user_account_payment_history_delete = PaymentHistory::where('user_account_id','=',$u_value->id)->delete();
		}
		$user_acounts_delete = UserAccounts::where('user_id','=',$id)->delete();
		
		$deleted = $user->delete();
		
		if($deleted){
			return Redirect::to('admin/customer/list')->with('message','Customer Deleted Successfully!!!');   
		}
	}
	
	
	public function anySenddetails(){
		
		$user_id = $_POST['user_id'];
		$user_info = User::find($user_id);
		$data = array('login_url'=>URL::to('/'),'email'=>$user_info->email,'password'=>$user_info->password1,'email'=>$user_info->email,'name'=>$user_info->name,'subject'=>"Login Details");
		
		$sent = CommonFunctions::send_larvel_default_mail('emails.login_details',$data);
		if($sent){
			echo 1;
		}
		else{
			echo "Mail not sent. Something went wrong!!!.";
		}
		
	}
	
	
	public function getDetail($id)
	{
		$user_info = User::find($id);
		if(empty($user_info))
			return Redirect::to('admin/customer/list/')->with('message','Customer Not Found!!');    
			
		return view('admin.customer.customer_accounts',array('user'=>$user_info));
	}
	/*View User Accounts*/
	public function anyUseraccounts($id)
	{
		$query = UserAccounts::where('user_id','=',$id);
		$iTotalRecords = $query->get()->count();
		$iDisplayLength = intval($_REQUEST['iDisplayLength']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($_REQUEST['iDisplayStart']);
		$sEcho = intval($_REQUEST['sEcho']);

		$records = array();
		$records["aaData"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;
	  
		$sort_col           = Input::get('iSortCol_0');
		$sort_order         = Input::get('sSortDir_0'); 
		
		$order_by = "users_accounts.id";
		//$sort_col ="desc";
		if($sort_col == 1)
		{
			$order_by="users_accounts.account_number";
		}
		else if($sort_col==2){
			$order_by="users_accounts.routing_number";
		}
		else if($sort_col==3){
			$order_by="users_accounts.country";
		}
		else if($sort_col==4){
			$order_by="users_accounts.currency";
		}
		else if($sort_col==5){
			$order_by="users_accounts.account_holder_type";
		}
		else if($sort_col==6){
			$order_by="users_accounts.verification_status";
		}

		
		$allrecords	= $query->orderBy($order_by,$sort_order)->get();
		 
		  foreach($allrecords as $key=>$value) {
			$charge_button ="";	
			$transaction_history ="";
			if($value->verification_status == "verified"){
				$ver_status ='<span class="label label-sm label-success">Verified</span>';
				$charge_button ='<a class="btn blue charge_amount_button" data-toggle="modal" href="#charge_amount" data-currency="'.$value->currency.'"  id="'.$value->id.'">Charge Amount</a>';
				$transaction_history = '<a href="'.URL::to('/admin/customer/paymenthistory/'.$value->id).'" class="btn green"><i class="fa fa-search"></i> View Bank Transaction History</a>';
			}
			else{
				$ver_status ='<span class="label label-sm label-danger">Pending</span>';
			}

			$id = ($key + 1);
			$records["aaData"][] = array(
			  $id,
			  $value->account_number,
			  $value->routing_number,
			  $value->country,
			  $value->currency,
			  $value->account_holder_type,
			  $ver_status,
			  CommonFunctions::formated_date_time($value->created_at),
			  $charge_button,
			  $transaction_history
		   );
		  }

		  if (isset($_REQUEST["sAction"]) && $_REQUEST["sAction"] == "group_action") {
			$records["sStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
			$records["sMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
		  }

		  $records["sEcho"] = $sEcho;
		  $records["iTotalRecords"] = $iTotalRecords;
		  $records["iTotalDisplayRecords"] = $iTotalRecords;
		  
		  echo json_encode($records);
	}
	
	
	/*Used to charge amount to a account*/
	public function postCharge()
	{
		
		try{
			
			include(app_path() . Config::get("constants.STRIPE_INIT_PATH"));
			$stripe_secret_key = AppSettings::stripe_secret_api_key();
			\Stripe\Stripe::setApiKey($stripe_secret_key);

			$account_id = Input::get('account_id');
			$amount = Input::get('amount');
			
			$account_data = UserAccounts::find($account_id);	
			$account_user_data = User::find($account_data->user_id);	
			

			// See your keys here: https://dashboard.stripe.com/account/apikeys
			\Stripe\Stripe::setApiKey($stripe_secret_key);
			$result = \Stripe\Charge::create(array(
			  "amount"   =>  $amount,
			  "currency" => $account_data->currency,
			  "customer" => $account_data->stripe_customer_id // Previously stored, then retrieved
			  ));
			
//echo "<pre>";print_r($result);die;
			$charge_info_object = json_encode($result);
			$charge_info_array = json_decode($charge_info_object,true);	
			

			$payment_history = new PaymentHistory;
			$payment_history->user_account_id = $account_id;
			$payment_history->amount = $amount;
			$payment_history->currency = $account_data->currency;
			$payment_history->payment_txn_id = $charge_info_array['id'];
			$payment_history->payment_status = $charge_info_array['status'];
			$payment_history->save();
			if($payment_history->id){
				return Redirect::to('admin/customer/detail/'.$account_data->user_id)->with('message','Amount Charged Successfully!!!');    
			}
		}
		catch(\Stripe\Error\Card $e) {
			  // Since it's a decline, \Stripe\Error\Card will be caught
			  $body = $e->getJsonBody();
			  $err  = $body['error'];
			  /*print('Status is:' . $e->getHttpStatus() . "\n");
			  print('Type is:' . $err['type'] . "\n");
			  print('Code is:' . $err['code'] . "\n");
			  // param is '' in this case
			  print('Param is:' . $err['param'] . "\n");
			  print('Message is:' . $err['message'] . "\n");*/
			  return Redirect::back()->with('error',$err['message']);  
			  
			} catch (\Stripe\Error\RateLimit $e) {
			  // Too many requests made to the API too quickly
			  return Redirect::back()->with('error',$e->getMessage()); 
			  
			} catch (\Stripe\Error\InvalidRequest $e) {
			  // Invalid parameters were supplied to Stripe's API
			  return Redirect::back()->with('error',$e->getMessage()); 
			  
			} catch (\Stripe\Error\Authentication $e) {
			  // Authentication with Stripe's API failed
			  // (maybe you changed API keys recently)
			  return Redirect::back()->with('error',$e->getMessage());
			  
			} catch (\Stripe\Error\ApiConnection $e) {
			  // Network communication with Stripe failed
			  return Redirect::back()->with('error',$e->getMessage());
			  
			} catch (\Stripe\Error\Base $e) {
			  // Display a very generic error to the user, and maybe send
			  // yourself an email
			  return Redirect::back()->with('error',$e->getMessage());
			  
			} catch (Exception $e) {
			  // Something else happened, completely unrelated to Stripe
			  return Redirect::back()->with('error',$e->getMessage());
			  
			}	

	}
	
	
	/*View User Single Bank Account Payment History*/
	public function getPaymenthistory($id)
	{
		$user_account_info = UserAccounts::find($id);
		$user_info = User::find($user_account_info->user_id);
		
		return view('admin.customer.payment_history',array('user_info'=>$user_info, 'user_account_info'=>$user_account_info));
	}
	
	/*List User Single Bank Account Payment History*/
	public function anyListpaymenthistory($id)
	{
		$query = PaymentHistory::where('user_account_id','=',$id);
	  $iTotalRecords = $query->count();
	  $iDisplayLength = intval($_REQUEST['iDisplayLength']);
	  $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
	  $iDisplayStart = intval($_REQUEST['iDisplayStart']);
	  $sEcho = intval($_REQUEST['sEcho']);
	  
	  $records = array();
	  $records["aaData"] = array(); 

	  $end = $iDisplayStart + $iDisplayLength;
	  $end = $end > $iTotalRecords ? $iTotalRecords : $end;
	
		$sort_col           = Input::get('iSortCol_0');
		$sort_order         = Input::get('sSortDir_0'); 

		$order_by = "payment_history.id";
		if($sort_col == 1)
		{
			$order_by="payment_history.amount";
		}
		else if($sort_col==2){
			$order_by="payment_history.currency";
		}
		else if($sort_col==3){
			$order_by="payment_history.payment_txn_id";
		}
		else if($sort_col==4){
			$order_by="payment_history.payment_status";
		}
	
		
		
		$allrecords	= $query->orderBy($order_by,$sort_order)->get();
		 
		  foreach($allrecords as $key=>$value) {
			
			$id = ($key + 1);
			$records["aaData"][] = array(
			  $id,
			  number_format((float)$value->amount, 2, '.', ''),
			  $value->currency,
			  $value->payment_txn_id,
			  $value->payment_status,
			  CommonFunctions::formated_date_time($value->created_at),
	
		   );
		  }

		  if (isset($_REQUEST["sAction"]) && $_REQUEST["sAction"] == "group_action") {
			$records["sStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
			$records["sMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
		  }

		  $records["sEcho"] = $sEcho;
		  $records["iTotalRecords"] = $iTotalRecords;
		  $records["iTotalDisplayRecords"] = $iTotalRecords;
		  
		  echo json_encode($records);
	}
	
	
	
	/*View User Payment History*/
	public function anyUserpaymenthistory($id)
	{
		//echo $id;die;
	  //$iTotalRecords = DB::table('payment_history')->join('users_accounts', 'users_accounts.id', '=', 'payment_history.user_account_id')->where('users_accounts.user_id','=',$id)->select('payment_history.*')->count();
	  
	  $query = DB::table('payment_history')->join('users_accounts', 'users_accounts.id', '=', 'payment_history.user_account_id')->where('users_accounts.user_id','=',$id)->select('payment_history.*');
	  $iTotalRecords = $query->count();
	  $iDisplayLength = intval($_REQUEST['iDisplayLength']);
	  $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
	  $iDisplayStart = intval($_REQUEST['iDisplayStart']);
	  $sEcho = intval($_REQUEST['sEcho']);
	  
	  $records = array();
	  $records["aaData"] = array(); 

	  $end = $iDisplayStart + $iDisplayLength;
	  $end = $end > $iTotalRecords ? $iTotalRecords : $end;
		
			$sort_col           = Input::get('iSortCol_0');
		$sort_order         = Input::get('sSortDir_0'); 
		
		$order_by = "payment_history.id";

		if($sort_col == 1)
		{
			$order_by="payment_history.amount";
		}
		else if($sort_col==2){
			$order_by="payment_history.currency";
		}
		else if($sort_col==3){
			$order_by="payment_history.payment_txn_id";
		}
		else if($sort_col==4){
			$order_by="payment_history.payment_status";
		}	
		
		
		$allrecords	= $query->orderBy($order_by,$sort_order)->get();
		 //echo "<pre>";print_r($allrecords);die;
		  foreach($allrecords as $key=>$value) {
			
			$id = ($key + 1);
			$records["aaData"][] = array(
			  $id,
			  $value->amount,
			  $value->currency,
			  $value->payment_txn_id,
			  $value->payment_status,
			  CommonFunctions::formated_date_time($value->created_at),
	
		   );
		  }

		  if (isset($_REQUEST["sAction"]) && $_REQUEST["sAction"] == "group_action") {
			$records["sStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
			$records["sMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
		  }

		  $records["sEcho"] = $sEcho;
		  $records["iTotalRecords"] = $iTotalRecords;
		  $records["iTotalDisplayRecords"] = $iTotalRecords;
		  
		  echo json_encode($records);
	}

}
