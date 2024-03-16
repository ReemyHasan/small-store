<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $roles = ['Owner', 'Super-admin', 'Admin', 'Supervisor'];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // Create permissions
        $permissions = [
            // permission update
            'Permission Update',
            //products crud
            'Product Create',
            'Product Read',
            'Product Update',
            'Product Delete',
            //category crud
            'Category Create',
            'Category Read',
            'Category Update',
            'Category Delete',
            // user crud
            'User Create',
            'User Read',
            'User Update',
            'User Delete',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Owner
        Role::where('name', 'Owner')->first()->permissions()->attach(Permission::all(), ['allow' => true]);

        // Super Admin
        $superAdmin = Role::where('name', 'Super-admin')->first();
        $superAdmin->permissions()->attach(
            Permission::where('name', '!=', 'Permission Update')->get(),
            ['allow' => true]
        );
        $superAdmin->permissions()->attach(
            Permission::where('name', 'Permission Update')->get(),
            ['allow' => false]
        );

        // Admin
        $admin = Role::where('name', 'Admin')->first();
        $admin->permissions()->attach(
            Permission::where('name', '!=', 'Permission Update')
                ->where(function ($query) {
                    $query->where('name', 'not like', 'User%');
                })
                ->get(),
            ['allow' => true]
        );
        $admin->permissions()->attach(
            Permission::where('name', 'Permission Update')
                ->orWhere('name', 'like', 'User%')
                ->get(),
            ['allow' => false]
        );

        // Supervisor
        $supervisor = Role::where('name', 'Supervisor')->first();
        $supervisor->permissions()->attach(
            Permission::where('name', '!=', 'Permission Update')
                ->where('name', 'not like', '%Delete%')
                ->where('name', 'not like', 'User%')
                ->get(),
            ['allow' => true]
        );
        $supervisor->permissions()->attach(
            Permission::where('name', 'Permission Update')
                ->orWhere('name', 'like', '%Delete%')
                ->orWhere('name', 'like', 'User%')
                ->get(),
            ['allow' => false]
        );
    }
}
