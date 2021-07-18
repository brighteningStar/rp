<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'super_admin'
        ]);

        Role::create([
            'name' => 'Asset Manager',
            'guard_name' => 'asset_manager'
        ]);

        Role::create([
            'name' => 'Man Power Manager',
            'guard_name' => 'man_power_manager'
        ]);

        Role::create([
            'name' => 'IT Service Provide',
            'guard_name' => 'it_service_provider'
        ]);

        Role::create([
            'name' => 'Investor',
            'guard_name' => 'investor'
        ]);
    }
}
