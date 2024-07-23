<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions =  [
            // <<===== Permission ====>>
            [
                'permission_name' => 'Permission',
                'permission_description' => 'View The All Permission'
            ],
            [
                'permission_name' => 'Create Permission',
                'permission_description' => 'Create The Permission'
            ],
            [
                'permission_name' => 'Edit Permission',
                'permission_description' => 'Edit The Permission'
            ],
            [
                'permission_name' => 'Delete Permission',
                'permission_description' => 'Delete The Permission'
            ],
            // <<===== Role ====>>
            [
                'permission_name' => 'Role',
                'permission_description' => 'View The All Role'
            ],
            [
                'permission_name' => 'Create Role',
                'permission_description' => 'Create The Role'
            ],
            [
                'permission_name' => 'Edit Role',
                'permission_description' => 'Edit The Role'
            ],
            [
                'permission_name' => 'Delete Role',
                'permission_description' => 'Delete The Role'
            ],
            // <<===== User ====>>
            [
                'permission_name' => 'User',
                'permission_description' => 'View The All User'
            ],
            [
                'permission_name' => 'Create User',
                'permission_description' => 'Create The User'
            ],
            [
                'permission_name' => 'Edit User',
                'permission_description' => 'Edit The User'
            ],
            [
                'permission_name' => 'Delete User',
                'permission_description' => 'Delete The User'
            ],
            // <<===== User permission ====>>
            [
                'permission_name' => 'User permission',
                'permission_description' => 'View The All User permission'
            ],
            [
                'permission_name' => 'Create User permission',
                'permission_description' => 'Create The User permission'
            ],
            [
                'permission_name' => 'Edit User permission',
                'permission_description' => 'Edit The User permission'
            ],
            [
                'permission_name' => 'Delete User permission',
                'permission_description' => 'Delete The User permission'
            ],
        ];

        foreach ($permissions as $permission) {
            try {
                DB::table('permission')->insert($permission);
            } catch (\Exception $e) {
                report($e);
            }
        }
    }
}
