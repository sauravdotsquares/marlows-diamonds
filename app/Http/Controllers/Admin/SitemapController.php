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
    public function index() {
        $getProductData = Products::select('slug','categories')->latest()->get();
        $getCategoryData = Category::with('grandchildren')->select('*')->get();
        $getPagesData = Pages::select('slug')->latest()->get();
        $getPostCategoryData = PostCategory::select('slug')->latest()->get();
        $getPostData = Posts::select('slug')->latest()->get();
        $getMenusData = Menus::select('slug')->latest()->get();

        $resultArray = [
            'getProductData' => $getProductData, // done
            'getCategoryData' => $getCategoryData, // done
            'getPagesData' => $getPagesData, // done
            'getPostCategoryData' => $getPostCategoryData,
            'getPostData' => $getPostData,
            'getMenusData' => $getMenusData,
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
        // $root->setAttributeNS('', 'version', '2.0');
        // $root->setAttributeNS('', 'encoding', 'utf-8');

        // $channelNew = $dom->createElement('channel');

        $customUrl = '';
        foreach($productArray['getCategoryData'] as $keyCat => $catDetails){
            $activeUrl = '';
            if(isset($catDetails->grandchildren) && count($catDetails->grandchildren)){
                foreach($catDetails->grandchildren as $graKey => $childValue){
                    if(isset($childValue->grandchildren) && count($childValue->grandchildren)){
                        foreach($childValue->grandchildren as $graKey1 => $childValueGrand){
                            $activeUrl = '/product-category/'.$catDetails->slug.'/'.$childValue->slug.'/'.$childValueGrand->slug;

                            $productUrl = $dom->createElement('url');

                            $locurl  = $dom->createElement('loc', url('').$activeUrl);
                            $productUrl->appendChild($locurl);

                            $lastmoddate   = $dom->createElement('lastmod', Carbon::now()->toIso8601String());

                            $productUrl->appendChild($lastmoddate);

                            $priority   = $dom->createElement('priority', 1 - substr_count($activeUrl, '/') / 10);

                            $productUrl->appendChild($priority);

                            $root->appendChild($productUrl);

                        }
                    }else{
                        $activeUrl = '/product-category/'.$catDetails->slug.'/'.$childValue->slug;

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
            }else{
                $activeUrl = '/product-category/'.$catDetails->slug;

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
