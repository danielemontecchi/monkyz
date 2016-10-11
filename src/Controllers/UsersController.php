<?php

namespace Lab1353\Monkyz\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends MonkyzController
{

	public function __construct()
	{
		$this->init();
	}

	public function getLogin()
	{    	
		return view('monkyz::users.login');
	}

	public function postLogin(Request $request)
	{
		$email = $request->input('email');
		$password = $request->input('password');
		$remember = (!empty($request->input('remember'))) ? true : false;

		if (Auth::attempt(compact('email', 'password'), $remember))
		{
			return redirect()->route('monkyz.dashboard');
		}

		return redirect()->back()
				->withInput()
				->withErrors('That username/password combo does not exist.');
	}

	public function getLogout()
	{
		Auth::logout();

		return redirect()->route('monkyz.users.login');
	}
}
