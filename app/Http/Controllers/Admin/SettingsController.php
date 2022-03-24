<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    public function index()
    {
    	$breadcrumb = [
            ["name" => "Settings", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
        
		$settings = Settings::all();
        return view('admin.settings.index',compact('settings'));
        
    }
	public function update(Request $request){
		$input = $request->all();
		
		//print_r($input);
		
		foreach($request->option_value as $id=>$option_value){
			// echo "<pre>";
		// print_r($option_value[0]);
		// die;
			Settings::where('id',$id)->update(['option_value'=>$option_value[0]]);
			
			
		}
		return back()->withInput(array('msg' => 'Setting Updated Successfully'));
    }
}
