<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeoScripts;

class SeoScriptsController extends Controller{
    

    public function __construct(){
        $this->view_path = "admin.seo_scripts.";
    }

    public function list(Request $request){
        $page_title = "Seo Scripts";
        $breadcrumb = [
            ["name" => "Home", "url" => url('/admin'), "icon" => "fa fa-home"],
            ["name" => "Seo Scripts", "url" => route("admin.seo_scripts.list"), "icon" => "fa fa-home"],
        ];
        populate_breadcrumb($breadcrumb);

        return view($this->view_path . 'list', compact(['page_title']));
    }

    public function add(Request $request){
        $page_title = "Seo Scripts";
        $breadcrumb = [
            ["name" => "Home", "url" => url('/admin'), "icon" => ""],
            ["name" => "Seo Scripts", "url" => route("admin.seo_scripts.list"), "icon" => ""],
            ["name" => "Add", "url" => route("admin.seo_scripts.add"), "icon" => ""],
        ];
        populate_breadcrumb($breadcrumb);

        return view($this->view_path . 'add');
    }

    public function edit(Request $request){
        return view($this->view_path . 'edit');
    }

    public function changeStatus(Request $request){
        return view($this->view_path . 'list');
    }


    public function delete(Request $request){
        return view($this->view_path . 'list');
    }

}
