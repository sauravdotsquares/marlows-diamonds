<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\SlugController;
use Illuminate\Http\Request;
use App\Models\FaqCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Str;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            ["name" => "Faqs", "url" => route("admin.faqcategories"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
		$faqcategories = FaqCategory::all();
		return view('admin.faqcategories.index', compact('faqcategories'));
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $breadcrumb = [
            ["name" => "Add Faq", "url" => route("admin.faqcategories"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
        $faqcategories = FaqCategory::all();
		return view('admin.faqcategories.create',compact('faqcategories'));
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
        ]);
        
		
		// dd($input);
		// echo "<pre>";
		// print_r($input);
		// die;

        FaqCategory::create($input);

        return redirect()->action('Admin\FaqCategoryController@index')->with('alert-success', 'Faq Category Added Successfully');
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
		
		$faqcategories = FaqCategory::find($id);
		if (empty($faqs)) {
            return 'URL NOT FOUND';
        }
        $faqcategories = FaqCategory::find($id);
		//dd($faqs );
        return view('admin.faqcategories.edit',compact('faqcategories'));
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

        $faqcategories = FaqCategory::findOrFail($id);

        if (empty($faqcategories)) {
            return 'URL NOT FOUND';
        }
		$input = $request->all();
		$request->validate([
            'title' => 'required|max:255',
            
		]);
		
        $faqcategories->fill($input)->save();

        return redirect()->action('Admin\FaqCategoryController@index')->with('alert-success', 'Category Updated Successfully');
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($faqid) {
        $id = base64_decode($faqid);
        FaqCategory::find($id)->delete(); 
		return redirect()->action('Admin\FaqCategoryController@index')->with('alert-success', 'Category Deleted Successfully');
    }
	
	
}

