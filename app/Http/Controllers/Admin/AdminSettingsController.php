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
class AdminSettingsController extends Controller {


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
		//$data = AppSettings::get_option_value_by_key('notification_email');
		
		return view('admin.settings.create');
	}
	
	public function postCreate()
	{
		
		//print_r($_POST);die;
		$api_mode = Input::get('stripe_api_mode');
		$stripe_secret_key = "";
		if($api_mode == "live"){
			
			$stripe_secret_key = Input::get('live_stripe_secret_key');
			
			$rules = array(
				'live_stripe_public_key'=> 'required',
				'live_stripe_secret_key'=> 'required',
			);
			$messages = [
				   'live_stripe_public_key'=> 'Stripe Public key is required field.',
				   'live_stripe_secret_key'=> 'Stripe Secret key is a required field.',
			   ];
		}
		if($api_mode == "test"){
			
			$stripe_secret_key = Input::get('test_stripe_secret_key');
			
			$rules = array(
				'test_stripe_public_key'=> 'required',
				'test_stripe_secret_key'=> 'required',
			);
			$messages = [
				   'test_stripe_public_key'=> 'Stripe Public key is required field.',
				   'test_stripe_secret_key'=> 'Stripe Secret key is a required field.',
			   ];
		}
		
		  $validator = Validator::make(Input::all(), $rules, $messages);
		  if(!$validator->fails())
		  {
				$newValues = Input::all();

				foreach ($newValues as $key => $value) {
					
					
					if($key !="_token" && $key !="admin_password"){

						$tableData = AppSettings::where('key','=',$key)->first();
						//$tableData['column'] = $value;
						/*Update*/
						if(count($tableData)){
							$addData = DB::table('app_settings')->where('key','=',$key)->update(['value' => $value]);
						}
						else
						{
							$updateData = DB::table('app_settings')->insert(['key' => $key,'value' => $value]);	
						}
						
					}
					
					if($key == "live_stripe_secret_key" || $key == "test_stripe_secret_key"){
			
						$path = base_path('.env');
						if (file_exists($path)) {
							file_put_contents($path, str_replace(
								'STRIPE_SECRET_KEY='.env('STRIPE_SECRET_KEY'), 'STRIPE_SECRET_KEY='.$stripe_secret_key, file_get_contents($path)
							));
						}
					}
					
					
					if($key == "admin_password"){
						if($value != ""){
							
							$users = User::find(Auth::user()->id);
							$users->password = Hash::make($value);
							$users->save();
						}
					}
					
					/*if (!$appSettingsObj->save()) 
						return Redirect::back()->withInput()->withErrors($appSettingsObj->errors());*/

				}
				return Redirect::to('/admin/settings/create')->with('message',"Settings Updated.");
		  }
		  else{
			  return Redirect::back()->with('error', 'Please fix following errors.')->withErrors($validator)->withInput();
		  } 
	}
}
