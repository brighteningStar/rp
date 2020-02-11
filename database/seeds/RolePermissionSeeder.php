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

        $adminPermissions = [
            [Permission::firstOrCreate(['name' => 'view_all_users']),'super_admin'],
            [Permission::firstOrCreate(['name' => 'create_new_user']),'super_admin'],
            [Permission::firstOrCreate(['name' => 'edit_users']),'super_admin'],
            [Permission::firstOrCreate(['name' => 'delete_users']),'super_admin'],
            [Permission::firstOrCreate(['name' => 'create_stock']),'admin'],
        ];

        foreach ($adminPermissions as $permission){
            $perm = $permission[0];
            $type = $permission[1];
            if($type=='admin'){
                if(!$admin->hasPermissionTo($perm->name)){
                    $admin->givePermissionTo($perm->name);
                }
            }
        }

        $allUsers = \App\Models\User::all();
        foreach ($allUsers as $user){
            $user->assignRole('super_admin');
        }






    }
}
