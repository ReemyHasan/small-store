<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function view(User $user)
    {
        return $user->hasPermission('Product Read');
    }

    public function create(User $user)
    {
        return $user->hasPermission('Product Create');
    }

    public function update(User $user, Product $product)
    {
        return (($user->hasPermission('Product Update') && $product->user->id == $user->id) || $user->role->name== 'Owner' );
    }

    public function delete(User $user, Product $product)
    {
        return (($user->hasPermission('Product Delete') && $product->user->id == $user->id) || $user->role->name== 'Owner');
    }
}
