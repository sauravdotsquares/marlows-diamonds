<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\AppProducts;
use App\Models\AppProductCategories;
// use App\Models\Products;
// use App\Models\ProductImages;
// use App\Models\ProductVariations;
// use App\Models\ProductVariationAttributes;
// use App\Models\ProductVariationDetails;
// use App\Models\Attributes;
use Illuminate\Support\Arr;
use App\Models\DiamondShapes;
use View;

class AppProductsController extends Controller{

    /**
     * tables
     * app_products
     * app_products_categories
     * app_products_images
     * 
     */

    
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

        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => $this->module_name, "url" => route($this->route_path. '.index'), "icon" => ""],
            ["name" => 'Add ' . $this->module_name, "url" => route($this->route_path. '.add'), "icon" => ""],
            ["name" => 'Upload images', "url" => route($this->route_path. '.add_images',['slug'=>$slug]), "icon" => ""],
        ];
        populate_breadcrumb($breadcrumb);




        return view($this->route_path . '.images',compact(['product']));

    }//endof addImages

}