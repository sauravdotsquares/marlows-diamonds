<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Http\Controllers\Admin\CategoryController;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Redirect;
// use App\Models\Products;
// use App\Models\ProductImages;
// use App\Models\ProductVariations;
// use App\Models\ProductVariationAttributes;
// use App\Models\ProductVariationDetails;
// use App\Models\Attributes;
// use Illuminate\Support\Arr;
// use App\Models\DiamondShapes;
// use App\Models\ProductVariationsMaster;
// use App\Models\GlobalCombinationsVariations;

use App\Models\Products\Combinations;
use App\Models\Products\CombinationAttributes;
use App\Models\Products\CombinationVaritions;

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
                        $new_attribute->attribute_data = $attributeData;
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
        $productTypes = Masters::where(['type'=>'product_type','is_active'=>1,'is_deleted'=>0])->get();
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
        $CombinationVaritions = CombinationVaritions::with(
            [ 
                // 'attributeData'=>function($query){ $query->select(['id','name','value']); },
                'attributeVariations'  =>function($query){ $query->select(['id','varition_id','attribute_id']); },
                'attributeVariations.varitionData',//  =>function($query){ $query->select(['id','varition_id','attribute_id']); },
            ],
            )->select('id','attribute_id','price','product_type')->where('combination_id',$combinations->id)->groupBy('attribute_id')->get();
            foreach ($CombinationVaritions as $key => $value) {
                $CombinationVaritions[$key]['attribute_data'] = $value['attribute_variations'];
            }
            prd($CombinationVaritions->toArray());

        if($request->post()){
            prd($request->all());

            $validated = $request->validate([
                'data.*.product_type' => 'required|numeric',
                'data.*.attribute_data.*.attribute_id' => 'required|numeric',
                'data.*.attribute_data.*.varition_id' => 'required|numeric',
                'data.*.attribute_data.*.combination_attribute_id' => 'required|numeric',
                'data.*.price' => 'required|numeric|min:1|max:100',
            ],[
                'data.*.price.required' => 'Please enter price percentage',
                'data.*.price.numeric' => 'Please enter valid numbers in price',
                'data.*.price.min' => 'Please enter minimum 1 percent',
                'data.*.price.max' => 'Please enter upto 100 percent',
                'data.*.product_type.required' => 'Please select product type',
                'data.*.product_type.numeric' => 'Please select valid product type',
            ]);

            

            if(!empty($validated['data'])){
                foreach ($validated['data'] as $data_key => $data_value) {
                    if(!empty($data_value['attribute_data'])){
                        foreach ($data_value['attribute_data'] as $attribute_data_key => $attribute_datavalue) {
                            
                            $productType = Masters::where('id',$data_value['product_type'])->first();
                            $variationData = Masters::where('id',$attribute_datavalue['varition_id'])->first();
                            $attributeData = Masters::where('id',$attribute_datavalue['attribute_id'])->first();

                            $new_combination = new CombinationVaritions();
                            $new_combination->product_type = $data_value['product_type'];
                            $new_combination->product_type_id = $productType->id;
                            $new_combination->product_type_data = json_encode($productType);
                            $new_combination->combination_id = $combinations->id;
                            $new_combination->combination_attribute_id = $attribute_datavalue['combination_attribute_id'];
                            $new_combination->varition_id = $attribute_datavalue['varition_id'];
                            $new_combination->varition_data = json_encode($variationData);
                            $new_combination->attribute_id = $attribute_datavalue['attribute_id'];
                            $new_combination->attribute_data = json_encode($attributeData);
                            $new_combination->price = $data_value['price'];
                            $new_combination->save();
                        }
                    }
                }
            }

            // 

        }


        return view($this->view_path . 'add_varitions', compact(['page_title','attributes','combinations','productTypes'])); 

    }//endof addVariations

}