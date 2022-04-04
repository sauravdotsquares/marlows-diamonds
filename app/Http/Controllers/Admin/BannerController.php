<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Banners;
use App\Http\Controllers\Controller;
use App\Pages;
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


        $input = $request->all();
		 $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
			
        ]);
        if($request->hasFile('image')) {

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
                    $image_prefix = 'banner_' . rand(0, 999999999) . '_' . date('d_m_Y_h_i_s');
                    $ext = $request->file('image')->getClientOriginalExtension();
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
		
		//dd($input);

        $banners = Banners::create($input);
	
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
		
		$banners = Banners::find($id);
		if (empty($banners)) {
            return 'URL NOT FOUND';
        }
        $banners = Banners::find($id);
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

       

        $input = $request->all();
		$request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
			
        ]);
		/*image update*/
       if($request->hasFile('image')) {

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
                    $image_prefix = 'banner_' . rand(0, 999999999) . '_' . date('d_m_Y_h_i_s');
                    $ext = $request->file('image')->getClientOriginalExtension();
                    $image = $image_prefix . '.' . $ext;
                    //$image_array[] = $image;
                    $request->file('image')->move($uploadpath, $image);
                }
            //}
        }

        
       if(empty($image)){
			//$input['image'] = '';
		}
		else{
			
			$input['image'] = $image;
		}
        $banners->fill($input)->save();

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
}
