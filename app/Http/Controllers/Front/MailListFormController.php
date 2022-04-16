<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Mail;
use App\Models\Enquiries;

class MailListFormController extends Controller {
    
    // Store Contact Form data
    public function MailListForm(Request $request) {
			
		// return response()->json($request->all());
		
        // Form validation
        $this->validate($request, [
            'title' => 'required',
            'email' => 'required|email',
            
         ]);
        //  Store data in database
        Enquiries::create($request->all());
        // 
		//  Send mail to admin
		
        // Mail::send('mail', array(
            // 'name' => $request->get('name'),
            // 'email' => $request->get('email'),
            // 'phone' => $request->get('phone'),
            // 'user_query' => $request->get('message'),
        // ), function($message) use ($request){
            // $message->from($request->email);
            // $message->to('marlowstesting@getnada.com', 'Admin')->subject('test subj');
        // });
        return back()->with('success', 'We have received your message and would like to thank you for writing to us.');
        
    }
}