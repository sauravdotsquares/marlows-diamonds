<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            return view('front.loginpages.dashboardpage');
        }
        return view('front.loginpages.loginpage');
    }
}