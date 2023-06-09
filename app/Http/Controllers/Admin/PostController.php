<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Posts;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\PostCategoryController;
use Intervention\Image\Facades\Image;

use URL;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            ["name" => "Dashboard", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Posts", "url" => route("admin.posts"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
		$posts = Posts::all();
		return view('admin.posts.index', compact('posts'));
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $breadcrumb = [
            ["name" => "Add New", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
        $posts = Posts::all();
        return view('admin.posts.create',compact('posts'));
	}
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request){


        $input = $request->all();
		 $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
			
        ]);
		
		if($request->hasFile('image')) {
			
			// $image = $request->file('image');
			// $imageName = $image->getClientOriginalName();
			// $fileName =  'public/news/' . time() . '-' . $imageName;
			// Image::make($image)->resize(600,300)->save(storage_path('app/' . $fileName));
			// $news->image = $fileName;
  
            $image = single_storage_image_upload($request->file('image'),'Post','500','300');
            $image = single_storage_image_upload($request->file('image'),'Post','1200','600');
        }
		
		// echo "Check";
		// print_r($image);
		// die;
		
		if(empty($image)){
			$input['image'] = '';
		}
		else{
			
			$input['image'] = $image;
		}
		
		$input['categories'] = !empty($request->categories)?implode(",",$request->categories):"";
		$input['faq_category'] = !empty($request->faq_category)?implode(",",$request->faq_category):"";
        $posts = Posts::create($input);

        return redirect()->action('Admin\PostController@index')->with('alert-success', 'Page Added Successfully');
    }
	
	public function uploadEditorImage(Request $request) {
        if ($files = $request->file('file')) {
            $image = single_storage_image_upload($request->file('file'),'PostsNew');
			// echo $image;
			// die;
            $file_path = \Storage::url($image);
            $url = asset($file_path);
            $imgURL = '<img alt="Upload item" src="'.$url.'" />';
            echo '/storage/'.$image;
            exit();
        }
    }
	
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($postid=null){
        $breadcrumb = [
            ["name" => "Dashboard", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
		
		$id = base64_decode($postid);
		if ($id == '') {
            return 'URL NOT FOUND';
        }
		
		$posts = Posts::find($id);
		if (empty($posts)) {
            return 'URL NOT FOUND';
        }
        $posts = Posts::find($id);
		//dd($posts );
        return view('admin.posts.edit',compact('posts'));
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $postid) {
        
		$id = base64_decode($postid);
        if ($id == '') {
            return 'URL NOT FOUND';
        }

        $posts = Posts::findOrFail($id);

        if (empty($posts)) {
            return 'URL NOT FOUND';
        }

       

        $input = $request->all();
		$request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
			
        ]);
		/*image update*/
       if($request->hasFile('image')) {

            //$image_array = [];

            //foreach ($request->file('image') as $image) {
                
                $image = '';
                $image = single_storage_image_upload($request->file('image'),'Post','500','300');
				$image = single_storage_image_upload($request->file('image'),'Post','1200','600');
            //}
        }

        
       if(empty($image)){
			//$input['image'] = '';
		}
		else{
			
			$input['image'] = $image;
		}
		$input['categories'] = !empty($request->categories)?implode(",",$request->categories):"";
        $input['faq_category'] = !empty($request->faq_category)?implode(',',$request->faq_category):"";
        $posts->fill($input)->save();

        return redirect()->action('Admin\PostController@index')->with('alert-success', 'Page Updated Successfully');
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($postid) {
        $id = base64_decode($postid);
        Posts::find($id)->delete(); 
		return redirect()->action('Admin\PostController@index')->with('alert-success', 'Page Deleted Successfully');
    }
	 /**
     * Status
     */
	public function status($ids,$status) { 
        $ids = base64_decode($ids);       
        $posts =  Posts::find($ids);
        if (empty($posts)) {
            return 'URL NOT FOUND';
        }

        $input['status'] = $status;
        unset($input['_token']);
        
        $posts->fill($input)->save();

        return redirect()->action('Admin\PostController@index')->with('alert-success', 'Page Status Updated Successfully');
    }
}
