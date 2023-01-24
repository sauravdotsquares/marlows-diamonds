<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Category;
// use App\Models\Products;
// use App\Models\ProductImages;
// use App\Models\ProductVariations;
// use App\Models\ProductVariationAttributes;
// use App\Models\ProductVariationDetails;
// use App\Models\Attributes;
// use Illuminate\Support\Arr;
use App\Models\DiamondShapes;
use App\Models\AppProductImages;
use App\Models\AppProducts;
use App\Models\Masters;
use App\Models\AppProductCategories;
use App\Models\AppProductAttributes;
use App\Models\MetaInformation;
use App\Models\ImageGallery;
use App\Models\Products\Combinations;

use App\Models\AppProductAttributeVariations;
use App\Models\AppProductAttributeVariationDescripiton;
use App\Models\Queue;


use Illuminate\Support\Facades\File; 
// use App\Models\ProductVariationsMaster;
// use App\Models\GlobalCombinationsVariations;
// use App\Models\Masters;

use View;

class AppProductsController extends Controller{
    

    public function __construct(){
        $this->view_path = "admin.app_products.products.";
        $this->default_pagination_limit = 12;
        $this->module_name = "Products";
        $this->route_path = "admin.app_products.";
    }


    /**
     * list of all products
     */
    public function list(Request $request){

        /**  Setup breadcrumb */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . "list"  )],
        ];
        populate_breadcrumb($breadcrumb);
        $page_title = 'Products';

        $query = AppProducts::where(['is_deleted'=>0]);
        
        /** Filter */
        $query = getFilter(AppProducts::class, $query, $request->query());

        $data = $query->paginate($this->default_pagination_limit);
        return view($this->view_path . 'list' ,compact(['data','page_title']) );
    }//endof list


    /**
     * add basic information of products
     */
    public function basicInformation(Request $request){

        /**  Setup breadcrumb */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . "list"  )],
            ["name" => 'Basic information', "url" => route($this->route_path . "basic_information"  )],
        ];
        populate_breadcrumb($breadcrumb);
        $page_title = 'Basic information';
        $category_data = $this->categoryOptions('options');
        $diamondShapes = DiamondShapes::all();
        $attributes = Masters::attributes();
        $combinations = Combinations::combinations();

        if($request->post()){


            

            /** create validations */
            $validated = $request->validate([
                'title' => 'required',
                'tags' => 'required',
                'categories' => 'required',
                "short_description" => "required",
                "description" => "required",
                'meta_title' => 'required',
                'meta_keyword' => 'required',
                'meta_description' => 'required',
                "is_variation" => "sometimes",
                "status" => "sometimes",
                "dfinder_status" => "sometimes",
                "diamond_shape" => "sometimes",
                "is_featured" => "sometimes",
                "media.*" => "sometimes",
                "attributes" => "required",
                "combination_id" => "sometimes",
            ],[
                'title.required' => 'Please enter product title',
                'tags.required' =>  'Please enter product tags',
                'categories.required' =>  'Please select categories',
                'meta_title.required' =>  'Please enter meta title',
                'meta_keyword.required' =>  'Please enter meta keywords',
                'meta_description.required' =>  'Please enter meta description',
                "attributes.required" => "Please select attributes"
            ]);


            try {
                /** create new product */
                $new_product = new AppProducts();
                $new_product->title = $validated['title'];
                $new_product->slug = generateSlug($validated['title'],AppProducts::class, 'slug');
                $new_product->tags = $validated['tags'];
                $new_product->short_description = $validated['short_description'];
                $new_product->description = $validated['description'];
                $new_product->is_variable = !empty($validated['is_variation']) ? (int)$validated['is_variation'] : 0;
                $new_product->dfinder_status = !empty($validated['dfinder_status']) ? (int)$validated['dfinder_status'] : 0;
                $new_product->diamond_shape = !empty($validated['diamond_shape']) ? $validated['diamond_shape'] : null;
                $new_product->is_featured = !empty($validated['is_featured']) ? (int)$validated['is_featured'] : 0;
                $new_product->status = !empty($validated['status']) ? (int)$validated['status'] : 0 ;
                $new_product->is_draft = 1;
                $new_product->combination_id = !empty($validated['combination_id']) ? $validated['combination_id'] : null ;
                if($new_product->save()){

                    /** add categories for product */
                    if( !empty($validated['categories']) && count($validated['categories'])){
                        foreach ($validated['categories'] as $categories_value) {
                            $new_category = new AppProductCategories();
                            $new_category->product_id = $new_product->id;
                            $new_category->category_id = $categories_value;
                            $new_category->save();
                        }
                    }

                    /** Add attributes for products */
                    if( !empty($validated['attributes']) && count($validated['attributes'])){
                        foreach ($validated['attributes'] as $attributes_value) {
                            $attributeData = Masters::where('id', $attributes_value)->first();
                            if(!empty($attributeData)){
                                $new_attribute = new AppProductAttributes();
                                $new_attribute->product_id = $new_product->id;
                                $new_attribute->attribute_id = $attributes_value;
                                $new_attribute->information =  json_encode($attributeData);
                                $new_attribute->save();
                            }
                        }
                    }

                    /** save meta information of product */
                    $new_meta = MetaInformation::saveMetaInformation(null,[
                        'parent_id' => $new_product->id,
                        'belongs_from' => 'md_app_products',
                        'meta_title'=>$validated['meta_title'],
                        'meta_description' =>$validated['meta_description'],
                        'meta_keyword' =>$validated['meta_keyword'],
                    ]);


                    /** save media from gallery to useful place */
                    foreach ($validated['media'] as $media_key => $media_value) {
                        ImageGallery::saveMedia(AppProductImages::class, $new_product->id, 'md_app_products', $media_key, $media_value);
                    }

                    // /** Update featured image */
                    // if(!empty($validated['featured_images'])){
                    //     AppProductImages::where('id',$validated['featured_images'] )->update([
                    //         'parent_id' => $new_product->id
                    //     ]);
                    // }
                    // /** Update thumb image */
                    // if(!empty($validated['thumb_image'])){
                    //     AppProductImages::where('id',$validated['thumb_image'] )->update([
                    //         'parent_id' => $new_product->id
                    //     ]);
                    // }
                    // /** Update image gallary */
                    // if(!empty($validated['image_gallary'])){
                    //     AppProductImages::whereIn('id',$validated['image_gallary'] )->update([
                    //         'parent_id' => $new_product->id
                    //     ]);
                    // }
                    // /** Update thumbnail video */
                    // if(!empty($validated['thumb_video'])){
                    //     AppProductImages::where('id',$validated['thumb_video'] )->update([
                    //         'parent_id' => $new_product->id
                    //     ]);
                    // }



                    return redirect()->route('admin.app_products.variations', $new_product->slug)->with('success',__('Basic information saved successfully'));
                }else{
                    return redirect()->route('admin.app_products.basic_information')->with('error',__('Something went wrong'));
                }
            } catch (\Exception $e) {
                return redirect()->route('admin.app_products.basic_information')->with('error',__($e->getMessage()));
            }  
        }
        
        return view($this->view_path . 'basic_information' ,compact(['category_data','diamondShapes','attributes','combinations']) );
    }//endof basicInformation



     /**
     * add basic information of products
     */
    public function editBasicInformation(Request $request){


        $product = AppProducts::with([
            'productMeta',
            'productAttributes'=>function($query){
                $query->select('id','product_id','attribute_id')->where(['is_deleted'=>0, 'is_active'=>1]);
            }
        ])
        ->where('slug',$request['slug'])->first();
        if(empty($product)){
            return redirect()->route('admin.app_products.list')->with('error','Something went wrong');
        }
        if( !empty($product->productAttributes) && $product->productAttributes->count()){
            $product->product_attributes_ids = array_map(function($element) { return $element['attribute_id'];}, $product->productAttributes->toArray());
        }

        /** get images */
        $product->productImages  = AppProductImages::getImages([
            'belongs_from' => 'md_app_products',
            'parent_id' => $product->id
        ]);

        $categories = AppProductCategories::where(['product_id'=>$product->id , 'is_deleted'=>0, 'is_active'=>1 ] )->pluck('category_id');
        $categories = $categories->count() ? $categories->toArray() : [];

        /**  Setup breadcrumb */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . "list"  )],
            ["name" => 'Basic information', "url" => route($this->route_path . "basic_information"  )],
        ];
        populate_breadcrumb($breadcrumb);
        $page_title = 'Basic information';
        $category_data = $this->categoryOptions('options', $categories);
        $diamondShapes = DiamondShapes::all();
        $attributes = Masters::attributes();
        $combinations = Combinations::combinations();

        if($request->post()){

            /** create validations */
            $validated = $request->validate([
                'title' => 'required',
                'tags' => 'required',
                'categories' => 'required',
                "short_description" => "required",
                "description" => "required",
                'meta_id' => 'sometimes',
                'meta_title' => 'required',
                'meta_keyword' => 'required',
                'meta_description' => 'required',
                "is_variation" => "sometimes",
                "status" => "sometimes",
                "dfinder_status" => "sometimes",
                "diamond_shape" => "sometimes",
                "is_featured" => "sometimes",
                "media.*" => "sometimes",
                "attributes" => "required",
                "combination_id" => "sometimes",
            ],[
                'title.required' => 'Please enter product title',
                'tags.required' =>  'Please enter product tags',
                'categories.required' =>  'Please select categories',
                'meta_title.required' =>  'Please enter meta title',
                'meta_keyword.required' =>  'Please enter meta keywords',
                'meta_description.required' =>  'Please enter meta description',
                "attributes.required" => "Please select attributes"
            ]);

            // prd($validated);

            try {
                /** create new product */
                $update_product = AppProducts::where('id',$product->id)->first();
                $update_product->title = $validated['title'];
                $update_product->tags = $validated['tags'];
                $update_product->short_description = $validated['short_description'];
                $update_product->description = $validated['description'];
                $update_product->is_variable = !empty($validated['is_variation']) ? (int)$validated['is_variation'] : 0;
                $update_product->dfinder_status = !empty($validated['dfinder_status']) ? (int)$validated['dfinder_status'] : 0;
                $update_product->diamond_shape = !empty($validated['diamond_shape']) ? $validated['diamond_shape'] : null;
                $update_product->is_featured = !empty($validated['is_featured']) ? (int)$validated['is_featured'] : 0;
                $update_product->combination_id = !empty($validated['combination_id']) ? $validated['combination_id'] : null ;
                if($update_product->save()){

                    /** add categories for product */
                    if( !empty($validated['categories']) && count($validated['categories'])){
                        $validCategoryIds = [];
                        foreach ($validated['categories'] as $categories_value) {
                            $existingCategory = AppProductCategories::where([ 'is_deleted'=>0, 'product_id'=> $update_product->id, 'category_id' => $categories_value ])->first();
                            if(empty($existingCategory)){
                                $new_category = new AppProductCategories();
                                $new_category->product_id = $update_product->id;
                                $new_category->category_id = $categories_value;
                                $new_category->save();
                                $validCategoryIds[] = $new_category->id;
                            }else{
                                $validCategoryIds[] = $existingCategory->id;
                            }
                        }
                        AppProductCategories::whereNotIn('id', $validCategoryIds)->where(['product_id'=> $update_product->id, 'is_deleted' =>0 ])->update(['is_deleted'=>1]);
                    }

                    /** Add attributes for products */
                    if( !empty($validated['attributes']) && count($validated['attributes'])){
                        $attr_valid = [];
                        foreach ($validated['attributes'] as $attributes_value) {
                            $attributeData = Masters::where('id', $attributes_value)->first();
                            if(!empty($attributeData)){

                                $existingAttr = AppProductAttributes::where(['attribute_id'=> $attributes_value, 'product_id'=> $update_product->id, 'is_deleted'=>0 ])->first();
                                if(!empty($existingAttr)){
                                    $attr_valid[] = $existingAttr->id;
                                }else{
                                    $new_attribute = new AppProductAttributes();
                                    $new_attribute->product_id = $update_product->id;
                                    $new_attribute->attribute_id = $attributes_value;
                                    $new_attribute->information =  json_encode($attributeData);
                                    $new_attribute->save();   
                                    $attr_valid[] = $new_attribute->id;
                                }
                            }
                        }
                        AppProductAttributes::whereNotIn('id', $attr_valid)->where(['is_deleted'=>0, 'product_id'=>$update_product->id ])->update(['is_deleted'=>1]);
                    }

                    /** save meta information of product  */
                    $new_meta = MetaInformation::saveMetaInformation($validated['meta_id'],[
                        'parent_id' => $update_product->id,
                        'belongs_from' => 'md_app_products',
                        'meta_title'=>$validated['meta_title'],
                        'meta_description' =>$validated['meta_description'],
                        'meta_keyword' =>$validated['meta_keyword'],
                    ]);

                    /** save media from gallery to useful place */
                    foreach ($validated['media'] as $media_key => $media_value) {
                        ImageGallery::saveMedia(AppProductImages::class, $update_product->id, 'md_app_products', $media_key, $media_value);
                    }


                    // /** Update featured image */
                    // if(!empty($validated['featured_images'])){
                    //     AppProductImages::where('id',$validated['featured_images'] )->update([
                    //         'parent_id' => $update_product->id
                    //     ]);
                    // }
                    // /** Update thumb image */
                    // if(!empty($validated['thumb_image'])){
                    //     AppProductImages::where('id',$validated['thumb_image'] )->update([
                    //         'parent_id' => $update_product->id
                    //     ]);
                    // }
                    // /** Update image gallary */
                    // if(!empty($validated['image_gallary'])){
                    //     AppProductImages::whereIn('id',$validated['image_gallary'] )->update([
                    //         'parent_id' => $update_product->id
                    //     ]);
                    // }

                    // /** Update thumbnail video */
                    // if(!empty($validated['thumb_video'])){
                    //     AppProductImages::where('id',$validated['thumb_video'] )->update([
                    //         'parent_id' => $update_product->id
                    //     ]);
                    // }

                    return redirect()->route('admin.app_products.variations_edit', $update_product->slug)->with('success',__('Basic information saved successfully'));
                }else{
                    return redirect()->route('admin.app_products.basic_information')->with('error',__('Something went wrong'));
                }
            } catch (\Exception $e) {
                return redirect()->route('admin.app_products.basic_information')->with('error',__($e->getMessage()));
            }  
        }
        
        return view($this->view_path . 'edit_basic_information' ,compact(['category_data','diamondShapes','attributes','combinations','product']) );
    }//endof basicInformation

    /**
     * function is use to select variations
     */
    public function variationsSelection(Request $request){

        /** Check if id is for valid product */
        $product = AppProducts::where('slug', $request['slug'])->first();
        if(empty($product)){
            return redirect()->back()->with('error',__('Product not identified'));
        }

        /**  Setup breadcrumb */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . "list"  )],
            ["name" => 'Basic information', "url" => route($this->route_path . "basic_information"  )],
            ["name" => 'Varitions', "url" => route($this->route_path . "variations", $product->slug )],
        ];
        populate_breadcrumb($breadcrumb);
        $page_title = ' information';
        $attributes = Masters::attributes();

        /** get all selected attributes */
        $selectedAttributes = AppProductAttributes::where([ 'product_id' => $product->id, 'is_deleted' => 0, 'is_active' => 1 ])->get()->toArray();//->pluck('attribute_id');
        
        $attributeData = [];
        foreach ($selectedAttributes as $attr_key => $attr_value) {
            $attribute = Masters::where(['id'=> $attr_value['attribute_id'], 'is_deleted'=>0])->select(['id','name','slug'])->first()->toArray();
            $attribute['product_attribute'] = $attr_value;
            if(!empty($attribute)){
                $variations = Masters::where(['parent_id'=> $attribute['id'], 'is_deleted'=>0 ])->select(['id','name','slug'])->get();
                if($variations->count()){
                    $attribute['variations'] = $variations->toArray();
                    array_push($attributeData, $attribute);
                }
            }
        }



        $product_vari = AppProductAttributeVariations::with(['variations'=>function($query){
            $query->select(['attribute_variation_id','attribute_id','master_attribute_id as variations_attribute_id', 'variation_id as id', 'id as rowId']);
        }])->select(['regular_price as price', 'id', 'in_stock'])->where(['product_id'=> $product->id, 'is_deleted'=>0, 'is_active'=>1])->get();
        
        if($product_vari->count()){
            $product_vari = $product_vari->toArray();
            foreach ($product_vari as $key => $value) {
                $product_vari[$key]['image'] = AppProductImages::image($value['id']);
                $product_vari[$key]['variation_ids'] = array_map(function($element) { return  $element['id']; }, $value['variations'] );
            }
        }


        if($request->post()){

             /** create validations */
             $validated = $request->validate([
                'variation_data.*.price' => 'required',
                'variation_data.*.variations' => 'sometimes',
                'variation_data.*.in_stock' => 'sometimes',
                'variation_data.*.image' => 'sometimes',
            ],[
                'variation_data.*.price.required' => 'Please enter price',
            ]);

            // prd($validated);
            $data = $request->all();
            $valid_varitions_images = [];
            foreach ($data['variation_data'] as $data_key => $data_value) {

                $new_var = new AppProductAttributeVariations();
                $new_var->product_id  = $product->id;
                $new_var->sale_price = $data_value['price'];
                $new_var->regular_price = $data_value['price'];
                $new_var->in_stock = $data_value['in_stock'] ? $data_value['in_stock'] : 0 ;
                $new_var->save();

                /** Update image */
                if(!empty($data_value['image']) && $new_var->id){
                    ImageGallery::saveMedia(AppProductImages::class, $new_var->id, 'md_app_product_attribute_variations', 'variation', $data_value['image']);
                }

                foreach ($data_value['variations'] as $var_data_key => $var_data_value) {
                    $varData = Masters::where('id', $var_data_value['id'])->first();
                    if( !empty($varData) ){
                        $new_var_des = new AppProductAttributeVariationDescripiton();
                        $new_var_des->product_id = $product->id;
                        $new_var_des->attribute_id = $var_data_value['attribute_id'];
                        $new_var_des->master_attribute_id = $var_data_value['variations_attribute_id'];
                        $new_var_des->attribute_variation_id = $new_var->id;
                        $new_var_des->variation_id = $var_data_value['id'];
                        $new_var_des->variation_parent_id = $varData['parent_id'];
                        $new_var_des->variation_name = $varData['name'];
                        $new_var_des->variation_data =  json_encode($varData);
                        $new_var_des->save();
                    }
                }
            }
            AppProductImages::whereIn('id', $valid_varitions_images)
            ->where([ 'is_deleted'=>0, 'parent_id'=> $product->id, 'belongs_from' => 'md_app_product_attribute_variations'  ])
            ->update([ 'is_deleted'=>1 ]);

            /** Remove this product from draft */
            AppProducts::where('id', $product->id)->update(['is_draft'=>0]);

            
            // ->route('admin.app_products.list')
            return  redirect()->back()->with('success',__('Product added successfully'));

        }

        return view($this->view_path . 'variations' ,compact(['attributes','attributeData','product','product_vari']) );
    }//endof variationsSelection



    /**
     * function is use to select variations
     */
    public function variationsSelectionEdit(Request $request){

        /** Check if id is for valid product */
        $product = AppProducts::where('slug', $request['slug'])->first();
        if(empty($product)){
            return redirect()->back()->with('error',__('Product not identified'));
        }

        /**  Setup breadcrumb */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . "list"  )],
            ["name" => 'Basic information', "url" => route($this->route_path . "basic_information"  )],
            ["name" => 'Varitions', "url" => route($this->route_path . "variations", $product->slug )],
        ];
        populate_breadcrumb($breadcrumb);
        $page_title = ' information';
        $attributes = Masters::attributes();

        /** get all selected attributes */
        $selectedAttributes = AppProductAttributes::where([ 'product_id' => $product->id, 'is_deleted' => 0, 'is_active' => 1 ])->get()->toArray();
        $attributeData = [];
        foreach ($selectedAttributes as $attr_key => $attr_value) {
            $attribute = Masters::where(['id'=> $attr_value['attribute_id'], 'is_deleted'=>0])->select(['id','name','slug'])->first()->toArray();
            $attribute['product_attribute'] = $attr_value;
            if(!empty($attribute)){
                $attribute['variations'] = Masters::attribute_variations($attribute['id'] );
                array_push($attributeData, $attribute);
            }
        }

        $productVariations = AppProductAttributeVariations::where(['is_deleted'=> 0, 'product_id'=> $product->id])
                            ->with(['images'=>function($query){
                                $query->where(['is_active'=>1, 'is_deleted'=> 0, 'belongs_from'=> 'md_app_product_attribute_variations' , 'image_type' => 'variation' ]);
                            }])
                            ->select(['regular_price as price', 'id', 'in_stock'])
                            ->get();

        // prd($productVariations->toArray());die;

        $form = "";
        if($productVariations->count()){
            foreach ($productVariations as $index => $item) {
                $images  = AppProductImages::getImages([
                    'belongs_from' => 'md_app_product_attribute_variations',
                    'parent_id' => $item->id
                ]);
                $form .= View::make('admin.app_products.products.elements.variations_form', compact(['index','attributeData','item','product','images']));
            }
        }else{
            $index = 0;
            $item = [];
            $form .= View::make('admin.app_products.products.elements.variations_form', compact(['index','attributeData','item','product']));
        }


        if($request->post()){

            // prd($request->all());

             /** create validations */
             $validated = $request->validate([
                'product_attribute_variations' => 'sometimes',
                'variation_data.*.price' => 'required',
                'variation_data.*.variations' => 'sometimes',
                'variation_data.*.in_stock' => 'sometimes',
                'variation_data.*.image' => 'sometimes',
            ],[
                'variation_data.*.price.required' => 'Please enter price',
            ]);

            $data = $request->all();
            // prd($data);

            $valid_varitions = [];
            $valid_varitions_images = [];
            foreach ($data['variation_data'] as $data_key => $data_value) {

                if(empty($data_value['product_attribute_variations'])){
                    $var_record = new AppProductAttributeVariations();
                }else{
                    $var_record = AppProductAttributeVariations::where('id',$data_value['product_attribute_variations'])->first();
                    if(empty($var_record)){
                        $var_record = new AppProductAttributeVariations();
                    }
                }

                $var_record->product_id  = $product->id;
                $var_record->sale_price = $data_value['price'];
                $var_record->regular_price = $data_value['price'];
                $var_record->in_stock = $data_value['in_stock'] ? $data_value['in_stock'] : 0 ;
                $var_record->save();
                $valid_varitions[] = $var_record->id;


                if(!empty($data_value['image']) && $var_record->id){
                    ImageGallery::saveMedia(AppProductImages::class, $var_record->id, 'md_app_product_attribute_variations', 'variation', $data_value['image']);
                    // /** Update parent id of image */
                    // AppProductImages::where('id', $data_value['image_id'] )->update(['parent_id'=> $var_record->id] );
                    // /** Delete previous image */
                    // $imagesToDelete = AppProductImages::where([ 
                    //     'is_deleted'=>0, 
                    //     'parent_id'=> $var_record->id, 
                    //     'belongs_from' => 'md_app_product_attribute_variations' 
                    // ])
                    // ->where('id','!=',$data_value['image_id'])
                    // ->pluck('id');
                    // if($imagesToDelete->count()){
                    //     $imagesToDelete = $imagesToDelete->toArray();
                    //     AppProductImages::whereIn('id',$imagesToDelete)->update([ 'is_deleted'=>1 ]);
                    //     $imagesModal = new AppProductImages();
                    //     /** add task to do later for delete images  */
                    //     $new_queue = new Queue();
                    //     $new_queue->task = json_encode([
                    //         'table' => $imagesModal->getTable(),
                    //         'action' => 'delete',
                    //         'perform_ids' => $imagesToDelete
                    //     ]);
                    //     $new_queue->save();
                    // }
                }

                

                $valid_varition_items = [];
                foreach ($data_value['variations'] as $var_data_key => $var_data_value) {

                    $varData = Masters::where('id', $var_data_value['variation_id'])->first();

                    if(!empty($varData)){
                        if(empty($data_value['product_attribute_variations'])){
                            $var_des_record = new AppProductAttributeVariationDescripiton();
                        }else{
                            $var_des_record = AppProductAttributeVariationDescripiton::where('id',$var_data_value['id'])->first();
                            if(empty($var_des_record)){
                                $var_des_record = new AppProductAttributeVariationDescripiton();
                            }
                        }
                        $var_des_record->product_id = $product->id;
                        $var_des_record->attribute_id = $var_data_value['attribute_id'];
                        $var_des_record->master_attribute_id = $var_data_value['master_attribute_id'];
                        $var_des_record->attribute_variation_id = $var_record->id;
                        $var_des_record->variation_id = $var_data_value['variation_id'];
                        $var_des_record->variation_parent_id = $varData['parent_id'];
                        $var_des_record->variation_name = $varData['name'];
                        $var_des_record->variation_data =  json_encode($varData);
                        $var_des_record->save();

                        $valid_varition_items[] = $var_des_record->id;
                    }
                }
                
                AppProductAttributeVariationDescripiton::where('attribute_variation_id',$var_record->id)
                ->where(['product_id' => $product->id , 'is_deleted' => 0])
                ->whereNotIn('id', $valid_varition_items)
                ->update(['is_deleted'=>1]);
            }

            /** Delete extra variations and variation description */
            AppProductAttributeVariations::whereNotIn('id', $valid_varitions)->where(['product_id' => $product->id , 'is_deleted' => 0 ] )->update(['is_deleted'=>1]);
            

            
            // $imagesToDelete = AppProductImages::whereNotIn('id', $valid_varitions_images)
            // ->where([ 'is_deleted'=>0, 'parent_id'=> $product->id, 'belongs_from' => 'md_app_product_attribute_variations'  ])->pluck('id');
            // prd($imagesToDelete);
            // if($imagesToDelete->count()){
            //     $imagesToDelete = $imagesToDelete->toArray();
            //     AppProductImages::whereIn('id',$imagesToDelete)->update([ 'is_deleted'=>1 ]);

            //     /** add task to do later for delete images  */
            //     $new_queue = new Queue();
            //     $new_queue->task = json_encode($imagesToDelete);
            //     $new_queue->save();
            // }

            

            

            

            // AppProductAttributeVariationDescripiton::whereIn('attribute_variation_id',$valid_varitions)->where(['product_id' => $product->id , 'is_deleted' => 0])->update(['is_deleted'=>1]);

            return  redirect()->route('admin.app_products.variations_edit', $product->slug)->with('success',__('Product added successfully'));
        }

        return view($this->view_path . 'variations_edit' ,compact(['attributes','attributeData','product','form']) );
    }//endof variationsSelection


    public function categoryOptions($type="options", $categories = [], $level=0, $prefix="", $selected_categories=[] ){
        $rows = Category::select(['name','title','id','parent_id','slug'])->where('parent_id',$level)->get();
        $html = '';
        if($rows->count()){
            $rows = $rows->toArray();
            foreach ($rows as $row) {

                switch ($type) {
                    case 'options':{

                        $isSelected = in_array($row['id'], $categories) ? 'selected' : '';

                        $html .= '<option value="'.$row['id'].'"    '.$isSelected.'  >' . $prefix . $row['name'] . "</option>";
                        break;
                    }
                    case 'new_line':{
                        $html .= $prefix . $row['name'] . "<br />";
                        break;
                    }
                    default:{
                        $html .= $prefix . $row['name'];
                        break;
                    }
                }
                $html .= $this->categoryOptions($type, $categories, $row['id'], $prefix . '----');
            }
        }
        
        return $html;
    }


    // 'featured_image','product_gallery','variation','thumb_image','thumb_video',''

    public function uploadImages(Request $request){

        $keys = array_keys($request->all());
        if(!count($keys)){
            return response()->json([
                'message' => 'Image not identified'
            ], 400);
        }
        $image_key = $keys[0];

        $imageType = $request->header('IMAGE-TYPE');
        if(empty($imageType)){
            return response()->json([
                'message' => 'Image type not identified'
            ], 400); ;
        }

        $imageFrom = $request->header('IMAGE-FROM') ? $request->header('IMAGE-FROM') : 'md_app_products' ;

        if($request->hasFile($image_key)){
            $fileData = upload_file($request[$image_key], 'products');
            if($fileData && is_array($fileData)){
                $new_image = new AppProductImages();
                $new_image->image = $fileData['name'];
                $new_image->size = $fileData['size'];
                $new_image->extension = $fileData['extension'];
                $new_image->original_name  = $fileData['original_name'];
                $new_image->metadata  = json_encode($fileData);
                $new_image->image_type  = $imageType;
                $new_image->belongs_from  = $imageFrom;
                $new_image->save();
                return $new_image->id;
            }
            return response()->json([
                'message' => 'Something went wrong'
            ], 400);
        }
        return response()->json([
            'message' => 'File not identified'
        ], 400);
    }


    public function removeImage(Request $request){
        $fileId = request()->getContent() ? request()->getContent() : $request['id'];
        if(empty($fileId)){
            return response()->json([
                'message' => 'File not identified'
            ], 400);
        }
        $file_data = AppProductImages::where('id', $fileId)->first();
        if(!empty($file_data)){
            $isDeleted = File::delete('uploads/'.$file_data->image);
            $file_data->delete();
        }
        return response()->json([
            'message' => 'File removed successfully'
        ], 200);
    }

    /**
     * Basic information
     * title
     * slug
     * tags
     * categories
     * short description
     * description
     * 
     * Meta information
     * meta title
     * meta keyword
     * meta description
     * 
     * Product information
     * Variable Product
     * Product Status
     * Enable Diamond Finder
     * Diamond Shape
     * Featured Status
     * 
     * 
     * product images
     * thumbnail image
     * product gallary images
     * 
     * 
     * product attributes
     * all attributes to be select
     * 
     * 
     */


    /**
     * function to change status
     * @param slug
     */
    public function changeStatus(Request $request){
        $product = AppProducts::where('slug',$request['slug'])->first();
        if(!empty($product)){

            $product->is_active = $product->is_active ? 0 : 1;
            $message = $product->is_active ? "Activated" : "Inactivated";

            if($product->save()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Product status ' . $message . ' successfully',
                ], 200);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Something went wrong'
                ], 200);
            }

        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Product not identified'
            ], 200);
        }
    }//endof changeStatus


    /**
     * function to delete record
     * @param slug
     */
    public function deleteRecord(Request $request){
        $product = AppProducts::where('slug',$request['slug'])->first();
        if(!empty($product)){
            $product->is_deleted =  1;
            if($product->save()){
                return response()->json([
                    'status' => 'success',
                    'message' => 'Product has been deleted successfully'
                ], 200);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Something went wrong'
                ], 200);
            }
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Product not identified'
            ], 200);
        }
    }//endof deleteRecord

}