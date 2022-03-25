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
        
		
        return view('admin.settings.index');
        
    }
	public function update(Request $request){
		$input = $request->all();
		// echo "<pre>";
		// print_r($input); die;
		
		foreach($request->option_value as $id=>$option_value){
			// echo "<pre>";
		// print_r($option_value[0]);
		// die;
			if($request->hasFile('logo')) {

            //$image_array = [];

            //foreach ($request->file('image') as $image) {
                
                $image = '';
                $uploadpath = public_path().'\images';
                //$original_name = $input['image']->getClientOriginalName();
				$original_name = $request->file('image')->getClientOriginalName();

                /*if (!$request->file('image')->isValid() || empty($uploadpath)) {
                    return $image;
                }*/
				//dd($input['image']);
                if (!empty($request->file('image'))) {
                    $image_prefix = 'logo_' . rand(0, 999999999) . '_' . date('d_m_Y_h_i_s');
                    $ext = $request->file('image')->getClientOriginalExtension();
					print_r()($ext);
					die;
                    $image = $image_prefix . '.' . $ext;
                    //$image_array[] = $image;
                    $request->file('image')->move($uploadpath, $image);
                }
            //}
        }
		if(empty($image)){
			$input['image'] = '';
		}
		else{
			
			$input['image'] = $image;
		}
			Settings::where('id',$id)->update(['option_value'=>$option_value[0]]);
			
			
		}
		
		return back()->withInput(array('msg' => 'Setting Updated Successfully'));
    }
}
