<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menus;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menus::create([
	            'parent' => 0,
	            'title' => 'Engagement Ring',
	            'slug' => '/engagement-rings/',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => 'Engagement Ring'
	        ]);
        Menus::create([
	            'parent' => 1,
	            'title' => 'Solitaire',
	            'slug' => '/product-category/engagement-rings/solitaire/',
	            'icon' => 'fas fa-angle-double-right',
	            'target' => '_self',
	            'tooltip' => 'Solitaire'
	        ]);
        Menus::create([
	            'parent' => 1,
	            'title' => 'Shoulder Set',
	            'slug' => '/product-category/engagement-rings/shoulder-set/',
	            'icon' => 'fas fa-angle-double-right',
	            'target' => '_self',
	            'tooltip' => 'Shoulder Set'
	        ]);
        Menus::create([
	            'parent' => 1,
	            'title' => 'Halo',
	            'slug' => '/product-category/engagement-rings/halo/',
	            'icon' => 'fas fa-angle-double-right',
	            'target' => '_self',
	            'tooltip' => 'Halo'
	        ]);
        Menus::create([
	            'parent' => 1,
	            'title' => 'Multi Stone',
	            'slug' => '/product-category/engagement-rings/multi-stone/',
	            'icon' => 'fas fa-angle-double-right',
	            'target' => '_self',
	            'tooltip' => 'Multi Stone'
	        ]);
        Menus::create([
	            'parent' => 0,
	            'title' => 'Wedding / Eternity Rings',
	            'slug' => '/product-category/wedding-rings/',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => 'Wedding / Eternity Rings'
	        ]);
        Menus::create([
	            'parent' => 6,
	            'title' => 'Mens',
	            'slug' => '/product-category/wedding-rings/mens/',
	            'icon' => 'fas fa-angle-double-right',
	            'target' => '_self',
	            'tooltip' => 'Mens'
	        ]);
        Menus::create([
	            'parent' => 7,
	            'title' => 'Diamond Band',
	            'slug' => '/product-category/wedding-rings/mens/diamond-band/',
	            'icon' => 'fas fa-angle-right',
	            'target' => '_self',
	            'tooltip' => 'Mens Diamond Band'
	        ]);
        Menus::create([
	            'parent' => 7,
	            'title' => 'Plain Band',
	            'slug' => '/product-category/wedding-rings/mens/plain-band/',
	            'icon' => 'fas fa-angle-right',
	            'target' => '_self',
	            'tooltip' => 'Mens Plain Band'
	        ]);
        Menus::create([
	            'parent' => 6,
	            'title' => 'Womens',
	            'slug' => '/product-category/wedding-rings/womens/',
	            'icon' => 'fas fa-angle-double-right',
	            'target' => '_self',
	            'tooltip' => 'Wedding Ring Womens'
	        ]);
        Menus::create([
	            'parent' => 10,
	            'title' => 'Diamond Band',
	            'slug' => '/product-category/wedding-rings/womens/diamond-band-womens/',
	            'icon' => 'fas fa-angle-right',
	            'target' => '_self',
	            'tooltip' => 'Womens Diamond Band'
	        ]);
        Menus::create([
	            'parent' => 10,
	            'title' => 'Plain Band',
	            'slug' => '/product-category/wedding-rings/womens/plain-band-womens/',
	            'icon' => 'fas fa-angle-right',
	            'target' => '_self',
	            'tooltip' => 'Womens Plain Band'
	        ]);
        Menus::create([
	            'parent' => 0,
	            'title' => 'Diamond Jewellery',
	            'slug' => '/product-category/diamond-jewellery/',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => 'Diamond Jewellery'
	        ]);
        Menus::create([
	            'parent' => 13,
	            'title' => 'Bracelets',
	            'slug' => '/product-category/diamond-jewellery/bracelets/',
	            'icon' => 'fas fa-angle-double-right',
	            'target' => '_self',
	            'tooltip' => 'Bracelets'
	        ]);
        Menus::create([
	            'parent' => 13,
	            'title' => 'Earrings',
	            'slug' => '/product-category/diamond-jewellery/earrings/',
	            'icon' => 'fas fa-angle-double-right',
	            'target' => '_self',
	            'tooltip' => 'Earrings'
	        ]);
        Menus::create([
	            'parent' => 13,
	            'title' => 'Necklaces',
	            'slug' => '/product-category/diamond-jewellery/necklaces/',
	            'icon' => 'fas fa-angle-double-right',
	            'target' => '_self',
	            'tooltip' => 'Necklaces'
	        ]);
        Menus::create([
	            'parent' => 13,
	            'title' => 'Pendants',
	            'slug' => '/product-category/diamond-jewellery/pendants/',
	            'icon' => 'fas fa-angle-double-right',
	            'target' => '_self',
	            'tooltip' => 'Pendants'
	        ]);
        Menus::create([
	            'parent' => 0,
	            'title' => 'Bespoke Diamond Search',
	            'slug' => '/live-diamond-search/',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => 'Bespoke Diamond Search'
	        ]);
        Menus::create([
	            'parent' => 0,
	            'title' => 'Sustainable Diamonds',
	            'slug' => '/lab-grown-diamond-engagement-rings/',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => 'Sustainable Diamonds'
	        ]);
        Menus::create([
	            'parent' => 0,
	            'title' => 'Visit Us',
	            'slug' => '/visit-us/',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => 'Visit Us'
	        ]);
        Menus::create([
	            'parent' => 0,
	            'title' => 'Blog',
	            'slug' => '/blog/', // Change after SEO discuss 05Jan2023 seo_change
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => 'Blog'
	        ]);
        
    }
}
