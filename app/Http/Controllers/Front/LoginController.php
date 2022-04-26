<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            return view('front.loginpages.dashboardpage');
        }
        return view('front.loginpages.loginpage');
    }

    public function getLoginRegisterAccount(Request $request)
    {

        $getUserExists = User::where('email',$request->email)->first();
        $details = $request->only('email', 'password');
        $details['is_active'] = 1;

        echo "<pre>";
        print_r($getUserExists);
        die;
        if(isset($getUserExists) && !empty($getUserExists)){
            $getLoginResponse = $this->login($details);
            return response()->json(['error'=>'Email id is found please login']);
        }

        if(isset($request->email) && isset($request->password)){
            $getRegisterResponse = $this->register($details);
            if(isset($getRegisterResponse) && !empty($getRegisterResponse)){
                $getLoginResponse = $this->login($details);
            }
        }
        return response()->json(['error'=>'Email and password is required']);
    }

    public function register($userDetails){

        if(isset($request->email) && isset($request->password)){
            $getInsertedDetails = User::create([
                'name' => 'customer',
                'email' => $request->email,
                'username' => isset($request->username)?$request->username:'customer',
                'password' => bcrypt($request->password),
                'nicename' => 'Customers',
                'user_role' => 3,
                'is_active' => 1
            ]);
            return true;
        }else{
            return false;
        }
    }

    public function login($userDetails){
        // echo "login<pre>";
        // print_r($userDetails);
        // die;

        if (auth()->guard('customer')->attempt($details)) {
            if(Auth::attempt($details, true)){
                Auth::login(Auth::user(), true);
                return true;
                // return response()->json(['success'=>'true']);
            }
        }else{
            return false;
        }
    }

}