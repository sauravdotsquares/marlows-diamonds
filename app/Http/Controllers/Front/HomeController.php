<?php

namespace App\Http\Controllers\Front;

//use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\DownloadDetail;
use App\Models\Settings;
use Mail;

class HomeController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('front.index');
    }

    /**
     * Download PDF function
     *
     * @param Request $request
     * @return void
     */
    public function downloadPDF(Request $request)
    {

        $admin_email = Settings::where("option_name", 'admin_email')->value('option_value');

        $input = $request->all();
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:download_details|max:255',
        ]);

        $getDetailsSubmit = DownloadDetail::create([
            'name' => $request->name,
            'email' => $request->email
        ]);

        if (isset($getDetailsSubmit) && !empty($getDetailsSubmit)) {
            if(env('APP_ENV') == 'production'){
                Mail::send('email.mail', array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                ), function ($message) use ($request, $admin_email) {
                    $message->from('hello@marlows-diamonds.co.uk');
                    $message->to($admin_email, 'Admin')->subject('NEED ASSISTANCE?');
                });
            }else if(env('APP_ENV') == 'local'){
                Mail::send('email.mail', array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                ), function ($message) use ($request, $admin_email) {
                    $message->from('hello@marlows-diamonds.co.uk');
                    $message->to('sharma.gajendra@dotsquares.com', 'Admin')->subject('NEED ASSISTANCE?');
                });
            }

            $file_path = public_path('assets/images/Marlows-DiamONDS-TERMINOLOGY-GUIDE-INFOGRAPHIC.pdf');
            return response()->download($file_path, 'example.pdf', [], 'inline');
        }

        return back()->with('error', 'Please fill necessory details');
    }
}
