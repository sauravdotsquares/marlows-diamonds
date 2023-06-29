<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Reviews;

use URL;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            ["name" => "Reviews", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
        $reviews = Reviews::all();
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumb = [
            ["name" => "Add Review", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
        $reviews = Reviews::all();
        return view('admin.reviews.create', compact('reviews'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {

        $input = $request->all();
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',

        ]);

        Reviews::create($input);
        return redirect()->action('Admin\ReviewController@index')->with('alert-success', 'Review Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($reviewid = null)
    {
        $breadcrumb = [
            ["name" => "Edit Review", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);

        $id = base64_decode($reviewid);
        if ($id == '') {
            return 'URL NOT FOUND';
        }

        $reviews = Reviews::find($id);
        if (empty($reviews)) {
            return 'URL NOT FOUND';
        }
        $reviews = Reviews::find($id);
        return view('admin.reviews.edit', compact('reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $reviewid)
    {

        $id = base64_decode($reviewid);
        if ($id == '') {
            return 'URL NOT FOUND';
        }

        $reviews = Reviews::findOrFail($id);

        if (empty($reviews)) {
            return 'URL NOT FOUND';
        }

        $input = $request->all();
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',

        ]);

        $reviews->fill($input)->save();

        return redirect()->action('Admin\ReviewController@index')->with('alert-success', 'Review Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($reviewid)
    {
        $id = base64_decode($reviewid);
        Reviews::find($id)->delete();
        return redirect()->action('Admin\ReviewController@index')->with('alert-success', 'Review Deleted Successfully');
    }

    /**
     * Status
     *
     * @param [type] $ids
     * @param [type] $status
     * @return void
     */
    public function status($ids, $status)
    {
        $ids = base64_decode($ids);
        $reviews =  Reviews::find($ids);
        if (empty($reviews)) {
            return 'URL NOT FOUND';
        }

        $input['status'] = $status;
        unset($input['_token']);

        $reviews->fill($input)->save();

        return redirect()->action('Admin\ReviewController@index')->with('alert-success', 'Review Status Updated Successfully');
    }
}
