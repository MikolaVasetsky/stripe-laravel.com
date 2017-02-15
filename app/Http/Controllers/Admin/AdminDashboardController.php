<?php namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

use App\User;
use App\UserAccounts;
use App\PaymentHistory;
use App\CommonFunctions;
use App\AppSettings;
use App\Card;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller {

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
	public function getDashboard()
	{
		//$get_customer_list = User::where('role','=','customer')->lists('name','id');
		$get_customer_list = DB::table('users')
			->join('users_accounts','users.id','=','users_accounts.user_id')
			->where('users_accounts.verification_status', '=', 'verified')
			->where('users.role','=','customer')
			->select('users.name','users.id')
			->distinct()
			->get();

		$list_customers = array();
		foreach($get_customer_list as $key=>$value){
			$list_customers[$value->id] = $value->name;
		}

		$cardsUsers = Card::distinct()->groupBy('user_id')->select('user_id')->get();
		foreach ($cardsUsers as $cardUser) {
			$list_customers[$cardUser->user->id] = $cardUser->user->name;
		}

		//echo "<pre>";print_r($list_customers);
		return view('admin.dashboard.charge_customer',array('customers_list'=>$list_customers));
	}




	public function anyCustomeraccounts(Request $request)
	{
		$customer_id = $request->get('customer_id');

		/* get all users accounts */
		$get_customer_list = UserAccounts::where('user_id','=',$customer_id)->where('verification_status','=','verified')->select('account_number','id')->get();
		$count_get_customer_list = count($get_customer_list);
		$array_result['account'] = $array_result['card'] = [];
		for ( $i = 0; $i < $count_get_customer_list; ++$i ) {
			$array_result['account'][$i]['id'] = $get_customer_list[$i]->id;
			$array_result['account'][$i]['type'] = 'account';
			$array_result['account'][$i]['text'] = 'Bank Account – ' . substr($get_customer_list[$i]->account_number, -4);
		}

		/*get all users cards*/
		$cards = Card::where('user_id', $customer_id)->select('id', 'cardNumber')->get();
		$count_cards = count($cards);
		for ( $i = 0; $i < $count_cards; ++$i ) {
			$array_result['card'][$i]['id'] = $cards[$i]->id;
			$array_result['card'][$i]['type'] = 'card';
			$array_result['card'][$i]['text'] = 'Credit Card – ' . $cards[$i]->cardNumber;
		}

		$array_result = array_merge($array_result['account'], $array_result['card']);

		echo json_encode($array_result);
	}

	public function postCreatecharge(Request $request)
	{
		try{
			$account_id = $request->account_id;
			$amount = (int)str_replace(array('$', '_', '.'), '', $request->amount);

			include(app_path() . Config::get("constants.STRIPE_INIT_PATH"));
			$stripe_secret_key = AppSettings::stripe_secret_api_key();
			\Stripe\Stripe::setApiKey($stripe_secret_key);

			if ( $request->type == 'account' ) { //create and save information about payment with account
				$account_data = UserAccounts::find($account_id);
				$account_user_data = User::find($account_data->user_id);

				$result = \Stripe\Charge::create(array(
				  "amount"   =>  $amount,
				  "currency" => $account_data->currency,
				  "customer" => $account_data->stripe_customer_id // Previously stored, then retrieved
				));

				$charge_info_object = json_encode($result);
				$charge_info_array = json_decode($charge_info_object,true);

				$payment_history = new PaymentHistory;
				$payment_history->user_account_id = $account_id;
				$payment_history->type = 'account';
				$payment_history->amount = $amount;
				$payment_history->currency = $account_data->currency;
				$payment_history->payment_txn_id = $charge_info_array['id'];
				$payment_history->payment_status = $charge_info_array['status'];
				$payment_history->user_id = $account_data->user_id;
				$payment_history->save();
				if($payment_history->id){
					return Redirect::to('admin/dashboard')->with('message','Amount Charged Successfully!!!');
				}
			} else if ( $request->type == 'card' ) { //create and save information about payment with card
				$cardInfo = Card::find($account_id);

				$result = \Stripe\Charge::create(array(
					"amount" => $amount,
					"currency" => "usd",
					"customer" => $cardInfo->token,
				));

				$payment_history = new PaymentHistory;
				$payment_history->user_account_id = $account_id;
				$payment_history->type = 'card';
				$payment_history->amount = $amount;
				$payment_history->currency = 'USD';
				$payment_history->payment_txn_id = $result->id;
				$payment_history->payment_status = $result->status;
				$payment_history->user_id = $cardInfo->user_id;
				$payment_history->save();
				if($payment_history->id){
					return Redirect::to('admin/dashboard')->with('message','Amount Charged Successfully!!!');
				}
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

	public function getTransactionhistory()
	{
		$res = PaymentHistory::all(); 
		$countRes = count($res);
		$historyArray = [];
		for ( $i = 0; $i < $countRes; ++$i ) {
			$historyArray[$i] = [
				'id' => $res[$i]->id,
				'amount' => $res[$i]->amount/100,
				'currency' => $res[$i]->currency,
				'paymentId' => $res[$i]->payment_txn_id,
				'paymentStatus' => $res[$i]->payment_status,
				'createdAt' => CommonFunctions::formated_date_time($res[$i]->created_at),
			];
			if ( $res[$i]->type == 'card' ) {
				$cardRes = Card::join('users', 'users.id', '=', 'cards.user_id')->find($res[$i]->user_account_id);
				$historyArray[$i]['userId'] = $res[$i]->user_id;
				if ( $cardRes ) {
					$historyArray[$i]['userName'] = $cardRes->name;
					$historyArray[$i]['number'] = 'Credit Card - ' . $cardRes->cardNumber;
				} else {
					$historyArray[$i]['userName'] = 'User deleted card';
					$historyArray[$i]['number'] = 'User deleted card';
				}
			} else {
				$accountRes = UserAccounts::join('users', 'users.id', '=', 'users_accounts.user_id')->find($res[$i]->user_account_id);
				$historyArray[$i]['userId'] = $res[$i]->user_id;
				if ( $accountRes ) {
					$historyArray[$i]['userName'] = $accountRes->name;
					$historyArray[$i]['number'] = 'Bank Account - ' . substr($accountRes->account_number, -4);
				} else {
					$historyArray[$i]['userName'] = 'User deleted card';
					$historyArray[$i]['number'] = 'User deleted card';
				}
			}
		}
		return view('admin.dashboard.transaction_history', compact('historyArray'));
	}

	/*Transactions History*/
	public function anyListtransactions()
	{
		//echo "sdfsd";die;
		$query = DB::table('payment_history')->join('users_accounts', 'users_accounts.id', '=', 'payment_history.user_account_id')->join('users', 'users.id', '=', 'users_accounts.user_id')->select('payment_history.*','users_accounts.user_id','users_accounts.account_number','users.name');
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
		//$sort_col ="desc";
		if($sort_col == 1)
		{
			$order_by="users.name";
		}
		else if($sort_col==2){
			$order_by="users_accounts.account_number";
		}
		else if($sort_col==3){
			$order_by="payment_history.amount";
		}
		else if($sort_col==4){
			$order_by="payment_history.currency";
		}
		else if($sort_col==5){
			$order_by="payment_history.payment_txn_id";
		}
		else if($sort_col==6){
			$order_by="payment_history.payment_status";
		}
		else if($sort_col==8){
			
			$order_by="payment_history.id";
		}
		//$allrecords	= PaymentHistory::orderBy('id','DESC')->get();
		$allrecords	= $query->orderBy($order_by,$sort_order)->get();
		 
		  foreach($allrecords as $key=>$value) {
			
			$id = ($key + 1);
			$records["aaData"][] = array(
			  $id,
			  $value->name,
			  $value->account_number,
			  number_format((float)$value->amount, 2, '.', ''),
			  $value->currency,
			  $value->payment_txn_id,
			  $value->payment_status,
			  '<a href="'.URL::to('admin/customer/detail/'.$value->user_id).'" class="btn green"><i class="fa fa-search"></i> View Account</a>',
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
