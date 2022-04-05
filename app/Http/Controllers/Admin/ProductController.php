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

        return view('admin.products.index');
    }

    public function create($prodSlug=null,$proid=null)
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

    public function submitProduct(Request $request)
    {

        // return response()->json(implode(",",$request->selected_attribute_name));
        // echo "<pre>";
        // print_r($request->selected_attribute_name);
        $arrayAttribute = [];
        foreach($request->selected_attribute_name as $key => $attribute){
            // echo $attribute;
            $arrayAttribute[$attribute]  = $request[$attribute];

        }
        // print_r($arrayAttribute);
        // die;
        
        $validator = Validator::make($request->all(), [
            // 'title' => 'required',
            // 'categories' => 'required',
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
                'categories'=>isset($request->categories)?implode(",",$request->categories):0,
                'description'=> $request->description,
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
            'vari_sale_price' => $request->vari_sale_price,
            'vari_regular_price' => $request->vari_regular_price,
            'vari_stock_status' => $request->vari_stock_status,
            'arrayAttribute' =>$arrayAttribute,
            
        ];



        $this->updateProductVariation($productDetails->id,$getVariationArray);
        

        $this->uploadProductVariationAttributes($productDetails->id,implode(",",$request->selected_attribute_name));

        echo "Final Submit";

        return redirect()->back()->with('success', $msg);  
    }

    public function updateProductVariation($productId,$getVariationArray)
    {
        // echo "<pre>";
        // print_r($getVariationArray['arrayAttribute']);
        // // print_r();
        // die;

        $attrKeys = array_keys($getVariationArray['arrayAttribute']);
        
        foreach($getVariationArray["vari_sale_price"] as $key => $value){
            $getProductData = ProductVariations::create([
                'product_id'=>$productId,
                'sale_price'=>isset($value)?$value:0.0,
                'regular_price'=>isset($getVariationArray['vari_regular_price'][$key])?$getVariationArray['vari_regular_price'][$key]:0.0,
                'stock_status'=>isset($getVariationArray['vari_stock_status'][$key])?$getVariationArray['vari_stock_status'][$key]:0,
            ]);

            foreach($getVariationArray['arrayAttribute'] as $key1 => $attr){
                // echo "<pre>";
                // print_r($key1);
                // print_r($key);
                // print_r($attr);
                // die;
                ProductVariationDetails::create([
                    'variation_id'=>$getProductData->id,
                    'key' =>$key1,
                    'value' =>$attr[$key],
                ]);
            }

        }
        // echo "final";
        // die;

        return true;
    }

    public function uploadProductVariationAttributes($productId,$variationAttributesArray)
    {
        ProductVariationAttributes::updateOrCreate(['product_id'=>$productId],[
            'product_id'=>$productId,
            'attr_values'=> $variationAttributesArray,
        ]);

        $this->uploadProductVariationDetails();

        return true;
        // echo "Done<pre>";
        // print_r($variationAttributesArray);
        // die;
    }

    public function uploadProductVariationDetails()
    {
        # code...
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

    public function getAttribute()
    {
        $getData = Attributes::latest()->get();
        return response()->json($getData);
    }
}
