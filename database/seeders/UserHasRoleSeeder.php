<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $user1 = User::findOrFail(1);
            $user2 = User::findOrFail(2);
            $user3 = User::findOrFail(3);
            $user4 = User::findOrFail(4);

            $user1->update(['role_id'=>1]);
            $user2->update(['role_id'=>2]);
            $user3->update(['role_id'=>3]);
            $user4->update(['role_id'=>4]);


    }
}
