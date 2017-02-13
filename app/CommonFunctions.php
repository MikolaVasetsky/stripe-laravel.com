<?php 
namespace App;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class CommonFunctions extends Model implements AuthenticatableContract {

	use Authenticatable;

	public static function generatePassword($length = "") 
	{
		$possibleChars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$password = '';
		for($i = 0; $i < $length; $i++) {
			$rand = rand(0, strlen($possibleChars) - 1);
			$password .= substr($possibleChars, $rand, 1);
		}
		return $password;
	}
		
        /*public static function send_mail($array,$content,$data) {

            $sent = Mail::raw($content, function($message) use ($data)
            {

                $message->to($data['to_email']);
                $message->bcc(Config::get('constants.BCC_EMAIL'));
                $message->subject($data['subject']);
				
            });

            return $sent;

        }*/

        
        public static function send_larvel_default_mail($email_file_path,$data) {

            $response=Mail::send($email_file_path,$data, function($message) use ($data)
            {							
                $message->to($data['email'],$data['name']);
                $message->bcc(Config::get('constants.BCC_EMAIL'));
                $message->subject($data['subject']);
            }); 

            return $response;

        }

        public static function formated_date($date){
  
            return date('d F, Y',  strtotime($date));
        }
		
		public static function formated_date_time($date_time){
  
            return date('d F, Y g:i A',  strtotime($date_time));
        }
}