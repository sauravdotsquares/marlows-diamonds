<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menus;

class MenuController extends Controller
{
    public function index()
    {
    	$breadcrumb = [
            ["name" => "Menus", "url" => route("admin.menus"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
        return view('admin.menus');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request){
    	$data = $request->all();
    	$data_array = json_decode($data['out']);
    	//echo '<pre>'; print_r($data_array);
    	Menus::truncate();
    	foreach ($data_array as $key => $value) {
    		
    		$menus = new Menus();
	        $menus->title = $value->text;
	        $menus->slug = $value->href;
	        $menus->icon = $value->icon;
	        $menus->target = $value->target;
	        $menus->tooltip = $value->title;
	        $menus->save();
	        
	        $menusId = $menus->id;
	     

    		if(isset($value->children) && count($value->children)>0){
    			foreach ($value->children as $key1 => $value1) {
		    		
		    		$menus1 = new Menus();
			        $menus1->parent = $menusId;
			        $menus1->title = $value1->text;
			        $menus1->slug = $value1->href;
			        $menus1->icon = $value1->icon;
			        $menus1->target = $value1->target;
			        $menus1->tooltip = $value1->title;
			        $menus1->save();
			        
			        $menusId1 = $menus1->id;

		    		if(isset($value1->children) && count($value1->children)>0){
		    			foreach ($value1->children as $key2 => $value2) {

				    		$menus2 = new Menus();
					        $menus2->parent = $menusId1;
					        $menus2->title = $value2->text;
					        $menus2->slug = $value2->href;
					        $menus2->icon = $value2->icon;
					        $menus2->target = $value2->target;
					        $menus2->tooltip = $value2->title;
					        $menus2->save();
					        
					        $menusId2 = $menus2->id;
				    		
				    	} 
		    		}

		    	} 
    		}

    	}
    	return redirect()->back()->with('status','Menus Successfully Updated.');
    }
}
