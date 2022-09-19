<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\AppProducts;
use App\Models\AppProductCategories;
use App\Models\AppProductImages;
// use App\Models\AppProductImages;
// use App\Models\Products;
// use App\Models\ProductImages;
// use App\Models\ProductVariations;
// use App\Models\ProductVariationAttributes;
// use App\Models\ProductVariationDetails;
// use App\Models\Attributes;

use App\Models\AppProductAttributes;
use App\Models\AppProductAttributeVariations;
use App\Models\AppProductAttributeVariationDescripiton;
use App\Models\Masters;
use App\Models\Category;
use App\Models\Products;


use Illuminate\Support\Arr;
use App\Models\DiamondShapes;
use View, File;

class AppProductsController extends Controller{

    
    public function __construct(Request $request){
        $this->view_path = "admin.app_products";
        $this->default_pagination_limit = 12;
        $this->module_name = "Products";
        $this->route_path = "admin.app_products";
    }

    /**
     * index()
     * function use to list all products with search
     */
    public function index(Request $request){
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => $this->module_name, "url" => route($this->route_path. '.index'), "icon" => ""],
        ];
        populate_breadcrumb($breadcrumb);
        $routePath = $this->route_path;

        $query = AppProducts::latest();

        /** getFilter function exists in helper.php  */
        $query = getFilter(AppProducts::class, $query, $request->query());

        $getProducts = $query->paginate(10);

        return view($this->route_path . '.index',compact(['getProducts','routePath']));
    }//endof index

    /**
     * add()
     * Function use to add new product
     */
    public function add(Request $request){
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => $this->module_name, "url" => route($this->route_path. '.index'), "icon" => ""],
            ["name" => 'Add ' . $this->module_name, "url" => route($this->route_path. '.add'), "icon" => ""],
        ];
        populate_breadcrumb($breadcrumb);
        $diamondShapes = DiamondShapes::all();


        if($request->post()){

            $validatedData = $request->validate([
                'title' => 'required',
                'tags' => 'sometimes',
                'categories'=> 'required',
                'short_description' => 'sometimes',
                'files' => 'sometimes',
                'description' => 'required',
                'is_variation' => 'sometimes',
                'status' => 'sometimes',
                'dfinder_status' => 'sometimes',
                'is_featured' => 'sometimes',
                'diamond_shape' => 'sometimes',
                'meta_title' => 'required',
                'meta_keyword' => 'required',
                'meta_description' => 'required',
            ]);

            $slug = generateSlug($validatedData['title'], AppProducts::class, 'slug');

            $new_product = new AppProducts();
            $new_product->title = $validatedData['title'];
            $new_product->slug = $slug;
            $new_product->tags = $validatedData['tags'];
            $new_product->dfinder_status = (int)$validatedData['dfinder_status'];
            $new_product->diamond_shape = $validatedData['diamond_shape'];
            $new_product->short_description = $validatedData['short_description'];
            $new_product->description = $validatedData['description'];
            $new_product->meta_title = $validatedData['meta_title'];
            $new_product->meta_keyword = $validatedData['meta_keyword'];
            $new_product->meta_description = $validatedData['meta_description'];
            $new_product->is_featured = (int)$validatedData['is_featured'];
            $new_product->is_variable = (int)$validatedData['is_variation'];
            $new_product->status = (int)$validatedData['status'];
            $new_product->is_draft = 1;
            if( $new_product->save() ){

                foreach ($validatedData['categories'] as $categories_key => $categories_value) {
                    $new_categories = new AppProductCategories();
                    $new_categories->product_id = $new_product->id;
                    $new_categories->category_id = $categories_value;
                    $new_categories->save();
                }

                return redirect()->route($this->route_path.'.add_images',['slug'=> $new_product->slug ])->with('success','Product saved successfully');
            }else{
                return redirect()->back()->with('error','Something went wrong');
            }
        }

        return view($this->route_path . '.add',compact(['diamondShapes']));
    }//endof add

    /**
     * addImages()
     * Function is use to add images for products
     */
    public function addImages(Request $request){

        $slug = $request['slug'];
        $product = AppProducts::where('slug',$slug)->first();
        if(empty($product)){
            return redirect()->route($this->route_path.'.index')->with('error','Product not identified');
        }

        $featured_image = AppProductImages::where(['product_id'=> $product->id,'image_type'=>'featured_image'])->get()->toArray();
        $product_gallery_images = AppProductImages::where(['product_id'=> $product->id,'image_type'=>'product_gallery'])->get()->toArray();

        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => $this->module_name, "url" => route($this->route_path. '.index'), "icon" => ""],
            ["name" => 'Add ' . $this->module_name, "url" => route($this->route_path. '.add'), "icon" => ""],
            ["name" => 'Upload images', "url" => route($this->route_path. '.add_images',['slug'=>$slug]), "icon" => ""],
        ];
        populate_breadcrumb($breadcrumb);

        if($request->ajax()){
            if($request->hasFile('file')) {
                $file = $request->file('file');
                $fileExtension = $file->getClientOriginalExtension();
                $originalName = $file->getClientOriginalName();
                $fileSize = $file->getSize();
                $newFileName = unique_code();
                $destinationPath = 'uploads/products/';
                $file->move($destinationPath, $newFileName .'.'. $fileExtension);

                $newImage = new AppProductImages();
                $newImage->product_id = $product->id;
                $newImage->image = 'products/'. $newFileName .'.'. $fileExtension;
                $newImage->size_in_bytes = $fileSize;
                $newImage->extension = $fileExtension;
                $newImage->original_image_name = $originalName;
                $newImage->image_type = $request['imageType'];
                $newImage->save();

                return response()->json([
                    'status'=>'success',
                    'message'=>'Upload Successfully',
                    'data' => $newImage->id
                ]);
            }else{
                return response()->json([
                    'status'=>'errro',
                    'message'=>'Something went wrong',
                ]);
            }
        }else if($request->post()){
            if( !empty($request['image_id']) ){
                $deleteableImages = AppProductImages::whereNotIn('id',$request['image_id'])->where('product_id',$product->id)->get();
                if($deleteableImages->count()){
                    foreach ($deleteableImages as $delete_key => $delete_value) {
                        File::delete(public_path("uploads/". $delete_value->image));
                        AppProductImages::where('id', $delete_value->id)->delete();
                    }
                }
                return redirect()->route($this->route_path.'.add_attributes',['slug'=> $product->slug ])->with('success','Images upload successfully');
            }else{
                return redirect()->back()->with('success','There is no image uploaded');
            }
        }

        return view($this->route_path . '.images',compact(['product','featured_image','product_gallery_images']));

    }//endof addImages

    /**
     * addAttributes
     * Add Variations for products
     */
    public function addAttributes(Request $request){
        $slug = $request['slug'];
        $product = AppProducts::where('slug',$slug)->first();
        if(empty($product)){
            return redirect()->route($this->route_path.'.index')->with('error','Product not identified');
        }

        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => $this->module_name, "url" => route($this->route_path. '.index'), "icon" => ""],
            ["name" => 'Add ' . $this->module_name, "url" => route($this->route_path. '.add'), "icon" => ""],
            ["name" => 'Upload images', "url" => route($this->route_path. '.add_images',['slug'=>$slug]), "icon" => ""],
            ["name" => 'Add variations', "url" => route($this->route_path. '.add_images',['slug'=>$slug]), "icon" => ""],
        ];
        populate_breadcrumb($breadcrumb);

        $attribute = Masters::attributes();
        $combinations = Masters::combinations();
        
        $selected_attributes = AppProductAttributes::where(['product_id'=>$product->id ,'is_deleted'=>0 ])->where('attribute_id','!=',null)->pluck('attribute_id')->toArray();
        $selected_combinations = AppProductAttributes::where(['product_id'=>$product->id, 'is_deleted'=>0  ])->where('attribute_id',null)->pluck('global_combination_id')->toArray();

        if($request->post()){

            $validated = $request->validate([
                'attributes' => 'required',
                'combinations' => 'sometimes'
            ],[
                'attributes.required' =>'Please select attributes'
            ]);

            AppProductAttributes::where(['product_id'=>$product->id, 'is_deleted'=>0 ])->update(['is_deleted'=>1]);

            foreach ($validated['attributes'] as $attributes_key => $attributes_value) {

                $information = Masters::where('id',$attributes_value )->first();
                if(!empty($information)){
                    $newProductAttribute = new AppProductAttributes();
                    $newProductAttribute->product_id = $product->id;
                    $newProductAttribute->attribute_id = $attributes_value;
                    $newProductAttribute->is_attribute = 1;
                    $newProductAttribute->information =  json_encode($information);
                    $newProductAttribute->save();
                }
            }
            
            foreach ($validated['combinations'] as $combinations_key => $combinations_value) {

                $information = Masters::where('id',$combinations_value )->first();
                if(!empty($information)){
                    $newProductAttribute = new AppProductAttributes();
                    $newProductAttribute->product_id = $product->id;
                    $newProductAttribute->global_combination_id = $combinations_value;
                    $newProductAttribute->is_attribute = 0;
                    $newProductAttribute->information =  json_encode($information);
                    $newProductAttribute->save();
                }
            }

            return redirect()->route($this->route_path.'.add_variations',['slug'=> $product->slug ])->with('success','Attributes added successfully');
            

        }

        return view($this->route_path . '.attributes',compact(['product','attribute','combinations','selected_attributes','selected_combinations']));
    }//endof addAttributes

    /**
     * addVariations
     */
    public function addVariations(Request $request){

        $slug = $request['slug'];
        $product = AppProducts::where('slug',$slug)->first();
        if(empty($product)){
            return redirect()->route($this->route_path.'.index')->with('error','Product not identified');
        }

        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => $this->module_name, "url" => route($this->route_path. '.index'), "icon" => ""],
            ["name" => 'Add ' . $this->module_name, "url" => route($this->route_path. '.add'), "icon" => ""],
            ["name" => 'Upload images', "url" => route($this->route_path. '.add_images',['slug'=>$slug]), "icon" => ""],
            ["name" => 'Add attributes', "url" => route($this->route_path. '.add_attributes',['slug'=>$slug]), "icon" => ""],
            ["name" => 'Add variations', "url" => route($this->route_path. '.add_images',['slug'=>$slug]), "icon" => ""],
        ];
        populate_breadcrumb($breadcrumb);

        $attr_variations = Masters::product_variations($product->id);


        $selectedVariationData = AppProductAttributeVariations::select(['sale_price','price as regular_price','stock as stock_status','id','image','video'])->where(['product_id'=>$product->id, 'is_deleted'=>0, 'is_active'=>1])->get()->toArray();
        foreach ($selectedVariationData as $selected_var_key => $selected_var_value) {
            $selectedVariationData[$selected_var_key]['variations'] = AppProductAttributeVariationDescripiton::where(['variations_id'=>$selected_var_value['id'], 'is_deleted'=>0, 'is_active'=>1 ])->pluck('selected_variation_id', 'selected_variation_name')->toArray();
        }
        session()->put('_old_input', ['form_data'=>$selectedVariationData]);

        if($request->post()){

            // $files = $request->file();
            // prd($files['form_data'][0]['image']);
            // prd($request->file());
            // prd($request['form_data'][0]["image"]);
            // prd($request->hasFile('["form_data"][0]["image"]'));

            $validated = $request->validate([
                'form_data.*.sale_price' => 'required|numeric',
                'form_data.*.regular_price' => 'required|numeric',
                'form_data.*.stock_status' => 'sometimes',
                'form_data.*.image' => 'sometimes',
                'form_data.*.video' => 'sometimes',
                'form_data.*.dataId' => 'sometimes',
                'form_data.*.variations.*' => 'sometimes',
            ],
            [
                'form_data.*.sale_price.required' => 'Please enter sale price',
                'form_data.*.sale_price.numeric' => 'Please enter valid numeric sale price',
                'form_data.*.regular_price.required' => 'Please enter regular price',
                'form_data.*.regular_price.numeric' => 'Please enter valid numeric sale price',
            ]);
            
            $validVariations = [];
            $validVariationItems = [];

            foreach ($validated['form_data'] as $form_data_key => $form_data_value) {


                // $file = $validated['form_data'][$form_data_key]['image'];
                if(!empty($file)){
                    $fileExtension = $file->getClientOriginalExtension();
                    $originalName = $file->getClientOriginalName();
                    $fileSize = $file->getSize();
                    $newFileName = unique_code();
                    $destinationPath = 'uploads/products/';
                    $file->move($destinationPath, $newFileName .'.'. $fileExtension);

                    $newImage = new AppProductImages();
                    $newImage->product_id = $product->id;
                    $newImage->image = 'products/'. $newFileName .'.'. $fileExtension;
                    $newImage->size_in_bytes = $fileSize;
                    $newImage->extension = $fileExtension;
                    $newImage->original_image_name = $originalName;
                    $newImage->image_type = $request['imageType'];
                    $newImage->save();
                }


                // $fileName = $file->getClientOriginalName();
                //prd($fileName);
                // $all_images = request()->allFiles();
                // prd( $request->file(  $validated['form_data'][$form_data_key]['image']));
                // if($request->hasFile($validated['form_data'][$form_data_key]['image'])){
                //     prd('true');
                // }else{
                //     prd('false');
                // }
                
                if(!empty($form_data_value['dataId'])){
                    $new_variation = AppProductAttributeVariations::where('id', $form_data_value['dataId'])->first();
                    if(empty($new_variation)){
                        $new_variation = new AppProductAttributeVariations();
                        $new_variation->product_id = $product->id;
                    }
                }else{
                    $new_variation = new AppProductAttributeVariations();
                    $new_variation->product_id = $product->id;
                }
                
                $new_variation->sale_price = $form_data_value['sale_price'];
                $new_variation->price = $form_data_value['regular_price'];
                $new_variation->image = null;
                $new_variation->video = null;
                $new_variation->stock = $form_data_value['stock_status']; 
                $new_variation->save();

                AppProductAttributeVariationDescripiton::where(['variations_id'=> $new_variation->id, 'product_id'=>$product->id ])->update(['is_deleted'=>1]);
                array_push($validVariations,$new_variation->id );

                foreach ($form_data_value['variations'] as $variations_key => $variations_value) {

                    $variationData = Masters::where('id', $variations_value)->first()->toArray();

                    $new_variation_item = new AppProductAttributeVariationDescripiton();
                    $new_variation_item->product_id = $product->id;
                    $new_variation_item->variations_id = $new_variation->id;
                    $new_variation_item->selected_variation_id = $variations_value;
                    $new_variation_item->selected_variation_parent_id = $variationData['parent_id'];
                    $new_variation_item->selected_variation_name = $variations_key;
                    $new_variation_item->selected_variation_data =  json_encode($variationData);
                    $new_variation_item->save();
                    array_push($validVariationItems,$new_variation_item->id);
                    
                }
                // AppProductAttributeVariationDescripiton::where(['selected_variation_id'=>$new_variation->id, 'product_id'])
            }
            AppProductAttributeVariations::whereNotIn('id', $validVariations)->where(['is_deleted'=>0, 'is_active'=>1,'product_id'=>$product->id])->update(['is_deleted'=>1]);
            AppProductAttributeVariationDescripiton::whereNotIn('id',$validVariationItems)->where(['is_deleted'=>0, 'is_active'=>1,'product_id'=>$product->id])->update(['is_deleted'=>1]);
            AppProducts::where('id', $product->id)->update(['is_draft'=>0]);

            return redirect()->route($this->route_path.'.index')->with('success','Product has been saved successfully');
        }

        return view($this->route_path . '.variations',compact(['product','attr_variations','selectedVariationData']));
    }//endof addVariations


    /**
     * edit()
     * Function use to edit new product
     */
    public function edit(Request $request){

        $slug = $request['slug'];
        $product = AppProducts::where('slug',$slug)->first();
        if(empty($product)){
            return redirect()->route($this->route_path.'.index')->with('error','Product not identified');
        }
        session()->put('_old_input', $product->toArray());

        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => $this->module_name, "url" => route($this->route_path. '.index'), "icon" => ""],
            ["name" => 'Add ' . $this->module_name, "url" => route($this->route_path. '.add'), "icon" => ""],
        ];
        populate_breadcrumb($breadcrumb);
        $diamondShapes = DiamondShapes::all();


        if($request->post()){

            $validatedData = $request->validate([
                'title' => 'required',
                'tags' => 'sometimes',
                'categories'=> 'sometimes',
                'short_description' => 'sometimes',
                'files' => 'sometimes',
                'description' => 'required',
                'is_variation' => 'sometimes',
                'status' => 'sometimes',
                'dfinder_status' => 'sometimes',
                'is_featured' => 'sometimes',
                'diamond_shape' => 'sometimes',
                'meta_title' => 'required',
                'meta_keyword' => 'required',
                'meta_description' => 'required',
            ]);

            $slug = generateSlug($validatedData['title'], AppProducts::class, 'slug');

            $product->title = $validatedData['title'];
            $product->tags = $validatedData['tags'];
            $product->dfinder_status = (int)$validatedData['dfinder_status'];
            $product->diamond_shape = $validatedData['diamond_shape'];
            $product->short_description = $validatedData['short_description'];
            $product->description = $validatedData['description'];
            $product->meta_title = $validatedData['meta_title'];
            $product->meta_keyword = $validatedData['meta_keyword'];
            $product->meta_description = $validatedData['meta_description'];
            $product->is_featured = (int)$validatedData['is_featured'];
            $product->is_variable = (int)$validatedData['is_variation'];
            $product->status = (int)$validatedData['status'];
            if( $product->save() ){

                AppProductCategories::where('product_id',$product->id)->update(['is_deleted'=>1]);
                foreach ($validatedData['categories'] as $categories_key => $categories_value) {
                    $new_categories = new AppProductCategories();
                    $new_categories->product_id = $product->id;
                    $new_categories->category_id = $categories_value;
                    $new_categories->save();
                }

                return redirect()->route($this->route_path.'.add_images',['slug'=> $product->slug ])->with('success','Product saved successfully');
            }else{
                return redirect()->back()->with('error','Something went wrong');
            }
        }

        return view($this->route_path . '.edit',compact(['diamondShapes','product']));
    }//endof edit

    /**
     * getCategories
     * function is used to get categories
     */
    public function getCategories(Request $request){

        $getCatId_arr = [];
        if(isset($request->id)){
            $getCatId_arr = AppProductCategories::where(['product_id'=>$request->id, 'is_deleted'=>0, 'is_active'=>1])->pluck('category_id')->toArray();
        }

        // prd($getCatId_arr);
        // if(isset($request->cate_id)){
        //     $getCategory = Category::find($request->cate_id);
        //     $getCatId = $getCategory->parent_id;
        //     $getCatId_arr = explode(",",$getCatId);
        // }

        $getParentData = Category::where('status',1)->where('parent_id',0)->get()->toArray();
        $dataArray = $child1 = array();
        if(count($getParentData)>0){
            foreach ($getParentData as $key => $parent) {
                $dataArray[$key]['id'] = $parent['id']; 
                $dataArray[$key]['name'] = $parent['name'];
                if(in_array($parent['id'],$getCatId_arr)){
                    echo '<option selected value="'.$parent['id'].'">'.$parent['name'] . '</option>';
                }else{
                    echo '<option  value="'.$parent['id'].'">'.$parent['name'] . '</option>';
                }
                $child = $this->getChildData($parent['id'], 0,$getCatId_arr);
                if(count($child)>0){
                    $dataArray[$key]['parent'] = $child;
                }
            }
        }
        die;
    }// endof getCategories

    /**
     * getChildData
     */
    public function getChildData($parent_id, $level,$getCatId_arr){
        $getChildData = Category::where('status',1)->where('parent_id',$parent_id)->get()->toArray();
        $level++;
        $dataArray = $child1 = array();
        if(count($getChildData)>0){
            foreach ($getChildData as $key => $child) {
                
                if(in_array($child['id'],$getCatId_arr)){
                    echo '<option selected value="'.$child['id'].'">'.str_repeat("-", ($level * 2)) . $child['name'] . '</option>';
                }else{
                    echo '<option value="'.$child['id'].'">'.str_repeat("-", ($level * 2)) . $child['name'] . '</option>';
                }
                $dataArray[$key]['id'] = $child['id']; 
                $dataArray[$key]['name'] = $child['name'];

                $child = $this->getChildData($child['id'], $level,$getCatId_arr);
                if(count($child)>0){
                    $dataArray[$key]['parent'] = $child;
                }

            }
        }
        return $dataArray;
    }//endof getChildData

}