<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Pages;
use App\Http\Controllers\Controller;
use File;

use URL;
class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            ["name" => "Pages", "url" => route("admin.pages"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
		$pages = Pages::all();
		return view('admin.pages.index', compact('pages'));
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $breadcrumb = [
            ["name" => "Dashboard", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);

        $templates = [];
        $files = File::allFiles(resource_path('views/front/pages/templates'));
        foreach ($files as $key => $value) {
             $explode = explode('.',$value->getfileName());
             $templates[$key]['value'] = $explode[0];
             $templates[$key]['name'] = ucwords(str_replace('_',' ',$explode[0]));
        }
     
        $pages = Pages::all();
        return view('admin.pages.create',compact('pages','templates'));
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
                $image = single_storage_image_upload($request->file('image'),'Post','1200','600');
            //}
        }
		
		if(empty($image)){
			$input['image'] = '';
		}
		else{
			
			$input['image'] = $image;
		}
		
		//dd($input);

        $pages = Pages::create($input);

        return redirect()->action('Admin\PageController@index')->with('alert-success', 'Page Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($pageid=null){
        $breadcrumb = [
            ["name" => "Dashboard", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
		
		$templates = [];
        $files = File::allFiles(resource_path('views/front/pages/templates'));
        foreach ($files as $key => $value) {
             $explode = explode('.',$value->getfileName());
             $templates[$key]['value'] = $explode[0];
             $templates[$key]['name'] = ucwords(str_replace('_',' ',$explode[0]));
        }
		
		$id = base64_decode($pageid);
		if ($id == '') {
            return 'URL NOT FOUND';
        }
		
		$pages = Pages::find($id);
		if (empty($pages)) {
            return 'URL NOT FOUND';
        }
        $pages = Pages::find($id);
		//dd($pages );
        return view('admin.pages.edit',compact('pages','templates'));
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $pageid) {
        
		$id = base64_decode($pageid);
        if ($id == '') {
            return 'URL NOT FOUND';
        }

        $pages = Pages::findOrFail($id);

        if (empty($pages)) {
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
                $image = single_storage_image_upload($request->file('image'),'Post','1200','600');
            //}
        }

        
       if(empty($image)){
			//$input['image'] = '';
		}
		else{
			
			$input['image'] = $image;
		}
        $pages->fill($input)->save();

        return redirect()->action('Admin\PageController@index')->with('alert-success', 'Page Updated Successfully');
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($pageid) {
        $id = base64_decode($pageid);
        Pages::find($id)->delete(); 
		return redirect()->action('Admin\PageController@index')->with('alert-success', 'Page Deleted Successfully');
    }
	 /**
     * Status
     */
	public function status($ids,$status) { 
        $ids = base64_decode($ids);       
        $pages =  Pages::find($ids);
        if (empty($pages)) {
            return 'URL NOT FOUND';
        }

        $input['status'] = $status;
        unset($input['_token']);
        
        $pages->fill($input)->save();

        return redirect()->action('Admin\PageController@index')->with('alert-success', 'Page Status Updated Successfully');
    }
}
