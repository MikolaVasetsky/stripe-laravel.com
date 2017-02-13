<?php 
namespace App;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
class AppSettings extends Model implements AuthenticatableContract {

	use Authenticatable;

	protected $table = 'app_settings';
	
	public static function get_option_value_by_key($key){
		
		$app_data = DB::table('app_settings')->where('key','=',$key)->first();
		$req_value = "";
		if(count($app_data )){
			$req_value = $app_data->value;
		}
		//echo $req_value;die;
		return $req_value;
		
	}
	
	public static function stripe_secret_api_key(){
		
		$app_data = DB::table('app_settings')->where('key','=','stripe_api_mode')->first();
		$return_key = "sk_test_pFiZ8p7wtpttDE2KYXnGKZi3";
		if(count($app_data )){
			$mode = $app_data->value;
			if($mode == "live"){
				$return_data = DB::table('app_settings')->where('key','=','live_stripe_secret_key')->first();
				$return_key = $return_data->value;
			}
			if($mode == "test"){
				$return_data = DB::table('app_settings')->where('key','=','test_stripe_secret_key')->first();
				$return_key = $return_data->value;
				
			}
		}

		return $return_key;
		
	}
	public static function stripe_public_api_key(){
		
		$app_data = DB::table('app_settings')->where('key','=','stripe_api_mode')->first();
		$return_key = "pk_test_nWetPzN5FFBjwOIGHGkwQqYk";
		if(count($app_data )){
			$mode = $app_data->value;
			if($mode == "live"){
				$return_data = DB::table('app_settings')->where('key','=','live_stripe_public_key')->first();
				$return_key = $return_data->value;
			}
			if($mode == "test"){
				$return_data = DB::table('app_settings')->where('key','=','test_stripe_public_key')->first();
				$return_key = $return_data->value;
			}
		}

		return $return_key;
		
	}

}