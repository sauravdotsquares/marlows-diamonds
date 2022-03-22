<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRoles;

class UsersRoleTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRoles::create([
	            'name' => 'Superadmin',
	        ]);
        UserRoles::create([
	            'name' => 'Admin',
	        ]);
        UserRoles::create([
	            'name' => 'Customer',
	        ]);
        UserRoles::create([
	            'name' => 'Subscriber',
	        ]);
        UserRoles::create([
	            'name' => 'Member',
	        ]);
    }
}
