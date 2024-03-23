<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class categoryPolicy
{
    public function view(User $user)
    {
        return $user->hasPermission('Category Read');
    }

    public function create(User $user)
    {
        return $user->hasPermission('Category Create');
    }

    public function update(User $user, Category $category)
    {
        return (($user->hasPermission('Category Update')&& $category->user->id == $user->id) || $user->role->name== 'Owner');
    }

    public function delete(User $user, Category $category)
    {
        return (($user->hasPermission('Category Delete') && $category->user->id == $user->id) || $user->role->name== 'Owner');
    }
}
