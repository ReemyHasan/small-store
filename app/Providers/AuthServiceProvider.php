<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Category;
use App\Models\Permission;
use App\Models\Product;
use App\Models\User;
use App\Policies\categoryPolicy;
use App\Policies\ProductPolicy;
use App\Policies\UpdatePermissionPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Product::class => ProductPolicy::class,
        Category::class => categoryPolicy::class,
        User::class => UserPolicy::class,
        Permission::class => UpdatePermissionPolicy::class,

    ];
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
