<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Banners;
use App\Models\BannerDetails;
use App\Http\Controllers\Controller;
use App\Models\Pages;
use URL;
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            ["name" => "Banners", "url" => route("admin.banners"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
		$banners = Banners::all();
		$pages = Pages::all();
		return view('admin.banners.index', compact('banners','pages'));
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $breadcrumb = [
            ["name" => "Add Banner", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
        $banners = Banners::all();
		$pages = Pages::all();
        return view('admin.banners.create',compact('banners','pages'));
	}
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request){


        $data = $request->all();
		
		 $request->validate([
            'title' => 'required|max:255',
            // 'description[]' => 'required',
            'status' => 'required',
			
        ]);
		$input = array();
		$input['page_id'] = $data['page_id'];
		$input['title'] = $data['title'];
		$input['status'] = $data['status'];
		
		$banners = Banners::create($input);
		
		if($banners->id !='' && count($data['description'] ) > 0)
		{
			$details = array();
			foreach($data['description'] as $key => $value)
			{
				$details['image'] = '';
				if($request->hasFile('image.'.$key)) {
				// echo "testingnn";
					// die;
					$image_array = [];
					$image = '';
					$uploadpath = public_path().'\images\banners';   
					$original_name = $request->file('image.'.$key)->getClientOriginalName();
					$image_prefix = 'banner_' . rand(0, 999999999) . '_' . date('d_m_Y_h_i_s');
					$ext = $request->file('image.'.$key)->getClientOriginalExtension();
					$image = $image_prefix . '.' . $ext;				
					$request->file('image.'.$key)->move($uploadpath, $image);
					$details['image'] = $image;
				}		
				$details['banner_id'] = $banners->id;
				$details['description'] = $value;
				BannerDetails::create($details);
				
			}	
		}
		return redirect()->action('Admin\BannerController@index')->with('alert-success', 'Banner Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($bannerid=null){
        $breadcrumb = [
            ["name" => "Edit Banner", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
		
		$id = base64_decode($bannerid);
		if ($id == '') {
            return 'URL NOT FOUND';
        }
		
		$banners = Banners::with('getBannerDetails')->find($id);
		if (empty($banners)) {
            return 'URL NOT FOUND';
        }
		
		$pages = Pages::all();
		//dd($banners );
        return view('admin.banners.edit',compact('banners','pages'));
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $bannerid) {
        
		$id = base64_decode($bannerid);
        if ($id == '') {
            return 'URL NOT FOUND';
        }

        $banners = Banners::findOrFail($id);

        if (empty($banners)) {
            return 'URL NOT FOUND';
        }

       

        $data = $request->all();
		$request->validate([
            'title' => 'required|max:255',
            // 'description[]' => 'required',
            'status' => 'required',
			
        ]);
		
		$input = array();
	   
		$banners->page_id = $data['page_id'];
		$banners->title = $data['title'];
		$banners->status = $data['status'];
		//dd($data['ids']);
        $banners->save();
		//dd(count($data['image']));
	 	if($banners->id !='' && count($data['description'] ) > 0)
		{
			$details = array();
			$arr_delete = array();
			
			//BannerDetails::where("banner_id", $id)->delete();
			
			foreach($data['description'] as $key => $value)
			{				
				 $image = $request->file('image.'.$key);
				// dd($data['ids'][$key]);
				
				 if ($image != null){ 
				//  dd($image);
					if($request->hasFile('image.'.$key) && isset($data['image'])) {
					
						$image_array = [];
						$image = '';
						$uploadpath = public_path().'\images\banners';   
						$original_name = $request->file('image.'.$key)->getClientOriginalName();
						$image_prefix = 'banner_' . rand(0, 999999999) . '_' . date('d_m_Y_h_i_s');
						$ext = $request->file('image.'.$key)->getClientOriginalExtension();
						$image = $image_prefix . '.' . $ext;				
						$request->file('image.'.$key)->move($uploadpath, $image);
						
						if(isset($data['ids'][$key]) && (!empty($data['ids']))){
							$banner_details =  BannerDetails::find($data['ids'][$key]); 
							$banner_details->banner_id =  $banners->id;
							$banner_details->image =  $image;
							$banner_details->description  = $value;
							// die($banner_details);
							 $banner_details->save();
						 }else{
							$details['image'] = $image;		
							$details['banner_id'] = $banners->id;
							$details['description'] = $value;
							BannerDetails::create($details);
						 }
							
							
						
					}
				 }else if(isset($data['ids'][$key]) && (!empty($data['ids']))){
					$banner_details =  BannerDetails::find($data['ids'][$key]); 
					$banner_details->banner_id =  $banners->id;
					$banner_details->description  = $value;
					// die($banner_details);
					 $banner_details->save();
				 }else{
					$details['banner_id'] = $banners->id;
					$details['description'] = $value;
					BannerDetails::create($details);
				 }
	
			}	
			
		} 
		return redirect()->action('Admin\BannerController@index')->with('alert-success', 'Banner Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($bannerid) {
        $id = base64_decode($bannerid);
        Banners::find($id)->delete(); 
		return redirect()->action('Admin\BannerController@index')->with('alert-success', 'Banner Deleted Successfully');
    }
	 /**
     * Status
     */
	public function status($ids,$status) { 
        $ids = base64_decode($ids);       
        $banners =  Banners::find($ids);
        if (empty($banners)) {
            return 'URL NOT FOUND';
        }

        $input['status'] = $status;
        unset($input['_token']);
        
        $banners->fill($input)->save();

        return redirect()->action('Admin\BannerController@index')->with('alert-success', 'Banner Status Updated Successfully');
    }
	
	public function deleteBannerImage($id){
	//dd($id);
		BannerDetails::find($id)->delete($id);	  
		return response()->json([
			'success' => 'Record deleted successfully!'
		]);
	}

}
