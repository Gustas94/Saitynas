<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'Guest']);
        Role::create(['name' => 'Registered']);
        Role::create(['name' => 'Loyal']);
        Role::create(['name' => 'Employee']);
        Role::create(['name' => 'Administrator']);
    }
}
