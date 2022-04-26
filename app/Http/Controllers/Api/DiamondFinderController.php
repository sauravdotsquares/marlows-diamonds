<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\HKDiamondStock;
use Illuminate\Support\Arr;
//use SoapClient;

//use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;

class DiamondFinderController
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function diamondSearch(Request $request)
    {
    	
        
       
        $data = array('shape'=>$request->shape,'grade'=>'EX','certificate'=>'GIA','colorFrom'=>'D','colorTo'=>'K','clarityFrom'=>'IF','clarityTo'=>'SI2','caratFrom'=>$request->carat_min,'caratTo'=>$request->carat_max,'paging'=>5);
        //echo '<pre>'; print_r($data); die;

        $hkData = getHKApiRecords($data);
        if(empty($hkData['data'])){
        	$hkData['to']=5;
        	$hkData['last_page']=10;
        	$hkData['total']=100;
        }
        //echo '<pre>'; print_r($hkData); die;
        //echo $hkData['current_page'];
        $rapnetData = getRapnetApiRecords($data,$hkData['current_page']);
        //echo '<pre>'; print_r($rapnetData); die;

        $rapnetRecords = [];
        if(!empty($rapnetData)){
	        foreach ($rapnetData as $key => $result) {
	        	$rapnetRecords[$key]['Shape'] = $result->ShapeTitle;;
	        	$rapnetRecords[$key]['Carat'] = $result->Weight;
	        	$rapnetRecords[$key]['Color'] = $result->ColorTitle;
	        	$rapnetRecords[$key]['Clarity'] = $result->ClarityTitle;
	        	if(isset($result->CutLongTitle))
	        		$rapnetRecords[$key]['Cut'] = $result->CutLongTitle;

	        	$rapnetRecords[$key]['Lab'] = $result->LabTitle;
	        	$rapnetRecords[$key]['Amount'] = $result->FinalPrice;
	        	$rapnetRecords[$key]['Stock_NO'] = $result->DiamondID;


	        	if($result->LabTitle=='GIA'){
					$rapnetRecords[$key]['CertificateLink']= 'https://www.gia.edu/cs/Satellite?reportno='.$result->CertificateNumber.'&childpagename=GIA%2FPage%2FReportCheck&pagename=GIA%2FDispatcher&c=Page&cid=1355954554547';
				}
				else if($result->LabTitle=='IGI'){
					$rapnetRecords[$key]['CertificateLink']= 'https://www.igi.org/reports/verify-your-report?r='.$result->CertificateNumber;
				}
				else if($result->LabTitle=='HRD'){
					$rapnetRecords[$key]['CertificateLink']= 'https://www.hrdantwerplink.be/?record_number='.$result->CertificateNumber.'&weight='.$result->Weight;
				}
				else {
					$rapnetRecords[$key]['CertificateLink']= 'https://www.diamondselections.com/GetCertificate.aspx?diamondid='.$result->DiamondID;	
				}

	        }
    	}
        //echo '<pre>'; print_r($rapnetRecords); die;

        $hkData['data'] = Arr::collapse([$hkData['data'], $rapnetRecords]);

        $hkData['VAT'] = getVAT();
        $hkData['firstDiamondAmount'] = $hkData['data'][0]['Amount'];
       // $hkData = 
		return response($hkData);
    }

}
