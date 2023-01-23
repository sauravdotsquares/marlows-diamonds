<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitemapUrls extends Model
{

    protected $table = 'sitemap_urls';
	use HasFactory;
	
	protected $fillable = [
        'type',
	    'url',
        'priority',
        'display_order',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at'
	];


    public static function deleteRecordByUrl($url){
        return self::where('url', $url)->delete();
    }


    public static function generateXml(){

        $pages = self::where(['is_deleted'=>0, 'is_active'=>1])->get();
        $siteMapdata = '<?xml version="1.0" encoding="utf-8"?>';
        $siteMapdata .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';

        foreach ($pages as $page_key => $page_value) {
            $dateTime = $page_value->created_at->tz('UTC')->toAtomString();
            $url = url($page_value->url);
            $siteMapdata .= "<url>
                    <loc>$url</loc>
                    <lastmod>$dateTime</lastmod>
                    <priority>0.8</priority>
                </url>";
        }
        $siteMapdata .= '</urlset>';
        
        mkdir(public_path('sitemaps'), 07777);
        $filePath = public_path('sitemaps/sitemap.xml');
        $file = fopen($filePath, "w");
        fwrite($file, $siteMapdata);
        return true;
    }
	
}
