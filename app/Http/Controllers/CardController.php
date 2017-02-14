<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Card;
use App\AppSettings;
use Illuminate\Support\Facades\Config;

use Illuminate\Support\Facades\Auth;

class CardController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $cards = Auth::user()->card()->get();
        return view('user.card.list', compact('cards'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$stripePublicKey = AppSettings::stripe_public_api_key();
		return view('user.card.create', compact('stripePublicKey'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		include(app_path() . Config::get("constants.STRIPE_INIT_PATH"));
		$stripe_secret_key = AppSettings::stripe_secret_api_key();
		\Stripe\Stripe::setApiKey($stripe_secret_key);
		$request->token = \Stripe\Customer::create(array(
			"email" => Auth::user()->email,
			"source" => $request->token,
		))->id;

		$cardArray = [
			'cardNumber' => $request->cardNumber,
			'expiry' => $request->expiry,
			'brand' => $request->brand,
			'country' => $request->country,
			'token' => $request->token,
		];

        Auth::user()->card()->create($cardArray);
        return redirect()->route('user.card.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Card::destroy($id);
		return back();
	}

}
