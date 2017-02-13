<?php 

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use App\User;
use App\UserAccounts;
use App\AppSettings;
class UserDashboardController extends Controller {
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
		
		return view('user.account.list');
	}
	
	/**
	* Function for deleting the Customer Bank Account
	*
	*/
	
	public function delete($id)
	{
		
		try{
		
			$UserAccounts = UserAccounts::find($id);	
			
			include(app_path() . Config::get("constants.STRIPE_INIT_PATH"));
			$stripe_secret_key = AppSettings::stripe_secret_api_key();
			\Stripe\Stripe::setApiKey($stripe_secret_key);
			
			$customer = \Stripe\Customer::retrieve( $UserAccounts->stripe_customer_id );
			$customer->sources->retrieve( $UserAccounts->stripe_bank_id )->delete();			
			
			$deleted = $UserAccounts->delete();
		
			if($deleted){
				return Redirect::to('user/dashboard')->with('message','Customer Account Deleted Successfully!!!');   
			}
		
		} 
		catch(\Exception $e){
			
		   return Redirect::to('user/dashboard')->with('error',$e->getMessage());
		}
		
	}
	
	
	public function anyAccountslist()
	{
		$user_id = Auth::user()->id;
		
		$iTotalRecords = UserAccounts::where('user_id','=',$user_id)->get()->count();
		$iDisplayLength = intval($_REQUEST['iDisplayLength']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($_REQUEST['iDisplayStart']);
		$sEcho = intval($_REQUEST['sEcho']);

		$records = array();
		$records["aaData"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		$allrecords	= UserAccounts::where('user_id','=',$user_id)->orderBy('id','desc')->get();
	 
		foreach($allrecords as $key=>$value) {
			$ver_button ="";
			if($value->verification_status == "pending"){
				$ver_status ='<span class="label label-sm label-danger">Pending</span>';
				$ver_button = '</br></br><a class="btn blue verification_button"  data-toggle="modal" href="#verify_account"  id="'.$value->id.'">Verify Account</a>';
			}
			else{
				$ver_status ='<span class="label label-sm label-success">Verified</span>';
			}
		
			$ver_button .= "</br></br><a href='".URL::to("/user/delete/".$value->id)."' onclick=\"return confirm('Are you sure to delete this customer account?')\" class='btn btn-xs default'><i class='fa fa-trash-o'></i> Delete</a>";
			
		
			$id = ($key + 1);
			$records["aaData"][] = array(
				$id,
				$value->account_number,
				$value->routing_number,
				$value->country,
				$value->currency,
				$value->account_holder_type,
				$ver_status.$ver_button,

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
	
	/*Update user profile info*/
	public function postUpdate()
	{
		$id = Auth::user()->id;
		
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
			
			include(app_path() . Config::get("constants.STRIPE_INIT_PATH"));
			$stripe_secret_key = AppSettings::stripe_secret_api_key();
			\Stripe\Stripe::setApiKey($stripe_secret_key);
			
			$cu = \Stripe\Customer::retrieve( $update_user->stripe_customer );
			$cu->description = "Customer for ".Input::get('email');
			$cu->email = Input::get('email'); 
			$cu->save();
			
			if( $password !="" ){
				
				$update_user->password = Hash::make(Input::get('password'));
				$update_user->password1 = Input::get('password');
			}
			$saved = $update_user->save();
			if($saved){
				return Redirect::to('user/dashboard/')->with('message','Profile Details Updated Successfully!!!');    
			}
		  }
		  else{
			  return Redirect::back()->with('error', 'Please fix following errors.')->withErrors($validator)->withInput();
		  }
	}
	
	
	public function getCreate()
	{
		$stripe_public_key = AppSettings::stripe_public_api_key();
		
		return view('user.account.create',array('stripe_public_key'=>$stripe_public_key));
	}
	
	public function postCreate()
	{
		//echo "<pre>";print_r($_POST);die;
		
		try{
			
			include(app_path() . Config::get("constants.STRIPE_INIT_PATH"));
			$stripe_secret_key = AppSettings::stripe_secret_api_key();
			\Stripe\Stripe::setApiKey($stripe_secret_key);

			// Get the bank token submitted by the form
			$token_id = $_POST['token'];

			$customer_id = Auth::user()->stripe_customer;
			$customer    = \Stripe\Customer::retrieve($customer_id);
			$bank = $customer->sources->create(array("source" => $token_id));

			$customer_info_object = json_encode($bank);
			$customer_info_array = json_decode($customer_info_object,true);
			//print_r($customer_info_array);die();
			
			$bank_id = $customer_info_array['id'];

			$add_user_account = new UserAccounts;
			$add_user_account->user_id = Auth::user()->id;
			$add_user_account->country = Input::get('country');
			$add_user_account->currency = Input::get('currency');
			$add_user_account->routing_number = Input::get('routing_number');
			$add_user_account->account_number = Input::get('account_number');
			$add_user_account->account_holder_name = Input::get('account_holder_name');
			$add_user_account->account_holder_type = Input::get('account_holder_type');
			$add_user_account->token = Input::get('token');
			$add_user_account->stripe_customer_id = $customer_id;
			$add_user_account->stripe_bank_id = $bank_id;
			$add_user_account->save();
			if($add_user_account->id){
				return Redirect::to('user/dashboard')->with('message','Account Details Added Successfully!!!');    
			}
			
			
		} 
		catch(\Exception $e){
			//print_r($e);die();
		   return Redirect::to('user/dashboard/create')->with('error',$e->getMessage());
		}
	}

}
