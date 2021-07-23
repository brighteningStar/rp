<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolesArray = [
            [
                'label' => 'Super Admin',
                'name' => 'super_admin'
            ],[
                'label' => 'Asset Manager',
                'name' => 'asset_manager'
            ],[
                'label' => 'Man Power Manager',
                'name' => 'man_power_manager'
            ],[
                'label' => 'IT Service Provider',
                'name' => 'it_service_provider'
            ],[
                'label' => 'Investor',
                'name' => 'investor'
            ]
        ];
       

        Role::insert($rolesArray);
    }
}
