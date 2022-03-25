<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $getData = User::where('user_role',3)->latest()->get();
        $breadcrumb = [
            ["name" => "Dashboard", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Users", "url" => route("admin.users"), "icon" => "fa fa-users"],

        ];
        populate_breadcrumb($breadcrumb);

        $result = [
            'getData'=>$getData,
        ];
        return view('admin.users.index',$result);
    }
}
