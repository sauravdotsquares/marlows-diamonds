<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\Products;
use App\Models\ProductImages;
use App\Models\ProductVariations;
use App\Models\ProductVariationAttributes;
use App\Models\ProductVariationDetails;
use App\Models\Attributes;
use Illuminate\Support\Arr;
use App\Models\DiamondShapes;
use App\Models\ProductVariationsMaster;
use App\Models\GlobalCombinationsVariations;
use App\Models\Masters;

use View;

class AppProductsController extends Controller{
    
}