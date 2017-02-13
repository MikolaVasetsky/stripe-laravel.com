<?php namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use Log;
class AchEventsController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function anyChargesuccess()
	{
		/*Log::info('Payment Succeeded - StripeWebhook - handleOrderPaymentSucceeded()', ['details' => json_encode($payload)]);*/
        //return new Response('Webhook Handled', 200);
		mail("quaysysdeveloper@gmail.com","Testing From App Without csrf","Test email","From: vinay.chaudhary@quaysys.com");
		echo "Hi";
		//echo app_path() . Config::get("constants.STRIPE_INIT_PATH");die;
		/*include(app_path() . Config::get("constants.STRIPE_INIT_PATH"));
		\Stripe\Stripe::setApiKey(Config::get("constants.STRIPE_TEST_SECRET_KEY"));
		$input = @file_get_contents("php://input");
		$event_json = json_decode($input);
		*/
		/*$sent = Mail::raw('Text to e-mail'.print_r($event_json,1), function ($message) {
			$message->from('us@example.com', 'Laravel');
			$message->subject("Charge Success Json Data");
			$message->to('quaysysdeveloper@gmail.com');
		});*/
		// Do something with $event_json
	//echo $sent;die;
		//http_response_code(200); // PHP 5.4 or greater
		
		
	}

}
