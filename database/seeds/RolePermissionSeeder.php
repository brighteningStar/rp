<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);

        $allPermissions = [
            [Permission::firstOrCreate(['name' => 'view_all_users']),'super_admin'],
            [Permission::firstOrCreate(['name' => 'create_new_user']),'super_admin'],
            [Permission::firstOrCreate(['name' => 'edit_user']),'admin'],
            [Permission::firstOrCreate(['name' => 'delete_user']),'super_admin'],

            [Permission::firstOrCreate(['name' => 'view_dashboard']),'admin'],

            [Permission::firstOrCreate(['name' => 'view_all_colors']),'admin'],
            [Permission::firstOrCreate(['name' => 'edit_color']),'admin'],
            [Permission::firstOrCreate(['name' => 'delete_color']),'admin'],
            [Permission::firstOrCreate(['name' => 'create_new_color']),'admin'],

            [Permission::firstOrCreate(['name' => 'edit_capacity']),'admin'],
            [Permission::firstOrCreate(['name' => 'delete_capacity']),'admin'],
            [Permission::firstOrCreate(['name' => 'create_new_capacity']),'admin'],
            [Permission::firstOrCreate(['name' => 'view_all_capacity']),'admin'],

            [Permission::firstOrCreate(['name' => 'edit_make']),'admin'],
            [Permission::firstOrCreate(['name' => 'delete_make']),'admin'],
            [Permission::firstOrCreate(['name' => 'create_new_make']),'admin'],
            [Permission::firstOrCreate(['name' => 'view_all_make']),'admin'],

            [Permission::firstOrCreate(['name' => 'edit_grade']),'admin'],
            [Permission::firstOrCreate(['name' => 'delete_grade']),'admin'],
            [Permission::firstOrCreate(['name' => 'create_new_grade']),'admin'],
            [Permission::firstOrCreate(['name' => 'view_all_grades']),'admin'],

            [Permission::firstOrCreate(['name' => 'edit_fault_type']),'admin'],
            [Permission::firstOrCreate(['name' => 'delete_fault_type']),'admin'],
            [Permission::firstOrCreate(['name' => 'create_new_fault_type']),'admin'],
            [Permission::firstOrCreate(['name' => 'view_all_fault_types']),'admin'],

            [Permission::firstOrCreate(['name' => 'edit_customer']),'admin'],
            [Permission::firstOrCreate(['name' => 'delete_customer']),'admin'],
            [Permission::firstOrCreate(['name' => 'create_new_customer']),'admin'],
            [Permission::firstOrCreate(['name' => 'view_all_customers']),'admin'],

            [Permission::firstOrCreate(['name' => 'edit_region']),'admin'],
            [Permission::firstOrCreate(['name' => 'delete_region']),'admin'],
            [Permission::firstOrCreate(['name' => 'create_new_region']),'admin'],
            [Permission::firstOrCreate(['name' => 'view_all_regions']),'admin'],

            [Permission::firstOrCreate(['name' => 'edit_supplier']),'admin'],
            [Permission::firstOrCreate(['name' => 'delete_supplier']),'admin'],
            [Permission::firstOrCreate(['name' => 'create_new_supplier']),'admin'],
            [Permission::firstOrCreate(['name' => 'view_all_suppliers']),'admin'],

            [Permission::firstOrCreate(['name' => 'edit_model']),'admin'],
            [Permission::firstOrCreate(['name' => 'delete_model']),'admin'],
            [Permission::firstOrCreate(['name' => 'create_new_model']),'admin'],
            [Permission::firstOrCreate(['name' => 'view_all_models']),'admin'],
        ];

        foreach ($allPermissions as $permission){
            $perm = $permission[0];
            $type = $permission[1];
            if($type=='admin'){
                if(!$admin->hasPermissionTo($perm->name)){
                    $admin->givePermissionTo($perm->name);
                }
            }
        }

    }
}
