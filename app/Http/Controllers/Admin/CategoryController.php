<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\SlugController;
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
            $getData = Category::where('slug',$catId)->first();
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
            $image = $request->image_url_bk;
        }

        //  setup parent_id 
        //  $getParentId = 0;
        if(isset($request->table_id) && !empty($request->table_id)){
            if($request->table_id == $request->parent_id){
                
                $request->parent_id = 0;
            }elseif(!isset($request->parent_id) && empty($request->parent_id)){
                $request->parent_id = 0;
            }

            if($request->slug_bk != $request->slug){
                $newSlug = new SlugController;
                $newCustomSlug = $newSlug->makeNewSlugName('Category',$request->name,$request->slug);  // 1. Model Name 2. Name/Title. 3. slugName
            }else{
                $newCustomSlug = $request->slug;
            }
        }else{
            $newSlug = new SlugController;
            $newCustomSlug = $newSlug->makeNewSlugName('Category',$request->name,$request->slug);  // 1. Model Name 2. Name/Title. 3. slugName
        }

        if($validator->fails()){
            if(isset($request->table_id) && !empty($request->table_id)){
                $insertedData = Category::updateOrCreate(['id'=>$request->table_id],[
                    'name'=> $request->name,
                    'slug'=> strtolower($newCustomSlug),
                    'status'=> isset($request->status)?$request->status:0,
                    'parent_id'=>$request->parent_id,
                    'description'=> $request->description,
                    'meta_title'=> $request->meta_title,
                    'meta_keyword'=> $request->meta_keyword,
                    'meta_description'=> $request->meta_description,
                    'image_url'=> $image,
                ]);
                return redirect()->back()->with('success', 'Successfully updated!!!'); 
            }
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }else{
            $insertedData = Category::updateOrCreate(['id'=>$request->table_id],[
                'name'=> $request->name,
                'slug'=> strtolower($newCustomSlug),
                'status'=> isset($request->status)?$request->status:0,
                'parent_id'=>$request->parent_id,
                'description'=> $request->description,
                'meta_title'=> $request->meta_title,
                'meta_keyword'=> $request->meta_keyword,
                'meta_description'=> $request->meta_description,
                'image_url'=> $image,
            ]);
            return redirect()->back()->with('success', 'Successfully added!!!');   
        }
    }

    public function status(Request $request)
    {
        $statusChange = Category::findOrFail($request->id);
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
        $post = Category::find($request->id)->delete();
        return response()->json($post);
    }


    function getCategoryTree($parent_id = 0, $spacing = '', $tree_array = array()) {
        $categories = Category::select('id', 'name', 'parent_id')->where('parent_id' ,'=', $parent_id)->orderBy('parent_id')->get();
        foreach ($categories as $item){
            $tree_array[] = ['categoryId' => $item->id, 'categoryName' =>$spacing . $item->name];
            $tree_array = $this->getCategoryTree($item->id, $spacing . '--', $tree_array);
        }

        return $tree_array;
    }

}
