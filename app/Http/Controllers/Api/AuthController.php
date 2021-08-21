<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;
use Mail;

class AuthController extends Controller
{

    public function open() 
    {
        $data = "This data is open and can be accessed without the client being authenticated";
        return response()->json(compact('data'),200);

    }

    public function closed() 
    {
        $data = "Only authorized users can see this";
        return response()->json(compact('data'),200);
    }
    
    public function login(Request $request){
        $validatedData = request()->validate([
	        'email' => 'required',
	        'password' => 'required',
	    ]);


	    $credentials = request(['email', 'password']);

	    if (!$token = auth('api')->attempt($credentials)) {
	        return response()->json(['errors' => ['root' => 'Please check your username and password and try again!']], 401);
	    }
	    return response()->json([
			// 'success' => true,
	    	'data' => auth('api')->user(),
	        'token' => $token,
	        'expires' => auth('api')->factory()->getTTL() * 60,
	    ]);


    }

	public function me(){
		return response()->json([
			// 'success' => true,
			'data' => auth('api')->user(),
		]);
	}
	
    public function logout(){
        \Auth::guard('api')->logout();
		return response()->json([
			'success' => true,
		]);
    }
}
