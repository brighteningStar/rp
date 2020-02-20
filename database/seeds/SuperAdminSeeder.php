<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin = \App\Models\User::firstOrCreate([
                'email' => 'system@mailinator.com',
            ],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'),

            ]);
        $super_admin->assignRole('super_admin');
    }
}
