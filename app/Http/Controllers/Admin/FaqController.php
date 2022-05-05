<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Faqs;
use App\Models\FaqCategory;

use URL;
class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            ["name" => "Faqs", "url" => route("admin.faqs"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
		$faqs = Faqs::all();
		return view('admin.faqs.index', compact('faqs'));
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $breadcrumb = [
            ["name" => "Add Faq", "url" => route("admin.faqs"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
        // $faqs = Faqs::all();
		$faqcategories = FaqCategory::get();
        return view('admin.faqs.create',compact('faqcategories'));
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
       
		
		//dd($input);
		// echo "<pre>";
		// print_r($input);
		// die;

        $faqs = Faqs::create($input);

        return redirect()->action('Admin\FaqController@index')->with('alert-success', 'Faq Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($faqid=null){
        $breadcrumb = [
            ["name" => "Edit Faq", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
		
		$id = base64_decode($faqid);
		if ($id == '') {
            return 'URL NOT FOUND';
        }
		
		$faqs = Faqs::find($id);
		if (empty($faqs)) {
            return 'URL NOT FOUND';
        }
        $faqs = Faqs::find($id);
		//dd($faqs );
        return view('admin.faqs.edit',compact('faqs'));
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $faqid) {
        
		$id = base64_decode($faqid);
        if ($id == '') {
            return 'URL NOT FOUND';
        }

        $faqs = Faqs::findOrFail($id);

        if (empty($faqs)) {
            return 'URL NOT FOUND';
        }

       

        $input = $request->all();
		$request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
			
        ]);
		
        $faqs->fill($input)->save();

        return redirect()->action('Admin\FaqController@index')->with('alert-success', 'Faq Updated Successfully');
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($faqid) {
        $id = base64_decode($faqid);
        Faqs::find($id)->delete(); 
		return redirect()->action('Admin\FaqController@index')->with('alert-success', 'Faq Deleted Successfully');
    }
	 /**
     * Status
     */
	public function status($ids,$status) { 
        $ids = base64_decode($ids);       
        $faqs =  Faqs::find($ids);
        if (empty($faqs)) {
            return 'URL NOT FOUND';
        }

        $input['status'] = $status;
        unset($input['_token']);
        
        $faqs->fill($input)->save();

        return redirect()->action('Admin\FaqController@index')->with('alert-success', 'Faq Status Updated Successfully');
    }
}
