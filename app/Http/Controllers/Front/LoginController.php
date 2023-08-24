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
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /**
     * Display Records
     *
     * @return void
     */
    public function index()
    {
        if (auth()->guard('customer')->check()) {
            return redirect(route('my_accounts'));
        }
        return view('front.loginpages.loginpage');
    }

    /**
     * Register Customer function
     *
     * @param Request $request
     * @return void
     */
    public function registerCustomer(Request $request)
    {
        $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required',
        ]);
        unset($request['_token']);

        $getRegisterResponse = $this->registerFrontEndUsers($request->all(''));

        if (isset($getRegisterResponse) && !empty($getRegisterResponse)) {
            $getLoginResponse = $this->loginFrontPageFunction($request->all(''));
            if (isset($getLoginResponse) && $getLoginResponse) {
                return redirect(route('my_accounts'));
            }
            $msg = "Incorrect login credentials";
        } else {
            $msg = "Please fill required parameter";
        }

        $request->session()->flash('error', $msg);
        return redirect(route('my-account'));
    }

    /**
     * Login Customer Function
     *
     * @param Request $request
     * @return void
     */
    public function loginCustomer(Request $request)
    {
        $request->validate([
            'login_email' => 'required|max:255',
            'login_password' => 'required',
        ]);
        unset($request['_token']);
        $getActiveResponse = $this->checkEmailActiveFunction($request->login_email);
        if (isset($getActiveResponse) && $getActiveResponse) {
            $userDetails = [
                'email' => $request->login_email,
                'password' => $request->login_password,
            ];
            $getLoginResponse = $this->loginFrontPageFunction($userDetails);
            if (isset($getLoginResponse) && $getLoginResponse) {
                if ($request->ajax()) {
                    return response()->json(['status' => 200, 'success' => 'success']);
                }
                return redirect(route('my_accounts'));
            }
        }
        $request->session()->flash('error', "Incorrect login credentials");
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
        Auth::guard('customer')->logout();
        return redirect(route('my-account'));
    }

    /**
     * Dashboard Page function
     *
     * @param Request $request
     * @return void
     */
    public function dashboardPage(Request $request)
    {
        if (Auth::check()) {
            $getUserDetails = $getUsersDetails = User::with('getCustomerAddressFunction')->where('id', Auth::guard('customer')->user()->id)->first();
            $getCountries = Country::get();

            return view('front.loginpages.dashboardpage', compact('getUserDetails', 'getCountries'));
        }
    }

    /**
     * Change Customer User Address Functions
     *
     * @param Request $request
     * @return void
     */
    public function changeCustomerUserAddress(Request $request)
    {
        if (auth()->guard('customer')->check()) {
            $getCustomerAddress = CustomerAddress::where('user_id', Auth::guard('customer')->user()->id)->first();
            if ($getCustomerAddress) {
                $getCustomerAddress->user_id = Auth::guard('customer')->user()->id;
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
            } else {
                $getCustomerAddress = new CustomerAddress;
                $getCustomerAddress->user_id = Auth::guard('customer')->user()->id;
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

    /**
     * Changes customer Account Details Function
     *
     * @param Request $request
     * @return void
     */
    public function changeCustomerAccountDetails(Request $request)
    {
        if (isset($request->old_password) && isset($request->new_password) && isset($request->confirm_password)) {
            $this->validate($request, [
                'old_password'     => 'required',
                'new_password'     => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
            ]);

            $data = $request->all();

            if (!\Hash::check($data['old_password'], Auth::guard('customer')->user()->password)) {

                return back()->with('error', 'You have entered wrong password');
            } else {
                User::where('email', Auth::guard('customer')->user()->email)->update([
                    'name' => $request->name,
                    'nicename' => $request->nicename,
                    'password' => Hash::make($request->new_password),
                ]);
                // here you will write password update code
                return back()->with('success', 'You have successfully updated account details');
            }
        } else {
            User::where('email', Auth::guard('customer')->user()->email)->update([
                'name' => $request->name,
                'nicename' => $request->nicename,
            ]);
            // here you will write password update code
            return back()->with('success', 'You have successfully updated account details');
        }
    }

    /**
     * Get Order Details Functions
     *
     * @param Request $request
     * @return void
     */
    public function getOrderDetails(Request $request)
    {
        $getOrderDetails = Order::with('getOrderDetailsFunction')->whereNotNull('custom_order_id')->latest()->where('user_id', Auth::guard('customer')->user()->id)->get();

        if (count($getOrderDetails)) {
            $view = view('front.ajax.user-order-list', compact('getOrderDetails'))->render();
            return response()->json(['html' => $view]);
        }
    }

    /**
     * Get Order Details Page
     *
     * @param Request $request
     * @return void
     */
    public function getOrderDetailsPage(Request $request)
    {
        $getOrderDetails = Order::with('getOrderDetailsFunction')->where('token', $request->token)->first();

        if ($getOrderDetails) {
            $view = view('front.ajax.user-order-details', compact('getOrderDetails'))->render();
            return response()->json(['html' => $view]);
        }
        return response()->json(['html' => '']);
    }

    /**
     * Register Frontend users
     *
     * @param [type] $userDetails
     * @return void
     */
    function registerFrontEndUsers($userDetails)
    {
        if (isset($userDetails['email'])) {
            $getInsertedDetails = User::updateOrCreate(['email' => $userDetails['email']], [
                'name' => 'customer',
                'email' => $userDetails['email'],
                'username' => isset($userDetails['username']) ? $userDetails['username'] : 'customer',
                'password' => bcrypt(isset($userDetails['password']) ? $userDetails['password'] : '123456789'),
                'nicename' => 'Customers',
                'user_role' => 3,
                'is_active' => 1
            ]);
            return $getInsertedDetails;
        }
        return false;
    }

    /**
     * Login Frontend Page function
     *
     * @param [type] $userDetails
     * @return void
     */
    public function loginFrontPageFunction($userDetails)
    {
        if (Auth::guard('customer')->attempt($userDetails)) {
            if (Auth::attempt($userDetails, true)) {
                Auth::guard('customer')->login(Auth::user(), true);
                return true;
            }
        }

        return false;
    }

    /**
     * Check email activation functions
     *
     * @param [type] $email
     * @return void
     */
    function checkEmailActiveFunction($email)
    {

        $userActive = DB::table('users')
            ->where('email', $email)
            ->where('is_active', 1)
            ->first();

        if (isset($userActive) &&  !empty($userActive)) {
            return true;
        }
        return false;
    }
}
