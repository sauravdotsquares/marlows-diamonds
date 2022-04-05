<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings;

class HeaderSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create([
	            'option_name' => 'top-bar-desktop',
	            'option_value' => 'STORE OPEN NOW. OVER 2500 DIAMONDS IN STOCK TO TAKE AWAY AT ONLINE PRICES',
	        ]);
        Settings::create([
	            'option_name' => 'field1',
	            'option_value' => '+44753 5425059',
	        ]);
        Settings::create([
	            'option_name' => 'field2',
	            'option_value' => 'Birmingham:<a href="tel:01212364415">0121 236 4415</a> | London:<a href="tel:02074051477">020 7405 1477</a>',
	        ]);
        Settings::create([
	            'option_name' => 'field3',
	            'option_value' => 'FINE JEWELLERS SINCE 1951 | TRUSTED BY THOUSANDS',
	        ]);
        Settings::create([
	            'option_name' => 'field4',
	            'option_value' => '<img src="/images/review-one.png" alt="Reviews">',
	        ]);
        Settings::create([
	            'option_name' => 'header-left',
	            'option_value' => 'Fine Jewellers Since 1951',
	        ]);
        Settings::create([
	            'option_name' => 'header-center',
	            'option_value' => '<img src="/images/reviewss.png" alt="Reviews">',
	        ]);
        Settings::create([
	            'option_name' => 'header-right',
	            'option_value' => 'Trusted by thousands and free 30 day returns.',
	        ]);
        Settings::create([
	            'option_name' => 'location1',
	            'option_value' => 'Birmingham: 0121 236 4415 <br> (Customer Help: 9am - 9pm)',
	        ]);
        Settings::create([
	            'option_name' => 'location2',
	            'option_value' => 'London: 0207 4051477 <br> (Customer Help: 9am - 9pm)',
	        ]);
        Settings::create([
	            'option_name' => 'whatsapp',
	            'option_value' => '+447535425059',
	        ]);
    }
}
