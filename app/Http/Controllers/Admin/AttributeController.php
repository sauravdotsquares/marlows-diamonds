<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;

class AttributeController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        
        $breadcrumb = [
            ["name" => "Attribute", "url" => route("admin.attributes"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
        ];

        populate_breadcrumb($breadcrumb);

		$query = Attribute::orderBy('id','DESC');
        $query = getFilter(Attribute::class,$query, $request->all());
       
        $attributes =  $query->paginate(10);
		return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $breadcrumb = [
            ["name" => "Add New attribute", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);

        $attribute = Attribute::all();
        return view('admin.attributes.create',compact('attribute'));
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
            'name' => 'required|max:255',
            'slug' => 'required',
            'values' => 'required',
        ]);

        $attribute = Attribute::create($input);

        return redirect()->action('Admin\AttributeController@index')->with('alert-success', 'Page Added Successfully');
    }

    /** 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($pageid=null){
        $breadcrumb = [
            ["name" => "Edit attribute", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
		
		$id = base64_decode($pageid);
		if ($id == '') {
            return 'URL NOT FOUND';
        }
		
		$pages = Attribute::find($id);
		if (empty($pages)) {
            return 'URL NOT FOUND';
        }
        return view('admin.attributes.edit',compact('pages'));
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

        $pages = Attribute::findOrFail($id);

        if (empty($pages)) {
            return 'URL NOT FOUND';
        }

        $input = $request->all();
		$request->validate([
            'name' => 'required|max:255',
            'slug' => 'required',
            'values' => 'required',
        ]);

        $pages->fill($input)->save();

        return redirect()->action('Admin\AttributeController@index')->with('alert-success', 'Page Updated Successfully');
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $pageid) {

        $id = base64_decode($pageid);
        
        $record = Attribute::where('id', $id)->first();
        if(!empty($record)){

            if(!empty($request['revert']) && $request['revert']=='true'){
                $record->is_deleted = 0;
                $message = "Page restored from trash";
            }else{
                $record->is_deleted = 1;
                $message = 'Page Deleted Successfully';
            }

            $record->save();
        }

		return redirect()->action('Admin\AttributeController@index')->with('success',$message );
    }
	 /**
     * Status
     */
	public function status($ids,$status) { 

        $ids = base64_decode($ids);       
        $pages =  Attribute::find($ids);
        if (empty($pages)) {
            return 'URL NOT FOUND';
        }

        $input['status'] = $status;
        unset($input['_token']);
        
        $pages->fill($input)->save();

        return redirect()->action('Admin\AttributeController@index')->with('alert-success', 'Page Status Updated Successfully');
    }
}
