<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Enquiries;

use URL;
class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            ["name" => "Enquiries", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
		$enquiries = Enquiries::all();
		return view('admin.enquiries.index', compact('enquiries'));
		
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($enquiryid=null){
        $breadcrumb = [
            ["name" => "Edit Review", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
		
		$id = base64_decode($enquiryid);
		if ($id == '') {
            return 'URL NOT FOUND';
        }
		
		$enquiries = Enquiries::find($id);
		if (empty($enquiries)) {
            return 'URL NOT FOUND';
        }
        $enquiries = Enquiries::find($id);
		//dd($enquiries );
        return view('admin.enquiries.edit',compact('enquiries'));
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $enquiryid) {
        
		$id = base64_decode($enquiryid);
        if ($id == '') {
            return 'URL NOT FOUND';
        }

        $enquiries = Enquiries::findOrFail($id);

        if (empty($enquiries)) {
            return 'URL NOT FOUND';
        }

       

        $input = $request->all();
		$request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            
			
        ]);
		
        $enquiries->fill($input)->save();

        return redirect()->action('Admin\EnquiryController@index')->with('alert-success', 'Review Updated Successfully');
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($enquiryid) {
        $id = base64_decode($enquiryid);
        Enquiries::find($id)->delete(); 
		return redirect()->action('Admin\EnquiryController@index')->with('alert-success', 'Review Deleted Successfully');
    }
	
}
