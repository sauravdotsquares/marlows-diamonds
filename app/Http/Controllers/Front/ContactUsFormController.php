<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
//use App\Models\Contact;

class ContactUsFormController extends Controller {
    
    // Store Contact Form data
    public function ContactUsForm(Request $request) {
			
		// return response()->json($request->all());
		
        // Form validation
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'message' => 'required'
         ]);
        //  Store data in database
        //Contact::create($request->all());
        // 
		//  Send mail to admin
		
        Mail::send('mail', array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'user_query' => $request->get('message'),
        ), function($message) use ($request){
            $message->from($request->email);
            $message->to('marlowstesting@getnada.com', 'Admin')->subject('test subj');
        });
        return back()->with('success', 'We have received your message and would like to thank you for writing to us.');
        
    }
}