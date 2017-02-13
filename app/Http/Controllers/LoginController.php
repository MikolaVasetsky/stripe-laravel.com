<?php namespace App\Http\Controllers;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\LoginRequest;
class LoginController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		
		$this->middleware('guest',['except' => 'getLogout']); 
		
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getLogin()
	{
		return view('common.login');
	}
	
		/*
	*post login data if success go to admin dashboard
	*/	
	 public function postLogin(LoginRequest $request)
	 {
		$credentials = $request->only('email', 'password');

		if(Auth::attempt($credentials))
		{
			$message="You are successfully logged in.";
			if (Auth::user()->role == 'admin') {
				
				return Redirect::to('admin/dashboard')->with('message', $message);
			}else{
				return Redirect::to('user/dashboard')->with('message', $message);
			} 
		}
		else
		{
			$message='Wrong Credentials.';
			return Redirect::to('/')->with('error', $message);
		}
	}
	
	public function getLogout()
	{
		Auth::logout();
		$message='You are successfully logout.';
		return Redirect::to('/')->with('message', $message);
	}

}
