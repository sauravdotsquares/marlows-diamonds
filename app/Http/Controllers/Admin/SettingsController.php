<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Providers\AppServiceProvider;

class SettingsController extends Controller
{
    public function index()
    {
    	$breadcrumb = [
            ["name" => "Settings", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
        
		
        return view('admin.settings.index');
        
    }
	public function update(Request $request){
		$request->request->remove('_token'); // to remove property from $request
		$input = $request->all();
		
		foreach($input as $key=>$value){
		
		if($key == 'logo'){
			if($request->hasFile('logo')) {
				$image = '';
				$uploadpath = public_path().'/images/logo';
				if (!empty($request->file('logo'))) {
					$image_prefix = 'logo_' . rand(0, 999999999) . '_' . date('d_m_Y_h_i_s');
					$ext = $request->file('logo')->getClientOriginalExtension();
					
					$image = $image_prefix . '.' . $ext;
					$request->file('logo')->move($uploadpath, $image);
				}
				$value = $image;
			}else{
				$value = $request->image_bk;
			}
		}
			$getData = Settings::updateOrCreate(['option_name'=>$key],[
				'option_name'=>$key,
				'option_value'=>$value,
			]);	
			
			app(AppServiceProvider::class)->clearSettingsCache();
		}
		
		
		
		return back()->withInput(array('msg' => 'Setting Updated Successfully'));
		
		
    }
	public function headerSetting()
    {
    	$breadcrumb = [
            ["name" => "Settings", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
        
		
        return view('admin.settings.headerSetting');
        
    }
	
	public function headerSettingUpdate(Request $request){
		$request->request->remove('_token'); // to remove property from $request
		$input = $request->all();
		
		foreach($input as $key=>$value){
		
			$getData = Settings::updateOrCreate(['option_name'=>$key],[
				'option_name'=>$key,
				'option_value'=>$value,
			]);	
			

		}

					app(AppServiceProvider::class)->clearSettingsCache();
		
		
		
		return back()->withInput(array('msg' => 'Setting Updated Successfully'));
		
		
    }
	public function footerSetting()
    {
    	$breadcrumb = [
            ["name" => "Settings", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
        
		
        return view('admin.settings.footerSetting');
        
    }
	
	public function footerSettingUpdate(Request $request){
		$request->request->remove('_token'); // to remove property from $request
		$input = $request->all();
		
		foreach($input as $key=>$value){
		
			$getData = Settings::updateOrCreate(['option_name'=>$key],[
				'option_name'=>$key,
				'option_value'=>$value,
			]);	
			
		}
		app(AppServiceProvider::class)->clearSettingsCache();
		
		
		return back()->withInput(array('msg' => 'Setting Updated Successfully'));
		
		
    }
}
