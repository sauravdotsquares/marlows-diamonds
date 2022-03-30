<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Appointments;

use URL;
class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumb = [
            ["name" => "Appointments", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
		$appointments = Appointments::all();
		return view('admin.appointments.index', compact('appointments'));
		
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($appointmentid=null){
        $breadcrumb = [
            ["name" => "Edit Review", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);
		
		$id = base64_decode($appointmentid);
		if ($id == '') {
            return 'URL NOT FOUND';
        }
		
		$appointments = Appointments::find($id);
		if (empty($appointments)) {
            return 'URL NOT FOUND';
        }
        $appointments = Appointments::find($id);
		//dd($appointments );
        return view('admin.appointments.edit',compact('appointments'));
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $appointmentid) {
        
		$id = base64_decode($appointmentid);
        if ($id == '') {
            return 'URL NOT FOUND';
        }

        $appointments = Appointments::findOrFail($id);

        if (empty($appointments)) {
            return 'URL NOT FOUND';
        }

       

        $input = $request->all();
		$request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            
			
        ]);
		
        $appointments->fill($input)->save();

        return redirect()->action('Admin\AppointmentController@index')->with('alert-success', 'Review Updated Successfully');
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($appointmentid) {
        $id = base64_decode($appointmentid);
        Appointments::find($id)->delete(); 
		return redirect()->action('Admin\AppointmentController@index')->with('alert-success', 'Review Deleted Successfully');
    }
	
}
