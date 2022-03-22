<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UsersTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
	            'name' => 'Superadmin',
	            'email' => 'gyanendra.kalakar@dotsquares.com',
	            'username' => 'superadmin',
	            'password' => bcrypt('Dots#123?!'),
	            'nicename' => 'Dotsquares',
	            'user_role' => 1
	        ]);
    }
}
