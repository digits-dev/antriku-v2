<?php

namespace App\Http\Controllers;

use DB;
use Request;
use Illuminate\Support\Facades\Session;

class CBHook extends Controller
{

	/*
	| --------------------------------------
	| Please note that you should re-login to see the session work
	| --------------------------------------
	|
	*/
	public function afterLogin()
	{
		// Session::put('just_logged_in', true);
	}
}
