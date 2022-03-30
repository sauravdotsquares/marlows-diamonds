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
        $getData =  Menus::orderBy('id')->get()->toArray();
        $menusArray = array();
        if(count($getData)>0){
        	foreach ($getData as $key => $value) {

        		$_id = $value['id']; 
        		if($value['parent']==0){
        			
        			$arrayChild = array();
        			foreach ($getData as $key1 => $value1) {
	        			if($value1['parent']!=0 && $_id==$value1['parent']){

	        				

	        				$arrayChild1 = array();
		        			foreach ($getData as $key2 => $value2) {
			        			if($value2['parent']!=0 && $value1['id']==$value2['parent']){

			        				$arrayChild1[] = array('text'=>$value2['title'],'href'=>$value2['slug'],'icon'=>$value2['icon'],'target'=>$value2['target'],'title'=>$value2['tooltip']);
			        				
			        			}
			        		}

			        		$arrayChild[] = array('text'=>$value1['title'],'href'=>$value1['slug'],'icon'=>$value1['icon'],'target'=>$value1['target'],'title'=>$value1['tooltip'],'children'=>$arrayChild1);
	        			}
	        		}

	        		$menusArray[] = array('text'=>$value['title'],'href'=>$value['slug'],'icon'=>$value['icon'],'target'=>$value['target'],'title'=>$value['tooltip'],'children'=>$arrayChild);
	        		
        		}
        	}
        }
        $data = json_encode($menusArray);
        //echo '<pre>'; print_r($menusArray);
        //dd($getData);
        return view('admin.menus',compact('data'));
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
    	foreach ($data_array as $key => $value) { // Level 1
    		// Save the date for level 1
    		$menus = new Menus();
	        $menus->title = $value->text;
	        $menus->slug = $value->href;
	        $menus->icon = $value->icon;
	        $menus->target = $value->target;
	        $menus->tooltip = $value->title;
	        $menus->save();
	        
	        $menusId = $menus->id;
	     

    		if(isset($value->children) && count($value->children)>0){
    			foreach ($value->children as $key1 => $value1) { // Level 2
		    		// Save the date for level 2 
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
		    			foreach ($value1->children as $key2 => $value2) { // Level 3
		    				// Save the date for level 3
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
