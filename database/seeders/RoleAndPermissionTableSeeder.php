<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleAndPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolePermission = [
            [
                'role' => 1,
                'permission' => 1,
            ],
            [
                'role' => 1,
                'permission' => 2,
            ],
            [
                'role' => 1,
                'permission' => 3,
            ],
            [
                'role' => 1,
                'permission' => 4,
            ],
            [
                'role' => 1,
                'permission' => 5,
            ],
            [
                'role' => 1,
                'permission' => 6,
            ],
            [
                'role' => 1,
                'permission' => 7,
            ],
            [
                'role' => 1,
                'permission' => 8,
            ],
            [
                'role' => 1,
                'permission' => 9,
            ],
            [
                'role' => 1,
                'permission' => 10,
            ],
            [
                'role' => 1,
                'permission' => 11,
            ],
            [
                'role' => 1,
                'permission' => 12,
            ],
            [
                'role' => 1,
                'permission' => 13,
            ],
            [
                'role' => 1,
                'permission' => 14,
            ],
            [
                'role' => 1,
                'permission' => 15,
            ],
            [
                'role' => 1,
                'permission' => 15,
            ],
            [
                'role' => 1,
                'permission' => 16,
            ],
        ];


        foreach ($rolePermission as $permission) {
            try {
                DB::table('role_and_permission')->insert($permission);
            } catch (\Exception $e) {
                report($e);
            }
        }
    }
}
