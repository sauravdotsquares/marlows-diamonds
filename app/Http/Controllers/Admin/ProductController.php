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
use Illuminate\Support\Arr;
use App\Models\DiamondShapes;
use App\Models\ProductVariationsMaster;
use App\Models\GlobalCombinationsVariations;
use App\Models\Masters;
use App\Models\ProductThumbVideos;
use App\Models\Category;
use App\Models\ProductPricingUpdates;
use App\Models\LabPricesList;


use View, DB;

class ProductController extends Controller
{

    
    public function __construct(){
        $this->lab_price_path = "admin.products.lab_price_variations.";
    }

    public function index(Request $request){
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Product Lists", "url" => route("admin.products-list"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);

        $query = Products::latest();

        $query = getFilter(Products::class, $query, $request->query());

        $getProducts = $query->paginate(10);

        return view('admin.products.index',compact('getProducts'));
    }

    public function create(){
        $breadcrumb = [
            ["name" => "Add New Product", "url" => route("admin.products-createform"), "icon" => "fa fa-home"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
        ];
        populate_breadcrumb($breadcrumb);

        $diamondShapes = DiamondShapes::all();

        // $result = [
        //     'getCategoryData' => $getCategoryData,
        // ];

        return view('admin.products.create',compact('diamondShapes'));
    }

    public function updatePage($productId = null){
        $breadcrumb = [
            ["name" => "Edit Product", "url" => route("admin.products-createform"), "icon" => "fa fa-home"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
        ];
        populate_breadcrumb($breadcrumb);

        $getProductData = Products::with('getProductImages','getProductGallery')->where('id',$productId)->first();

        if ($productId == '' && !isset($getProductData) && empty($getProductData)){
            return 'URL NOT FOUND';
        }
        $diamondShapes = DiamondShapes::all();

        return view('admin.products.update',compact('getProductData','diamondShapes'));
    }

    public function submitProduct(Request $request){

        $validator = Validator::make($request->all(), [
            // 'title' => 'required',
            // 'description' => 'required',
            // 'featured_image' => 'required',
        ]);

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
                'dfinder_status'=> isset($request->dfinder_status)?$request->dfinder_status:0,
                'diamond_shape'=> isset($request->diamond_shape)?$request->diamond_shape:'',
                'is_variable'=> isset($request->is_variation)?$request->is_variation:1,
                'is_featured'=> isset($request->is_featured)?$request->is_featured:0,
                'is_taxable'=> isset($request->is_taxable)?$request->is_taxable:0,
                'stock_status'=> isset($request->in_stock)?$request->in_stock:1,
                'categories'=>isset($request->categories)?implode(",",$request->categories):0,
                'short_description'=> $request->short_description,
                'description'=> $request->description,
                'sale_price'=> $request->sale_price,
                'regular_price'=> $request->regular_price,
                'meta_title'=> $request->meta_title,
                'meta_keyword'=> $request->meta_keyword,
                'meta_description'=> $request->meta_description,
            ]);
            $msg = 'Successfully submitted!!!';
        }

        if($request->hasFile('featured_image')) {
            $imagefeatured_image = final_image_upload_single_function($request->file('featured_image'),'Products',$productDetails->id,'230','230');
        }else{
            $imagefeatured_image = [];
        }
        //print_r($imagefeatured_image); die;
        if($request->hasFile('gallery_image')) {
            $imagegallery_image = final_image_upload_array_function($request->file('gallery_image'),'Products',$productDetails->id,'230','230');
        }else{ 
            $imagegallery_image = [];
        }

        //print_r($imagefeatured_image); die;
        if(count($imagegallery_image) || count($imagefeatured_image)){
            $finalArrayImages = array_merge($imagegallery_image,$imagefeatured_image);
        }else{
            $finalArrayImages = [];
        }

        if(isset($finalArrayImages) && !empty($finalArrayImages) && count($finalArrayImages)){
            $this->uploadProductImages($finalArrayImages,$productDetails->id);
        }

        if(isset($request->data) && !empty($request->data)){
            $getVariationArray = [
                'variationData' => $request->data,
            ];
            $this->updateProductVariation($productDetails->id,$getVariationArray);
        }

        if(isset($request->selected_attribute_name) && !empty($request->selected_attribute_name)){
            $this->uploadProductVariationAttributes($productDetails->id,implode(",",$request->selected_attribute_name));
        }

        // return response()->json($request->all());

        return redirect()->back()->with('success', $msg);
    }

    public function updateProductVariation($productId,$getVariationArray)
    {

        $getProductVariation = ProductVariations::where('product_id',$productId)->pluck('id');
        //ProductVariationDetails::whereIn('variation_id',$getProductVariation)->delete();
        //ProductVariations::where('product_id',$productId)->delete();
        //echo '<pre>'; print_r($getVariationArray['variationData']); die;
        foreach($getVariationArray['variationData'] as $key => $value){

            if(isset($value['vari_image']) && $value['vari_image']) {
                $imageVariImage = product_image_upload($value['vari_image'],'ProductsVariImages');
            }else if(isset($value['vari_image_exist']) && $value['vari_image_exist']){
                $imageVariImage = $value['vari_image_exist'];
            }else{
                $imageVariImage = null;
            }


            if(isset($value['vari_video']) && $value['vari_video']) {
                $imageVariVideo = product_video_upload($value['vari_video'],'ProductsVariVideos');
            }else if(isset($value['vari_video_exist']) && $value['vari_video_exist']) {
                $imageVariVideo = $value['vari_video_exist'];
            }else{
                $imageVariVideo = null;
            }

           if(isset($value['is_update']) && $value['is_update']!=''){

                $getProductDataVariation = ProductVariations::where('id',$value['is_update'])
                ->update([
                    'sale_price'=>isset($value['vari_sale_price'])?$value['vari_sale_price']:0,
                    'regular_price'=>isset($value['vari_regular_price'])?$value['vari_regular_price']:0.0,
                    'stock_status'=>isset($value['vari_stock_status'])?$value['vari_stock_status']:0,
                    'vari_image'=>isset($imageVariImage)?$imageVariImage:null,
                    'vari_video'=>isset($imageVariVideo)?$imageVariVideo:null,
                ]);
           }else{
                $getProductDataVariation = ProductVariations::create([
                    'product_id'=>$productId,
                    'sale_price'=>isset($value['vari_sale_price'])?$value['vari_sale_price']:0,
                    'regular_price'=>isset($value['vari_regular_price'])?$value['vari_regular_price']:0.0,
                    'stock_status'=>isset($value['vari_stock_status'])?$value['vari_stock_status']:0,
                    'vari_image'=>isset($imageVariImage)?$imageVariImage:null,
                    'vari_video'=>isset($imageVariVideo)?$imageVariVideo:null,
                ]);
            }

            /*
                echo $value['attri_carat']; die;
                echo '<pre>'; print_r($value); die;
            */

            foreach($value as $key1 => $variData){
                $newKey = explode("_",$key1);
                if(isset($newKey[0]) && $newKey[0] === 'attri'){

                    if(isset($value['is_update']) && $value['is_update']!=''){

                       ProductVariationDetails::where('variation_id',$value['is_update'])->where('key',$key1)->update([
                            'value' =>$variData,
                        ]);
                   }else{

                        ProductVariationDetails::create([
                            'product_id' => $productId,
                            'variation_id'=>$getProductDataVariation->id,
                            'key' =>$key1,
                            'value' =>$variData,
                        ]);

                   }

                }
            }

        }

        return true;
    }

    public function deleteProductVariation(Request $request){

        ProductVariations::where('id',$request->var_id)->delete();

        ProductVariationDetails::where('variation_id',$request->var_id)->delete();

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
        if(count($imagesArray) && !empty($imagesArray)){

            foreach($imagesArray as $key => $image){
                if($key == 'f2'){
                    $productDetails = ProductImages::create([
                        'product_id'=> $productId,
                        // 'thumb_image_url'=> $image['T'],
                        'image_url'=> $image['R'],
                        'is_featured'=> 1,
                    ]);
                }else{
                    $productDetails = ProductImages::create([
                        'product_id'=> $productId,
                        // 'thumb_image_url'=> $image['T'],
                        'image_url'=> $image['R'],
                        'is_featured'=> 0, 
                    ]);
                }
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
            $getAttributeDesign = '';
            foreach ($getData as $key => $parent) {
                if(in_array('attri_'.$parent->slug,$getAttrId_arr)){
                    // echo '<option selected value="'.$parent['id'].'">'.$parent['name'] . '</option>';
                    $getAttributeDesign .=  '<div><input type="checkbox" checked id="attributevari'.$parent->id.'" name="selected_attribute_name[]" data-name="'.$parent->name.'" data-value="'.$parent->values.'" value="attri_'.$parent->slug.'">'.$parent->name.'</div>';
                }else{
                    $getAttributeDesign .=  '<div><input type="checkbox" id="attributevari'.$parent->id.'" name="selected_attribute_name[]" data-name="'.$parent->name.'" data-value="'.$parent->values.'" value="attri_'.$parent->slug.'">'.$parent->name.'</div>';
                }
            }
        }

        $finalResult = [
            'getAttributeDesign' => $getAttributeDesign,
            'getAttrId_arr' => $getAttrId_arr,
            'getAttribute' => isset($getAttribute)?$getAttribute:'',
            'getData'=>$getData
        ];
        // die;
        return response()->json($finalResult);
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

    // public function getProductDetailsVariation(Request $request)
    // {
    //     $getVariationId = ProductVariations::where('product_id',$request->id)->pluck('id');
    //     $getVariationData = ProductVariations::where('product_id',$request->id)->get();

    //     $getVariationDetails = ProductVariationDetails::select('variation_id','key','value')->whereIn('variation_id',$getVariationId)->get();

    //     $getData = Attributes::latest()->get();

    //     $result = [
    //         'getVariationId' => $getVariationId,
    //         'getVariationData' => $getVariationData,
    //         'getVariationDetails' => $getVariationDetails,
    //         'getData'=>$getData
    //     ];

    //     return response()->json($result);

    // }

    public function getProductDetailsVariation(Request $request)
    {
        $getVariations = ProductVariations::where('product_id',$request->id)->get()->toArray();

        // Get Product Attributes

        $attributes_val = ProductVariationAttributes::where('product_id',$request->id)->value('attr_values');

        if($attributes_val!=''){

            $attributes = explode(',', $attributes_val);
            $all_attrs = [];
            foreach ($attributes as $key => $attribute) {

                $attr_key = explode('_', $attribute);
                $attr = Attributes::where('slug',$attr_key[1])->first();
                $attr_val = explode('|',$attr->values);
                $all_attrs[$key]['name'] = $attr->name;
                $all_attrs[$key]['key'] = $attribute;
                $all_attrs[$key]['value'] = $attr_val;
            }

        }

        //echo '<pre>';print_r($all_attrs); die;

        $variationArray = [];
        if(!empty($getVariations)){
            foreach ($getVariations as $key => $variation) {
                if($key==0) $section = 'item_details'; else $section = 'item_details'.$key;
                // Get Product Variations

                $prod_variations = ProductVariationDetails::where('variation_id',$variation['id'])->get();
                $prod_varitn = [];
                foreach ($prod_variations as $key1 => $prod_variation) {
                    $prod_varitn[$prod_variation->key]=$prod_variation->value;
                }
                //echo '<pre>'; print_r($prod_varitn); die;
                $variationArray[] = View::make('admin.products.variation',['index'=>$key,'section'=>$section,'variation'=>$variation,'all_attrs'=>$all_attrs,'prod_varitn'=>$prod_varitn])->render();
            }
        }
        return $variationArray;
    }

    public function removeProductImages(Request $request)
    {
        $productDetails = ProductImages::where('id',$request->productimage)->delete();

        return response()->json(['status'=>200,'msg'=>"Removed!!!"]);

    }

    public function getProductExcelReport(){
        // Excel file name for download
        $fileName = "product-data_" . date('Y-m-d') . ".xls";

        // Column names
        $fields = array('Product Name','Carat','Metal','DiamondWeight','Width','Price');

        // Display column names as first row
        $excelData = implode("\t", array_values($fields)) . "\n";

        // Fetch records from database
        $getAllProductList = Products::with(['getProductVariation'])->select('*')->latest()->get();

        if(count($getAllProductList)){
            foreach($getAllProductList as $key => $products){
                foreach($products->getProductVariation as $key1 => $var1){
                    $title = '';
                    $metalType = '';
                    $caratType = '';
                    $widthType = '';
                    $diamondWeight = '';
                    $price = '';
                    foreach($var1->get_vari_details_id as $key2 => $var2){
                        $var2->key = str_replace("attri_","",$var2->key);
                        $title = $products->title;
                        if(isset($var2->key) && $var2->key == 'metal-type'){
                            $metalType .= $var2->value;
                        }else{
                            $metalType .= '';
                        }
                        if(isset($var2->key) && $var2->key == 'carat'){
                            $caratType .= $var2->value;
                        }else{
                            $caratType .= '';
                        }
                        if(isset($var2->key) && $var2->key == 'total-diamond-weight'){
                            $diamondWeight .= $var2->value;
                        }else{
                            $diamondWeight .= '';
                        }
                        if(isset($var2->key) && $var2->key == 'width-mm'){
                            $widthType = $var2->value;
                        }else{
                            $widthType = '';
                        }
                        $price = $var1->regular_price;
                    }
                    $lineData = array($products->title,$caratType,$metalType,$diamondWeight,$widthType,$var1->regular_price);
                    $excelData .= implode("\t", array_values($lineData)) . "\n";
                }
            }
        }else{
            $excelData .= 'No records found...'. "\n";
        }

        // Headers for download
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");

        // Render excel data
        echo $excelData;
        exit;
    }


    public function productPricing(Request $request){

        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Products", "url" => route("admin.products-list"), "icon" => ""],
            ["name" => "Product pricing", "url" => route("admin.product-pricing",[$request['slug']]), "icon" => ""],
        ];
        $page_title = 'Product pricing';
        populate_breadcrumb($breadcrumb);
        $product = Products::where(['slug'=> $request['slug']])->first();
        if(empty($product)){
            return redirect()->route('admin.products-list')->with('error','Products not identified');
        }
        
        $variationData = ProductVariationsMaster::select(['id','master_id','price','total_price'])->where(['product_id'=> $product->id, 'is_active'=>1, 'is_deleted'=>0])->get()->toArray();

        foreach ( $variationData as $k=>$v ){
            $variationData[$variationData[$k]['master_id']] = $v;
            unset($variationData[$k]);
        }
        $caratData = Masters::where(['type'=> 'carat'])->get();

        if($request->post()){

            

            $validated = $request->validate([
                'data.*.master_id' => 'required|numeric',
                'data.*.price' => 'required|numeric|digits_between:1,7',
                'data.*.total_price' => 'sometimes',
                'data.*.dataId' => 'sometimes',
                'slug' => 'required',
            ],
            [
                'data.*.master_id.required' => 'Please select carat',
                'data.*.master_id.price' => 'Please select valid price',
                'data.*.price.digits_between' => 'Price must be between 1 and 7 digits.',
                'data.*.price.total_price' => 'Total price must be between 1 and 7 digits.',
                'data.*.price.required' => 'Please enter numbers',
                'data.*.price.total_price' => 'Please enter numbers',
                'data.*.price.numeric' => 'Please enter valid numbers',
            ]);

            if(!empty($validated['data'])){
                $validDataId = [];
                foreach ($validated['data'] as $data_key => $data_value) {

                    $master_data = Masters::where('id',$data_value['master_id'] )->first();

                    if(!empty($data_value['id'])){
                        $new_record = ProductVariationsMaster::where(['id'=> $data_value['id']])->first();
                        if(empty($new_record)){
                            $new_record = new ProductVariationsMaster();
                            $new_record->product_id = $product->id;
                        }
                    }else{
                        $new_record = new ProductVariationsMaster();
                        $new_record->product_id = $product->id;
                    }

                    $new_record->master_id = $data_value['master_id'];
                    $new_record->master_parent_id =  $master_data->parent_id;
                    $new_record->master_data = json_encode($master_data);
                    $new_record->combination_id = 1;
                    $new_record->price = $data_value['price'];
                    $new_record->total_price = $data_value['total_price'];
                    $new_record->save();
                    array_push($validDataId, $new_record->id);
                }

                ProductVariationsMaster::whereNotIn('id', $validDataId)->where(['product_id'=>$product->id])->where('is_deleted',0)->update(['is_deleted'=>1]);
                return redirect()->back()->with('success','Pricing updated successfully');
            }

        }

        
        return view('admin.products.pricing',compact(['product','page_title','caratData','variationData']));
        //ProductVariationsMaster
        
    }


    public function getProductPricing(Request $request){

        // $request['price']
        if(!empty($request['price']) && is_numeric($request['price'])  && strlen($request['price']) < 7 ){

            $dataToSend = [];
            $combinationData = GlobalCombinationsVariations::where('global_combinations_id',1)->get()->toArray();
            foreach ($combinationData as $combination_key => $combination_value) {

                $master_type = Masters::select(['name','slug','id'])->where('id', $combination_value['variations_id']['metal_types'] )->first();
                $product_type = Masters::select(['name','slug','id'])->where('id', $combination_value['variations_id']['product_type'] )->first();
                
                $percentage = (float)$combination_value['price'];
                $totalWidth = (float)$request['price'];
                $new_width = ($percentage / 100) * $totalWidth;
                $new_width = number_format((float)$new_width, 2, '.', '');

                $string = $product_type->name .' + '. $master_type->name . '( '.  $percentage .'% ) = ' . $new_width;

                array_push($dataToSend, $string);
            }

            return response()->json(['status'=>'success', 'price'=> $request['price'], 'data'=> $dataToSend]);

        }else{
            return response()->json(['status'=>'error']);
        }

    }


    public function uploadFiles(Request $request){

        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Products", "url" => route("admin.products-list"), "icon" => ""],
            ["name" => "Product file", "url" => route("admin.update_product_images",[$request['slug']]), "icon" => ""],
        ];
        $page_title = 'Product pricing';
        populate_breadcrumb($breadcrumb);
        $product = Products::where(['slug'=> $request['slug']])->first();
        if(empty($product)){
            return redirect()->route('admin.products-list')->with('error','Products not identified');
        }
        if($request->post()){

            if($request->hasFile('image')){
                //$imageVariVideo = product_video_upload($value['vari_video'],'ProductsVariVideos');
                $image = product_video_upload($request->file('image'),'ProductsVariVideos');

                $file = $request->file('image');

                if(!empty($image) && !empty($image)){
                    $new_image = new ProductThumbVideos();
                    $new_image->product_id  = $product->id;
                    $new_image->image_url = $image;
                    $new_image->type = "thumbnail_rotation_image";
                    $new_image->status = 1;
                    $new_image->extension = $file->getClientOriginalExtension();;
                    $new_image->size = $file->getSize();
                    if( $new_image->save() ){
                        
                        ProductThumbVideos::where(['type'=>'thumbnail_rotation_image','product_id'=> $product->id])->where('id','!=',$new_image->id)->delete();

                        return redirect()->back()->with('success','File uploaded successfully');
                    }else{
                        return redirect()->back()->with('error','Something went wrong');
                    }
                }

                
            }else{
                return redirect()->back()->with('error','Something went wrong');
            }
        }

        return view('admin.products.upload_files', compact(['product']));
    }

    /**
     * basePriceList
     * List of prices of all prices
     */
    public function basePriceList(Request $request){


        /** Query to get all variations and products */
        $dataToMarkup = ProductVariations::whereHas('product', function($query) {
            $query->select(['id','status','categories','title','dfinder_status']);
            $query->where(['status'=>1, 'dfinder_status'=>1]);
        })->with(['product'=>function($query){
            $query->select(['id','title','categories','slug']);
        }])
        ->get();

        $fileName = date('d-m-Y') .'-products-markup.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $vat = getVAT();
        $columns = [
            'Product', 
            'Variations', 
            'Markup price',
            'Vat ' . '('.$vat.')',
            'Total',
        ];

        $callback = function() use($dataToMarkup, $columns, $vat) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($dataToMarkup as $key => $value) {
                if($value->regular_price > 0){
                    $totalAmount = $value->regular_price * $vat;

                    $Variations_data = [];
                    foreach($value->get_vari_details_id as $key => $attribute){
                        $att_key = str_replace("attri_","",$attribute->key);
                        $Variations_data[] = $att_key. ":- " . ($attribute->value ? $attribute->value : 'All') ;
                    }
                    $row['Product'] = $value->product->title;
                    $row['Variations'] = implode(', ',$Variations_data);
                    $row['markup_price'] = $value->regular_price;
                    $row['vat'] = round($totalAmount - $value->regular_price);
                    $row['Total'] = round($totalAmount);
                    fputcsv($file, $row);
                }
            }

            // foreach ($product_variations as $task) {
            //     $row['product']  = $task->product->title;
            //     $Variations_data = [];
            //     foreach($task->get_vari_details_id as $key => $attribute){
            //         $att_key = str_replace("attri_","",$attribute->key);
            //         $Variations_data[] = $att_key. ":- " . $attribute->value;
            //     }
            //     $row['variations'] = implode(', ',$Variations_data);
            //     $row['base_price']  =  show_percentage($task->regular_price, $pricingData);
            //     $row['mined_price']  = !empty($task['mined']['regular_price']) ?  show_percentage($task['mined']['regular_price'], $pricingData)  : 'N/A';
            //     $row['lab_grown_price']  = !empty($task['lab_grown']['regular_price']) ? show_percentage($task['lab_grown']['regular_price'], $pricingData) : 'N/A';
            //     $row['discounted']  = "N/A";
            //     $row['new_price']  = show_percentage($task->regular_price,$pricingData,'action' );
            //     $row['new_mined']  = !empty($task['mined']['regular_price']) ?  show_percentage($task['mined']['regular_price'],$pricingData,'action' ) : 'N/A' ;
            //     $row['new_lab_grown']  = !empty($task['lab_grown']['regular_price']) ?  show_percentage($task['lab_grown']['regular_price'],$pricingData,'action' ) : 'N/A' ;;
            //     fputcsv($file, $row);
            // }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);


        // $datatocheck = DB::raw('select * from md_products where FIND_IN_SET(2, categories) OR FIND_IN_SET(3, categories) OR FIND_IN_SET(4, categories) OR FIND_IN_SET(5, categories) OR FIND_IN_SET(6, categories)')->get();
        // $to_data = [2,3,4,5,6];
        // $notIn = 54;
        // // $child_categories = Category::get_all_child_ids(2);
        // // prd($child_categories);die;
        // $productIdsQuery = Products::where('status',1);
        // $category_custom_query = '';
        // foreach ($to_data as $cat_key => $cat_value) {
        //     if(!$cat_key){  $category_custom_query .= '( '; }
        //     $category_custom_query .= " find_in_set('".$cat_value."',categories)";
        //     if($cat_key+1 != count($to_data)){ $category_custom_query .= " OR "; }
        //     else{ $category_custom_query .= ' ) '; }
        // }
        // $category_custom_query .= " AND NOT find_in_set($notIn, categories) ";

        // $productIdsQuery->whereRaw(DB::raw($category_custom_query));
        // $productIdsQuery = $productIdsQuery->pluck('id');
        // prd($productIdsQuery);

        $data = $request->all();
        $search = true;
        $productId = "";
        $pricingData=null;
        $productName = !empty($data['title']) ? $data['title'] : '';

        $isExport  = (!empty($request['export']) && $request['export']=='true') ? true : false;

        /** filter according to update pricing id */
        if(!empty($request['pricing-id'])){
            $pricingData = ProductPricingUpdates::where('id', $request['pricing-id'])->first();
            if(!empty($pricingData)){
                $search = false;
                $data['category'] = !empty($pricingData->category_id) ? $pricingData->category_id : '';
                $productId = !empty($pricingData->product_id) ? $pricingData->product_id : '';
                $productName = "";
            }
        }

        $product_pricing_ids = ProductPricingUpdates::where(['is_deleted'=>0, 'is_active'=>1])->get();
        $categories = Category::category_options();
        /** breadcrumb */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Products", "url" => route("admin.products-list"), "icon" => ""],
            ["name" => "Product pricing", "url" => route("admin.base-price-list"), "icon" => ""],
        ];
        $page_title = 'Product pricing';
        populate_breadcrumb($breadcrumb);

        
        $category = !empty($data['category']) ? Category::get_all_child_ids($data['category']) : [];

        $category_custom_query = "";
        foreach ($category as $cat_key => $cat_value) {
            if(!$cat_key){  $category_custom_query .= '( '; }
            $category_custom_query .= " find_in_set('".$cat_value."',categories)";
            if($cat_key+1 != count($category)){ $category_custom_query .= " OR "; }
            else{ $category_custom_query .= ' ) '; }
        }

        /** Query to count total products */
        $productsCount = Products::where('status',1)->select(['id','status','categories']);

        if(!empty($productId)){
            $productsCount->where('id', $productId);
        }
        if(!empty($category) && !empty($category_custom_query)){
            $productsCount->whereRaw(DB::raw($category_custom_query));
        }
        if(!empty($productName)){
            $productsCount->where('title', 'like' , "%$productName%");
        }
        $productsCount = $productsCount->count();

        /** Query to get all variations and products */
        $query = ProductVariations::whereHas('product', function($query) use ($category_custom_query, $productId,$productName) {
            if(!empty($category_custom_query)){
                $query->whereRaw(DB::raw($category_custom_query));
            }
            $query->select(['id','status','categories','title']);
            if(!empty($productId)){
                $query->where('id', $productId);
            }
            if(!empty($productName)){
            $query->where('title', 'like' , "%$productName%");
        }
        })
        ->with(['product'=>function($query) use ($data) {
            $query->select(['id','title','categories','slug']);
        }])
        ->select(['id','product_id','sale_price','regular_price']);

        if($isExport){
            /** if this data is for export */
            $product_variations = $query->get();
        }else{
            /** if this data is for listing */
            $product_variations = $query->paginate(500);
        }
        

        if($product_variations->count()){
            
            /** Update prices according to static calculations */
            foreach ($product_variations as $key => $value) {

                $selected_variation =  [];
                foreach ($value->get_vari_details_id as $var_key => $var_value) {
                    $selected_variation[] = $var_value->value;
                }

                $pricing = Products::product_pricing([
                    "slug" => $value->product->slug,
                    "variations" => $selected_variation,
                    "diamond_type" => 'mined'
                ]);

                $lab_grown_pricing = Products::product_pricing([
                    "slug" => $value->product->slug,
                    "variations" => $selected_variation,
                    "diamond_type" => 'lab_grown'
                ]);

                $value->mined = $pricing;
                $value->lab_grown = $lab_grown_pricing;
            }
        }

        // prd($product_variations->toArray());die;

        if(!empty($request['export']) && $request['export']=='true'){
            $fileName = date('d-m-Y') .'-pricing.csv';
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
            $columns = [
                'Product', 
                'Variations', 
                'Base Price',
                'Mined Price',
                'Lab grown Price',
                'Discounted',
                'New Price',
                'New Mined',
                'New Lab grown'
            ];

            $callback = function() use($product_variations, $columns, $pricingData) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
    
                foreach ($product_variations as $task) {
                    $row['product']  = $task->product->title;
                    $Variations_data = [];
                    foreach($task->get_vari_details_id as $key => $attribute){
                        $att_key = str_replace("attri_","",$attribute->key);
                        $Variations_data[] = $att_key. ":- " . $attribute->value;
                    }
                    $row['variations'] = implode(', ',$Variations_data);
                    $row['base_price']  =  show_percentage($task->regular_price, $pricingData);
                    $row['mined_price']  = !empty($task['mined']['regular_price']) ?  show_percentage($task['mined']['regular_price'], $pricingData)  : 'N/A';
                    $row['lab_grown_price']  = !empty($task['lab_grown']['regular_price']) ? show_percentage($task['lab_grown']['regular_price'], $pricingData) : 'N/A';
                    $row['discounted']  = "N/A";
                    $row['new_price']  = show_percentage($task->regular_price,$pricingData,'action' );
                    $row['new_mined']  = !empty($task['mined']['regular_price']) ?  show_percentage($task['mined']['regular_price'],$pricingData,'action' ) : 'N/A' ;
                    $row['new_lab_grown']  = !empty($task['lab_grown']['regular_price']) ?  show_percentage($task['lab_grown']['regular_price'],$pricingData,'action' ) : 'N/A' ;;
                    fputcsv($file, $row);
                }
                fclose($file);
            };
    
            return response()->stream($callback, 200, $headers);

        }else{
            return view('admin.products.base_pricelist', compact([
                'product_variations',
                'categories',
                'productsCount',
                'search',
                'product_pricing_ids',
                'pricingData'
            ]));
        }

        
    } // endof basePriceList

    public function basePriceexportCsv(Request $request){

        $product_variations = ProductVariations::whereHas('product')->with(['product'=>function($query){
            $query->select(['id','title']);
        }])->select(['id','product_id','sale_price','regular_price'])->get(); 

        $fileName = date('d-m-Y') .'-pricing.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        
        $columns = array('Product', 'Variations', 'Base Price','Discounted','New Price');
        $callback = function() use($product_variations, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($product_variations as $task) {
                $row['product']  = $task->product->title;
                $row['base_price']  = $task->regular_price;
               
                $Variations_data = [];
                foreach($task->get_vari_details_id as $key => $attribute){
                    $att_key = str_replace("attri_","",$attribute->key);
                    $Variations_data[] = $att_key. ":- " . $attribute->value;
                }
                $row['variations'] = implode(', ',$Variations_data);
                $row['discounted']  = "N/A";
                $row['new_price']  = "N/A";
                fputcsv($file, array($row['product'],$row['variations'], $row['base_price'],$row['discounted'],$row['new_price']));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

    }

    /**
     * basePriceUpdate
     * This function is use to create new addition and remove product
     */
    public function basePriceUpdate(Request $request){

        $categories = Category::category_options();
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Products", "url" => route("admin.products-list"), "icon" => ""],
            ["name" => "Update product pricing", "url" => route("admin.base-price-list"), "icon" => ""],
        ];
        $page_title = 'Product pricing';
        populate_breadcrumb($breadcrumb);

        
        if($request->isMethod('post')){

            /** create validations */
            $validated = $request->validate([
                'product_id' => 'sometimes',
                'category_id' => 'sometimes',
                'product_name' => 'sometimes',
                'percentage' => 'required|integer|between:1,100',
                'type' => 'required',
                
            ],[
                'product_id.required' => 'Please select product',
                'category_id.required' => 'Please select product',
                'percentage.required' => 'Please enter percentage',
                'percentage.integer' => 'Please enter valid integer',
                'percentage.between' => 'Percentage must between 1 to 100',
                'type.required' => 'Please select valid type',
            ]);

            /** Create price updates */
            $pricing_update = new ProductPricingUpdates();
            $pricing_update->product_id = $validated['product_id'];
            $pricing_update->category_id = $validated['category_id'];
            $pricing_update->type = $validated['type'];
            $pricing_update->percentage = $validated['percentage'];
            if($pricing_update->save()){
                return redirect()->route('admin.base-price-list',['pricing-id'=>$pricing_update->id])->with('success','Pricing created successfully');
            }else{
                return redirect()->back()->with('error','Something went wrong');
            }
        }

        return view('admin.products.base_price_update',compact(['categories'])); 
    }// endof basePriceUpdate

    /**
     * productSearch
     * this function is use to get products using search keyword
     */
    public function productSearch(Request $request){

        $productsCount = Products::where('status',1)->select(['id','status','title']);

        if(!empty($request['term'])){
            $term = $request['term'];
            $productsCount = $productsCount->where('title','like','%'.$term.'%');
        }

        $productsCount = $productsCount->take(15)->get();
        return response()->json($productsCount);
    }// endof productSearch



    /** START:: lab price crud work */
    public function labPriceList(Request $request){
        
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Engagement lab price", "url" => route("admin.lab_price_variations.list"), "icon" => "fas fa-dollar-sign"],

        ];
        populate_breadcrumb($breadcrumb);
        $page_title = "Engagement lab price";

        $query = LabPricesList::orderBy('id','DESC')->where(['is_deleted'=>0]);

        $query = getFilter(LabPricesList::class, $query, $request->query());

        $data = $query->paginate(10);

        return view($this->lab_price_path . 'index', compact(['data','page_title']));
    }//endof 

    public function labPriceAdd(Request $request){
        
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Engagement lab price", "url" => route("admin.lab_price_variations.list"), "icon" => "fas fa-dollar-sign"],
            ["name" => "Add", "url" => route("admin.lab_price_variations.add"), "icon" => "fa fa-plus"],

        ];
        populate_breadcrumb($breadcrumb);
        $page_title = "Add engagement lab price variation";

        if($request->isMethod('post')){

            /** create validations */
            $validated = $request->validate([
                'clarity' => 'required',
                'color' => 'required',
                'carat' => 'required',
                "price" => "required",
            ],[
                'clarity.required' => 'Please enter clarity',
                'color.required' =>  'Please enter color',
                'carat.required' =>  'Please enter carat',
                'price.required' =>  'Please enter price',
            ]);

            $new_record = new LabPricesList();
            $new_record->clarity = $validated['clarity'];
            $new_record->color = $validated['color'];
            $new_record->carat = $validated['carat'];
            $new_record->price = $validated['price'];
            $new_record->save();
            return redirect()->route('admin.lab_price_variations.list')->with('success','Record has been created successfully');
        }


        return view($this->lab_price_path . 'add', compact(['page_title']));
    }//endof 

    public function labPriceChangeStatus(Request $request){
    
        $id = $request['id'];
        $record = LabPricesList::where('id', $id)->first();

        if(!empty($record)){
            $record->is_active = $record->is_active ? 0 : 1;
            $record->save();
            return  response()->json(['status'=>'success', 'message'=> 'Status has been updated successfully' ]);
        }
        return  response()->json(['status'=>'error', 'message'=> 'Record not identified' ]);
    }//endof 


    public function labPriceDelete(Request $request){
    
        $id = $request['id'];
        $record = LabPricesList::where('id', $id)->first();

        if(!empty($record)){
            $record->is_deleted = 1;
            $record->save();
            return  response()->json(['status'=>'success', 'message'=> 'Record has been deleted successfully' ]);
        }
        return  response()->json(['status'=>'error', 'message'=> 'Record not identified' ]);
    }//endof 


    public function labPriceEdit(Request $request){
        
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Engagement lab price", "url" => route("admin.lab_price_variations.list"), "icon" => "fas fa-dollar-sign"],
            ["name" => "edit", "url" => route("admin.lab_price_variations.add"), "icon" => "fa fa-edit"],

        ];
        populate_breadcrumb($breadcrumb);
        $page_title = "Edit engagement lab price variation";

        $id = $request['id'];
        $data = LabPricesList::where('id',$id)->first();
        if(empty($data)){
            return redirect()->route('admin.lab_price_variations.list')->with('error','Record is not identified');
        }

        if($request->isMethod('post')){

            /** create validations */
            $validated = $request->validate([
                'clarity' => 'required',
                'color' => 'required',
                'carat' => 'required',
                "price" => "required",
            ],[
                'clarity.required' => 'Please enter clarity',
                'color.required' =>  'Please enter color',
                'carat.required' =>  'Please enter carat',
                'price.required' =>  'Please enter price',
            ]);

            $data->clarity = $validated['clarity'];
            $data->color = $validated['color'];
            $data->carat = $validated['carat'];
            $data->price = $validated['price'];
            $data->save();
            return redirect()->route('admin.lab_price_variations.list')->with('success','Record has been updated successfully');
        }


        return view($this->lab_price_path . 'edit',compact(['data','page_title']));
    }//endof 

}
