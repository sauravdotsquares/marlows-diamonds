<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\Combinations;
use App\Models\Products\CombinationAttributes;
use App\Models\Products\CombinationVaritions;
use App\Models\Products\CombinationVariationDetails;
use App\Models\Masters;

use View;

class CombinationsController extends Controller{
    

    public function __construct(){
        $this->view_path = "admin.app_products.combinations.";
        $this->default_pagination_limit = 12;
        $this->module_name = "Variations Combinations";
        $this->route_path = "admin.combinations.";
    }

    /**
     * Index is use to list all 
     */
    public function index(Request $request){

        /**  Setup pagination */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . "index"  )],
        ];
        populate_breadcrumb($breadcrumb);
        $page_title = $this->module_name;

        return view($this->view_path . 'index', compact(['page_title']));
    }

    /**
     * addAttributes
     */
    public function addAttributes(Request $request){

        /**  Setup pagination */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . "index"  )],
            ["name" => 'Add Attributes', "url" => route($this->route_path . "add_attributes"  )],
        ];
        populate_breadcrumb($breadcrumb);
        $page_title = 'Add Attributes';

        /** get all attributes from masters table */
        $attributes = Masters::where(['type'=> 'product_attributes', 'is_active'=>1, 'is_deleted'=>0])->get();


        if($request->post()){

            /** create validations */
            $validated = $request->validate([
                'name' => 'required',
                'attributes' => 'required'
            ],[
                'name.required' => 'Please type combination name',
                'attributes.required' => 'Please select at least one attribute',
            ]);

            /** Save combination details */
            $new_combination = new Combinations();
            $new_combination->name = $validated['name'];
            $new_combination->is_draft = 1;
            $new_combination->slug = generateSlug($validated['name'], Combinations::class, 'slug');
            if( $new_combination->save() ){

                /** Save combination attributes details */
                foreach ($validated['attributes'] as $attributes_key => $attributes_value) {
                    $attributeData = Masters::where('id', $attributes_value)->where(['is_active'=>1,'is_deleted'=>0])->first();
                    if(!empty($attributeData)){
                        $new_attribute = new CombinationAttributes();
                        $new_attribute->combination_id = $new_combination->id;
                        $new_attribute->attribute_id = $attributes_value;
                        // $new_attribute->attribute_data = $attributeData;
                        $new_attribute->save();
                    }
                }

                return redirect()->back()->with('success','Combination attributes saved successfully');
            }else{
                return redirect()->back()->with('success','Something went wrong');
            }
        }

        return view($this->view_path . 'add_attributes', compact(['page_title','attributes']));
    }//endof addAttributes

    /**
     * addVariations
     */
    public function addVariations(Request $request){

        $combinations = Combinations::where('slug', $request['slug'])->first();
        if(empty($combinations)){
            return redirect()->back()->with('error','Record not identified');
        }
        // $productTypes = Masters::where(['type'=>'product_type','is_active'=>1,'is_deleted'=>0])->get();
        $attributes = CombinationAttributes::with(['attributeData','variationsData'])
                    ->whereHas('attributeData')
                    ->whereHas('variationsData')
                    ->where(['is_active'=>1, 'is_deleted'=> 0, 'combination_id' =>$combinations->id ])
                    ->get();

        /**  Setup pagination */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . "index"  )],
            ["name" => 'Add Attributes', "url" => route($this->route_path . "add_attributes"  )],
        ];
        populate_breadcrumb($breadcrumb);
        $page_title = 'Add varitions';

        // $combinations
        // with(['attributeData','varitionData','productTypeData','combinationData'])
        // =>function($query){
        //     $query->select(['id','varition_id']);
        // }
        // $CombinationVaritions = CombinationVaritions::with(
        //     [ 
        //         // 'attributeData'=>function($query){ $query->select(['id','name','value']); },
        //         'attributeVariations'  =>function($query){ $query->select(['id','varition_id','attribute_id']); },
        //         'attributeVariations.varitionData',//  =>function($query){ $query->select(['id','varition_id','attribute_id']); },
        //     ],
        //     )->select('id','attribute_id','price')->where('combination_id',$combinations->id)->groupBy('attribute_id')->get();
        //     foreach ($CombinationVaritions as $key => $value) {
        //         $CombinationVaritions[$key]['attribute_data'] = $value['attribute_variations'];
        //     }
        // prd($CombinationVaritions->toArray());

        if($request->post()){
            

            $validated = $request->validate([
                'data.*.attribute_data.*.attribute_id' => 'required|numeric',
                'data.*.attribute_data.*.varition_id' => 'required|numeric',
                'data.*.attribute_data.*.combination_attribute_id' => 'required|numeric',
                'data.*.price' => 'required|numeric|min:1|max:100',
            ],[
                'data.*.price.required' => 'Please enter price percentage',
                'data.*.price.numeric' => 'Please enter valid numbers in price',
                'data.*.price.min' => 'Please enter minimum 1 percent',
                'data.*.price.max' => 'Please enter upto 100 percent',
            ]);

            if(!empty($validated['data'])){
                foreach ($validated['data'] as $data_key => $data_value) {

                    $new_cmb_vr = new CombinationVaritions();
                    $new_cmb_vr->price = $data_value['price'];
                    $new_cmb_vr->combination_id = $combinations->id;
                    $new_cmb_vr->save();

                    if(!empty($data_value['attribute_data'])){
                        foreach ($data_value['attribute_data'] as $attribute_data_key => $attribute_datavalue) {
                            $new_cmb_vr_detail = new CombinationVariationDetails();
                            $new_cmb_vr_detail->combination_id = $combinations->id;
                            $new_cmb_vr_detail->combination_varition_id = $new_cmb_vr->id;
                            // $new_cmb_vr_detail->combination_attribute_id = $attribute_datavalue['combination_attribute_id'];
                            $new_cmb_vr_detail->varition_id = $attribute_datavalue['varition_id'];
                            $new_cmb_vr_detail->attribute_id = $attribute_datavalue['attribute_id'];
                            $new_cmb_vr_detail->price = $data_value['price'];
                            $new_cmb_vr_detail->save();
                        }
                    }
                }
            }
        }


        return view($this->view_path . 'add_varitions', compact(['page_title','attributes','combinations'])); 

    }//endof addVariations

}