<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings;
class FooterSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create([
	            'option_name' => 'footer_sec1-title',
	            'option_value' => 'About',
	        ]);
		Settings::create([
	            'option_name' => 'about',
	            'option_value' => 'For over three generations, we’ve been helping countless happy couples express love and commitment. At Marlow’s, we add sparkle to life’s special moments through our beautiful range of diamond jewellery.',
	        ]);	
		Settings::create([
	            'option_name' => 'footer_sec2-title',
	            'option_value' => 'Catalogue',
	        ]);
		Settings::create([
	            'option_name' => 'catalogue',
	            'option_value' => '<ul><li><a href="/engagement-rings/">Engagement Rings</a></li><li><a href="/product-category/wedding-rings/">Wedding Rings</a></li><li><a href="/product-category/eternity-rings/">Eternity Rings</a></li><li><a href="/product-category/diamond-jewellery/">Diamond Jewellery</a></li><li><a href="/auctions/">Auction</a></li><li><a href="/live-diamond-search/">Live Diamond Search</a></li></ul>',
	        ]);
		Settings::create([
	            'option_name' => 'footer_sec3-title',
	            'option_value' => 'Resources',
	        ]);
		Settings::create([
	            'option_name' => 'resources',
	            'option_value' => '<ul><li><a href="/covid-19-policy/">COVID-19 Policy</a></li><li><a href="/visit-us/">Locations</a></li><li><a href="/faq/">FAQ</a></li><li><a href="/certificates-explained/">Certificates Explained</a></li><li><a href="/finance-options/">Finance</a></li><li><a href="/blog/">Blog</a></li></ul>', // Change after SEO discuss 05Jan2023 seo_change
	        ]);	
		Settings::create([
			'option_name' => 'footer_sec4-title',
			'option_value' => 'Resources',
		]);	
		Settings::create([
			'option_name' => 'sec-resources',
			'option_value' => '<ul><li><a href="/buying-engagement-ring-online-guide/">Guide To Buying An Engagement Ring Online</a></li><li><a href="/gia-certified-diamonds/">Marlows Gia Certified Diamonds</a></li><li><a href="/bespoke-engagement-rings/">Bespoke Engagement Rings</a></li><li><a href="/diamond-education/">Diamond Education</a></li><li><a href="/hearts-and-arrows-diamonds/">Hearts And Arrows Diamonds</a></li></ul>',
		]);
		Settings::create([
			'option_name' => 'footer_sec5-title',
			'option_value' => 'Policies',
		]);
		Settings::create([
			'option_name' => 'policies',
			'option_value' => '<ul><li><a href="/diamond-certificates/">Conflict-Free diamonds</a></li><li><a href="/privacy/">Privacy Policy</a></li><li><a href="/cookies/">Cookies Policy</a></li><li><a href="/terms/">Terms and Conditions</a></li></ul>',
		]);
		Settings::create([
			'option_name' => 'footer-left',
			'option_value' => '<img src="/Payment-Gateways.png" alt="Payment Gateways"><img src="/Deko_landscape_bw_darkBG.png" alt="Deko Pay">',
		]);
		Settings::create([
			'option_name' => 'footer-center',
			'option_value' => 'Important Disclaimer - Marlow’s Diamonds &amp; JE Marlow &amp; Sons Ltd do not issue diamond certificates or lab reports. These are issued by indepedent bodies such as the GIA, HRD or IGI<br>
J E Marlow &amp; Sons Ltd. is acting as a credit broker offering finance products from Omni Capital Retail Finance Limited is authorised and regulated by the Financial Conduct Authority (register number 720279). Credit is subject to status.',
		]);
		Settings::create([
			'option_name' => 'footer-right',
			'option_value' => 'Copyright J E Marlow &amp; Sons Ltd. Registered in England and Wales.<br>
<b>Birmingham Store:</b> 46-47 Warstone Lane Hockley, Birmingham B18 6JJ.<br>
<b>London Store:</b> 20 Beauchamp Pl, Knightsbridge, London SW3 1NQ. <br> Registraton No. 00867377. VAT No. GB 111114741<br>
<b>© 2020 Marlows Diamonds. All Rights Reserved.</b>',
		]);
	}
}
