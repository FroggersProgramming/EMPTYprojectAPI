<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\CategoryField;
use App\Models\Role;
use App\Models\User;
use App\Policies\CategoryFieldPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\RolePolicy;
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
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        CategoryField::class => CategoryFieldPolicy::class,
        Category::class =>  CategoryPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
