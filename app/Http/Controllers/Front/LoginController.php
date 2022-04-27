<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Session;

class LoginController extends Controller
{
    public function index()
    {   
        if(auth()->guard('customer')->check()){
            return redirect(route('my_accounts'));
        }
        return view('front.loginpages.loginpage');
    }

    public function getLoginRegisterAccount(Request $request)
    {
        
        $getUserExists = User::where('email',$request->email)->first();
        $details = $request->only('email', 'password');
        $details['is_active'] = 1;
        
        if(isset($getUserExists) && !empty($getUserExists)){
            $getLoginResponse = $this->login($details);
            if(isset($getLoginResponse) && $getLoginResponse){
                return response()->json(['status'=>200,'success'=>'success']);
            }else{
                return response()->json(['status'=>500,'error'=>'email or password not matched']);
            }
        }

        if(isset($request->email) && isset($request->password)){
            $getRegisterResponse = $this->register($details);
            if(isset($getRegisterResponse) && $getRegisterResponse){
                $getLoginResponse = $this->login($details);
                if(isset($getLoginResponse) && $getLoginResponse){
                    return response()->json(['status'=>200,'success'=>'success']);
                }else{
                    return response()->json(['status'=>500,'error'=>'email or password not matched']);
                }
            }
        }
        return response()->json(['error'=>'Email and password is required']);
    }

    public function register($userDetails){
        if(isset($userDetails['email']) && isset($userDetails['password'])){
            $getInsertedDetails = User::create([
                'name' => 'customer',
                'email' => $userDetails['email'],
                'username' => isset($userDetails['username'])?$userDetails['username']:'customer',
                'password' => bcrypt($userDetails['password']),
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
        if (auth()->guard('customer')->attempt($userDetails)) {
            if(Auth::attempt($userDetails, true)){
                Auth::login(Auth::user(), true);
                return true;
            }
        }else{
            return false;
        }
    }

    public function registerCustomer(Request $request)
    {
        unset($request['_token']);
        $getRegisterResponse = $this->register($request->all(''));

        if(isset($getRegisterResponse) && $getRegisterResponse == 1){
            $getLoginResponse = $this->login($request->all(''));

            if(isset($getLoginResponse) && $getLoginResponse == 1){
                return redirect(route('my_accounts'));
            }else{
                $msg = "Incorrect login credentials";
            }
        }else{
            $msg = "Please fill required parameter";
        }

        $request->session()->flash('error', $msg);
        return redirect(route('my-account'));
    }

    public function registerCheckoutCustomer($userDetails)
    {
        $getRegisterResponse = $this->register($userDetails);

        if(isset($getRegisterResponse) && $getRegisterResponse == 1){
            $getLoginResponse = $this->login($userDetails);
            if(isset($getLoginResponse) && $getLoginResponse == 1){
                return true;
            }
        }
        return false;
    }

    public function loginCustomer(Request $request)
    {
        unset($request['_token']);

        if(isset($request->email) && !empty($request->email) && isset($request->password) && !empty($request->password)){
            $getLoginResponse = $this->login($request->all(''));
            if(isset($getLoginResponse) && $getLoginResponse == 1){
                return redirect(route('my_accounts'));
            }else{
                $msg = "Incorrect login credentials";
            }
        }else{
            $msg = "Please fill required parameter";
        }
        $request->session()->flash('error', $msg);
        return redirect(route('my-account'));
    }


    /**
     * Log out account user.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $request->session()->flash('error', 'You have successfully logout');

        Session::flush();
        
        Auth::logout();

        return redirect(route('my-account'));
    }

    public function dashboardPage(Request $request)
    {
        return view('front.loginpages.dashboardpage');
    }

    public function checkEmailId(Request $request)
    {
        $checkEmail = User::where('email',$request->email)->count();

        return response()->json($checkEmail);
    }

}