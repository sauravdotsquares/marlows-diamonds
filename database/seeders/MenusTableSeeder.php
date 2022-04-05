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
	            'title' => '',
	            'slug' => '',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => ''
	        ]);
        Menus::create([
	            'parent' => 10,
	            'title' => '',
	            'slug' => '',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => ''
	        ]);
        Menus::create([
	            'parent' => 0,
	            'title' => '',
	            'slug' => '',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => ''
	        ]);
        Menus::create([
	            'parent' => 0,
	            'title' => '',
	            'slug' => '',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => ''
	        ]);
        Menus::create([
	            'parent' => 0,
	            'title' => '',
	            'slug' => '',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => ''
	        ]);
        Menus::create([
	            'parent' => 0,
	            'title' => '',
	            'slug' => '',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => ''
	        ]);
        Menus::create([
	            'parent' => 0,
	            'title' => '',
	            'slug' => '',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => ''
	        ]);
        Menus::create([
	            'parent' => 0,
	            'title' => '',
	            'slug' => '',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => ''
	        ]);
        Menus::create([
	            'parent' => 0,
	            'title' => '',
	            'slug' => '',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => ''
	        ]);
        Menus::create([
	            'parent' => 0,
	            'title' => '',
	            'slug' => '',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => ''
	        ]);
        Menus::create([
	            'parent' => 0,
	            'title' => '',
	            'slug' => '',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => ''
	        ]);
        Menus::create([
	            'parent' => 0,
	            'title' => '',
	            'slug' => '',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => ''
	        ]);
        Menus::create([
	            'parent' => 0,
	            'title' => '',
	            'slug' => '',
	            'icon' => 'fas fa-align-justify',
	            'target' => '_self',
	            'tooltip' => ''
	        ]);
    }
}
