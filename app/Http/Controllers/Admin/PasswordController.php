<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function index()
    {
    	$breadcrumb = [
            ["name" => "Change Password", "url" => route("admin.change-password"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
        return view('admin.change-password');
    }
	
	public function changePassword(Request $request)
    {
        $oldPassword = $request->input('old_password');
        $newPassword = $request->input('new_password');
        $confirmPassword = $request->input('password_confirmation');
        
            if (!(Hash::check($request->get('old_password'), Auth::user()->password))) {
                // The passwords not matches
                
				return back()->withInput(array('msg' => 'Your current password does not matches with the password you provided'));
               
            }
            //uncomment this if you need to validate that the new password is same as old one
            if(strcmp($request->get('old_password'), $request->get('new_password')) == 0){
                //Current password and new password are same
                
                return back()->withInput(array('msg' => 'New Password cannot be same as your current password. Please choose a different password.'));
            }
            if(trim($request->get('password_confirmation')) != trim($request->get('new_password'))){
                //Current password and new password are same
               
                 return back()->withInput(array('msg' => 'New Password and confirm password should be same'));
            }
            $validatedData = $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|string|min:8',
            ]);
            $user = Auth::user();
            $user->password = Hash::make($request->get('new_password'));
            if ($user->save()) {
             
				return back()->withInput(array('msg' => 'Password has been changed successfully.'));
                
            } else {
                
				return back()->withInput(array('msg' => 'Password could not be changed, please try again'));
            }
        
    }
	
}
