<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;
use App\Models\ProductImages;

class CSVController extends Controller
{
    public function csvProductsVariationImportFunction(){
        // Read the CSV file using League CSV package
        $csv = Reader::createFromPath(storage_path('app/public/pricingdiamond.csv'), 'r');
        $csv->setHeaderOffset(0); // Assuming first row is the header
        // Get records
        $records = $csv->getRecords();
        foreach ($records as $record) {
            // dd($record);

            $getProductId = DB::table('products')->where('title','like','%'.$record['title'].'%')->value('id');
            if((!empty($record['lab_grown_rrp']) && $record['lab_grown_rrp'] > 0) ||
            (!empty($record['mined_diamond_rrp']) && $record['mined_diamond_rrp'] > 0)){
                $getVariationData = explode(',',$record['variations']);
                $transformedAttributes = [];
                foreach ($getVariationData as $attribute) {
                    
                    [$key, $value] = explode(":- ", $attribute, 2);
                    
                    $formattedKey = "attri_" . str_replace(' ', '_', trim($key));
                    
                    $transformedAttributes[$formattedKey] = trim($value);

                }

                unset($transformedAttributes['attri_finger-size']);

               
                $getProductId = DB::table('product_variations')->where('product_id',$getProductId)->pluck('id');
                $getProductIdDetails = DB::table('product_variation_details')
                                    ->whereIn('variation_id', $getProductId) // Filter by variation IDs
                                    ->where(function ($query) use ($transformedAttributes) {
                                        foreach ($transformedAttributes as $key => $value) {
                                            $query->orWhere('key', $key)->where('value', $value);
                                        }
                                    })
                                    ->get();
                $groupedByVariationId = collect($getProductIdDetails)->groupBy('variation_id');
               
                // Get only those variation_ids that have all required attributes
                $filteredData = $groupedByVariationId->filter(function ($items) use ($transformedAttributes) {
                    $keys = $items->pluck('key')->toArray();
                    return empty(array_diff(array_keys($transformedAttributes), $keys)); // Ensures all required keys exist
                });
                
                // Flatten the result if needed
                $filteredRecords = $filteredData->flatten(1);

                if(isset($filteredRecords) && !empty($filteredRecords[0])){
                    $getProductId = DB::table('product_variations')->where('id',$filteredRecords[0]->variation_id)->update([
                        'lab_grown_rrp' => $record['lab_grown_rrp'],
                        'lab_grown' => $record['lab_grown'],
                        'data_status' => 1,
                    ]);
                    dump("Product Variatrions Uploaded properly ==>".$filteredRecords[0]->variation_id."--".$record['title']);
                }else{
                    dump("Product Variatrions Not Uploaded ============>"."--------------".$record['title']);
                }

            }else{
                dump("Lab RRP Price will be 0");
            }
        }
        echo "Product Images CSV Import Uploaded";
    }
}
