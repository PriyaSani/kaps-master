<?php

namespace App\Http\Controllers\Mr\auth;

use Hash;
use App\Model\MrDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = 'mr-panel/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    public function showResetForm(Request $request, $token = null)
    {
    	
        return view('mr_panel.auth.password.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
    
    //defining guard for admins

    public function resetPassword(Request $request){

    	$password = Hash::make($request->password);
    	$update_password = MrDetail::Where('email',$request->email)->update(['password' => $password]);

    	return redirect(route('mr.login'))->with('messages', [
	         [
	            'type' => 'success',
	            'title' => 'Password',
	            'message' => 'Mr Password Successfully Changed',
	        ],
        ]); 
    }
    protected function broker()
    {
        return Password::broker('mr');
    }

    protected function guard()
    {
        return Auth::guard('mr');
    }

}
