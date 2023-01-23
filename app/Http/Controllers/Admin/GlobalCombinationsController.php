<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GlobalCombinations;
use App\Models\GlobalCombinationsVariations;
use App\Models\Masters;


class GlobalCombinationsController extends Controller{


    public function __construct(Request $request){
        $this->view_path = "admin.global_combinations";
        $this->default_pagination_limit = 12;
        $this->module_name = "Global combinations";
        $this->route_path = "admin.product_combinations";
        $this->master_type = $request['type'];
        $this->master_type_value = ucwords(str_replace('_' ,' ', $request['type']));
    }

    public function index(Request $request){

        /**  Setup pagination */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . ".index" )],
        ];
        populate_breadcrumb($breadcrumb);

        $dataToPass = GlobalCombinations::where(['is_deleted'=>0])->latest()->paginate($this->default_pagination_limit);
        $page_title = $this->module_name;
        $route_path = $this->route_path;
        $viewParams = [
            'dataToPass',
            'page_title',
            'route_path'
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

        $dataToPass = [];
        $masterData = Masters::where(['is_deleted'=>0])->groupBy('type')->pluck('type')->toArray();
        foreach ($masterData as $master_key => $master_value) {
            $dataToPass[$master_value] =  Masters::where(['is_deleted'=>0, 'type'=>$master_value])->get()->toArray();
        }

        if($request->post()){

            $data = $request->validate([
                'name' => 'required',
                'form_data.*.product_type' => 'required|numeric',
                'form_data.*.metal_types' => 'required|numeric',
                'form_data.*.price' => 'required|numeric|min:1|max:100',
            ],
            [
                'name.required' => 'Please enter name',
                'form_data.*.product_type.required' => 'Please select product type',
                'form_data.*.product_type.numeric' => 'Invalid product type',
                'form_data.*.metal_types.required' => 'Please select metal type',
                'form_data.*.metal_types.numeric' => 'Invalid metal type',
                'form_data.*.price.required' => 'Please enter price',
                'form_data.*.price.numeric' => 'Please enter valid price',
                'form_data.*.price.min' => 'Please enter price greater than 1',
                'form_data.*.price.max' => 'Please enter less than 100',
            ]);


            $slug = generateSlug($data['name'], GlobalCombinations::class, 'slug');

            $new_record = new GlobalCombinations();
            $new_record->name = $data['name'];
            $new_record->slug = $slug;
            if( $new_record->save() ){
                foreach ($data['form_data'] as $form_key => $form_value) {
                    $new_v  = new GlobalCombinationsVariations();
                    $new_v->global_combinations_id = $new_record->id;
                    $new_v->variations_id = json_encode($form_value);
                    $new_v->price = $form_value['price'];
                    $new_v->save();
                }
            }

            return redirect()->route($this->route_path. '.index')->with('success','Record has been added successfully');
        }

        return view($this->view_path. '.add', compact(['page_title','dataToPass']));
    }

    public function edit(Request $request){

        $page_title = "Edit " . $this->module_name;
        if(empty($request['slug'])){
            return redirect()->route($this->route_path . '.index')->with('error','Record not identified');
        }

        $data = GlobalCombinations::with(['variations'])->where('slug',$request['slug'] )->first()->toArray();
        $form_data = [];
        if(empty($data)){
            return redirect()->route($this->route_path . '.index')->with('error','Record not identified');
        }
        if(!empty($data['variations'])){
            foreach ($data['variations'] as $key => $value) {
                $data['form_data'][$key] = $value['variations_id'];
                $data['form_data'][$key]['id'] = $value['id'];
            }
        }

        $dataToPass = [];
        $masterData = Masters::where(['is_deleted'=>0])->groupBy('type')->pluck('type')->toArray();
        foreach ($masterData as $master_key => $master_value) {
            $dataToPass[$master_value] =  Masters::where(['is_deleted'=>0, 'type'=>$master_value])->get()->toArray();
        }

        /**  Setup pagination */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . ".index")],
            ["name" => "Edit ". $this->module_name , "url" => route($this->route_path . ".edit", ['slug' => $data['slug'] ]  )],
        ];
        populate_breadcrumb($breadcrumb);

        if($request->post()){
            $validated = $request->validate([
                'name' => 'required',
                'form_data.*.product_type' => 'required|numeric',
                'form_data.*.metal_types' => 'required|numeric',
                'form_data.*.price' => 'required|numeric|min:1|max:100',
                'form_data.*.id' => 'sometimes'
            ],
            [
                'name.required' => 'Please enter name',
                'form_data.*.product_type.required' => 'Please select product type',
                'form_data.*.product_type.numeric' => 'Invalid product type',
                'form_data.*.metal_types.required' => 'Please select metal type',
                'form_data.*.metal_types.numeric' => 'Invalid metal type',
                'form_data.*.price.required' => 'Please enter price',
                'form_data.*.price.numeric' => 'Please enter valid price',
                'form_data.*.price.min' => 'Please enter price greater than 1',
                'form_data.*.price.max' => 'Please enter less than 100',
            ]);
            
            $globalData = GlobalCombinations::where(['id'=> $data['id'] ])->first();
            $globalData->name = $request['name'];
            $globalData->save();

            $idsNotToDelete = [];

            foreach ($request['form_data'] as $form_data_key => $form_data_value) {

                if(!empty($form_data_value['id'])){
                    // Existing record
                    $variationRecord = GlobalCombinationsVariations::where('id',$form_data_value['id'] )->first();
                    $variationRecord->variations_id = json_encode($form_data_value);
                    $variationRecord->price = $form_data_value['price'];
                    $variationRecord->save();
                    array_push($idsNotToDelete, $variationRecord->id);

                }else{
                    $variationRecord  = new GlobalCombinationsVariations();
                    $variationRecord->global_combinations_id = $globalData->id;
                    $variationRecord->variations_id = json_encode($form_data_value);
                    $variationRecord->price = $form_data_value['price'];
                    $variationRecord->save();
                    array_push($idsNotToDelete, $variationRecord->id);
                    // New record
                }
            }
            
            GlobalCombinationsVariations::where('global_combinations_id',$globalData->id)->whereNotIn('id',$idsNotToDelete)->delete();

            return redirect()->route($this->route_path . '.index')->with('success','Record has been updated successfully');
        }

        return view($this->view_path. '.edit',compact(['data','page_title','dataToPass','data']));
    }

    public function status(Request $request){

        $response = [];

        $record = GlobalCombinations::where('slug', $request['slug'])->first();
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

    public function view(Request $request){

        $page_title = "View " . $this->module_name;
        if(empty($request['slug'])){
            return redirect()->route($this->route_path . '.index')->with('error','Record not identified');
        }

        $data = GlobalCombinations::with(['variations'])->where('slug',$request['slug'] )->first()->toArray();
        $form_data = [];
        if(empty($data)){
            return redirect()->route($this->route_path . '.index')->with('error','Record not identified');
        }
        if(!empty($data['variations'])){
            foreach ($data['variations'] as $key => $value) {
                $data['form_data'][$key] = $value['variations_id'];
                $data['form_data'][$key]['id'] = $value['id'];
            }
        }

        // $dataToPass = [];
        // $masterData = Masters::where(['is_deleted'=>0])->groupBy('type')->pluck('type')->toArray();
        // foreach ($masterData as $master_key => $master_value) {
        //     $dataToPass[$master_value] =  Masters::where(['is_deleted'=>0, 'type'=>$master_value])->get()->toArray();
        // }


        // prd($data);die;

        /**  Setup pagination */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . ".index")],
            ["name" => "View ". $this->module_name , "url" => route($this->route_path . ".view", ['slug' => $data['slug'] ]  )],
        ];
        populate_breadcrumb($breadcrumb);


        return view($this->view_path. '.view',compact(['data','page_title','data']));
    }

}



