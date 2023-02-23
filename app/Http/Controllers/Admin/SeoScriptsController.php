<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeoScripts;

class SeoScriptsController extends Controller{
    

    public function __construct(){
        $this->view_path = "admin.seo_scripts.";
    }

    /**
     * List all items
     */
    public function list(Request $request){
        
        
        // $data = get_ip_info("Visitor");
        // prd($data);

        $page_title = "Seo Scripts";
        $breadcrumb = [
            ["name" => "Home", "url" => url('/admin'), "icon" => ""],
            ["name" => "Seo Scripts", "url" => route("admin.seo_scripts.list"), "icon" => ""],
        ];
        populate_breadcrumb($breadcrumb);

        $query = SeoScripts::where(['is_deleted'=>0]);

        $query = getFilter(SeoScripts::class, $query, $request->all());

        $data = $query->paginate(10);

        return view($this->view_path . 'list', compact(['page_title','data']));
    }//endof list

    /**
     * Add a new record
     */
    public function add(Request $request){
        $page_title = "Seo Scripts";
        $breadcrumb = [
            ["name" => "Home", "url" => url('/admin'), "icon" => ""],
            ["name" => "Seo Scripts", "url" => route("admin.seo_scripts.list"), "icon" => ""],
            ["name" => "Add", "url" => route("admin.seo_scripts.add"), "icon" => ""],
        ];
        populate_breadcrumb($breadcrumb);

        if($request->isMethod('post')){
            $validated = $request->validate([
                'page' => 'required',
                'header_script' => 'required_without_all:footer_script',
                'footer_script' => 'required_without_all:header_script',
            ],[
                'page.required' => 'Please enter page url',
                'header_script.required_without_all' => 'Please type scripts for header or footer',
                'footer_script.required_without_all' => 'Please type scripts for header or footer',
            ]);

            $record = new SeoScripts();
            $record->page = $validated['page'];
            $record->header_script = $validated['header_script'];
            $record->footer_script = $validated['footer_script'];
            $record->save();
            return redirect()->route('admin.seo_scripts.list')->with('success','Script added successfully');
        }

        return view($this->view_path . 'add');
    }//endof add

    /**
     * Edit a record
     */
    public function edit(Request $request){

        $record = SeoScripts::where('id', $request['id'])->first();
        if(!empty($record)){

            $page_title = "Seo Scripts";
            $breadcrumb = [
                ["name" => "Home", "url" => url('/admin'), "icon" => ""],
                ["name" => "Seo Scripts", "url" => route("admin.seo_scripts.list"), "icon" => ""],
                ["name" => "Edit", "url" => route("admin.seo_scripts.edit", $record->id), "icon" => ""],
            ];
            populate_breadcrumb($breadcrumb);

            if($request->isMethod('post')){
                $validated = $request->validate([
                    'page' => 'required|url',
                    'header_script' => 'required_without_all:footer_script',
                    'footer_script' => 'required_without_all:header_script',
                ],[
                    'page.required' => 'Please enter page url',
                    'header_script.required_without_all' => 'Please type scripts for header or footer',
                    'footer_script.required_without_all' => 'Please type scripts for header or footer',
                ]);
    
                $record->page = $validated['page'];
                $record->header_script = $validated['header_script'];
                $record->footer_script = $validated['footer_script'];
                $record->save();
                return redirect()->route('admin.seo_scripts.list')->with('success','Script has been updated successfully');
            }



            return view($this->view_path . 'edit',compact(['record']));
        }
        return redirect()->route('admin.seo_scripts.list')->with('error', 'Record not identified');
    }//endof edit

    /**
     * change status of record
     */
    public function changeStatus(Request $request){
        $record = SeoScripts::where('id', $request['id'])->first();
        if(!empty($record)){
            $record->is_active = $record->is_active ? 0 : 1;
            $record->save();
            return redirect()->route('admin.seo_scripts.list')->with('success', 'Status has been updated successfully');
        }
        return redirect()->route('admin.seo_scripts.list')->with('error', 'Record not identified');
    }//endof changeStatus

    /**
     * Delete a record
     */
    public function delete(Request $request){
        $record = SeoScripts::where('id', $request['id'])->first();
        if(!empty($record)){
            $record->is_deleted = 1;
            $record->save();
            return redirect()->route('admin.seo_scripts.list')->with('success', 'Record has been deleted successfully');
        }
        return redirect()->route('admin.seo_scripts.list')->with('error', 'Record not identified');
    }//endof delete


    /**
     * Edit a record
     */
    public function view(Request $request){

        $record = SeoScripts::where('id', $request['id'])->first();
        if(!empty($record)){

            $page_title = "Seo Scripts";
            $breadcrumb = [
                ["name" => "Home", "url" => url('/admin'), "icon" => ""],
                ["name" => "Seo Scripts", "url" => route("admin.seo_scripts.list"), "icon" => ""],
                ["name" => "View", "url" => route("admin.seo_scripts.view", $record->id), "icon" => ""],
            ];
            populate_breadcrumb($breadcrumb);

            return view($this->view_path . 'view',compact(['record']));
        }
        return redirect()->route('admin.seo_scripts.list')->with('error', 'Record not identified');
    }//endof edit

}
