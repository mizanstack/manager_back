<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Email;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\StudentResource;
use DB;
use Carbon\Carbon;
use Mail;

class AuthController extends Controller
{

	public function forgot_password(Request $request){
        $exp_minutes = 10;
        $student = Student::where('email', '=', $request->email)
            ->first();
        //Check if the student exists
        if (!$student) {
            return response()->json(['errors' => ['root' => 'Email not exists']], 401);
        }

        $student->reset_token = rand(1000,9999);
        $student->reset_token_expire_in_min = Carbon::now()->addMinutes($exp_minutes)->timestamp;
        $student->save();


        if (Email::send_forgot_password_email($student)) {
            return response()->json(['status' => 'success', 'message' => 'A reset link has been sent to your email address.']);
        } else {
            return response()->json(['errors' => ['root' => 'Something is wrong']], 401);
        }
    }

    public function change_password(Request $request){
        // return response()->json($request->all());

        $request->validate([

            'email' => 'required|exists:students',
            'reset_token' => 'required|exists:students',
            'password' => 'min:4|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:4'
       ],
       [
       ]);



       try {
            DB::beginTransaction();
            $student = Student::where('email', $request->email)->where('reset_token', $request->reset_token)->get()->first();
            $student->password = bcrypt($request->password);
            $student->save();


            DB::commit();
            // DB::rollBack();

            return response()->json(['status' => 'success', 'message' => 'Password Updated. You can login..']);
       }
       catch( \Execption $e ) {
            DB::rollBack();

            return response()->json(['status' => 'error', 'message' => 'Something wrong']);
       }
    }

	public function update_profile(Request $request){

		if(!$student = auth('api')->user()){
			 return response()->json(['errors' => ['root' => 'User not logged in']], 401);
		}

		$request->validate([
            'name' => 'required',
        ],
       [
       ]);



       try {
            DB::beginTransaction();
            if($student->password){
	            $student->password = bcrypt($request->password);
            }
            $student->name = $request->name;
            $student->save();

            DB::commit();
            // DB::rollBack();

            return response()->json(['status' => 'success', 'message' => 'We got your update request successfully.']);
       }
       catch( \Execption $e ) {
            DB::rollBack();

            return response()->json(['status' => 'error', 'message' => 'Something wrong']);
       }

	}
    
    public function login(Request $request){
        $validatedData = request()->validate([
	        'email' => 'required',
	        'password' => 'required',
	    ]);

        $check_active_or_not = \App\Models\Student::where('email', request('email'))->first();
        if($check_active_or_not && $check_active_or_not->status != 1){
        	 return response()->json(['errors' => ['root' => 'Your credentials not active']], 401);
        }

	    $credentials = request(['email', 'password']);

	    if (!$token = auth('api')->attempt($credentials)) {
	        return response()->json(['errors' => ['root' => 'Please check your username and password and try again!']], 401);
	    }
	    return response()->json([
			// 'success' => true,
	    	'data' => new StudentResource(auth('api')->user()),
	        'token' => $token,
	        'expires' => auth('api')->factory()->getTTL() * 60,
	    ]);


    }

	public function me(){
		return response()->json([
			// 'success' => true,
			'data' => new StudentResource(auth('api')->user()),
		]);
	}
	
    public function logout(){
        \Auth::guard('api')->logout();
		return response()->json([
			'success' => true,
		]);
    }
}
