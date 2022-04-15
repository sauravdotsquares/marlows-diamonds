<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SoapClient;

class ApiController extends Controller
{
    public function getRepnetApiFunction($filterArray)
    {

        // echo "asdads<pre>";
        // print_r($filterArray);
        // print_r($filterArray['carat']);
        // die;

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
            "LabCollection" => $filterArray['certificate'],
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

        return $rapnetAllData;

    }

    public function getHariKrishnaFunction($getFilterData)
    {

        // echo "getHariKrishnaFunction<pre>";
        // print_r($resp);
        // die;

        $info = getdate();
        $date = $info['mday'];
        $month = $info['mon'];
        $year = $info['year'];
        $hour = $info['hours'];
        $min = $info['minutes'];
        $sec = $info['seconds'];

        $current_date = "$date/$month/$year == $hour:$min:$sec";

        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            //CURLOPT_URL => 'http://web.hkerp.co/apihkstock?user=fd0c4f55-3a3b-46db-a1ce-ac178cfe8d59&type=json',
            CURLOPT_URL => 'https://service.hk.co/apihkstock?user=fd0c4f55-3a3b-46db-a1ce-ac178cfe8d59&type=json',
            CURLOPT_USERAGENT => 'Codular Sample cURL Request'
        ]);
        // Send the request & save response to $resp
        $resp = curl_exec($curl);

        echo "<pre>";
        print_r($resp);
        die;
    }

}
