<?php

namespace App\Http\Controllers\Webhooks;
use Symfony\Component\HttpFoundation\Response;
use Log;
use App\User;
use App\UserAccounts;
use App\CommonFunctions;
use App\PaymentHistory;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use App\AppSettings;
class StripeController extends \Laravel\Cashier\WebhookController {

    /**
     * [description]
     * @param  array  $payload [description]
     * @return [type]          [description]
     */
    public function handleStripeWebhookEvents()
    {
		$input = @file_get_contents("php://input");
        //Log::info('StripeWebhook - handleOrderPaymentSucceeded()', ['details' => json_encode($input)]);
		$event_json = json_decode($input,true);
		// $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");

		$f = fopen("newFileTestHooks.txt", 'a+');
		fwrite($f, date('Y-m-d H:i:s')."\n");
		fwrite($f, $input."\n\n");

		// fwrite($myfile, $input);
		/*When new bank account is added to a customer*/
		// return new Response('Webhook Handled', 200);
		if($event_json['type'] == "customer.created"){
			//Log::info('Customer Created - StripeWebhook - handleStripeWebhookEvents()', ['details' => print_r($event_json['data']['object'])]);
			//print($event_json->data);
			$user_account_info = UserAccounts::where('stripe_customer_id','=',$event_json['data']['object']['id'])->first();
			if(count($user_account_info) > 0){
				$user_info = User::find($user_account_info->user_id);
				$data = array('name'=>Config::get('constants.ADMIN_NAME'),
				'email'=>AppSettings::get_option_value_by_key('notification_email'),
				'customer_email'=>$user_info->email,
				'customer_name'=>$user_info->name,
				'account_number'=>$user_account_info->account_number,
				'subject'=>"New Bank Account Details Added.");
				$sent = CommonFunctions::send_larvel_default_mail('emails.webhooks.bank_added',$data);
			}
		}

		/*When bank account is verifird by customer*/
		if($event_json['type'] == "customer.source.updated"){
			//Log::info('Account Verification - StripeWebhook - customer.source.updated()', ['details' => print_r($event_json)]);
			$user_account_info = UserAccounts::where('stripe_bank_id','=',$event_json['data']['object']['id'])->first();
			if(count($user_account_info) > 0){
				if($event_json['data']['object']['status'] == "verified"){
					$msg = "The Following account details has been verified";
				}
				else{
					$msg = "The Following account details has not verified yet.";
				}
				$user_info = User::find($user_account_info->user_id);
				$data = array('name'=>Config::get('constants.ADMIN_NAME'),
				'email'=>AppSettings::get_option_value_by_key('notification_email'),
				'customer_email'=>$user_info->email,
				'customer_name'=>$user_info->name,
				'account_number'=>$user_account_info->account_number,
				'msg'=>$msg,
				'subject'=>"Account Number Verification.");
				$sent = CommonFunctions::send_larvel_default_mail('emails.webhooks.account_verify',$data);
			}
		}

		/*When charge created and has pending*/
		if($event_json['type'] == "charge.pending"){
			$user_account_info = UserAccounts::where('stripe_customer_id','=',$event_json['data']['object']['customer'])->first();
			$payment_history = PaymentHistory::where('payment_txn_id','=',$event_json['data']['object']['id'])->first();
			if(count($payment_history) > 0){
				$user_info = User::find($user_account_info->user_id);
				$data = array('name'=>Config::get('constants.ADMIN_NAME'),
				'email'=>AppSettings::get_option_value_by_key('notification_email'),
				'customer_email'=>$user_info->email,
				'customer_name'=>$user_info->name,
				'account_number'=>$user_account_info->account_number,
				'amount'=>$payment_history->amount,
				'currency'=>$payment_history->currency,
				'subject'=>"Charge Created Pending Status.");
				$sent = CommonFunctions::send_larvel_default_mail('emails.webhooks.charge_pending',$data);
			}
		}

		/*When charge crated and updated to success*/
		if($event_json['type'] == "charge.succeeded"){
			//Log::info('charge.pending', ['details' => print_r($event_json)]);

			$user_account_info = UserAccounts::where('stripe_customer_id','=',$event_json['data']['object']['customer'])->first();
			$payment_history = PaymentHistory::where('payment_txn_id','=',$event_json['data']['object']['id'])->first();
			if($payment_history->id){
				//if($event_json['data']['object']['status'] == "succeeded"){
					$payment_history_update = PaymentHistory::find($payment_history->id);
					$payment_history_update->payment_status = "succeeded";
					$payment_history_update->save();
				//}
				$user_info = User::find($user_account_info->user_id);
				$data = array('name'=>Config::get('constants.ADMIN_NAME'),
				'email'=>AppSettings::get_option_value_by_key('notification_email'),
				'customer_email'=>$user_info->email,
				'customer_name'=>$user_info->name,
				'account_number'=>$user_account_info->account_number,
				'amount'=>$payment_history->amount,
				'currency'=>$payment_history->currency,
				'subject'=>"Amount Charged Successfully.");
				$sent = CommonFunctions::send_larvel_default_mail('emails.webhooks.charge_success',$data);
			}
		}

		/*When charge crated and updated to success*/
		if($event_json['type'] == "charge.failed"){
			$user_account_info = UserAccounts::where('stripe_customer_id','=',$event_json['data']['object']['customer'])->first();
			$payment_history = PaymentHistory::where('payment_txn_id','=',$event_json['data']['object']['id'])->first();
			if($payment_history->id){
				//if($event_json['data']['object']['status'] == "failed"){
					$payment_history_update = PaymentHistory::find($payment_history->id);
					$payment_history_update->payment_status = "failed";
					$payment_history_update->save();
				//}
				$user_info = User::find($user_account_info->user_id);
				$data = array('name'=>Config::get('constants.ADMIN_NAME'),
				'email'=>AppSettings::get_option_value_by_key('notification_email'),
				'customer_email'=>$user_info->email,
				'customer_name'=>$user_info->name,
				'account_number'=>$user_account_info->account_number,
				'amount'=>$payment_history->amount,
				'currency'=>$payment_history->currency,
				'subject'=>"Charged Amount Failed.");
				$sent = CommonFunctions::send_larvel_default_mail('emails.webhooks.charge_failed',$data);
			}
		}

        return new Response('Webhook Handled', 200);
    }
}