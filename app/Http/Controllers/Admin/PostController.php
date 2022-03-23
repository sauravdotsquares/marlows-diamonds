<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Posts;
use App\Http\Controllers\Controller;

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
            ["name" => "Dashboard", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Homex", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

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

            //$image_array = [];

            //foreach ($request->file('image') as $image) {
                
                $image = '';
                $uploadpath = public_path().'\images';
                //$original_name = $input['image']->getClientOriginalName();
				$original_name = $request->file('image')->getClientOriginalName();

                /*if (!$request->file('image')->isValid() || empty($uploadpath)) {
                    return $image;
                }*/
				//dd($input['image']);
                if (!empty($request->file('image'))) {
                    $image_prefix = 'banner_' . rand(0, 999999999) . '_' . date('d_m_Y_h_i_s');
                    $ext = $request->file('image')->getClientOriginalExtension();
                    $image = $image_prefix . '.' . $ext;
                    //$image_array[] = $image;
                    $request->file('image')->move($uploadpath, $image);
                }
            //}
        }
		
		if(empty($image)){
			$input['image'] = '';
		}
		else{
			
			$input['image'] = $image;
		}
		
		//dd($input);

        $posts = Posts::create($input);

        return redirect()->action('Admin\PostController@index')->with('alert-success', 'Page Added Successfully');
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
            ["name" => "Homex", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

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
                $uploadpath = public_path().'\images';
                //$original_name = $input['image']->getClientOriginalName();
				$original_name = $request->file('image')->getClientOriginalName();

                /*if (!$request->file('image')->isValid() || empty($uploadpath)) {
                    return $image;
                }*/
				//dd($input['image']);
                if (!empty($request->file('image'))) {
                    $image_prefix = 'post_' . rand(0, 999999999) . '_' . date('d_m_Y_h_i_s');
                    $ext = $request->file('image')->getClientOriginalExtension();
                    $image = $image_prefix . '.' . $ext;
                    //$image_array[] = $image;
                    $request->file('image')->move($uploadpath, $image);
                }
            //}
        }

        
       if(empty($image)){
			//$input['image'] = '';
		}
		else{
			
			$input['image'] = $image;
		}
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
