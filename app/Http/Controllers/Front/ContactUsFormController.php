<?php
// This is Appointments controller
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use App\Models\Appointments;
use App\Models\Settings;

class ContactUsFormController extends Controller {

    // Store Contact Form data
    public function ContactUsForm(Request $request) {
		    $admin_email = Settings::where("option_name",'admin_email')->value('option_value');

		// Form validation
        $this->validate($request, [
            'title' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'description' => 'required'
         ]);
        //  Store data in database
         Appointments::create($request->all());
        //
		//  Send mail to admin


        Mail::send('email.mail', array(
            'title' => $request->get('title'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'user_query' => $request->get('description'),
        ), function($message) use ($request,$admin_email ){
            $message->from('ds19@24livehost.com');
			$message->to($admin_email, 'Admin')->subject('NEED ASSISTANCE?');
        });
        return back()->with('success', 'We have received your message and would like to thank you for writing to us.');

    }
}
