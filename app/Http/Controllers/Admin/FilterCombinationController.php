<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductFilter;
use App\Models\ProductFilterItems;
use App\Models\ProductVariations;
use App\Models\Category;
use App\Models\DiamondShapes;
use App\Models\Masters;

class FilterCombinationController extends Controller
{
    public function __construct(Request $request){
        $this->view_path = "admin.filter_combinations";
        $this->default_pagination_limit = 12;
        $this->module_name = "Filter combinations";
        $this->route_path = "admin.filter_master";
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

        $dataToPass = ProductFilter::where(['is_deleted'=>0])->latest()->paginate($this->default_pagination_limit);
        $page_title = $this->module_name;
        $route_path = $this->route_path;
        $viewParams = [
            'dataToPass',
            'page_title',
            'route_path'
        ];

        // prd($route_path);

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
        // prd($dataToPass);
        if($request->post()){
            // prd($request->all());
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

            if(isset($data['slug']) && !empty($data['slug'])){
                $slug = $data['slug'];
            }else{
                $slug = generateSlug($data['name'], ProductFilter::class, 'slug');
            }


            $new_record = new ProductFilter();
            $new_record->name = $data['name'];
            $new_record->slug = $slug;
            if( $new_record->save() ){
                // foreach ($data['form_data'] as $form_key => $form_value) {
                //     $new_v  = new GlobalCombinationsVariations();
                //     $new_v->global_combinations_id = $new_record->id;
                //     $new_v->variations_id = json_encode($form_value);
                //     $new_v->price = $form_value['price'];
                //     $new_v->save();
                // }
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

        $data = ProductFilter::where('slug',$request['slug'])->first();

        $form_data = [];
        if(empty($data)){
            return redirect()->route($this->route_path . '.index')->with('error','Record not identified');
        }
        // if(!empty($data['variations'])){
        //     foreach ($data['variations'] as $key => $value) {
        //         $data['form_data'][$key] = $value['variations_id'];
        //         $data['form_data'][$key]['id'] = $value['id'];
        //     }
        // }
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
            // echo "In the post";
            // prd($request->all());
            $validated = $request->validate([
                'name' => 'required',
                // 'form_data.*.product_type' => 'required|numeric',
                // 'form_data.*.metal_types' => 'required|numeric',
                // 'form_data.*.price' => 'required|numeric|min:1|max:100',
                // 'form_data.*.id' => 'sometimes'
            ],
            [
                'name.required' => 'Please enter name',
                // 'form_data.*.product_type.required' => 'Please select product type',
                // 'form_data.*.product_type.numeric' => 'Invalid product type',
                // 'form_data.*.metal_types.required' => 'Please select metal type',
                // 'form_data.*.metal_types.numeric' => 'Invalid metal type',
                // 'form_data.*.price.required' => 'Please enter price',
                // 'form_data.*.price.numeric' => 'Please enter valid price',
                // 'form_data.*.price.min' => 'Please enter price greater than 1',
                // 'form_data.*.price.max' => 'Please enter less than 100',
            ]);

            $globalData = ProductFilter::where(['id'=> $data['id'] ])->first();
            $globalData->name = $request['name'];
            $globalData->save();

            $idsNotToDelete = [];

            // foreach ($request['form_data'] as $form_data_key => $form_data_value) {

            //     if(!empty($form_data_value['id'])){
            //         // Existing record
            //         $variationRecord = GlobalCombinationsVariations::where('id',$form_data_value['id'] )->first();
            //         $variationRecord->variations_id = json_encode($form_data_value);
            //         $variationRecord->price = $form_data_value['price'];
            //         $variationRecord->save();
            //         array_push($idsNotToDelete, $variationRecord->id);

            //     }else{
            //         $variationRecord  = new GlobalCombinationsVariations();
            //         $variationRecord->global_combinations_id = $globalData->id;
            //         $variationRecord->variations_id = json_encode($form_data_value);
            //         $variationRecord->price = $form_data_value['price'];
            //         $variationRecord->save();
            //         array_push($idsNotToDelete, $variationRecord->id);
            //         // New record
            //     }
            // }

            // GlobalCombinationsVariations::where('global_combinations_id',$globalData->id)->whereNotIn('id',$idsNotToDelete)->delete();

            return redirect()->route($this->route_path . '.index')->with('success','Record has been updated successfully');
        }
        echo "In the postfdsa";

        return view($this->view_path. '.edit',compact(['data','page_title','dataToPass','data']));
    }

    public function status(Request $request){

        $response = [];

        $record = ProductFilter::where('slug', $request['slug'])->first();
        // prd($record);
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

        $response = [];

        $record = ProductFilter::where('slug', $request['slug'])->first();
        if(!empty($record)){
            $record->is_deleted =  $record->is_deleted ? 0 : 1;
            $record->save();
            $response['status'] = 'success';
            $response['message'] = 'Record Deleted successfully';
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

        $data = ProductFilter::where('slug',$request['slug'] )->first()->toArray();
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
        prd($masterData);
        foreach ($masterData as $master_key => $master_value) {
            $dataToPass[$master_value] =  Masters::where(['is_deleted'=>0, 'type'=>$master_value])->get()->toArray();
        }

        /**  Setup pagination */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . ".index")],
            ["name" => "View ". $this->module_name , "url" => route($this->route_path . ".view", ['slug' => $data['slug'] ]  )],
        ];
        populate_breadcrumb($breadcrumb);


        return view($this->view_path. '.view',compact(['data','page_title','data']));
    }

    public function filterItemAdd(Request $request, $slugData){
        // echo "<pre>";
        // prd($slugData);


        $page_title = "Add Item " . $this->module_name;
        /**  Setup pagination */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . ".index", [ 'type'=> $this->master_type]  )],
            ["name" => "Add ". $this->module_name , "url" => route($this->route_path . ".add", [ 'type'=> $this->master_type]  )],
        ];
        populate_breadcrumb($breadcrumb);

        $getFilterData = ProductFilter::select('id','name','slug')->where('slug',$slugData)->first()->toArray();

        $dataToPass = [];
        // prd($slugData);
        $masterData = [];
        if($slugData == 'filter-by-price'){
            $masterData['MinPrice'] = ProductVariations::where('regular_price','!=',0.00)->min('regular_price');
            $masterData['MaxPrice'] = ProductVariations::max('regular_price');
        } elseif($slugData == 'filter-by-shape'){
            $masterData = DiamondShapes::select('name','value')->get()->toArray();
        } elseif($slugData == 'filter-by-style'){
            $masterData = Category::select('name','id as value')->where(['is_deleted'=>0,'parent_id' => 8])->get()->toArray();
        } elseif($slugData == 'colour'){
            $masterData = Masters::select('name','slug','value')->where(['is_deleted'=>0,'type'=>'colour'])->get()->toArray();
        } elseif($slugData == 'diamond-clarity'){
            $masterData = Masters::select('name','slug','value')->where(['is_deleted'=>0,'type'=>'diamond-clarity'])->get()->toArray();
        } elseif($slugData == 'carat'){
            $masterData = Masters::select('name','slug','value')->where(['is_deleted'=>0,'type'=>'carat'])->get()->toArray();
        } elseif($slugData == 'metal_type'){
            $masterData = Masters::select('name','slug','value')->where(['is_deleted'=>0,'type'=>'metal_types'])->get()->toArray();
        } elseif ($slugData == 'category'){
            $masterData = Masters::select('name','slug','value')->where(['is_deleted'=>0,'type'=>'categories'])->get()->toArray();
        }

        // prd($masterData);

        // foreach ($masterData as $master_key => $master_value) {
        //     $dataToPass[$master_value] =  Masters::where(['is_deleted'=>0, 'type'=>$master_value])->get()->toArray();
        // }
        if($request->post()){
            $data = $request->validate([
                // 'item_name' => 'required',
                'min_price' => 'required_if:item_value,null',
                'max_price' => 'required_if:item_value,null',
                'item_value' => 'required_if:max_price,null',
                'product_filter_id' => 'required|numeric',
                'item_type' => 'required',
            ],
            [
                // 'item_name.required' => 'Please enter item name',
                'min_price.required' => 'Please enter Min Price',
                'max_price.required' => 'Please enter Max Price',
                'item_value' => 'Please enter Item Value',
                'product_filter_id' => 'Please enter Item Value',
                'item_type' => 'Please enter Item type',
            ]);
            // $data = $request->input();
            if(!empty($request->input('item_value'))){
                $itemValue = explode("-", $request->input('item_value'));
                $data['item_name'] = $itemValue[1];
            }else{
                $data['item_name'] = 'price';
            }

            if(isset($data['slug']) && !empty($data['slug'])){
                $item_slug = $data['slug'];
            }else{
                $item_slug = generateSlug($data['item_name'], ProductFilter::class, 'slug');
            }

            $new_record = new ProductFilterItems();
            $new_record->product_filter_id = isset($data['product_filter_id'])?$data['product_filter_id']:0;
            $new_record->item_name = isset($itemValue[1])?$itemValue[1]:$data['item_name'];
            $new_record->item_slug = $item_slug;
            $new_record->item_id = isset($data['item_id'])?$data['item_id']:0;
            $new_record->item_value = isset($itemValue[0])?$itemValue[0]:0;
            $new_record->item_type = isset($data['item_type'])?$data['item_type']:0;
            $new_record->min_price = isset($data['min_price'])?$data['min_price']:0;
            $new_record->max_price = isset($data['max_price'])?$data['max_price']:0;
            if( $new_record->save()){
                // echo "saved";
                // prd($request->all());
            }

            return redirect()->back()->with('success','Record has been added successfully');
            // return redirect()->route($this->route_path. '.view')->with('success','Record has been added successfully');
        }

        // prd($dataToPass);

        return view($this->view_path. '.additem', compact(['slugData','page_title','dataToPass','masterData','getFilterData']));
    }

    public function filterItemEdit(Request $request){
        echo "Check edit function";
        prd($request->all());
    }

    public function filterItemStatus(Request $request){
        echo "Check status function";
    }

    public function filterItemDelete(Request $request){
        echo "Check delete function";
    }

}
