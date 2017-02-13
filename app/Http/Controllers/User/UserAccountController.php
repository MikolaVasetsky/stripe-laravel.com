<?php namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use App\User;
use App\UserAccounts;
use App\AppSettings;
class UserAccountController extends Controller {


	/**
	 * Create a new controller instance.
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

	
	
	public function postVerify()
	{
		//echo "<pre>";print_r($_POST);die;
		
		try{
			
			include(app_path() . Config::get("constants.STRIPE_INIT_PATH"));
			$stripe_secret_key = AppSettings::stripe_secret_api_key();
			\Stripe\Stripe::setApiKey($stripe_secret_key);

			$account_id = Input::get('account_id');
			$account_data = UserAccounts::find($account_id);	
			
			// See your keys here: https://dashboard.stripe.com/account/apikeys
			\Stripe\Stripe::setApiKey($stripe_secret_key);

			// get the existing bank account
			$customer = \Stripe\Customer::retrieve(Auth::user()->stripe_customer);
			$bank_account = $customer->sources->retrieve($account_data->stripe_bank_id);

			// verify the account
			$result = $bank_account->verify(array('amounts' => array(trim(Input::get('amount1')),trim(Input::get('amount2')))));

			$customer_info_object = json_encode($result);
			$customer_info_array = json_decode($customer_info_object,true);	
			
			
			if($customer_info_array['status'] == "verified"){
				$account_data->verification_status = $customer_info_array['status'];
				$updated = $account_data->save();
				return Redirect::to('user/dashboard')->with('message','Account Details Updated Successfully!!!');    
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
			  return Redirect::to('user/dashboard')->with('error',$err['message']);  
			  
			} catch (\Stripe\Error\RateLimit $e) {
			  // Too many requests made to the API too quickly
			  return Redirect::to('user/dashboard')->with('error',$e->getMessage()); 
			  
			} catch (\Stripe\Error\InvalidRequest $e) {
			  // Invalid parameters were supplied to Stripe's API
			  return Redirect::to('user/dashboard')->with('error',$e->getMessage()); 
			  
			} catch (\Stripe\Error\Authentication $e) {
			  // Authentication with Stripe's API failed
			  // (maybe you changed API keys recently)
			  return Redirect::to('user/dashboard')->with('error',$e->getMessage());
			  
			} catch (\Stripe\Error\ApiConnection $e) {
			  // Network communication with Stripe failed
			  return Redirect::to('user/dashboard')->with('error',$e->getMessage());
			  
			} catch (\Stripe\Error\Base $e) {
			  // Display a very generic error to the user, and maybe send
			  // yourself an email
			  return Redirect::to('user/dashboard')->with('error',$e->getMessage());
			  
			} catch (Exception $e) {
			  // Something else happened, completely unrelated to Stripe
			  return Redirect::to('user/dashboard')->with('error',$e->getMessage());
			  
			}	

	}
}
