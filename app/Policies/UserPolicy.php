<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{

    public function view(User $user): bool
    {
        return $user->roles->contains(function ($role) {
            return $role->permissions->contains(function ($permission) {
                return $permission->name == 'User Read' && $permission->pivot->allow;
            });
        });
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->roles->contains(function ($role) {
            return $role->permissions->contains(function ($permission) {
                return $permission->name == 'User Create' && $permission->pivot->allow;
            });
        });
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->roles->contains(function ($role) {
            return $role->permissions->contains(function ($permission) {
                return $permission->name == 'User Update' && $permission->pivot->allow;
            });
        });
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->roles->contains(function ($role) {
            return $role->permissions->contains(function ($permission) {
                return $permission->name == 'User Delete' && $permission->pivot->allow;
            });
        });
    }
}
