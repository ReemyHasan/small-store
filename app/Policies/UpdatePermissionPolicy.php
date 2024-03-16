<?php

namespace App\Policies;

use App\Models\User;

class UpdatePermissionPolicy
{
    public function update(User $user)
    {
        return $user->roles->contains(function ($role) {
            return $role->permissions->contains(function ($permission) {
                return $permission->name == 'Permission Update' && $permission->pivot->allow;
            });
        });
    }
}
