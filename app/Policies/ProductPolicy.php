<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function view(User $user)
    {
        return $user->roles->contains(function ($role) {
            return $role->permissions->contains(function ($permission) {
                return $permission->name == 'Product Read' && $permission->pivot->allow;
            });
        });
    }

    public function create(User $user)
    {
        return $user->roles->contains(function ($role) {
            return $role->permissions->contains(function ($permission) {
                return $permission->name == 'Product Create' && $permission->pivot->allow;
            });
        });
    }

    public function update(User $user, Product $product)
    {
        return $user->roles->contains(function ($role) {
            return $role->permissions->contains(function ($permission) {
                return $permission->name == 'Product Update' && $permission->pivot->allow;
            });
        });
    }

    public function delete(User $user, Product $product)
    {
        return $user->roles->contains(function ($role) {
            return $role->permissions->contains(function ($permission) {
                return $permission->name == 'Product Delete' && $permission->pivot->allow;
            });
        });
    }
}
