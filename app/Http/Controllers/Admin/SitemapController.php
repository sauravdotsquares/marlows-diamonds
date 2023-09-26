<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Category;
use App\Models\Pages;
use App\Models\Posts;
use App\Models\PostCategory;
use App\Models\Menus;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function sitemapFunction() {
        $getProductData = Products::select('slug','categories')->latest()->get();
        $getCategoryData = Category::with('grandchildren')->select('*')->where('parent_id',0)->get();
        $getPagesData = Pages::select('slug')->where('status',1)->latest()->get();
        $getPostCategoryData = PostCategory::select('slug')->latest()->get();
        $getPostData = Posts::select('slug')->latest()->get();

        $resultArray = [
            'getProductData' => $getProductData, // done
            'getCategoryData' => $getCategoryData, // done
            'getPagesData' => $getPagesData, // done
            'getPostCategoryData' => $getPostCategoryData,
            'getPostData' => $getPostData,
        ];

        $this->createXMLfileNewFormat($resultArray);
        echo "Done";
    }

    public function createXMLfileNewFormat($productArray){

        $filePath = public_path('sitemap.xml');

        $dom     = new \DOMDocument('1.0', 'utf-8');

        $root = $dom->createElement('urlset');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        // $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');
        $customUrl = '';

        // Main URL Show Start
        $productUrl = $dom->createElement('url');

        $locurl  = $dom->createElement('loc', url(''));
        $productUrl->appendChild($locurl);

        $lastmoddate   = $dom->createElement('lastmod', Carbon::now()->toIso8601String());

        $productUrl->appendChild($lastmoddate);

        $priority   = $dom->createElement('priority', 1 - substr_count('/', '/') / 10);
        $productUrl->appendChild($priority);
        $root->appendChild($productUrl);

        // Main URL End

        // account URL Start
            $productUrl = $dom->createElement('url');

            $locurl  = $dom->createElement('loc', url('').'/my-account');
            $productUrl->appendChild($locurl);

            $lastmoddate   = $dom->createElement('lastmod', Carbon::now()->toIso8601String());

            $productUrl->appendChild($lastmoddate);

            $priority   = $dom->createElement('priority', 1 - substr_count('/my-account', '/') / 10);
            $productUrl->appendChild($priority);
            $root->appendChild($productUrl);

        // account URL End

        // /products/wishlist URL Start
            $productUrl = $dom->createElement('url');

            $locurl  = $dom->createElement('loc', url('').'/products/wishlist');
            $productUrl->appendChild($locurl);

            $lastmoddate   = $dom->createElement('lastmod', Carbon::now()->toIso8601String());

            $productUrl->appendChild($lastmoddate);

            $priority   = $dom->createElement('priority', 1 - substr_count('/products/wishlist', '/') / 10);
            $productUrl->appendChild($priority);
            $root->appendChild($productUrl);
        // /products/wishlist URL End

        // /products/cart URL Start
            $productUrl = $dom->createElement('url');

            $locurl  = $dom->createElement('loc', url('').'/products/cart');
            $productUrl->appendChild($locurl);

            $lastmoddate   = $dom->createElement('lastmod', Carbon::now()->toIso8601String());

            $productUrl->appendChild($lastmoddate);

            $priority   = $dom->createElement('priority', 1 - substr_count('/products/cart', '/') / 10);
            $productUrl->appendChild($priority);
            $root->appendChild($productUrl);
        // /products/cart URL End

        // /users/forget-password URL Start
            $productUrl = $dom->createElement('url');

            $locurl  = $dom->createElement('loc', url('').'/users/forget-password');
            $productUrl->appendChild($locurl);

            $lastmoddate   = $dom->createElement('lastmod', Carbon::now()->toIso8601String());

            $productUrl->appendChild($lastmoddate);

            $priority   = $dom->createElement('priority', 1 - substr_count('/users/forget-password', '/') / 10);
            $productUrl->appendChild($priority);
            $root->appendChild($productUrl);
        // /users/forget-password URL End

        foreach($productArray['getCategoryData'] as $keyCat => $catDetails){
            $activeUrl = '';
            if(isset($catDetails->grandchildren) && count($catDetails->grandchildren)){
                $increData1 = 0;
                foreach($catDetails->grandchildren as $graKey => $childValue){
                    $increData2 = 0;
                    if(isset($childValue->grandchildren) && count($childValue->grandchildren)){
                        foreach($childValue->grandchildren as $graKey1 => $childValueGrand){
                            $activeUrl = '/product-category/'.$catDetails->slug.'/'.$childValue->slug.'/'.$childValueGrand->slug;

                            if($increData1==0){
                                $productUrl = $dom->createElement('url');
                                $activeUrl1 = '/product-category/'.$catDetails->slug;

                                $locurl1  = $dom->createElement('loc', url('').$activeUrl1);

                                $productUrl->appendChild($locurl1);

                                $lastmoddate1   = $dom->createElement('lastmod', Carbon::now()->toIso8601String());

                                $productUrl->appendChild($lastmoddate1);

                                $priority1   = $dom->createElement('priority', 1 - substr_count($activeUrl1, '/') / 10);

                                $productUrl->appendChild($priority1);

                                $root->appendChild($productUrl);

                                $increData1= $increData1+1;
                            }

                            if($increData2==0){
                                $productUrl = $dom->createElement('url');
                                $activeUrl2 = '/product-category/'.$catDetails->slug.'/'.$childValue->slug;

                                $productUrl = $dom->createElement('url');

                                $locurl2  = $dom->createElement('loc', url('').$activeUrl2);

                                $productUrl->appendChild($locurl2);

                                $lastmoddate2   = $dom->createElement('lastmod', Carbon::now()->toIso8601String());

                                $productUrl->appendChild($lastmoddate2);

                                $priority2   = $dom->createElement('priority', 1 - substr_count($activeUrl2, '/') / 10);

                                $productUrl->appendChild($priority2);

                                $root->appendChild($productUrl);

                                $increData2= $increData2+1;
                            }

                            $productUrl = $dom->createElement('url');
                            $locurl  = $dom->createElement('loc', url('').$activeUrl);
                            $productUrl->appendChild($locurl);

                            $lastmoddate   = $dom->createElement('lastmod', Carbon::now()->toIso8601String());

                            $productUrl->appendChild($lastmoddate);

                            $priority   = $dom->createElement('priority', 1 - substr_count($activeUrl, '/') / 10);

                            $productUrl->appendChild($priority);

                            $root->appendChild($productUrl);

                        }
                    }
                }
            }
        }

        foreach($productArray['getProductData'] as $key => $productArrayNew){
            if(isset($productArrayNew->slug) && !empty($productArrayNew->slug)){
                $productUrl = $dom->createElement('url');

                $locurl  = $dom->createElement('loc', url('').'/product/'.$productArrayNew->slug);
                $productUrl->appendChild($locurl);

                $lastmoddate   = $dom->createElement('lastmod', Carbon::now()->toIso8601String());

                $productUrl->appendChild($lastmoddate);

                $priority   = $dom->createElement('priority', 1 - substr_count('/product/'.$productArrayNew->slug, '/') / 10);
                $productUrl->appendChild($priority);
                $root->appendChild($productUrl);
            }
        }

        foreach($productArray['getPostData'] as $key => $postArrayNew){

            if(isset($postArrayNew->slug) && !empty($postArrayNew->slug)){
                $productUrl = $dom->createElement('url');

                $locurl  = $dom->createElement('loc', url('').'/blog-resources/'.$postArrayNew->slug);
                $productUrl->appendChild($locurl);

                $lastmoddate   = $dom->createElement('lastmod', Carbon::now()->toIso8601String());

                $productUrl->appendChild($lastmoddate);

                $priority   = $dom->createElement('priority', 1 - substr_count('/blog-resources/'.$postArrayNew->slug, '/') / 10);
                $productUrl->appendChild($priority);
                $root->appendChild($productUrl);
            }
        }

        foreach($productArray['getPagesData'] as $pageKey => $valuePageData){
            $productUrl = $dom->createElement('url');

            $locurl  = $dom->createElement('loc', url('').'/'.$valuePageData->slug);
            $productUrl->appendChild($locurl);

            $lastmoddate   = $dom->createElement('lastmod', Carbon::now()->toIso8601String());
            $productUrl->appendChild($lastmoddate);

            $priority   = $dom->createElement('priority', 1 - substr_count('/'.$valuePageData->slug, '/') / 10);
            $productUrl->appendChild($priority);
            $root->appendChild($productUrl);
        }

        foreach($productArray['getPostCategoryData'] as $pageKey => $valuePageData){
            $productUrl = $dom->createElement('url');

            $locurl  = $dom->createElement('loc', url('').'/'.$valuePageData->slug);
            $productUrl->appendChild($locurl);

            $lastmoddate   = $dom->createElement('lastmod', Carbon::now()->toIso8601String());
            $productUrl->appendChild($lastmoddate);

            $priority   = $dom->createElement('priority', 1 - substr_count('/'.$valuePageData->slug, '/') / 10);
            $productUrl->appendChild($priority);
            $root->appendChild($productUrl);
        }




        $dom->appendChild($root);

        $dom->save($filePath);
    }
}
