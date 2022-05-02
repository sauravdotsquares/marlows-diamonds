<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiamondShapes;

class DiamondShapesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DiamondShapes::create([
            'value' => 'ROUND',
            'name' => 'Round',
        ]);
        DiamondShapes::create([
            'value' => 'PEAR',
            'name' => 'Pear',
        ]);
        DiamondShapes::create([
            'value' => 'MARQUISE',
            'name' => 'Marquise',
        ]);
        DiamondShapes::create([
            'value' => 'HEART',
            'name' => 'Heart',
        ]);
        DiamondShapes::create([
            'value' => 'ASSCHER',
            'name' => 'Asscher',
        ]);
        DiamondShapes::create([
            'value' => 'PRINCESS',
            'name' => 'Princess',
        ]);
        DiamondShapes::create([
            'value' => 'RADIANT',
            'name' => 'Radiant',
        ]);
        DiamondShapes::create([
            'value' => 'EMERALD',
            'name' => 'Emerald',
        ]);
        DiamondShapes::create([
            'value' => 'OVAL',
            'name' => 'Oval',
        ]);
        DiamondShapes::create([
            'value' => 'CUSHION',
            'name' => 'Cushion',
        ]);
    }
}
