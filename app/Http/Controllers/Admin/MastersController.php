<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masters;

class MastersController extends Controller{


    public function __construct(Request $request){
        $this->view_path = "admin.masters";
        $this->default_pagination_limit = 12;
        $this->module_name = "Masters";
        $this->route_path = "admin.masters";
        $this->master_type = $request['type'];
        $this->master_type_value = ucwords(str_replace('_' ,' ', $request['type']));
    }

    public function index(Request $request){

        /**  Setup pagination */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . ".index", [ 'type'=> $this->master_type]  )],
        ];
        populate_breadcrumb($breadcrumb);

        $dataToPass = Masters::where(['is_deleted'=>0, 'type'=> $this->master_type])->latest()->paginate($this->default_pagination_limit);
        $masterType = $this->master_type;
        $page_title = $this->module_name;
        $viewParams = [
            'dataToPass',
            'masterType',
            'page_title'
        ];

        return view($this->view_path. '.list', compact($viewParams));
    }

    public function add(Request $request){
        $page_title = "Add " . $this->module_name;
        /**  Setup pagination */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . ".index", [ 'type'=> $this->master_type]  )],
            ["name" => "Add ". $this->module_name , "url" => route($this->route_path . ".add", [ 'type'=> $this->master_type]  )],
        ];
        populate_breadcrumb($breadcrumb);


        $parentData = Masters::where(['parent_id'=>null])->get();

        if($request->post()){

            $data = $request->validate([
                'name' => 'required',
                'value' => 'required',
                'parent_id' => 'sometimes'
            ]);
            $slug = generateSlug($data['name'], Masters::class, 'slug');

            $new_master_record= new Masters();
            $new_master_record->name = $data['name'];
            $new_master_record->type = $this->master_type;
            $new_master_record->value = $data['value'];
            $new_master_record->slug = $slug;
            $new_master_record->parent_id = !empty($data['parent_id']) ? $data['parent_id'] : null ;
            $new_master_record->save();
            return redirect()->route('admin.masters.index',['type'=>$this->master_type ])->with('success','Record has been added successfully');
        }

        return view($this->view_path. '.add', compact(['page_title','parentData']));
    }

    public function edit(Request $request){

        $page_title = "Edit " . $this->module_name;
        if(empty($request['slug'])){
            return redirect()->route('admin.masters.index',['type'=>$this->master_type ])->with('error','Record not identified');
        }

        $data = Masters::where('slug',$request['slug'] )->first();
        if(empty($data)){
            return redirect()->route('admin.masters.index',['type'=>$this->master_type ])->with('error','Record not identified');
        }

        /**  Setup pagination */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . ".index", [ 'type'=> $this->master_type]  )],
            ["name" => "Edit ". $this->module_name , "url" => route($this->route_path . ".edit", [ 'type'=> $this->master_type , 'slug' => $data->slug ]  )],
        ];
        populate_breadcrumb($breadcrumb);

        $parentData = Masters::where(['parent_id'=>null])->get();

        if($request->post()){

            $validated = $request->validate([
                'name' => 'required',
                'value' => 'required',
                'parent_id' => 'sometimes'
            ]);

            $data->name = $validated['name'];
            $data->value = $validated['value'];
            $data->parent_id = !empty($validated['parent_id']) ? $validated['parent_id'] : null ;
            $data->save();
            return redirect()->route('admin.masters.index',['type'=>$this->master_type ])->with('success','Record has been updated successfully');
        }

        return view($this->view_path. '.edit',compact(['data','page_title','parentData']));
    }

    public function status(Request $request){

        $response = [];

        $record = Masters::where('slug', $request['slug'])->first();
        if(!empty($record)){
            $record->is_active =  $record->is_active ? 0 : 1;
            $record->save();
            $response['status'] = 'success';
            $response['message'] = 'Record updated successfully';
        }else{
            $response['status'] = 'error';
            $response['message'] = 'Record not identified';
        }

        if($request->ajax()){
            return response()->json($response);
        }else{
            return redirect()->back()->with($response['status'],$response['message']);
        }

    }

    public function delete(Request $request){

        return view($this->view_path. '.list');
    }

}