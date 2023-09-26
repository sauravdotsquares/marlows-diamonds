<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Popups;

use URL;
class PopupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            ["name" => "Popups", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
		$popups = Popups::all();
		return view('admin.popups.index', compact('popups'));
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $breadcrumb = [
            ["name" => "Add Popup", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
        $popups = Popups::all();
        return view('admin.popups.create',compact('popups'));
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
        
		$popups = Popups::create($input);

        return redirect()->action('Admin\PopupController@index')->with('alert-success', 'Popup Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($popupid=null){
        $breadcrumb = [
            ["name" => "Edit Popup", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
		
		$id = base64_decode($popupid);
		if ($id == '') {
            return 'URL NOT FOUND';
        }
		
		$popups = Popups::find($id);
		if (empty($popups)) {
            return 'URL NOT FOUND';
        }
        $popups = Popups::find($id);
		//dd($popups );
        return view('admin.popups.edit',compact('popups'));
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $popupid) {
        
		$id = base64_decode($popupid);
        if ($id == '') {
            return 'URL NOT FOUND';
        }

        $popups = Popups::findOrFail($id);

        if (empty($popups)) {
            return 'URL NOT FOUND';
        }

       

        $input = $request->all();
		$request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
			
        ]);
		
        $popups->fill($input)->save();

        return redirect()->action('Admin\PopupController@index')->with('alert-success', 'Popup Updated Successfully');
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($popupid) {
        $id = base64_decode($popupid);
        Popups::find($id)->delete(); 
		return redirect()->action('Admin\PopupController@index')->with('alert-success', 'Popup Deleted Successfully');
    }
	 /**
     * Status
     */
	public function status($ids,$status) { 
        $ids = base64_decode($ids);       
        $popups =  Popups::find($ids);
        if (empty($popups)) {
            return 'URL NOT FOUND';
        }

        $input['status'] = $status;
        unset($input['_token']);
        
        $popups->fill($input)->save();

        return redirect()->action('Admin\PopupController@index')->with('alert-success', 'Popup Status Updated Successfully');
    }
}
