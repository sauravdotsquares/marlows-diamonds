<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProductCat($slugUrl = null)
    {
        echo "<pre>";
        print_r($slugUrl);
        die;
    }
}
