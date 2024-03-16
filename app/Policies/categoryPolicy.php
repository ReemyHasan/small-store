<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class categoryPolicy
{
    public function view(User $user)
    {
        return $user->roles->contains(function ($role) {
            return $role->permissions->contains(function ($permission) {
                return $permission->name == 'Category Read' && $permission->pivot->allow;
            });
        });
    }

    public function create(User $user)
    {
        return $user->roles->contains(function ($role) {
            return $role->permissions->contains(function ($permission) {
                return $permission->name == 'Category Create' && $permission->pivot->allow;
            });
        });
    }

    public function update(User $user, Category $category)
    {
        return $user->roles->contains(function ($role) {
            return $role->permissions->contains(function ($permission) {
                return $permission->name == 'Category Update' && $permission->pivot->allow;
            });
        });
    }

    public function delete(User $user, Category $category)
    {
        return $user->roles->contains(function ($role) {
            return $role->permissions->contains(function ($permission) {
                return $permission->name == 'Category Delete' && $permission->pivot->allow;
            });
        });
    }
}
