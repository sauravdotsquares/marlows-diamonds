<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menus;
use App\Providers\AppServiceProvider;

class MenuController extends Controller
{
    public function index()
    {
    	$breadcrumb = [
            ["name" => "Menus", "url" => route("admin.menus"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
        $getData =  Menus::where('parent',0)->orderBy('id')->get()->toArray();
        $menusArray = array();
        if(count($getData)>0){
        	foreach ($getData as $key => $value) {

        		
        		$menusArray[$key]['text'] = $value['title']; 
                $menusArray[$key]['href'] = $value['slug'];
                $menusArray[$key]['icon'] = $value['icon'];
                $menusArray[$key]['target'] = $value['target'];
                $menusArray[$key]['title'] = $value['tooltip'];
    			
                $child = $this->getChildData($value['id'], 0);
                if(count($child)>0){
                    $menusArray[$key]['children'] = $child;
                }
        		
        	}
        }
        $data = json_encode($menusArray);
        //echo '<pre>'; print_r($menusArray);
        //dd($getData);
        return view('admin.menus',compact('data'));
    }

    public function getChildData($parent_id, $level){

    	$getData =  Menus::where('parent',$parent_id)->orderBy('id')->get()->toArray();
    	$menusArray = array();
    	$level++;
		foreach ($getData as $key => $value) {
			$menusArray[$key]['text'] = $value['title']; 
            $menusArray[$key]['href'] = $value['slug'];
            $menusArray[$key]['icon'] = $value['icon'];
            $menusArray[$key]['target'] = $value['target'];
            $menusArray[$key]['title'] = $value['tooltip'];

            $child = $this->getChildData($value['id'], $level);
            if(count($child)>0){
                $menusArray[$key]['children'] = $child;
            }
		}
		return $menusArray;
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
    	//echo '<pre>'; print_r($data_array); die;
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
	     	
	     	$this->saveChildData($value,$menusId, 0);

    	}
		app(AppServiceProvider::class)->clearMenuCache();
    	return redirect()->back()->with('status','Menus Successfully Updated.');
    }

    public function saveChildData($data, $parentId, $level){
    	$level++;
    	if(isset($data->children) && count($data->children)>0){
    		foreach ($data->children as $key => $value) { // Level 2
	    		// Save the date for level 2 
	    		$menus = new Menus();
	    		$menus->parent = $parentId;
		        $menus->title = $value->text;
		        $menus->slug = $value->href;
		        $menus->icon = $value->icon;
		        $menus->target = $value->target;
		        $menus->tooltip = $value->title;
		        $menus->save();
		        
		        $menusId = $menus->id;

		        $this->saveChildData($value,$menusId, $level);
		    }
    	}
    }
}
