<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\SlugController;
use Illuminate\Http\Request;
use App\Models\PostCategory;
use App\Models\Posts;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Str;

class PostCategoryController extends Controller
{
    public function index()
    {
        $breadcrumb = [
            ["name" => "Categories", "url" => route("admin.categories"), "icon" => "fa fa-home"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
        $getData = PostCategory::latest()->get();
        $result = [
            'getData'=> $getData,
        ];
        return view('admin.postcategories.index',$result);
    }

    public function getPostCategory(Request $request)
    {
        $getCatId_arr = [];
		
        if(isset($request->id)){
            $getPostCategoryArray = Posts::find($request->id);
			// echo "<pre>";
			// print_r($getPostCategoryafdsd);
			// die;
            $getCatId = $getPostCategoryArray->categories;
            $getCatId_arr = explode(",",$getPostCategoryArray->categories);
        }
        // dd($getCatId_arr);

        $getParentData = PostCategory::where('status',1)->where('parent_id',0)->get()->toArray();
        $dataArray = $child1 = array();
        if(count($getParentData)>0){
            foreach ($getParentData as $key => $parent) {
                $dataArray[$key]['id'] = $parent['id']; 
                $dataArray[$key]['name'] = $parent['name'];
                if(in_array($parent['id'],$getCatId_arr)){
                    echo '<option selected value="'.$parent['id'].'">'.$parent['name'] . '</option>';
                }else{
                    echo '<option value="'.$parent['id'].'">'.$parent['name'] . '</option>';
                }
                $child = $this->getChildData($parent['id'], 0,$getCatId_arr);
                if(count($child)>0){
                    $dataArray[$key]['parent'] = $child;
                }
            }
        }
        die;
        //echo '<pre>'; print_r($dataArray);die;
        //return response()->json($dataArray);
    }

    public function getChildData($parent_id, $level,$getCatId_arr){
        $getChildData = PostCategory::where('status',1)->where('parent_id',$parent_id)->get()->toArray();
        $level++;
        $dataArray = $child1 = array();
        if(count($getChildData)>0){
            foreach ($getChildData as $key => $child) {
                //echo str_repeat("-", ($level * 2)) . $child['name'] . '<br>';
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
    }

    public function createForm($catId = null)
    {
        $breadcrumb = [
            ["name" => "Create Category", "url" => route("admin.postcategories"), "icon" => "fa fa-home"],
            ["name" => "Dashboard", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
        ];
        populate_breadcrumb($breadcrumb);

        if(!is_null($catId)){
            $getData = PostCategory::where('slug',$catId)->first();
            $result = [
                'getData' => $getData
            ];
        }else{
            $result = [
                'getData' => ''
            ];
        }

        return view('admin.postcategories.create',$result);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($request->hasFile('image')) {
            $image = '';
            $uploadpath = public_path('storage').'\categories';
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
                $insertedData = PostCategory::updateOrCreate(['id'=>$request->table_id],[
                    'name'=> $request->name,
                    'slug'=> strtolower($newCustomSlug),
                    'status'=> isset($request->status)?$request->status:0,
                    'parent_id'=>isset($request->parent_id)?$request->parent_id:0,
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
            $insertedData = PostCategory::updateOrCreate(['id'=>$request->table_id],[
                'name'=> $request->name,
                'slug'=> strtolower($newCustomSlug),
                'status'=> isset($request->status)?$request->status:0,
                'parent_id'=>isset($request->parent_id)?$request->parent_id:0,
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
        $statusChange = PostCategory::findOrFail($request->id);
		// dd($statusChange);
		// die;
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
        $post = PostCategory::find($request->id)->delete();
        return response()->json($post);
    }


    function getPostCategoryTree($parent_id = 0, $spacing = '', $tree_array = array()) {
        $postcategories = PostCategory::select('id', 'name', 'parent_id')->where('parent_id' ,'=', $parent_id)->orderBy('parent_id')->get();
        foreach ($postcategories as $item){
            $tree_array[] = ['categoryId' => $item->id, 'categoryName' =>$spacing . $item->name];
            $tree_array = $this->getPostChildData($item->id, $spacing . '--', $tree_array);
        }

        return $tree_array;
    }
	
	public function getPostChildData($parent_id, $level,$getCatId_arr){
        $getChildData = PostCategory::where('status',1)->where('parent_id',$parent_id)->get()->toArray();
        $level++;
        $dataArray = $child1 = array();
        if(count($getChildData)>0){
            foreach ($getChildData as $key => $child) {
                //echo str_repeat("-", ($level * 2)) . $child['name'] . '<br>';
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
    }

}
