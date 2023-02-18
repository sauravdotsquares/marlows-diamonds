<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LabPricesList;

use URL;
class LabPricesListController extends Controller{

    public function __construct(){
        $this->lab_price_path = "admin.labprices.";
    }

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
                'clarity' => 'required|max:100',
                'color' => 'required|max:100',
                'carat' => 'required|max:100',
                "price" => "required|max:100",
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
                'clarity' => 'required|max:100',
                'color' => 'required|max:100',
                'carat' => 'required|max:100',
                "price" => "required|max:100",
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
