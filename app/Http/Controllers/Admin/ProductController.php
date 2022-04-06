<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\ProductVariations;
use App\Models\ProductVariationAttributes;
use App\Models\ProductVariationDetails;
use App\Models\Attributes;

class ProductController extends Controller
{
    public function index(Type $var = null)
    {
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Product Lists", "url" => route("admin.products-list"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);

        $getProducts = Products::latest()->get();



        return view('admin.products.index',compact('getProducts'));
    }

    public function create()
    {

        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Product Form", "url" => route("admin.products-createform"), "icon" => "fa fa-home"],
        ];
        populate_breadcrumb($breadcrumb);

        // $result = [
        //     'getCategoryData' => $getCategoryData,
        // ];

        return view('admin.products.create');
    }

    public function updatePage($productId = null)
    {

        

        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Product Form", "url" => route("admin.products-createform"), "icon" => "fa fa-home"],
        ];
        populate_breadcrumb($breadcrumb);

        $getProductData = Products::with('getProductImages','getProductGallery')->where('id',$productId)->first();

        if ($productId == '' && !isset($getProductData) && empty($getProductData)){
            return 'URL NOT FOUND';
        }

        // echo "asfs<pre>";
        // print_r($getProductData);
        // die;

        $result = [
            'getProductData' => $getProductData,
        ];

        return view('admin.products.update',$result);
    }

    public function submitProduct(Request $request)
    {

        // return response()->json($request->data);

        $validator = Validator::make($request->all(), [
            // 'title' => 'required',
            // 'description' => 'required',
            // 'featured_image' => 'required',
        ]);

        //  setup categories 
        //  $getParentId = 0;
        if(isset($request->table_id) && !empty($request->table_id)){
            if($request->table_id == $request->categories){
                $request->categories = 0;
            }elseif(!isset($request->categories) && empty($request->categories)){
                $request->categories = 0;
            }

            if($request->slug_bk != $request->slug){
                $newSlug = new SlugController;
                $newCustomSlug = $newSlug->makeNewSlugName('Products',$request->title,$request->slug);  // 1. Model Name 2. Name/Title. 3. slugName
            }else{
                $newCustomSlug = $request->slug;
            }
        }else{
            $newSlug = new SlugController;
            $newCustomSlug = $newSlug->makeNewSlugName('Products',$request->title,$request->slug);  // 1. Model Name 2. Name/Title. 3. slugName
        }

        if($validator->fails()){
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }else{
            $productDetails = Products::updateOrCreate(['id'=>$request->table_id],[
                'title'=> $request->title,
                'slug'=> strtolower($newCustomSlug),
                'tags'=> $request->tags,
                'status'=> isset($request->status)?$request->status:0,
                'is_featured'=> isset($request->is_featured)?$request->is_featured:0,
                'is_taxable'=> isset($request->is_taxable)?$request->is_taxable:0,
                'categories'=>isset($request->categories)?implode(",",$request->categories):0,
                'description'=> $request->description,
                'sale_price'=> $request->sale_price,
                'regular_price'=> $request->regular_price,
                'meta_title'=> $request->meta_title,
                'meta_keyword'=> $request->meta_keyword,
                'meta_description'=> $request->meta_description,
                // 'image_url'=> $image,
            ]);
            $msg = 'Successfully added!!!';
        }

        if($request->hasFile('gallery_image')) {
            $imagegallery_image = single_image_upload($request->file('gallery_image'),'Products');
        }else{
            $imagegallery_image = $request->image_url_bk;
        }

        if($request->hasFile('featured_image')) {
            $imagefeatured_image = single_image_upload($request->file('featured_image'),'Products');
        }else{
            $featured_image = $request->image_url_bk;
        }
        
        $finalArrayImages = array_merge($imagegallery_image,$imagefeatured_image);
        if(isset($finalArrayImages) && !empty($finalArrayImages) && count($finalArrayImages)){
            $this->uploadProductImages($finalArrayImages,$productDetails->id);
        }

        $getVariationArray = [
            'variationData' => $request->data,
        ];

        $this->updateProductVariation($productDetails->id,$getVariationArray);
        

        $this->uploadProductVariationAttributes($productDetails->id,implode(",",$request->selected_attribute_name));

        // return response()->json($request->all());

        return redirect()->back()->with('success', $msg);  
    }

    public function updateProductVariation($productId,$getVariationArray)
    {
        foreach($getVariationArray['variationData'] as $key => $value){

            if(isset($value['vari_image']) && $value['vari_image']) {
                $imageVariImage = product_image_upload($value['vari_image'],'ProductsVariImages');
            }else{
                $imageVariImage = null;
            }

            if(isset($value['vari_video']) && $value['vari_video']) {
                $imageVariVideo = product_video_upload($value['vari_video'],'ProductsVariVideos');
            }else{
                $imageVariVideo = null;
            }

            $getProductDataVariation = ProductVariations::create([
                'product_id'=>$productId,
                'sale_price'=>isset($value['vari_sale_price'])?$value['vari_sale_price']:0,
                'regular_price'=>isset($value['vari_regular_price'])?$value['vari_regular_price']:0.0,
                'stock_status'=>isset($value['vari_stock_status'])?$value['vari_stock_status']:0,
                'vari_image'=>isset($imageVariImage)?$imageVariImage:null,
                'vari_video'=>isset($imageVariVideo)?$imageVariVideo:null,
            ]);

            foreach($value as $key1 => $variData){
                $newKey = explode("_",$key1);
                if(isset($newKey[0]) && $newKey[0] === 'attri'){
                    ProductVariationDetails::create([
                        'variation_id'=>$getProductDataVariation->id,
                        'key' =>$key1,
                        'value' =>$variData,
                    ]);
                }
            }
        }
        return true;
    }

    public function uploadProductVariationAttributes($productId,$variationAttributesArray)
    {
        ProductVariationAttributes::updateOrCreate(['product_id'=>$productId],[
            'product_id'=>$productId,
            'attr_values'=> $variationAttributesArray,
        ]);

        return true;
    }

    public function uploadProductImages($imagesArray,$productId)
    {
        foreach($imagesArray as $key => $image){
            if($key == 'f2'){
                $productDetails = ProductImages::create([
                    'product_id'=> $productId,
                    'image_url'=> $image,
                    'is_featured'=> 1,
                ]);
            }else{
                $productDetails = ProductImages::create([
                    'product_id'=> $productId,
                    'image_url'=> $image,
                    'is_featured'=> 0,
                ]);
            }
        }
        return true;
    }

    public function addAttribute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'value' => 'required',
        ]);

        $newSlug = new SlugController;
        $newCustomSlug = $newSlug->makeNewSlugName('Attributes',$request->name,$request->name);  
        // 1. Model Name 2. Name/Title. 3. slugName
    

        if($validator->fails()){
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }else{
            $addAttributes = Attributes::updateOrCreate(['slug'=>$request->slug],[
                'name'=> $request->name,
                'slug'=> strtolower($newCustomSlug),
                'values'=> $request->value,
            ]);
        }
        return response()->json(['success'=>"true"]);
    }

    public function getAttribute(Request $request)
    {
        

        $getAttrId_arr = [];
        if(isset($request->id)){
            $getAttribute = ProductVariationAttributes::where('product_id',$request->id)->first();
            if(isset($getAttribute) && !empty($getAttribute)){
                $getAttrId = $getAttribute->attr_values;
                $getAttrId_arr = explode(",",$getAttribute->attr_values);
            }
        }

        $getData = Attributes::latest()->get();


        if(count($getData)>0){
            foreach ($getData as $key => $parent) {
                if(in_array('attri_'.$parent->slug,$getAttrId_arr)){
                    // echo '<option selected value="'.$parent['id'].'">'.$parent['name'] . '</option>';
                    echo '<div><input type="checkbox" checked id="attributevari'.$parent->id.'" name="selected_attribute_name[]" data-name="'.$parent->name.'" data-value="'.$parent->values.'" value="attri_'.$parent->slug.'">'.$parent->name.'</div>';
                }else{
                    echo '<div><input type="checkbox" id="attributevari'.$parent->id.'" name="selected_attribute_name[]" data-name="'.$parent->name.'" data-value="'.$parent->values.'" value="attri_'.$parent->slug.'">'.$parent->name.'</div>';
                }
            }
        }
        die;
        // return response()->json($getData);
    }


    public function status(Request $request)
    {
        $statusChange = Products::findOrFail($request->id);
        if($statusChange){
            
            $statusChange->update([
                'status'=>$request->status,
            ]);
            return response()->json($statusChange);
        }
        return response()->json(['error'=>'geterror'],422);
    }

    public function delete(Request $request)
    {
        
        $post = Products::find($request->id)->delete();
        return response()->json($post);
    }
}
