<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Enquiries;
use App\Models\Settings;
use App\Mail\WelcomeEmail;

class MailListFormController extends Controller {

    // Store Contact Form data
    public function MailListForm(Request $request) {
        $admin_email = Settings::where("option_name",'admin_email')->value('option_value');

        // Form validation
        $this->validate($request, [
            'title' => 'required',
            'email' => 'required|email',
            'description' => 'required',
        ]);
        //  Store data in database
        Enquiries::create($request->all());
		//  Send mail to admin

        if (env('APP_ENV')=='production'){
                
             $requestData = [
                'title' => $request->get('title'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'custom_url' => $request->get('custom_url'),
                'description' => $request->get('description'),
            ];
            
            // $adminEmail = 'sharma.gajendra@dotsquares.com';
            Mail::to($admin_email)->bcc('sharma.gajendra@dotsquares.com')->queue(new WelcomeEmail($requestData));
            // Mail::to('sharma.gajendra@dotsquares.com')->queue(new WelcomeEmail($requestData));

            
            //         Mail::send('email.mail', array(
            //             'title' => $request->get('title'),
            //             'email' => $request->get('email'),
            //             'phone' => $request->get('phone'),
            //             'url' => $request->get('custom_url'),
            //             'user_query' => $request->get('description'),
            //         ), function($message) use ($request,$admin_email ){
            //             $message->from('hello@marlows-diamonds.co.uk');
            // 			$message->to($admin_email, 'Admin')->subject('New Website Enquiry');
            // 			$message->bcc('sharma.gajendra@dotsquares.com', 'Admin')->subject('New Website Enquiry');
            //         });
        }else{
            $requestData = [
                'title' => $request->get('title'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'custom_url' => $request->get('custom_url'),
                'description' => $request->get('description'),
            ];
            
            $adminEmail = 'sharma.gajendra@dotsquares.com';

            // $when = now()->addMinutes(3);

            // Mail::to($adminEmail)->later($when, new WelcomeEmail($requestData));

            Mail::to($adminEmail)->cc('sanyukta.chauhan@dotsquares.com')->queue(new WelcomeEmail($requestData));
            // SendEmailJob::dispatch($requestData, $adminEmail);
            // Mail::send('email.mail', array(
            //     'title' => $request->get('title'),
            //     'email' => $request->get('email'),
            //     'phone' => $request->get('phone'),
            //     'url' => $request->get('custom_url'),
            //     'user_query' => $request->get('description'),
            // ), function($message) use ($request,$admin_email ){
            //     $message->from('hello@marlows-diamonds.co.uk');
    		// 	$message->to('sharma.gajendra@dotsquares.com', 'Admin')->subject('New Website Enquiry local');
    		// 	//$message->cc('gajendra30@gmail.com', 'Admin')->subject('New Website Enquiry local');
            // });
        }
       
        return response()->json(['status'=> 200, 'success'=>'Thank you for subscribe us!!!']);
    }
}
