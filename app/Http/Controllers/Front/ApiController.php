<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HKDiamondStock;
use App\Models\Order;
use App\Mail\OrderAbandonmentMail;
use App\Mail\OrderMailProcess;
use Mail;
use SoapClient,Log;
use Carbon\Carbon;

class ApiController extends Controller
{

    public function __construct(Request $request){
        $this->hare_krishna_api = "https://service.hk.co/apihkstock?user=fd0c4f55-3a3b-46db-a1ce-ac178cfe8d59&type=json";
    }

    public function getRepnetApiFunction($filterArray)
    {

        $client = new SoapClient("https://technet.rapaport.com/WebServices/RetailFeed/Feed.asmx?WSDL",
        array( "trace" => 1, "exceptions" => 0, "cache_wsdl" => 0) );

        $params = array('Username'=>'95503', 'Password'=>'@diamond1');
        $client->__soapCall("Login", array($params), NULL, NULL, $output_headers);

        $ticket = $output_headers["AuthenticationTicketHeader"]->Ticket;

        $client1 = new SoapClient("https://technet.rapaport.com/WebServices/RetailFeed/Feed.asmx?WSDL", array( "trace" => 1, "exceptions" => 0, "cache_wsdl" => 0) );

        $rapnetData = $rapnetAllData = array();

        $ns = "http://technet.rapaport.com/";
        $headerBody = array("Ticket" => $ticket);
        $header = new \SoapHeader($ns, 'AuthenticationTicketHeader', $headerBody);
        $client1->__setSoapHeaders($header);

        if(isset($filterArray['grade'])){
            if($filterArray['grade'] == 'EX'){
                $filterTo = 'EXCELLENT';
            }elseif($filterArray['grade'] == 'VG'){
                $filterTo = 'VERYGOOD';
            }elseif($filterArray['grade'] == 'GD'){
                $filterTo = 'GOOD';
            }else{
                $filterTo = 'EXCELLENT';
            }
        }

        // $ColorFrom = $filterArray['color'];
		// $ColorTo = $filterArray['color'];

        $searchParams = array(
            "ShapeCollection" => 'ROUND',
            "LabCollection" => isset($filterArray['certificate'])?$filterArray['certificate']:'GIA',
            "ColorFrom" => isset($filterArray['color'])?$filterArray['color']:"D",
            "ColorTo" => isset($filterArray['color'])?$filterArray['color']:"J",
            "ClarityFrom" => isset($filterArray['clarity'])?$filterArray['clarity']:"IF",
            "ClarityTo" => isset($filterArray['clarity'])?$filterArray['clarity']:"I1",
            "SizeFrom" => isset($filterArray['carat'])?$filterArray['carat']:"0.3",
            "SizeTo" => isset($filterArray['carat'])?$filterArray['carat']:"1.5",
            "CutFrom" => isset($filterTo)?$filterTo:"EXCELLENT",
            "CutTo" => isset($filterTo)?$filterTo:"GOOD",
            "GirdleSizeMin" => "EXTR_THICK",
            "GirdleSizeMax" => "SLIGHTLY_THICK",
            "TablePercentFrom" => "48.2",
            "TablePercentTo" => "73.4",
            "DepthPercentFrom" => "33.86",
            "DepthPercentTo" => "73.8",
            "MeasLengthFrom" => "3.7",
            "MeasLengthTo" => "6.4",
            "MeasWidthFrom" => "2.8",
            "MeasWidthTo" => "7.9",
            "MeasDepthFrom" => "2.7",
            "MeasDepthTo" =>"3.86",
            "PriceFrom" => "1",
            "PriceTo" => "999999",
            "PageNumber" => 1,
            "PageSize" => 25,
            "SortDirection" => "ASC",
            "SortBy" => "PRICE"
        );


        $params1 = array("SearchParams" => $searchParams, "DiamondsFound" => 0);

        $results=$client1->__soapCall("GetDiamonds", array($params1), NULL, NULL, $output_headers);

        if(isset($results->GetDiamondsResult) && !empty($results->GetDiamondsResult->any)){
            $apiXmlResponse = simplexml_load_string($results->GetDiamondsResult->any);
            $object = json_decode(json_encode($apiXmlResponse->NewDataSet));
        }else{
            $object = new \stdclass;
            $object->Table1 = '';
        }

        if(is_object($object->Table1)){
            $allData[]=$object->Table1;
        }else{
            $allData=$object->Table1;
        }

        if(!empty($allData)){
            $rapnetAllData = array_merge($rapnetData,$allData);
        }

        // $i = 0;
        foreach($rapnetAllData as $key => $value){
            $data[$key]['Stock_NO'] = isset($value->DiamondID)?$value->DiamondID:'';
            $data[$key]['Shape'] = isset($value->ShapeTitle)?$value->ShapeTitle:'';
            $data[$key]['Carat']= isset($value->Weight)?$value->Weight:'';
            $data[$key]['Clarity']= isset($value->ClarityTitle)?$value->ClarityTitle:'';
            $data[$key]['Color']= isset($value->ColorTitle)?$value->ColorTitle:'';
            $data[$key]['Symble']= isset($value->CurrencySymbol)?$value->CurrencySymbol:'';
            $data[$key]['Amount']= isset($value->FinalPrice)?$value->FinalPrice:'';
            $data[$key]['CERT_NO']= isset($value->CertificateNumber)?$value->CertificateNumber:'';
            $data[$key]['Lab']= isset($value->LabTitle)?$value->LabTitle:'';
            $data[$key]['Cut']= isset($value->CutLongTitle)?$value->CutLongTitle:'';
            $data[$key]['FancyColorDescription']= '';
            $data[$key]['ImageLink']= '';
            $data[$key]['CertificateLink']= '';

            if($value->LabTitle=='GIA'){
                $data[$key]['CertificateLink']= 'https://www.gia.edu/cs/Satellite?reportno='.$value->CertificateNumber.'&childpagename=GIA%2FPage%2FReportCheck&pagename=GIA%2FDispatcher&c=Page&cid=1355954554547';
            }else if($value->LabTitle=='IGI'){
                // $data['CertificateLink']= 'https://www.igiworldwide.com/search_report.aspx?PrintNo='.$value->CertificateNumber.'&weight='.$value->Weight;
                $data[$key]['CertificateLink']= 'https://www.igi.org/reports/verify-your-report?r='.$value->CertificateNumber;
            }else if($value->LabTitle=='HRD'){
                $data[$key]['CertificateLink']= 'https://www.hrdantwerplink.be/?record_number='.$value->CertificateNumber.'&weight='.$value->Weight;
            }else{
                $data[$key]['CertificateLink']= 'https://www.diamondselections.com/GetCertificate.aspx?diamondid='.$value->DiamondID;
            }
            $data[$key]['data_fetch']= 'Rapnet';

        }

        return $data;

    }

    public function getHariKrishnaFunction(){

        ini_set('max_execution_time', 1200);
        set_time_limit(0);

        $start_date_time = date('Y-m-d H:i:s');
        Log::info("Harekrishna API work start at:- ". $start_date_time);

        $start_time = microtime(true); 
        $json_file_path = public_path('imports/hare_krishna.json');

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->hare_krishna_api,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request'
        ]);
        $resp = curl_exec($curl);
        curl_close($curl);
        $isValid = isValidJson($resp);
        // $resp = file_get_contents($json_file_path);
        // $isValid = isValidJson($resp);

        if($isValid){
            
            /** Delete order file */
            if(file_exists($json_file_path)){
                unlink($json_file_path);
            }
            /** Create new file and put json content */
            $putFile = file_put_contents($json_file_path, $resp);
            
            /** Make data to save accordingly */
            $arData = json_decode($resp, true);
            
            // Delete old data with truncate
             HKDiamondStock::truncate();
            
            // $dataToInsert = [];
            $recordsAdded= 0;
            foreach($arData as $key => $stock){
                $dataToInsert = [];
                $stock['Sr_No'] = $stock['Sr_No_'];
                $stock['Flourescent'] = $stock['Fluorescent'];
                $stock['Measurements'] = $stock['Measurement'];
                $stock['ImportIdx'] = 7;
                unset($stock['Sr_No_']);
                unset($stock['Fluorescent']);
                unset($stock['Measurement']);
                $dataToInsert[0] = $stock;
                HKDiamondStock::insert($dataToInsert);
                $recordsAdded = $recordsAdded + 1;
            }
            
            // Delete old data with truncate
            //HKDiamondStock::truncate();

            // Save all data using chunks
            // $recordsAdded = 0;
            // $collection = collect($dataToInsert);
            // foreach ($collection->chunk(100) as  $chunk) {
            //     HKDiamondStock::insert($chunk->toArray());
            //     $recordsAdded = $recordsAdded + $chunk->count();
            // }

            

            $end_time = microtime(true);
            $execution_time = ($end_time - $start_time);
            echo " Execution time of script = ".$execution_time." sec<br />";
            echo 'Records added:- ' . $recordsAdded;

            $end_date_time = date('Y-m-d H:i:s');
            Log::info("SUCCESS:- Harekrishna API work start at:- ". $end_date_time);
            Log::info("SUCCESS:- Harekrishna Total records added:- ". $recordsAdded);
            Log::info("SUCCESS:- Harekrishna Total time take:- ". $execution_time. " Seconds");
            Log::info("-------------");
            die;
        }else{
            $end_time = microtime(true);
            $execution_time = ($end_time - $start_time);
            echo " Execution time of script = ".$execution_time." sec<br />";
            print_r($resp);
            $end_date_time = date('Y-m-d H:i:s');
            Log::info("ERROR:- Harekrishna API work end at:- ". $end_date_time);
            Log::info("ERROR:- Harekrishna Total execution time:- ". $execution_time. " Seconds");
            Log::info("ERROR:- Harekrishna :- ". trim(preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", strip_tags (preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $resp)))));
            Log::info("-------------");
            die;
        }

        // sendAbandonmentMailTest();
    }


    //pending and processing starts from here
    public function sendAbandonmentMailTest(){

        $orders = Order:: with('getOrderDetailsFunction')->whereBetween('created_at', [Carbon::now()->subDay(), Carbon::now()])
            ->where(function ($query) {$query->where('status', 0) ->orWhere('status', 1)->orWhere('status', 2)->orWhere('status', 3);})->get()->toArray();

            $excludedUsers = [];
            foreach ($orders as $item) {
                if ($item['status'] == 2|| $item['status'] == 3) {
                    $excludedUsers[$item['user_id']] = true;
                }
            }

            $filteredData = array_filter($orders, function ($item) use ($excludedUsers) {
                return !isset($excludedUsers[$item['user_id']]);
            });

            $uniqueUsers = [];
            $result = [];

            foreach ($filteredData as $item) {
                if (!isset($uniqueUsers[$item['user_id']])) {
                    $uniqueUsers[$item['user_id']] = true;
                    $result[] = $item;
                }
            }

            foreach($result as $order) {

                Log::info("Email sent successfully for order ID Started: {$order['id']}");
                $data = [
                    'data' => $order,
                ];

                $customerEmail = $order['user_details']['email'];
                $adminEmailLondon = "london@marlows-diamonds.co.uk";

                
                $when = Carbon::now()->addHours(24);
                Mail::send('email.orderstatusqueueprocess', ['data1' => $data], function($message) use ($customerEmail, $adminEmailLondon) {

                    $message->from('order@marlows-diamonds.co.uk');
                    $message->to($adminEmailLondon, 'Admin')->subject('Marlows Diamonds: Your transaction not completed.');
                    $message->cc($customerEmail, 'Customer');
                    $message->bcc('kartik.tanwar@dotsquares.com', 'Customer');
            });

               Order::where('id', $order['id'])->update(['email_status' => 2]);
               Log::info("Email sent successfully for order ID Ended: {$order['id']}");
        }
    }


    //pending and processing ends here

    function getOrderMailProcessingFunction() {

        $start_date_time = date('Y-m-d H:i:s');
        Log::info("Order Mail Processing API work start at:- ". $start_date_time);

        $currentYear = date('Y');
    
        $query = Order::with('getOrderDetailsFunction')
        ->where(function ($query) use ($currentYear) {
            $query->whereYear('created_at', $currentYear)
                ->where('email_status', 1);
        })
        ->where(function ($query) {
            $query->where('status', 1)
                ->orWhere('status', 0);
        })->limit(1)->get();
    
        if ($query !== null) {
            $processing_date_time = date('Y-m-d H:i:s');
            Log::info("Order Mail Processing API work Processing at:- ". $processing_date_time);
            foreach ($query as $key => $order) {
                if (env('APP_ENV') == 'local') {
                    $data = [
                        'data' => $order->toArray()
                    ];
                    $adminEmail = 'kartik.tanwar@dotsquares.com'; // use it on production $order->user_details->email
                    $when = Carbon::now()->addMinutes(250);
                    // $when = Carbon::now()->addSeconds(10);
                    Mail::to($adminEmail)->cc('jyoti21tp@gmail.com')->bcc('gajendra3036@gmail.com')->later($when, new OrderMailProcess($data));
                    Order::where('id', $order->id)->update(['email_status' => 2]);
                }
            }
            echo "Mail Send Completed";
            $end_date_time = date('Y-m-d H:i:s');
            Log::info("Order Mail API work Completed at:- ". $end_date_time);
        }else{
            $failed_date_time = date('Y-m-d H:i:s');
            Log::info("Order Mail API work Failed at:- ". $failed_date_time);
        }
        $wrong_date_time = date('Y-m-d H:i:s');
        Log::info("Order Mail Something Went Wrong:- ". $wrong_date_time);
    }

    public function getOrderMailProcessingPreviewFunction() {
        $currentYear = date('Y');
        $getOrderDetails = Order::with('getOrderDetailsFunction')
        ->where(function ($query) use ($currentYear) {
            $query->whereYear('created_at', $currentYear)
                ->where('email_status', 1);
        })->where(function ($query) {
            $query->where('status', 1)
                ->orWhere('status', 0);
        })->first()->toArray();

        $data1 = [
            'data' => $getOrderDetails,
        ];

        return view('email.orderstatusqueueprocess',compact('data1'));
    }

}
