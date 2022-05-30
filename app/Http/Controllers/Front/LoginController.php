<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\Order;
use Session;
use Hash;

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
        if(isset($userDetails['email'])){
            // echo "if";
            // die;
            $getInsertedDetails = User::create([
                'name' => 'customer',
                'email' => $userDetails['email'],
                'username' => isset($userDetails['username'])?$userDetails['username']:'customer',
                'password' => bcrypt(isset($userDetails['password'])?$userDetails['password']:'123456789'),
                'nicename' => 'Customers',
                'user_role' => 3,
                'is_active' => 1
            ]);
            return $getInsertedDetails;
        }

        return false;
    }

    public function login($userDetails){
        if(isset($userDetails['email'])){
            $getDetails = [
                'email'=>$userDetails['email'],
                'password'=>isset($userDetails['password'])?$userDetails['password']:'123456789',
            ];
        }
        if(isset($getDetails) && !empty($getDetails)){
            if(Auth::attempt($userDetails, true)){
                Auth::login(Auth::user(), true);
                $getUserId = User::where('email',$userDetails['email'])->first();
                return $getUserId;
            }
        }
        return false;
    }

    public function loginPageFunction($userDetails){
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
        // if(isset($getRegisterResponse) && $getRegisterResponse == 1){
        //     $getLoginResponse = $this->login($userDetails);
        //     return $getLoginResponse;
        // }
        return $getRegisterResponse;
    }

    public function loginCustomer(Request $request)
    {
        unset($request['_token']);

        if(isset($request->email) && !empty($request->email) && isset($request->password) && !empty($request->password)){
            $getLoginResponse = $this->loginPageFunction($request->all(''));
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
        $getUserDetails = $getUsersDetails = User::with('getCustomerAddressFunction')->where('id',Auth::user()->id)->first();
        $getCountries = Country::get();

        return view('front.loginpages.dashboardpage',compact('getUserDetails','getCountries'));
    }

    public function checkEmailId(Request $request)
    {
        $checkEmail = User::where('email',$request->email)->count();

        return response()->json($checkEmail);
    }

    public function changeCustomerUserAddress(Request $request)
    {
        if(auth()->guard('customer')->check()){
            $getCustomerAddress = CustomerAddress::where('user_id',Auth::user()->id)->first();
            if($getCustomerAddress){
                $getCustomerAddress->user_id = Auth::user()->id;
                $getCustomerAddress->order_id = 1;
                $getCustomerAddress->first_name = $request->first_name;
                $getCustomerAddress->last_name = $request->last_name;
                $getCustomerAddress->company_name = $request->company_name;
                $getCustomerAddress->country_id = $request->country_id;
                $getCustomerAddress->street_address_l1 = $request->street_address_l1;
                $getCustomerAddress->street_address_l2 = $request->street_address_l2;
                $getCustomerAddress->town_city = $request->town_city;
                $getCustomerAddress->state = $request->state;
                $getCustomerAddress->pin_code = $request->pin_code;
                $getCustomerAddress->mobile = $request->mobile;
                $getCustomerAddress->email = $request->email;
                $getCustomerAddress->order_notes = $request->order_notes;
                $getCustomerAddress->save();
            }else{
                $getCustomerAddress = new CustomerAddress;
                $getCustomerAddress->user_id = Auth::user()->id;
                $getCustomerAddress->order_id = 1;
                $getCustomerAddress->first_name = $request->first_name;
                $getCustomerAddress->last_name = $request->last_name;
                $getCustomerAddress->company_name = $request->company_name;
                $getCustomerAddress->country_id = $request->country_id;
                $getCustomerAddress->street_address_l1 = $request->street_address_l1;
                $getCustomerAddress->street_address_l2 = $request->street_address_l2;
                $getCustomerAddress->town_city = $request->town_city;
                $getCustomerAddress->state = $request->state;
                $getCustomerAddress->pin_code = $request->pin_code;
                $getCustomerAddress->mobile = $request->mobile;
                $getCustomerAddress->email = $request->email;
                $getCustomerAddress->order_notes = $request->order_notes;
                $getCustomerAddress->save();
            }
        }

        $request->session()->flash('success', "Successfully submitted...");
        return redirect()->back();
    }


    public function changeCustomerAccountDetails(Request $request)
    {
        if(isset($request->old_password) && isset($request->new_password) && isset($request->confirm_password)){
            $this->validate($request, [
                // 'username'     => 'required|unique:users',
                'old_password'     => 'required',
                'new_password'     => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
            ]);

            $data = $request->all();

            if(!\Hash::check($data['old_password'], auth()->user()->password)){

                return back()->with('error','You have entered wrong password');

            }else{
                User::where('email', auth()->user()->email)->update([
                    'name'=> $request->name,
                    'nicename'=> $request->nicename,
                    'password' => Hash::make($request->new_password),
                ]);
                // here you will write password update code
                return back()->with('success','You have successfully updated account details');
            }
        }else{
            User::where('email', auth()->user()->email)->update([
                'name'=> $request->name,
                'nicename'=> $request->nicename,
            ]);
            // here you will write password update code
            return back()->with('success','You have successfully updated account details');
        }
    }

    public function getOrderDetails(Request $request)
    {
        $getOrderDetails = Order::with('getOrderDetailsFunction')->whereNotNull('token')->latest()->where('user_id',Auth::user()->id)->get();

        if(count($getOrderDetails)){
            $view = view('front.ajax.user-order-list',compact('getOrderDetails'))->render();
            return response()->json(['html'=> $view]);
        }
    }

    public function getOrderDetailsPage(Request $request)
    {
        $getOrderDetails = Order::with('getOrderDetailsFunction')->where('token',$request->token)->first();

        if($getOrderDetails){
            $view = view('front.ajax.user-order-details',compact('getOrderDetails'))->render();
            return response()->json(['html'=> $view]);
        }
        return response()->json(['html'=> '']);
    }

}
