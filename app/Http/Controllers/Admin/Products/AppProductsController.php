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
use App\Models\Products\Combinations;


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
                "thumb_image" => "sometimes",
                "featured_images" => "sometimes",
                "image_gallary" => "sometimes",
                "thumb_video" => "sometimes",
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

                    /** Update featured image */
                    if(!empty($validated['featured_images'])){
                        AppProductImages::where('id',$validated['featured_images'] )->update([
                            'parent_id' => $new_product->id
                        ]);
                    }
                    /** Update thumb image */
                    if(!empty($validated['thumb_image'])){
                        AppProductImages::where('id',$validated['thumb_image'] )->update([
                            'parent_id' => $new_product->id
                        ]);
                    }
                    /** Update image gallary */
                    if(!empty($validated['image_gallary'])){
                        AppProductImages::whereIn('id',$validated['image_gallary'] )->update([
                            'parent_id' => $new_product->id
                        ]);
                    }

                    /** Update thumbnail video */
                    if(!empty($validated['thumb_video'])){
                        AppProductImages::where('id',$validated['thumb_video'] )->update([
                            'parent_id' => $new_product->id
                        ]);
                    }

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


        if($request->post()){

             /** create validations */
             $validated = $request->validate([
                'variation_data.*.price' => 'required',
                'variation_data.*.variations' => 'sometimes',
                'variation_data.*.in_stock' => 'sometimes',
                'variation_data.*.image_id' => 'sometimes',
            ],[
                'variation_data.*.price.required' => 'Please enter price',
            ]);


            $data = $request->all();
            prd($data);

        }

        return view($this->view_path . 'variations' ,compact(['attributes','attributeData','product']) );
    }//endof variationsSelection


    public function categoryOptions($type="options", $level=0, $prefix=""){
        $rows = Category::select(['name','title','id','parent_id','slug'])->where('parent_id',$level)->get();
        $html = '';
        if($rows->count()){
            $rows = $rows->toArray();
            foreach ($rows as $row) {

                switch ($type) {
                    case 'options':{
                        $html .= '<option value="'.$row['id'].'">' . $prefix . $row['name'] . "</option>";
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
                $html .= $this->categoryOptions($type, $row['id'], $prefix . '----');
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
        $fileId = request()->getContent();
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