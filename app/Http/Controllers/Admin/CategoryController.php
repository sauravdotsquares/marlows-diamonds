<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Str;

class CategoryController extends Controller
{
    public function index()
    {
        $breadcrumb = [
            ["name" => "Dashboard", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Category", "url" => route("admin.categories"), "icon" => "fa-list-alt"],

        ];
        populate_breadcrumb($breadcrumb);
        $getData = Category::latest()->get();
        $result = [
            'getData'=> $getData,
        ];
        return view('admin.categories.index',$result);
    }

    public function getCategory(Request $request)
    {
        $getData = Category::latest()->get();
        return response()->json($getData);
    }

    public function createForm($catId = null)
    {
        $breadcrumb = [
            ["name" => "Dashboard", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Category-Create", "url" => route("admin.categories"), "icon" => "fa-list-alt"],

        ];
        populate_breadcrumb($breadcrumb);

        if(!is_null($catId)){
            $getData = Category::find($catId);
            $result = [
                'getData' => $getData
            ];
        }else{
            $result = [
                'getData' => ''
            ];
        }
        return view('admin.categories.create',$result);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($request->hasFile('image')) {
            $image = '';
            $uploadpath = public_path().'\images';
            $original_name = $request->file('image')->getClientOriginalName();
            if (!empty($request->file('image'))) {
                $image_prefix = 'category_' . rand(0, 999999999) . '_' . date('d_m_Y_h_i_s');
                $ext = $request->file('image')->getClientOriginalExtension();
                $image = $image_prefix . '.' . $ext;
                $request->file('image')->move($uploadpath, $image);
            }
        }else{
            $image = '';
        }

        // $getSlugName = $this->setSlugAttribute($request->slug);

        // echo "after slugname <pre>";
        // print_r($getSlugName);
        // die;

        if($validator->fails()){
            if(isset($request->table_id) && !empty($request->table_id)){
                $insertedData = Category::updateOrCreate(['id'=>$request->table_id],[
                    'name'=> $request->name,
                    'slug'=> $request->slug,
                    'status'=> $request->status,
                    'description'=> $request->description,
                    'meta_title'=> $request->meta_title,
                    'meta_description'=> $request->meta_description,
                    'image_url'=> $image,
                ]);
                return redirect()->back()->with('success', 'Successfully updated!!!'); 
            }
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }else{
            $insertedData = Category::updateOrCreate(['id'=>$request->table_id],[
                'name'=> $request->name,
                'slug'=> $request->slug,
                'status'=> $request->status,
                'description'=> $request->description,
                'meta_title'=> $request->meta_title,
                'meta_description'=> $request->meta_description,
                'image_url'=> $image,
            ]);
            return redirect()->back()->with('success', 'Successfully added!!!');   
        }
    }

}
