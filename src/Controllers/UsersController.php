<?php

namespace Lab1353\Monkyz\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Hash;
use Illuminate\Http\Request;
use Lab1353\Monkyz\Models\DynamicModel;
use Validator;

class UsersController extends MonkyzController
{

	public function __construct()
	{
		$this->init();
        $this->middleware('guest', ['except' => 'logout']);
	}

	public function getLogin()
	{
		return view('monkyz::users.login');
	}

	public function postLogin(Request $request)
	{
		$email = $request->input('email');
		$password = $request->input('password');

		$validator = Validator::make(compact('email', 'password'), [
			'email'    => 'required|email',
			'password' => 'required|alphaNum'
		]);

		if ($validator->fails()) {
			return redirect()->back()
				->withErrors($validator)
				->withInput();
		} else {
			if (Auth::attempt(compact('email', 'password'), $request->has('remember'))) {
				return redirect()->route('monkyz.dashboard');
			} else {
				$model = new DynamicModel('users');
				$user = $model->where('email', $email)->first();
				if (!empty($user)) {
					if (Hash::check($password, $user->password)) {
						Auth::loginUsingId($user->id, $request->has('remember'));
						return redirect()->route('monkyz.dashboard');
					}
				}
			}

			return redirect()->back()
					->withInput()
					->with('error', 'That username/password combo does not exist.');
		}
	}

	public function getLogout()
	{
		Auth::logout();

		return redirect()->route('monkyz.users.login');
	}
}
