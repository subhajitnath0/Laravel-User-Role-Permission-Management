<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'role' => 'Admin',
                'description' => 'Manages users, roles, application settings , and holds highest level of access and control.'
            ],
            [
                'role' => 'User',
                'description' => 'A registered member of the system.'
            ],
        ];

        foreach ($roles  as $role) {
            try {
                DB::table('roles')->insert($role);
            } catch (\Exception $e) {
                report($e);
            }
        }
    }
}
