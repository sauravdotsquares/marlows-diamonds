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
    	$colorFrom = 'D'; $colorTo = 'K'; $colour=array();
    	if($request->colour!=''){
            $colour = explode(',',$request->colour);
                $colorFrom = $colour[0]; $colorTo = $colour[count($colour)-1];
        }

       	$clarityFrom = 'IF'; $clarityTo = 'SI2'; $clarity=array();
    	if($request->clarity!=''){
        	$clarity = explode(',',$request->clarity);
			$clarityFrom = $clarity[0]; $clarityTo = $clarity[count($clarity)-1];
       	}

       	$gradeFrom = 'EX'; $gradeTo = 'GD'; $grade=array();
    	if($request->grade!=''){
        	$grade = explode(',',$request->grade);
			$gradeFrom = $grade[0]; $gradeTo = $grade[count($grade)-1];
       	}

       	$polishFrom = 'EX'; $polishTo = 'GD'; $polish=array();
    	if($request->polish!=''){
        	$polish = explode(',',$request->polish);
			$polishFrom = $polish[0]; $polishTo = $polish[count($polish)-1];
       	}

       	$symmetryFrom = 'EX'; $symmetryTo = 'GD'; $symmetry=array();
    	if($request->symmetry!=''){
        	$symmetry = explode(',',$request->symmetry);
			$symmetryFrom = $symmetry[0]; $symmetryTo = $symmetry[count($symmetry)-1];
       	}

       	$fluorescence = array();
    	if($request->fluorescence!=''){
        	$fluorescence = explode(',',$request->fluorescence);
       	}
       	$certificate = array();
    	if($request->certificate!=''){
        	$certificate = explode(',',$request->certificate);
       	}

        $data = array('shape'=>$request->shape,'colorFrom'=>$colorFrom,'colorTo'=>$colorTo,'colour'=>$colour,'clarityFrom'=>$clarityFrom,'clarityTo'=>$clarityTo,'clarity'=>$clarity,'caratFrom'=>$request->carat_min,'caratTo'=>$request->carat_max,'gradeFrom'=>$gradeFrom,'gradeTo'=>$gradeTo,'grade'=>$grade,'polishFrom'=>$polishFrom,'polishTo'=>$polishTo,'polish'=>$polish,'symmetryFrom'=>$symmetryFrom,'symmetryTo'=>$symmetryTo,'symmetry'=>$symmetry,'fluorescence'=>$fluorescence,'certificate'=>$certificate,'paging'=>5,'PageSize'=>5);
        //echo '<pre>'; print_r($data); die;

        $hkData = getHKApiRecords($data);
        if(empty($hkData['data'])){
        	$hkData['to']=5;
        	$hkData['last_page']=10;
        	$hkData['total']=100;
        }else if(!empty($hkData['data']) && $hkData['total']<50){
        	$hkData['to']=5;
        	$hkData['last_page']=10;
        	$hkData['total']=100;
        }

        $rapnetData = getRepnetAPIPattern($data,$hkData['current_page']);



        $rapnetData = getRapnetApiRecordsDiamondSearch($data,$hkData['current_page']);


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
                $rapnetRecords[$key]['CERT_NO'] = $result->CertificateNumber;


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
