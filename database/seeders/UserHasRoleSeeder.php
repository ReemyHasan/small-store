<?php

namespace Database\Seeders;

use App\Models\UserHasRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRoleMappings = [
            ['user_id' => 561, 'role_id' => 1],
            ['user_id' => 562, 'role_id' => 2]
        ];

        foreach ($userRoleMappings as $mapping) {
            UserHasRole::create($mapping);
        }
    }
}
