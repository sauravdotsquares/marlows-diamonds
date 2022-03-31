<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Type $var = null)
    {
        return view('admin.products.index');
    }

    public function create($prodSlug)
    {
        echo "Product Slug<pre>";
        print_r($prodSlug);
        die;
    }
}
