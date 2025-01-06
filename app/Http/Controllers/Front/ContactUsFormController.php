<?php
// This is Appointments controller
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Appointments;
use App\Models\Settings;
use App\Mail\WelcomeEmail;

class ContactUsFormController extends Controller {

    // Store Contact Form data
    public function ContactUsForm(Request $request) {
        $admin_email = Settings::where("option_name",'admin_email')->value('option_value');

        // Form validation
        $this->validate($request, [
            'title' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'description' => 'required',
            'custom_url' => 'required',
            // 'g-recaptcha-response' => 'required'
        ]);
        
        if(isset($request->email) && $request->email == 'sample@email.tst'){
            return response()->json(['status'=> 200, 'success'=>'We have received your message and would like to thank you for writing to us.']);
        }
        //  Store data in database
        Appointments::create($request->all());
        //
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
            
            
            // Mail::send('email.mail', array(
            //     'title' => $request->get('title'),
            //     'email' => $request->get('email'),
            //     'phone' => $request->get('phone'),
            //     'url' => $request->get('custom_url'),
            //     'user_query' => $request->get('description'),
            // ), function($message) use ($request,$admin_email ){
            //     $message->from('dssmtp@marlows-diamonds.co.uk');
            //     $message->to($admin_email, 'Admin')->subject('New Website Enquiry');
            //     $message->bcc('sharma.gajendra@dotsquares.com', 'Dev bcc')->subject('New Website Enquiry');
            // });
        }else{
            $requestData = [
                'title' => $request->get('title'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'custom_url' => $request->get('custom_url'),
                'description' => $request->get('description'),
            ];
            
            // $adminEmail = 'sharma.gajendra@dotsquares.com';
            Mail::to($admin_email)->bcc('sharma.gajendra@dotsquares.com')->queue(new WelcomeEmail($requestData));

            // $requestData = [
            //     'title' => $request->get('title'),
            //     'email' => $request->get('email'),
            //     'phone' => $request->get('phone'),
            //     'custom_url' => $request->get('custom_url'),
            //     'description' => $request->get('description'),
            // ];
            
            // $adminEmail = 'sharma.gajendra@dotsquares.com';
            
            // SendEmailJob::dispatch($requestData, $adminEmail);

            // Mail::send('email.mail', array(
            //     'title' => $request->get('title'),
            //     'email' => $request->get('email'),
            //     'phone' => $request->get('phone'),
            //     'url' => $request->get('custom_url'),
            //     'user_query' => $request->get('description'),
            // ), function($message) use ($request,$admin_email ){
            //     $message->from('dssmtp@marlows-diamonds.co.uk');
            //     $message->to('sharma.gajendra@dotsquares.com', 'Admin')->subject('New Website Enquiry');
            // });
        }

        // Mail::send('email.mail', array(
        //     'title' => $request->get('title'),
        //     'email' => $request->get('email'),
        //     'phone' => $request->get('phone'),
        //     'url' => $request->get('custom_url'),
        //     'user_query' => $request->get('description'),
        // ), function($message) use ($request,$admin_email ){
        //     $message->from('dssmtp@marlows-diamonds.co.uk');
        //     $message->to($admin_email, 'Admin')->subject('New Website Enquiry');
        // });

        return response()->json(['status'=> 200, 'success'=>'We have received your message and would like to thank you for writing to us.']);
        // return back()->with('success', 'We have received your message and would like to thank you for writing to us.');

    }
}
