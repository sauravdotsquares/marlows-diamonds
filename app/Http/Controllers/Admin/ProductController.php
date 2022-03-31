<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Products;

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
        
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'categories' => 'required',
            'description' => 'required',
            'featured_image' => 'required',
        ]);

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

        // echo "<pre>";
        // print_r($request->all(''));
        // die;

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
            if(isset($request->table_id) && !empty($request->table_id)){
                Products::updateOrCreate(['id'=>$request->table_id],[
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
                return redirect()->back()->with('success', 'Successfully updated!!!'); 
            }
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }else{
            Products::updateOrCreate(['id'=>$request->table_id],[
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
            return redirect()->back()->with('success', 'Successfully added!!!');   
        }

    }
}
