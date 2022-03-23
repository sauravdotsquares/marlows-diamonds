<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class UsersRoleTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
	            'name' => 'Superadmin',
	        ]);
        Role::create([
	            'name' => 'Admin',
	        ]);
        Role::create([
	            'name' => 'Customer',
	        ]);
        Role::create([
	            'name' => 'Subscriber',
	        ]);
        Role::create([
	            'name' => 'Member',
	        ]);
    }
}
