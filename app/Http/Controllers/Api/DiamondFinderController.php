<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\HKDiamondStock;
use App\Models\MarginApiRange;
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
		$colorFrom = 'D';
		$colorTo = 'K';
		$colour = array();
		if ($request->colour != '') {
			$colour = explode(',', $request->colour);
			$colorFrom = $colour[0];
			$colorTo = $colour[count($colour) - 1];
		}

		$clarityFrom = 'IF';
		$clarityTo = 'SI2';
		$clarity = array();
		if ($request->clarity != '') {
			$clarity = explode(',', $request->clarity);
			$clarityFrom = $clarity[0];
			$clarityTo = $clarity[count($clarity) - 1];
		}

		$gradeFrom = 'EX';
		$gradeTo = 'GD';
		$grade = array();
		if ($request->grade != '') {
			$grade = explode(',', $request->grade);
			$gradeFrom = $grade[0];
			$gradeTo = $grade[count($grade) - 1];
		}

		$polishFrom = 'EX';
		$polishTo = 'GD';
		$polish = array();
		if ($request->polish != '') {
			$polish = explode(',', $request->polish);
			$polishFrom = $polish[0];
			$polishTo = $polish[count($polish) - 1];
		}

		$symmetryFrom = 'EX';
		$symmetryTo = 'GD';
		$symmetry = array();
		if ($request->symmetry != '') {
			$symmetry = explode(',', $request->symmetry);
			$symmetryFrom = $symmetry[0];
			$symmetryTo = $symmetry[count($symmetry) - 1];
		}

		$fluorescence = array();
		if ($request->fluorescence != '') {
			$fluorescence = explode(',', $request->fluorescence);
		}
		$certificate = array();
		if ($request->certificate != '') {
			$certificate = explode(',', $request->certificate);
		}

		$data = array('shape' => $request->shape, 'colorFrom' => $colorFrom, 'colorTo' => $colorTo, 'colour' => $colour, 'clarityFrom' => $clarityFrom, 'clarityTo' => $clarityTo, 'clarity' => $clarity, 'caratFrom' => $request->carat_min, 'caratTo' => $request->carat_max, 'gradeFrom' => $gradeFrom, 'gradeTo' => $gradeTo, 'grade' => $grade, 'polishFrom' => $polishFrom, 'polishTo' => $polishTo, 'polish' => $polish, 'symmetryFrom' => $symmetryFrom, 'symmetryTo' => $symmetryTo, 'symmetry' => $symmetry, 'fluorescence' => $fluorescence, 'certificate' => $certificate, 'paging' => 5, 'PageSize' => 5);

		$hkData = getHKApiRecords($data);
		$hkData['data'] = array_map(array($this, "amountChange"), $hkData['data']);

        if(empty($hkData['data'])){
        	$hkData['to']=5;
        	$hkData['last_page']=10;
        	$hkData['total']=100;
        }else if(!empty($hkData['data']) && $hkData['total']<50){
        	$hkData['to']=5;
        	$hkData['last_page']=10;
        	$hkData['total']=100;
        }
		// if (!empty($hkData['data']) && $hkData['total'] < 50) {
		// 	$hkData['to'] = 5;
		// 	$hkData['last_page'] = 10;
		// 	$hkData['total'] = 100;
		// }

		if (!empty($hkData['data']) && $hkData['total'] < 50) {
			$hkData['to'] = 5;
			$hkData['last_page'] = 10;
			$hkData['total'] = 100;
		}

		$rapnetData = getRapnetApiRecordsDiamondSearch($data, $hkData['current_page']);

		$rapnetRecords = [];
		if (!empty($rapnetData)) {
			foreach ($rapnetData as $key => $result) {
				$rapnetRecords[$key]['Shape'] = $result->shape;
				$rapnetRecords[$key]['Carat'] = $result->size;
				$rapnetRecords[$key]['Color'] = $result->color;
				$rapnetRecords[$key]['Clarity'] = $result->clarity;
				if (isset($result->cut))
					$rapnetRecords[$key]['Cut'] = $result->cut;

				$rapnetRecords[$key]['Lab'] = $result->lab;
				$rapnetRecords[$key]['oldAmount'] = $result->total_sales_price;
				$rapnetRecords[$key]['Amount'] = $result->total_sales_price;
				$rapnetRecords[$key]['Stock_NO'] = $result->diamond_id;
				$rapnetRecords[$key]['CERT_NO'] = !empty($result->cert_num) ? $result->cert_num : '';


				if ($result->lab == 'GIA') {
					$rapnetRecords[$key]['CertificateLink'] = 'https://www.gia.edu/cs/Satellite?reportno=' . $rapnetRecords[$key]['CERT_NO'] . '&childpagename=GIA%2FPage%2FReportCheck&pagename=GIA%2FDispatcher&c=Page&cid=1355954554547';
				} else if ($result->lab == 'IGI') {
					$rapnetRecords[$key]['CertificateLink'] = 'https://www.igi.org/reports/verify-your-report?r=' . $rapnetRecords[$key]['CERT_NO'];
				} else if ($result->lab == 'HRD') {
					$rapnetRecords[$key]['CertificateLink'] = 'https://www.hrdantwerplink.be/?record_number=' . $rapnetRecords[$key]['CERT_NO'] . '&weight=' . $result->size;
				} else {
					$rapnetRecords[$key]['CertificateLink'] = 'https://www.diamondselections.com/GetCertificate.aspx?diamondid=' . $result->DiamondID;
				}
			}
		}

		$hkData['data'] = Arr::collapse([$rapnetRecords, $hkData['data']]);

		usort($hkData['data'], function ($a, $b) {
			// return $b['Amount'] - $a['Amount']; // sort by descending
			return $a['Amount'] - $b['Amount']; // sort by ascending
		});

		$hkData['VAT'] = getVAT();
		$hkData['firstDiamondAmount'] = isset($hkData['data'][0]) ? $hkData['data'][0]['Amount'] : '';

		return response($hkData);
	}

	public function amountChange($num)
	{
		$marginAPIPercentage = MarginApiRange::where('api_type', 'harikrishna')->whereRaw('"' . $num['Amount'] . '" between `from_price` and `to_price`')
			->where('status', 1)
			->first();
		$num['oldAmount'] = $num['Amount'];
		if (isset($num['Amount']))
			$num['Amount'] = $num['Amount'] * $marginAPIPercentage->percentage;
		return $num;
	}
}
