<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use App\Models\Enquiries;
use App\Models\Settings;

class MailListFormController extends Controller {

    // Store Contact Form data
    public function MailListForm(Request $request) {

		// return response()->json($request->all());
        $admin_email = Settings::where("option_name",'admin_email')->value('option_value');

        // Form validation
        $this->validate($request, [
            'title' => 'required',
            'email' => 'required|email',
            'description' => 'required',
            'custom_url' => 'required',
            'g-recaptcha-response' => 'required'
        ]);
        //  Store data in database
        Enquiries::create($request->all());
        //
		//  Send mail to admin

        Mail::send('email.mail', array(
            'title' => $request->get('title'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'url' => $request->get('custom_url'),
            'user_query' => $request->get('description'),
        ), function($message) use ($request,$admin_email ){
            $message->from('hello@marlows-diamonds.co.uk');
			$message->to($admin_email, 'Admin')->subject('New Website Inquiry');
        });
        // Mail::send('mail', array(
            // 'name' => $request->get('name'),
            // 'email' => $request->get('email'),
            // 'phone' => $request->get('phone'),
            // 'url' => $request->get('custom_url'),
            // 'user_query' => $request->get('message'),
        // ), function($message) use ($request){
            // $message->from($request->email);
            // $message->to('marlowstesting@getnada.com', 'Admin')->subject('test subj');
        // });
        return response()->json(['status'=> 200, 'success'=>'We have received your message and would like to thank you for writing to us.']);
        // return back()->with('success', 'We have received your message and would like to thank you for writing to us.');

    }
}
