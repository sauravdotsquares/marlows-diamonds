<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImageGallery;
use Illuminate\Support\Facades\File; 

class ImageGalleryController extends Controller
{

    public function __construct(){
        $this->default_pagination = 10;
        $this->default_view_path = "admin.image_gallery.";
        $this->module_name = "Image Gallery";
        $this->route_path = "admin.image_gallery.";
    }

    /**
     * List of image gallery
     */
    public function index(){
        /**  Setup pagination */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . "index" )],
        ];
        populate_breadcrumb($breadcrumb);

        $images = ImageGallery::where(['is_deleted'=>0])->orderBy('id','DESC')->paginate($this->default_pagination);

        $routePath = $this->route_path;
        return view($this->default_view_path.'list',compact(['images','routePath']));
    }


    /**
     * List of image gallery
     */
    public function getFilesList(){
        /**  Setup pagination */
        // $breadcrumb = [
        //     ["name" => "Home", "url" => route("admin.dashboard")],
        //     ["name" => $this->module_name , "url" => route($this->route_path . "index" )],
        // ];
        // populate_breadcrumb($breadcrumb);

        $images = ImageGallery::where(['is_deleted'=>0])->orderBy('id','DESC')->paginate(3);
        return response()->json(['status'=>'success','data'=>$images]);
        // $routePath = $this->route_path;
        // return view($this->default_view_path.'list',compact(['images','routePath']));
    }

    /**
     * Add new files
     */
    public function add(Request $request){
        /**  Setup pagination */
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . "index" )],
            ["name" => "Add new file" , "url" => route($this->route_path . "add" )],
        ];
        populate_breadcrumb($breadcrumb);
        $routePath = $this->route_path;
        return view($this->default_view_path.'add',compact(['routePath']));
    }//endof add


    /**
     * Upload a new file
     */
    public function uploadImages(Request $request){

        $keys = array_keys($request->all());
        if(!count($keys)){
            return response()->json([
                'message' => 'Image not identified'
            ], 400);
        }
        $image_key = $keys[0];

        if($request->hasFile($image_key)){
            $fileData = upload_file($request[$image_key], 'products');
            if($fileData && is_array($fileData)){
                $new_image = new ImageGallery();
                $new_image->image = $fileData['name'];
                $new_image->size = $fileData['size'];
                $new_image->extension = $fileData['extension'];
                $new_image->original_name  = $fileData['original_name'];
                $new_image->metadata  = json_encode($fileData);
                $new_image->save();
                return $new_image->id;
            }
            return response()->json([
                'message' => 'Something went wrong'
            ], 400);
        }
        return response()->json([
            'message' => 'File not identified'
        ], 400);
    } // endof uploadImages

    /**
     * removeImage 
     */
    public function removeImage(Request $request){
        $fileId = request()->getContent() ? request()->getContent() : $request['id'];
        if(empty($fileId)){
            return response()->json([
                'message' => 'File not identified'
            ], 400);
        }
        $file_data = ImageGallery::where('id', $fileId)->first();
        if(!empty($file_data)){
            $isDeleted = File::delete('uploads/'.$file_data->image);
            $file_data->delete();
        }
        return response()->json([
            'message' => 'File removed successfully'
        ], 200);
    } // endof removeImage


    /**
     * Delete 
     */
    public function deleteFile(Request $request){

        $image = ImageGallery::where('id', $request['id'])->first();
        if(!empty($image)){
            $image->is_deleted = 1;
            $image->save();
            return response()->json(['status'=> 'success', 'message'=>'File deleted successfully']);
        }
        return response()->json(['status'=> 'error', 'message'=>'Something went successfully']);
    } // endof removeImage


    public function useImage(Request $request){
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard")],
            ["name" => $this->module_name , "url" => route($this->route_path . "index" )],
            ["name" => "Add new file" , "url" => route($this->route_path . "add" )],
        ];
        populate_breadcrumb($breadcrumb);
        return view($this->default_view_path.'use');

    }
}
