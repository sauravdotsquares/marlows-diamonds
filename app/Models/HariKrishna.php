<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HariKrishna extends Model
{
    use HasFactory;

    // public $timestamps = false;
    //BaseModelOne.php
    protected $connection = 'mysql';

    protected $table = "hkdiamondstock";

    protected $fillable = [
        "Sr_No",
        "Stock_NO",
        "Shape",
        "Carat",
        "Clarity",
        "Color",
        "Color_Shade",
        "Rap_Rate",
        "Rap_Vlu",
        "Rap__",
        "Pr_Ct",
        "Amount",
        "TD_",
        "Tab_",
        "Cut",
        "Polish",
        "Symmetry",
        "Flourescent",
        "Measurements",
        "Lab",
        "H_A",
        "CUL",
        "Girdle",
        "Girdle_",
        "BIT",
        "BIC",
        "WIT",
        "WIC",
        "MILKY",
        "LIns",
        "LUS",
        "OPPV",
        "OPTA",
        "OPCR",
        "CA",
        "CH",
        "PA",
        "PHP",
        "CERT_NO",
        "Location",
        "RO",
        "EC",
        "Keytosymbol",
        "FancyColorDescription",
        "ImageLink",
        "CertificateLink",
        "VideoLink",
        "ImportIdx",
    ];
}
